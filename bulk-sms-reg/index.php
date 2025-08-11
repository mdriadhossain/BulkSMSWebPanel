<?php
// Include header
include 'header.php';

require_once '../Config/config.php';

/*// Database connection with PDO SQLSRV
$serverName = "localhost"; // or "SERVERNAME\INSTANCE"
$dbName = "BULKSMSPanel";
$dbUser = "sa";
$dbPass = "nopass@1234";

try {
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$dbName", $dbUser, $dbPass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}*/

$conn = PDOConnectDB2();

// Initialize error storage
$errors = [
    "username" => "",
    "company" => "",
    "mobile" => "",
    "email" => "",
    "headertext" => "",
    "type" => "",
    "amount" => ""
];
$success = "";

// Suggest usernames
function suggestUsernames($username)
{
    return [
        $username . rand(10, 99),
        $username . "_" . rand(100, 999),
        $username . date("Y")
    ];
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usernameInput = trim($_POST["username"]);
    $companyName = trim($_POST["company"]);
    $mobile = trim($_POST["mobile"]);
    $email = trim($_POST["email"]);
    $headertext = trim($_POST["headertext"]);
    $type = $_POST["type"] ?? '';
    $amount = trim($_POST["amount"]);

    if (empty($usernameInput)) {
        $errors["username"] = "Username is required.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $usernameInput)) {
        $errors["username"] = "Username can only contain letters, numbers, and underscores (no spaces or special characters).";
    } else {
        $stmt = $conn->prepare("SELECT UserID FROM UserInfo WHERE UserName = ?");
        $stmt->execute([$usernameInput]);
        if ($stmt->fetch()) {
            $errors["username"] = "Username is not available. Try these: " . implode(", ", suggestUsernames($usernameInput));
        }
    }

    // Company validation
    if (empty($companyName)) {
        $errors["company"] = "Company name is required.";
    }

    // Mobile validation
    if (empty($mobile)) {
        $errors["mobile"] = "Mobile number is required.";
    } elseif (!preg_match('/^[0-9]{10,14}$/', $mobile)) {
        $errors["mobile"] = "Mobile number must be between 10 and 14 digits.";
    }

    // Email validation
    if (empty($email)) {
        $errors["email"] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email format.";
    }

    // Type select validation
    if (empty($type) || !in_array($type, ['Masking', 'Non-Masking'])) {
        $errors["type"] = "Please select Masking or Non-Masking.";
    }

    // Amount validation
    if ($amount === '') {
        $errors["amount"] = "Amount is required.";
    } elseif (!is_numeric($amount)) {
        $errors["amount"] = "Amount must be a number.";
    } else {
        $amount = (float)$amount;
        if ($type === 'Masking' && $amount < 10000) {
            $errors["amount"] = "Amount must be at least 10,000 Tk for Masking SMS.";
        }
        if ($type === 'Non-Masking' && $amount < 1000) {
            $errors["amount"] = "Amount must be at least 1,000 Tk for Non-Masking SMS.";
        }
    }


    function getMaxUserID(PDO $conn)
    {
        $sql = "SELECT MAX(UserID) AS max_user_id FROM UserInfo";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['max_user_id'] : null;
    }

    $maxUserID = getMaxUserID($conn);
    if ($maxUserID) {
        $nextUserID = $maxUserID + 1;
    } else {
        $nextUserID = 1;
    }

    function generatePassword($length = 6)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $charLen = strlen($chars);
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, $charLen - 1)];
        }
        return $password;
    }

// Example usage
    $password = generatePassword();

    // Insert if valid
    if (!array_filter($errors)) {
        $stmt = $conn->prepare("INSERT INTO UserInfo (UserID, UserName, Password, MobileNo, Email, CompanyName, CreatedBy, CreateDate, HeaderText, IsActive) VALUES (?, ?, ?, ?, ?, ?, 'Web', GETDATE(), ?, 0)");
        if ($stmt->execute([$nextUserID, $usernameInput, $password, $mobile, $email, $companyName, $headertext])) {

            $sql = "SELECT UserID FROM UserInfo WHERE UserName = ?";
            $stmt2 = $conn->prepare($sql);
            $stmt2->execute([$usernameInput]);
            $newUserId = $stmt2->fetchColumn();

            $stmt3 = $conn->prepare("INSERT INTO UserRole (UserID, RoleID, CreatedBy, CreateDate) VALUES (?, 'reseller', 'Web', GETDATE())");

            if ($stmt3->execute([$newUserId])) {

                $newUserMaskingId = "MID_" . $usernameInput;
                $requestingIP = "127.0.0.1";

                $stmt4 = $conn->prepare("INSERT INTO MaskingDetail (UserName, MaskingID,RequestingIP,MaskingForGP,MaskingForRO,MaskingForBL,MaskingForAT,MaskingForTT) VALUES (?, ?, ?, '0', '0', '0', '0', '0')");

                if ($stmt4->execute([$usernameInput, $newUserMaskingId, $requestingIP])) {
                    echo $success = "Registration successful!";
                    $_POST = []; // Clear form

                    /*$params = http_build_query([
                        'username' => $usernameInput,
                        'email' => $email
                    ]);
                    header("Location: https://developer.sslcommerz.com/registration/?$params");
                    exit; // important to stop execution after redirect*/
                }
            }
        } else {
            $success = "Database error. Please try again.";
        }
    }
}
?>

<div class="form-container">
    <h2>SignUp Form For Bulk SMS</h2>

    <?php if ($success) echo "<div class='success'>$success</div>"; ?>

    <form method="post" action="">
        <!-- Username -->
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
        <?php if ($errors["username"]) echo "<div class='error'>{$errors['username']}</div>"; ?>

        <!-- Company -->
        <label>Company Name:</label>
        <input type="text" name="company" value="<?php echo htmlspecialchars($_POST['company'] ?? ''); ?>">
        <?php if ($errors["company"]) echo "<div class='error'>{$errors['company']}</div>"; ?>

        <!-- Mobile -->
        <label>Mobile Number:</label>
        <input type="text" name="mobile" value="<?php echo htmlspecialchars($_POST['mobile'] ?? ''); ?>">
        <?php if ($errors["mobile"]) echo "<div class='error'>{$errors['mobile']}</div>"; ?>

        <!-- Email -->
        <label>Email:</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
        <?php if ($errors["email"]) echo "<div class='error'>{$errors['email']}</div>"; ?>

        <!-- Header Text -->
        <label>Header Text:</label>
        <input type="text" name="headertext" value="<?php echo htmlspecialchars($_POST['headertext'] ?? ''); ?>">

        <!-- Select type -->
        <label>Select SMS Type:</label>
        <select name="type">
            <option value="">-- Select --</option>
            <option value="Masking" <?php if (($_POST['type'] ?? '') === 'Masking') echo 'selected'; ?>>Masking</option>
            <option value="Non-Masking" <?php if (($_POST['type'] ?? '') === 'Non-Masking') echo 'selected'; ?>>
                Non-Masking
            </option>
        </select>
        <?php if ($errors["type"]) echo "<div class='error'>{$errors['type']}</div>"; ?>

        <!-- Amount -->
        <label>Amount (Tk):</label>
        <input type="text" name="amount" value="<?php echo htmlspecialchars($_POST['amount'] ?? ''); ?>">
        <?php if ($errors["amount"]) echo "<div class='error'>{$errors['amount']}</div>"; ?>

        <br>
        <div style="margin-top: 20px;">
            <input type="submit" value="Proceed Payment" style="padding: 10px 20px;">
            <button type="button" onclick="window.location.href='https://bestbulksms.com/'"
                    style="padding: 10px 20px; margin-left: 10px; cursor: pointer;">Back Home
            </button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
