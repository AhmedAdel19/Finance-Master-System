<?php
include 'NavBar.php';
include 'db_connection.php';
include 'error_handler.php';

error();
ini_set('display_errors', 0);

//session_start();
if (isset($_SESSION['U_Name']) && $_SESSION['G_Name'] == 'admin') {
    echo '<h4 style="color: #fff ; font-weight:bold ; font-size: 20px ; font-family: inherit ; text-align: center " >'. "Welcome" . "  " . $_SESSION['U_Name'] . "</h4>><br>";
    // header('location:logout.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // collect value of input field

        $success ="";
        $username = $_POST['username'];
        $userFullName = $_POST['fullName'];
        $password = $_POST['password'];
        $hashedpass = sha1($password);
        $G_ID = '';
        $Regional_Stores = $_POST['Regional_Stores'];
        $User_Dept = $_POST['User_Dept'];
        $G_Name = $_POST['G_Name'];
        $Store_Code=$_POST['Store_Code'];


        if (empty($username) || empty($password)  || empty($User_Dept) || empty($G_Name)) {
            echo "record is empty";
        } else {


            $stmt3 = $conn->prepare("SELECT * FROM  users WHERE User_name = '$username'");
            $stmt3->execute();
            $row3 = $stmt3->fetchAll();
            // global $row;
            $count3 = $stmt3->rowCount();

            if($count3 > 0){
                //echo "The username is already exist, please change the username.";
                echo "<script type='text/javascript'>alert('The username is already exist, please change the username.')</script>";

            }else{
                $time = date("H:i:s");
                $date = date("Y/m/d");

                $q = "INSERT INTO users(full_name,User_name,User_Pass,Regional_Stores,User_Dept,G_Name,Store_Code,created_date , created_time) VALUES ('$userFullName','$username','$hashedpass','$Regional_Stores','$User_Dept','$G_Name','$Store_Code','$date' , '$time')";
                $conn->exec($q);

                echo "<script type='text/javascript'>alert('New User is successfully Registered.')</script>";

            }



            // header('location:login.php');
           // $success =  'New User is successfully Registered.';
        }
        $stmt = $conn->prepare("SELECT MAX(User_ID) AS ID FROM users ");
        $stmt->execute();
        $row = $stmt->fetch();

        $user_id = $row['ID'];

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
    }
    ?>
    <html>
        <body>
            <form id='register' action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post' accept-charset='UTF-8'>
                <fieldset >
                    <html>
                        <head>
                            <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
                            <meta charset="UTF-8">

                            <title>Finance Master-Registration</title>
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
                                .Registration-block input#fullName {
                                    background: #fff url('http://i.imgur.com/u0XmBmv.png') 20px top no-repeat;
                                    background-size: 16px 80px;
                                }

                                .Registration-blockk input#fullName:focus {
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
                                        position: relative;


                                }

                                .Registrationn-block button:hover {
                                        background: #ff7b81;
                                }

                                </style>
                            </head>
                            <body>

                                <!-- <div class="register"></div> -->
                                <div class="Registration-block">

                                    <form id='Registration' action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'
                                          accept-charset='UTF-8'>

                                        <h1>Registration</h1>

                                        <input type="text" value="" name='fullName' placeholder="User full Name" id="fullName" />


                                        <input type="text" value="" name='username' placeholder="Username" id="username" />

                                        <input type="password" value=""  name='password' placeholder="Password" id="password" />
                                       <!-- <input type="text" value="" name='G_ID' placeholder="Group ID " id="G_ID" /> -->


                                        <select class="it" value="" name='User_Dept'
                                                placeholder="Select User Dept" id="User_Dept"  required="required">

                                            <option value="">Select User Department</option>

                                            <?php

                                            $stmt3 = $conn->prepare("SELECT `id`, `department_name` FROM `departments`");
                                            $stmt3->execute();
                                            $row3 = $stmt3->fetchAll();
                                            // global $row;
                                            $count3 = $stmt3->rowCount();


                                            if ($count3 > 0) {
                                                foreach ($row3 as $row) {
                                                    ?>

                                                    <option value="<?php echo $row['department_name']  ?>">  <?php echo $row['department_name']  ?> </option>

                                                    <?php
                                                }
                                            }
                                            ?>

                                            ?>


                                        </select>

<!--                                        <select  value="" name='G_Name' placeholder="G_Name " id="G_Name" >-->
<!--                                            <option value="">Select Group Name</option>-->
<!--                                            <option value="IT">IT</option>-->
<!--                                            <option value="hr">hr</option>-->
<!--                                            <option value="cs">cs</option>-->
<!--                                            <option value="admin">admin</option>-->
<!--                                            <option value="TManagers">TManagers</option>-->
<!--                                            <option value="ITUsers">ITUsers</option>-->
<!--                                            <option value="Stores">Stores</option>-->
<!--                                            <option value="Stock">Stock</option>-->
<!--                                            <option value="StoreManager">StoreManager</option>-->
<!--                                            <option value="AreaManager">AreaManager</option>-->
<!--                                        </select>-->

                                        <select  value="" name='G_Name' placeholder="G_Name " id="G_Name" >

                                            <option value="">Select Group Name</option>

                                            <?php
                                            $stmt3 = $conn->prepare("SELECT * FROM `groups`");
                                            $stmt3->execute();
                                            $row3 = $stmt3->fetchAll();
                                            // global $row;
                                            $count3 = $stmt3->rowCount();

                                            ?>

                                            <?php

                                            if ($count3 > 0) {
                                                foreach ($row3 as $row) {
                                                    ?>

                                                    <option value="<?php echo $row['GName']  ?>"

                                                        <?php
                                                        if($G_Name == $row['GName']){
                                                            echo 'selected';
                                                        }

                                                        ?>>  <?php echo $row['GName']  ?> </option>

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
                                                     $stmtstorecode = $conn->prepare("SELECT `sbs_no`, `store_no`, `store_code`, `store_name` FROM `branches`");
                                                    $stmtstorecode->execute();
                                                    $stmtstorecodeArray = $stmtstorecode->fetchAll();
                                                    // global $row;
                                                    $count3 = $stmtstorecode->rowCount();
                                                    if ($count3 > 0) {
                                                        foreach ($stmtstorecodeArray as $row) {
                                                            ?>
                                                            <option value="<?php echo $row['store_code']  ?>">
                                                                <?php echo $row['store_code']  ?> </option>
                                                            <?php

                                                        }
                                                    }
                                                    ?>

                                                </select>

                                            </div>

                                            <div class="col-md-6">

                                                <input type="text" value="" name='Store_Code' placeholder="Store Code" id="Store_Code" />

                                            </div>

                                        </div>

                                        <input type="text" value="" name='Regional_Stores' placeholder="Regional_Stores"
                                               id="Regional_Stores" />

                                        <div class="row" >

                                            <div class="col-md-6">
                                                <button class="register">Submit</button>

                                            </div>

                                        </div>

                                    </form>
                                </div>
                                <fieldset/>

            </form>

        </body>


    </html>

    <?php
}

if (!isset($_SESSION['U_Name'])) {

    echo "You don't have a permision to access this page " . " , " . "Please Login First ";
    header("refresh:3;url=login.php");
}
?>
                    <?php
                    if (isset($_SESSION['U_Name']) && $_SESSION['G_Name'] != 'admin') {

                        header('location:Home.php');
                    }

                    ?>

                    <script type="text/javascript">
                    // alert("this is regestration Page");
                        $(function() {

                            <?php
                            //$php_array = array('abc','def','ghi');
                            $stmtstorecodeArrayJson = json_encode($stmtstorecodeArray);
                            ?>
                            var array_code = <?php echo $stmtstorecodeArrayJson; ?>;
                            console.log(array_code);

                            $('#Store_Code_Select').on('change', function(event) {


                                // alert(this.value);

                                for (i = 0; i < array_code.length; i++) {

                                    //console.log(array_code[i]['period_fdate']);

                                    if (this.value  == array_code[i]['2']) {

                                    //    console.log(array_code[i][2]);

                                        // document.getElementById("toDate").style.display = "block";
                                        //document.getElementById("toDate").val ="ddd";
                                        //var st = "From " +"to";
                                        $("#Store_Code").val( array_code[i][2] );

                                        //console.log(array_code[i]['period_fdate']);
                                    }

                                }

                                //  console.log(array_code[this.value]['period_id']);
                                //  document.getElementById("").style.display = "block";
                                //  var foo = this.value();
                                //  document.getElementById("").value = "2014-02-09";

                            });
                        });
                    </script>
