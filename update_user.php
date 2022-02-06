<?php
include 'NavBar.php';
include 'db_connection.php';
include 'error_handler.php';
error();
ini_set('display_errors', 0);
if (isset($_SESSION['U_Name']) && $_SESSION['G_Name'] == 'admin')
{
    $user_id="";
    if(isset($_GET['User_ID']) && isset($_GET['G_Name']) && isset($_GET['User_Dept']) && isset($_GET['User_Name']) && isset($_GET['Full_Name']))
    {
        $user_id = $_GET['User_ID'];
        $User_Dept = $_GET['User_Dept'];
        $G_Name = $_GET['G_Name'];
        $User_Name = $_GET['User_Name'];
        $Full_Name = $_GET['Full_Name'];
        $q = "SELECT * FROM `users` WHERE `User_ID`= $user_id LIMIT 1";
        $user_stmt = $conn->prepare($q);
        $user_stmt->execute();
        $user_row = $user_stmt->fetch();
    }
    echo "Welcome" . "  " . $_SESSION['U_Name'] ."<br>";
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $success ="";
        $G_ID = '';
        $User_Dept = $_POST['User_Dept'];
        $G_Name = $_POST['G_Name'];
        $user_id = $_POST['id'];
        $storeCode =$_POST['Store_Code'];
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        if (empty($User_Dept) || empty($G_Name))
        {
            echo "record is empty";
        }
        else {
            try
            {
                $q = "UPDATE users SET User_name='$username', G_Name='$G_Name',User_Dept ='$User_Dept'
                 ,Store_Code='$storeCode' ,full_name ='$fullname'
                 WHERE User_ID=$user_id";
                $get_stmt = $conn->prepare($q);
                // careful, without a LIMIT this can take long if your table is huge
                $get_stmt->execute();
                echo "<script type='text/javascript'>alert('User is Updated successfully .')</script>";
            }
            catch (Exception $exception)
            {
                echo $exception;
            }
        }
        if ($G_Name == 'IT')
        {
            $G_ID = '1';
            $stmt2 = $conn->prepare("UPDATE users SET  GID='$G_ID' WHERE User_ID='$user_id'  ");
            $stmt2->execute(array($$G_ID));
        }
        if ($G_Name == 'hr') {
            $G_ID = '2';
            $stmt2 = $conn->prepare("UPDATE users SET  GID='$G_ID' WHERE User_ID='$user_id'  ");
            $stmt2->execute(array($$G_ID));
        }
        if ($G_Name == 'cs') {
            $G_ID = '3';
            $stmt2 = $conn->prepare("UPDATE users SET  GID='$G_ID' WHERE User_ID='$user_id'  ");
            $stmt2->execute(array($$G_ID));
        }
        if ($G_Name == 'admin') {
            $G_ID = '4';
            $stmt2 = $conn->prepare("UPDATE users SET  GID='$G_ID' WHERE User_ID='$user_id'  ");
            $stmt2->execute(array($$G_ID));
        }
        if ($G_Name == 'TManagers') {
            $G_ID = '5';
            $stmt2 = $conn->prepare("UPDATE users SET  GID='$G_ID' WHERE User_ID='$user_id'  ");
            $stmt2->execute(array($$G_ID));
        }
        if ($G_Name == 'ITUsers') {
            $G_ID = '6';
            $stmt2 = $conn->prepare("UPDATE users SET  GID='$G_ID' WHERE User_ID='$user_id'  ");
            $stmt2->execute(array($$G_ID));
        }
        if ($G_Name == 'Stores') {
            $G_ID = '7';
            $stmt2 = $conn->prepare("UPDATE users SET  GID='$G_ID' WHERE User_ID='$user_id'  ");
            $stmt2->execute(array($$G_ID));
        }
        if ($G_Name == 'Stock') {
            $G_ID = '8';
            $stmt2 = $conn->prepare("UPDATE users SET  GID='$G_ID' WHERE User_ID='$user_id'  ");
            $stmt2->execute(array($$G_ID));
        }
        if ($G_Name == 'AreaManager') {
            $G_ID = '9';
            $stmt2 = $conn->prepare("UPDATE users SET  GID='$G_ID' WHERE User_ID='$user_id'  ");
            $stmt2->execute(array($$G_ID));
        }
        echo '<script type="text/javascript">'.
        "window.location = 'update_user.php?User_ID=$user_id&G_Name=$G_Name&User_Dept=$User_Dept&User_Name=$username';"
        .'</script>';
    }
    ?>
    <html>
        <body>
            <!DOCTYPE html>
            <html>
            <head>
                <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
                <meta charset="UTF-8">
                <title>Finance Master-Update</title>
                <style>
                    body {
                        background: url('http://i.imgur.com/Eor57Ae.jpg') no-repeat fixed center center;
                        background-size: cover;
                        font-family: Montserrat;
                    }
                    .register {
                        width: 213px;
                        height: 36px;

                        margin: 30px auto;
                    }
                    .Registration-block {
                        width: 430px;
                        padding: 20px;
                        background: #fff;
                        border-radius: 5px;
                        border-top: 5px solid #ff656c;
                        margin: 0 auto;
                    }

                    .Registration-block h1 {
                        text-align: center;
                        color: #000;
                        font-size: 18px;
                        text-transform: uppercase;
                        margin-top: 0;
                        margin-bottom: 20px;
                    }

                    .Registration-block input {
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
                    .Registration-block select {
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

                    .Registration-block input#username {
                        background: #fff url('http://i.imgur.com/u0XmBmv.png') 20px top no-repeat;
                        background-size: 16px 80px;
                    }

                    .Registration-blockk input#username:focus {
                        background: #fff url('http://i.imgur.com/u0XmBmv.png') 20px bottom no-repeat;
                        background-size: 16px 80px;
                    }

                    .Registration-block input#password {

                        /*//http://i.imgur.com/Qf83FTt.png*/

                            background: #fff url('http://i.imgur.com/Qf83FTt.png') 20px top no-repeat;
                            background-size: 16px 80px;
                    }

                    .Registration-block input#password:focus {
                            background: #fff url('http://i.imgur.com/Qf83FTt.png') 20px bottom no-repeat;
                            background-size: 16px 80px;
                    }

                    .Registration-block input:active, .login-block input:focus {
                            border: 1px solid #ff656c;
                    }

                    .Registration-block button {
                            width: 150px;
                            height: 40px;
                            box-sizing: border-box;
                            border-radius: 5px;
                            font-weight: bold;
                            text-transform: uppercase;
                            font-size: 14px;
                            font-family: Montserrat;
                            outline: none;
                            cursor: pointer;
                            position: relative;
                    }
                    .Registrationn-block button:hover {
                            background: #ff7b81;
                    }

                </style>
            </head>
            <div>
            <div class="register"></div>
                <div class="Registration-block">
                    <form id='Registration' action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post' accept-charset='UTF-8'>
                        <h1>Update</h1>
                        <input type="text" value="<?php echo $User_Name ?>" name='username' placeholder="Username" id="username" />
                        <input type="text" value="<?php echo $Full_Name ?>" name='fullname' placeholder="Fullname" id="fullname" />

                        <label>User Department </label>
                        <select class="it" value="" name='User_Dept'
                                placeholder="Select User Dept" id="User_Dept"  required="required">
                            <option value="">Select User Department</option>
                            <?php
                            $stmt3 = $conn->prepare("SELECT `id`, `department_name` FROM `departments`");
                            $stmt3->execute();
                            $row3 = $stmt3->fetchAll();
                            $count3 = $stmt3->rowCount();
                            if ($count3 > 0)
                            {
                                foreach ($row3 as $row)
                                {
                                    ?>
                                    <option value="<?php echo $row['department_name']  ?>"
                                        <?php
                                        if($User_Dept == $row['department_name'])
                                        {
                                            echo 'selected';
                                        }
                                        ?>
                                        ><?php echo $row['department_name']  ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <label>Group Name</label>
                        <select  value="" name='G_Name' placeholder="G_Name " id="G_Name" >
                            <option value="">Select Group Name</option>
                            <?php
                            $stmt3 = $conn->prepare("SELECT * FROM `groups`");
                            $stmt3->execute();
                            $row3 = $stmt3->fetchAll();
                            $count3 = $stmt3->rowCount();
                            ?>
                            <?php
                            if ($count3 > 0)
                            {
                                foreach ($row3 as $row)
                                {
                                    ?>
                                    <option value="<?php echo $row['GName']  ?>"
                                        <?php
                                        if($G_Name == $row['GName'])
                                        {
                                            echo 'selected';
                                        }
                                        ?>>  <?php echo $row['GName']  ?>
                                    </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                        <div class="row">
                            <div class="col-md-6">
                                <select class="it" value="" name='Store_Code_Select'
                                        placeholder="Receipt Store Code" id="Store_Code_Select">
                                    <option value="">Select Store Code</option>
                                    <?php
                                    $stmtstorecode = $conn->prepare("SELECT `sbs_no`, `store_no`, `store_code`,`store_name` FROM `branches`");
                                    $stmtstorecode->execute();
                                    $stmtstorecodeArray = $stmtstorecode->fetchAll();
                                    $count3 = $stmtstorecode->rowCount();
                                    if ($count3 > 0)
                                    {
                                        foreach ($stmtstorecodeArray as $row)
                                        {
                                            ?>
                                            <option value="<?php echo $row['store_code']  ?>">
                                                <?php echo $row['store_code']  ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" value="<?php echo $user_row['Store_Code']?>" name='Store_Code'
                                       placeholder="Store Code" id="Store_Code" />
                            </div>
                        </div>
                        <input type="hidden" value="<?php echo $user_id ?>" name='id' />
                        <div class="row" >
                            <div class="col-md-6">
                                <button class="register btn btn-primary">Submit</button>
                            </div>
                            <div class="col-md-6">
                                <button class="register btn btn-secondary"
                                        type="button" onclick="window.history.back()" >Back</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </body>
    </html>
    <?php
}
if (!isset($_SESSION['U_Name']))
{
    echo "You don't have a permision to access this page " . " , " . "Please Login First ";
    header("refresh:3;url=login.php");
}
?>
<br>
<script type="text/javascript">
    $(function()
    {
        <?php $stmtstorecodeArrayJson = json_encode($stmtstorecodeArray); ?>
        var array_code = <?php echo $stmtstorecodeArrayJson; ?>;
        $('#Store_Code_Select').on('change', function(event)
        {
            for (i = 0; i < array_code.length; i++)
            {
                if (this.value  == array_code[i]['2'])
                {
                    $("#Store_Code").val(array_code[i][2]);
                }
            }
        });
    });
</script>
