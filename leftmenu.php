        <!-- BEGIN SIDEBAR -->
        <nav id="page-leftbar" role="navigation">
                <!-- BEGIN SIDEBAR MENU -->
            <ul class="acc-menu" id="sidebar">
                
                                <?php
                $cn = ConnectDB();
                //mysql_select_db(getDBMain());
                $user = $_SESSION['User'];
                $qry = "SELECT DISTINCT MenuID, MenuLevel, isLink, Parent, MenuOrder FROM MenuDefine 
				WHERE (MenuID IN(SELECT MenuID FROM RoleMenu WHERE (Permission = 1) AND (RoleID IN (SELECT RoleID FROM UserRole 
				WHERE (UserID IN (SELECT UserID FROM UserInfo WHERE (UserName = '$user')))))))
				ORDER BY MenuOrder";
                $rs = $rs = odbc_exec($cn, $qry);

                $b = 0;   $c = 0;
                
                   $iconArray=array ("fa fa-envelope-o","fa fa-calendar","fa fa-money","fa fa-bar-chart-o",  "fa fa-exchange", "fa fa-group" ,"fa fa-book");
                         
                
                while ($row = db_fetch_array($rs)) {
                    //$PageID = $row[0];
                    //$MenuCaption = $row[1];
                    //$isLink = $row[2];
                    //$a = $row[3];
                    $PageID = odbc_result($rs, "MenuId");
                    $MenuCaption = odbc_result($rs, "MenuLevel");
                    $Menuurlurl = odbc_result($rs, "Menuurl");
                    $isLink = odbc_result($rs, "isLink");
                    $a = odbc_result($rs, "Parent");
                    //echo $a;


                    if ($a == 0) {
                        if ($a == $b) {
                            ?>
                            <!--<i class='fa fa-home'></i>-->
                           <li><a href="index.php?parent=Dashboard"> <i class="fa fa-dashboard"></i> <span>  Dashboard </span></a> </li>
                
                            <li><a href="#"> <i class="<?php echo $iconArray[$c]; ?>"></i>  <span> <?php echo $MenuCaption; ?></span></a>
                                <ul  class="acc-menu">
                                    <?php
                                     $c=$c+1;
                                    
                                } else {
                                    ?>
                                </ul>
                            </li>
                            <li><a href="#"><i class="<?php echo $iconArray[$c]; ?>"></i><span> <?php echo $MenuCaption; ?></span></a>
                                <ul  class="acc-menu">
                                    <?php
                                     $c=$c+1;
                                }
                            } else {
                                $b = $a;
                                ?>
                                <li><a href = 'index.php?parent=<?php echo $PageID; ?>'><?php echo $MenuCaption; ?></a> </li>
                                <?php
                            }
                        }
                        //db_close($cn);
                        ?>
                  
                    </ul>
                </li>
            </ul>
            <!-- END SIDEBAR MENU -->
        </nav>