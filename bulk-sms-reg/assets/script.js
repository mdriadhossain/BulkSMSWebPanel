// Example: confirm form submission
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    form.addEventListener("submit", function (e) {
        const username = document.querySelector("[name='username']").value.trim();
        if (username.length < 3) {
            alert("Username must be at least 3 characters.");
            e.preventDefault();
        }
    });
});
