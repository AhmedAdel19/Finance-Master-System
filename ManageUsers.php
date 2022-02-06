<?php
include 'NavBar.php';
// include 'setlogpages.php';
include 'db_connection.php';
include 'error_handler.php';
error();
?>
<html><head>
  <title>Finance Master-Users</title>

  <link rel="stylesheet" href="css/table2.css" /> </head></html>
<?php
if (isset($_SESSION['U_Name']) && $_SESSION['G_Name'] == 'admin')
{
    $userid = $_SESSION['User_ID'];
    $username = $_SESSION['U_Name'];
    $pagename = 'ManageUsers';
    $pageapp = 'DejavuPortal';
    setlogpage($userid, $username, $pagename, $pageapp);
    $action = '';
    if (isset($_GET['action']))
    {
        $action = $_GET['action'];
    }
    else {
        $action = 'Manage';
    }
    if ($action == 'Manage')
    {
        ?>
        <ul class="dropdown-menu">
            <li><a href="?action=Add">Add New User</a></li>
            <li><a href="?action=Edit">Update User Information</a></li>
            <li><a href="?action=Delete">Delete User</a></li>
        </ul>
        <?php
    }
    else if ($action == 'Add')
    {
        echo "You can Add new User";
    }
    else if ($action == 'Insert')
    {
        echo "Data Inserted";
    }
    else if ($action == 'Edit')
    {
        $stmt = $conn->prepare("SELECT * From users  ");
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0)
        {
            echo "<table style='margin-top:10px; margin-left:377px;' >\n";
            echo "<thead>";
            echo "<tr>\n";
            echo "<th>G_ID</th>";
            echo "<th>Full Name</th>";
            echo "<th>UserName</th>";
            echo "<th>G_Name</th>";
            echo "<th>Store Code</th>";
            echo "<th>Reset Password</th>";
            echo "<th>Edit</th>";
            echo "</thead>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                echo "<tr >\n";
                echo " <td  >" . $row['GID'] . "</td>";
                echo " <td  >" . $row['full_name'] . "</td>";
                echo " <td  >" . $row['User_name'] . "</td>";
                echo " <td  >" . $row['G_Name'] . "</td>";
                echo " <td  >" . $row['Store_Code'] . "</td>";
                echo "<td> <a href='ManageUsers.php?action=Reset&user_id=" . $row['User_ID'] . " ' >"."<img width='30px' src='Image/public/reset-password.png'/></a> </td>";
                echo ' <td><a href="';
                echo '/update_user.php?User_ID=';
                echo $row['User_ID'];
                echo '&G_Name=';
                echo $row['G_Name'];
                echo '&Full_Name=';
                echo $row['full_name'];
                echo '&User_Dept=';
                echo $row['User_Dept'];
                echo '&User_Name=';
                echo $row['User_name'];
                echo '"><i class="fa fa-edit" style="">';
                echo '</i></a>';
                echo ' <a class="delete_row" href="';
                echo '/delete_user.php?User_ID=';
                echo  $row['User_ID'];
                echo '"><i class="fa fa-remove" style="">';
                echo '</i></a>';
                echo "</tr>\n";
                echo "</tr>\n";
            }
            echo "</table>\n";
        }
        else {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <h1 align="center" font-size="4em">No Users To Show </h1>
                </div>
            </div>
            <?php
        }

    }
    else if ($action == 'Delete') {}
    else if ($action == 'Reset')
    {
        if(isset($_GET['user_id']))
        {
            $user_id=$_GET['user_id'];
            ?>
            <html>
                <head>
                    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
                    <meta charset="UTF-8">
                    <title>Finance Master System</title>
                    <style>
                        body {
                            background-size: cover;
                            font-family: Montserrat;
                        }
                        .Reset-block {
                            width: 430px;
                            padding: 20px;
                            background: #fff;
                            border-radius: 5px;
                            border-top: 5px solid #ff656c;
                            margin: 0 auto;
                            margin-top: 110px;
                        }
                        .Reset-block h1 {
                            text-align: center;
                            color: #000;
                            font-size: 18px;
                            text-transform: uppercase;
                            margin-top: 0;
                            margin-bottom: 20px;
                        }

                        .Reset-block input {
                            width: 100%;
                            height: 42px;
                            box-sizing: border-box;
                            border-radius: 5px;
                            border: 1px solid #ccc;
                            margin-bottom: 20px;
                            font-size: 14px;
                            font-family: Montserrat;
                            padding: 0 20px 0 50px;
                            outline: none;
                        }

                        .Reset-block input#username {
                            background: #fff url('http://i.imgur.com/u0XmBmv.png') 20px top no-repeat;
                            background-size: 16px 80px;
                        }

                        .Reset-block input#username:focus {
                            background: #fff url('http://i.imgur.com/u0XmBmv.png') 20px bottom no-repeat;
                            background-size: 16px 80px;
                        }

                        .Reset-block input#password {
                            background: #fff url('http://i.imgur.com/Qf83FTt.png') 20px top no-repeat;
                            background-size: 16px 80px;
                        }

                        .Reset-block input#password:focus {
                            background: #fff url('http://i.imgur.com/Qf83FTt.png') 20px bottom no-repeat;
                            background-size: 16px 80px;
                        }

                        .Reset-block input:active, .Reset-block input:focus {
                            border: 1px solid #ff656c;
                        }

                        .Reset-block button {
                            width: 100%;
                            height: 40px;
                            background: #ff656c;
                            box-sizing: border-box;
                            border-radius: 5px;
                            border: 1px solid #e15960;
                            color: #fff;
                            font-weight: bold;
                            text-transform: uppercase;
                            font-size: 14px;
                            font-family: Montserrat;
                            outline: none;
                            cursor: pointer;
                        }

                        .Reset-block button:hover {
                            background: #ff7b81;
                        }
                        .show-pass{
                            position: absolute;
                            top: 6px;
                            right: -30px;

                        }

                    </style>
                </head>
                <body >
                    <div class="Reset"></div>
                    <div class="Reset-block">
                        <form id='Reset' style="margin-bottom:100px;"  action="?action=Reset&user_id=<?php echo  $user_id; ?>" method='post'
                              accept-charset='UTF-8'>
                            <h1>Reset Password</h1>
                            <input type="password" value="" name='reset_pass' placeholder="New Password"  />
                           <!-- <i class="show-pass fa fa-eye f-2x"> <img src="https://cdn0.iconfinder.com/data/icons/feather/96/eye-16.png" alt="eye" /></i> -->
                           <!-- <input type="password" value=""  name='password' placeholder="Password" id="password" required="required" /> -->
                            <button name="submit" value="submit">Reset</button>
                        </form>
                    </div>
                </body>

            </html>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $reset_pass = $_POST['reset_pass'];
                if (isset($reset_pass)) {
                    $hashed_pass = sha1($reset_pass);
                }
                $stmt = $conn->prepare("UPDATE users SET  User_Pass='$hashed_pass' WHERE User_ID='$user_id'  ");
                $stmt->execute(array($hashed_pass, $user_id));
                $count = $stmt->rowCount();
                if ($count > 0) {
                    echo "<script type='text/javascript'>alert('password Reset Successfully  ')</script>";
                }
            }
        }
        else{
            $user_id=0;
        }
    }
    else if ($action == 'Privilege') {
        ?>
        <html>
            <head>
                <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
                <meta charset="UTF-8">
                <style>
                    body {

                        background-size: cover;
                        font-family: Montserrat;
                    }

                    .privilege-block {
                        width: 430px;
                        padding: 20px;
                        background: #fff;
                        border-radius: 5px;
                        border-top: 5px solid #ff656c;
                        margin: 0 auto;
                        margin-top: 110px;
                    }

                    .privilege-block h1 {
                        text-align: center;
                        color: #000;
                        font-size: 18px;
                        text-transform: uppercase;
                        margin-top: 0;
                        margin-bottom: 20px;
                    }

                    .privilege-block input {
                        width: 100%;
                        height: 42px;
                        box-sizing: border-box;
                        border-radius: 5px;
                        border: 1px solid #ccc;
                        margin-bottom: 20px;
                        font-size: 14px;
                        font-family: Montserrat;
                        padding: 0 20px 0 50px;
                        outline: none;
                    }
                    .privilege-block select {
                        width: 100%;
                        height: 42px;
                        box-sizing: border-box;
                        border-radius: 5px;
                        border: 1px solid #ccc;
                        margin-bottom: 20px;
                        font-size: 14px;
                        font-family: Montserrat;
                        padding: 0 20px 0 50px;
                        outline: none;
                    }


                    .privilege-block input:active, .Reset-block input:focus {
                        border: 1px solid #ff656c;
                    }

                    .privilege-block button {
                        width: 100%;
                        height: 40px;
                        background: #ff656c;
                        box-sizing: border-box;
                        border-radius: 5px;
                        border: 1px solid #e15960;
                        color: #fff;
                        font-weight: bold;
                        text-transform: uppercase;
                        font-size: 14px;
                        font-family: Montserrat;
                        outline: none;
                        cursor: pointer;
                    }

                    .privilege-block button:hover {
                        background: #ff7b81;
                    }


                </style>
            </head>
            <body >
                <div class="privilege"></div>
                <div class="privilege-block">
                    <form id='privilege' style="margin-bottom:100px;"  action="?action=set_privilege" method='post'
                          accept-charset='UTF-8'>
                        <h1>Set Privilege</h1>
                        <select  value="" name='G_Name' placeholder="G_Name " id="G_Name" >
                            <option value="">Select Group </option><?php
                            $stmt7 = $conn->prepare("SELECT GName FROM groups    ");
                            $stmt7->execute();
                            $row7 = $stmt7->fetchAll();
                            // global $row;
                            $count7 = $stmt7->rowCount();
                            if ($count7 > 0) {
                                foreach ($row7 as $row)
                                {
                                    ?>
                                    <option value="<?php echo $row['GName']; ?>"><?php echo $row['GName']; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <select  value="" name='page' placeholder="page " id="G_Name" >
                            <option value="">Select Page </option><?php foreach (glob("*.php") as $filename) { ?>

                                <option value="<?php echo $filename; ?> "> <?php echo $filename; ?></option>
                                <?php
                            }
                            ?>
                        </select>

                        <input type="text" value=""  name='page_name' placeholder="page name" id="page_name" required="required" />
                                                      <!-- <input type="password" value=""  name='password' placeholder="Password" id="password" required="required" /> -->

                        <button name="submit" value="submit">Set Privilege</button>

                    </form>
                </div>
            </body>

        </html>
        <?php
    }
    else if ($action == 'set_privilege')
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $G_Name = $_POST['G_Name'];
            $page = $_POST['page'];
            $page_name = $_POST['page_name'];

            if ($G_Name == 'IT') {
                $G_ID = '1';
                $q = "INSERT INTO djv_access_tbl(G_ID,Acc_Name,Acc_Desc) VALUES ('$G_ID','$page','$page_name')";
                $conn->exec($q);
                echo "<script type='text/javascript'>alert('Privilege Set Successfuly ')</script>";
            } else if ($G_Name == 'hr') {
                $G_ID = '2';
                $q = "INSERT INTO djv_access_tbl(G_ID,Acc_Name,Acc_Desc) VALUES ('$G_ID','$page','$page_name')";
                $conn->exec($q);
                echo "<script type='text/javascript'>alert('Privilege Set Successfuly ')</script>";
            } else if ($G_Name == 'cs') {
                $G_ID = '3';
                $q = "INSERT INTO djv_access_tbl(G_ID,Acc_Name,Acc_Desc) VALUES ('$G_ID','$page','$page_name')";
                $conn->exec($q);
                echo "<script type='text/javascript'>alert('Privilege Set Successfuly ')</script>";
            } else if ($G_Name == 'admin') {
                $G_ID = '4';
                $q = "INSERT INTO djv_access_tbl(G_ID,Acc_Name,Acc_Desc) VALUES ('$G_ID','$page','$page_name')";
                $conn->exec($q);
                echo "<script type='text/javascript'>alert('Privilege Set Successfuly ')</script>";
            } else if ($G_Name == 'TManagers') {
                $G_ID = '5';
                $q = "INSERT INTO djv_access_tbl(G_ID,Acc_Name,Acc_Desc) VALUES ('$G_ID','$page','$page_name')";
                $conn->exec($q);
                echo "<script type='text/javascript'>alert('Privilege Set Successfuly ')</script>";
            } else if ($G_Name == 'ITUsers') {
                $G_ID = '6';
                $q = "INSERT INTO djv_access_tbl(G_ID,Acc_Name,Acc_Desc) VALUES ('$G_ID','$page','$page_name')";
                $conn->exec($q);
                echo "<script type='text/javascript'>alert('Privilege Set Successfuly ')</script>";
            } else if ($G_Name == 'Stores') {
                $G_ID = '7';
                $q = "INSERT INTO djv_access_tbl(G_ID,Acc_Name,Acc_Desc) VALUES ('$G_ID','$page','$page_name')";
                $conn->exec($q);
                echo "<script type='text/javascript'>alert('Privilege Set Successfuly ')</script>";
            } else if ($G_Name == 'Stock') {
                $G_ID = '8';
                $q = "INSERT INTO djv_access_tbl(G_ID,Acc_Name,Acc_Desc) VALUES ('$G_ID','$page','$page_name')";
                $conn->exec($q);
                echo "<script type='text/javascript'>alert('Privilege Set Successfuly ')</script>";
            } else {
                echo"Please Select Group";
            }
        }
    } elseif ($action == 'Logs') {
        ?>
        <html>
            <head>
                <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
                <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
                <script src="//cdn.jsdelivr.net/webshim/1.14.5/polyfiller.js"></script>
                <script>
                    webshims.setOptions('forms-ext', {types: 'date'});
                    webshims.polyfill('forms forms-ext');
                    $.webshims.formcfg = {
                        en: {
                            dFormat: '/',
                            dateSigns: '/',
                            patterns: {
                                d: "yy/mm/dd"
                            }
                        }
                    };
                </script>
                <meta charset="UTF-8">
                <style>
                    body {

                        background-size: cover;
                        font-family: Montserrat;
                    }

                    .Logs-block {
                        width: 430px;
                        padding: 20px;
                        background: #fff;
                        border-radius: 5px;
                        border-top: 5px solid #ff656c;
                        margin: 0 auto;
                        margin-top: 110px;
                    }

                    .Logs-block h1 {
                        text-align: center;
                        color: #000;
                        font-size: 18px;
                        text-transform: uppercase;
                        margin-top: 0;
                        margin-bottom: 20px;
                    }

                    .Logs-block input {
                        width: 100%;
                        height: 42px;
                        box-sizing: border-box;
                        border-radius: 5px;
                        border: 1px solid #ccc;
                        margin-bottom: 20px;
                        font-size: 14px;
                        font-family: Montserrat;
                        padding: 0 20px 0 50px;
                        outline: none;
                    }

                    .Logs-block input:active, .Reset-block input:focus {
                        border: 1px solid #ff656c;
                    }

                    .Logs-block button {
                        width: 100%;
                        height: 40px;
                        background: #ff656c;
                        box-sizing: border-box;
                        border-radius: 5px;
                        border: 1px solid #e15960;
                        color: #fff;
                        font-weight: bold;
                        text-transform: uppercase;
                        font-size: 14px;
                        font-family: Montserrat;
                        outline: none;
                        cursor: pointer;
                    }
                    .Logs-block button:hover {
                        background: #ff7b81;
                    }
                    table th {text-align:center}
                    table.center{
                        margin-left:auto;
                        margin-right:auto;
                    }
                </style>
            </head>
            <body >
                <div class="Logs"></div>
                <div class="Logs-block">
                    <form id='Logs' style="margin-bottom:100px;"  action="?action=Show_Logs" method='post'
                          accept-charset='UTF-8'>
                        <h1>Logs Filter</h1>
                        <label>From</label>
                        <input type="date" value=""  name='from' placeholder="Date From" id="from"  />
                        <label>To</label>
                        <input type="date" value=""  name='to' placeholder="Date to" id="to"  />
                        <!-- <input type="password" value=""  name='password' placeholder="Password" id="password" required="required" /> -->
                        <button name="submit" value="submit">Show Logs</button>
                    </form>
                </div>
            </body>

        </html>

        <?php
    }
    elseif ($action == 'Show_Logs')
    {
        ?>
        <head>
            <link rel="stylesheet" href="css/table.css" />
            <style>
                table th {text-align:center}
                table.center{
                    margin-left:auto;
                    margin-right:auto;
                }
            </style></head>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            // collect value of input field
            echo "<br><br>";
            $DateFrom = $_POST['from'];
            $DateTo = $_POST['to'];
            $from = str_replace('-', '/', $DateFrom);
            $to = str_replace('-', '/', $DateTo);
            if (isset($DateFrom) && isset($DateTo))
            {
                $stmt = $conn->prepare("SELECT log_datestr,log_timestr,log_userName,log_IP,log_access,log_app FROM djv_logs WHERE log_datestr BETWEEN '$from' AND '$to'  ORDER BY log_datestr DESC ,log_timestr DESC ");
                $stmt->execute(array($from, $to));
            }
            if (empty($DateFrom) && empty($DateTo))
            {
                $stmt = $conn->prepare("SELECT log_datestr,log_timestr,log_userName,log_IP,log_access,log_app FROM djv_logs ORDER BY log_datestr DESC ,log_timestr DESC ");
                $stmt->execute();
            }
            $count = $stmt->rowCount();
            if ($count > 0)
            {
                echo "<table class='center'  width='700 '>\n";
                echo "<thead>";
                echo "<tr>\n";
                echo "<th  > Date  </th>";
                echo "<th > Time </th>";
                echo "<th >Username </th>";
                echo "<th >Loge_IP </th>";
                echo "<th > Log_Access</th>";
                echo "<th > Log_App</th>";
                echo "</thead>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    echo "<tr >\n";
                    foreach ($row as $item)
                    {
                        echo " <td  >  " . $item . "</td>\n";
                    }
                    echo "</tr>\n";
                }
                echo "</table>\n";
            }
            else {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <h1 align="center" font-size="4em"> There Is No Data  </h1>
                    </div></div>
                <?php
            }
        }
    }
    else {
        echo "You can't access";
    }
}
else if (!isset($_SESSION['U_Name']))
{
    echo "You don't have a permision to access this page " . " Please Login First ";
    header("refresh:3;url=login.php");
}

if (isset($_SESSION['U_Name']) && $_SESSION['G_Name'] != 'admin')
{
    header('location:Home.php');
}
?>
<script type="text/javascript">

    $('.delete_row').click(function(){
        return confirm("Are you sure you want to delete?");
    });
</script>
