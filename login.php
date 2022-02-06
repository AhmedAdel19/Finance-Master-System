<?php
include 'Config.php';
include 'db_connection.php';
session_start();
// if (isset($_SESSION['U_Name'])) {
//     header('location:tickets_dashboard.php');
// }
date_default_timezone_set('Africa/Cairo');
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // collect value of input field
    $username = $_POST['username'];
    $password = $_POST['password'];
    $ip = $_POST['submit'];
    $time = date("H:i:s");
    $date = date("Y/m/d");
    $hashedpass = sha1($password);
    if (empty($username) || empty($password)) {
        echo "record is empty " . " ";
    }
    if (isset($username) && isset($password)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE User_name=? AND User_Pass =?");
        $stmt->execute(array($username, $hashedpass));
        $row = $stmt->fetch();
        // global $row;
        $count = $stmt->rowCount();
        $userid = $row['User_ID'];
    }


    if ($count > 0)
    {
        $_SESSION['U_Name'] = $username;
        $_SESSION['G_Name'] = $row['G_Name'];
        $_SESSION['U_ID']=$row['User_ID'];
        $_SESSION['S_Code']=$row['Store_Code'];
        $_SESSION['G_ID']=$row['GID'];
        $_SESSION['U_Type']=$row['type'];
        $_SESSION['U_UseDash']=$row['use_dashboard'];

        header('location:Home.php');
    }
    else {
        echo "Login Invalid , Please Login again";
    }
}
function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <meta charset="UTF-8">
        <title>Finance Master-login</title>
        <style>
            body {
                background-size: cover;
                font-family: Montserrat;
                background-color: #f6f6f6;
                background-image:url('/images/bg.jpg');
            }

            .logo {
                width: 500px;
                height: 180px;
                background: url('https://s30.postimg.org/kxflvssep/new.jpg');
                margin: 30px auto;
            }

            .login-block {
                width: 430px;
                padding: 20px;
                background: #fff;
                border-radius: 5px;
                border-top: 5px solid #0095ef;
                margin: 0 auto;
            }

            .login-block h1 {
                text-align: center;
                color: #1569C7;
                font-size: 18px;
                text-transform: uppercase;
                margin-top: 0;
                margin-bottom: 20px;
            }

            .login-block input {
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

            .login-block input#username {
                background: #fff url('http://i.imgur.com/u0XmBmv.png') 20px top no-repeat;
                background-size: 16px 80px;
            }

            .login-block input#username:focus {
                background: #fff url('http://i.imgur.com/u0XmBmv.png') 20px bottom no-repeat;
                background-size: 16px 80px;
            }

            .login-block input#password {
                background: #fff url('http://i.imgur.com/Qf83FTt.png') 20px top no-repeat;
                background-size: 16px 80px;
            }

            .login-block input#password:focus {
                background: #fff url('http://i.imgur.com/Qf83FTt.png') 20px bottom no-repeat;
                background-size: 16px 80px;
            }

            .login-block input:active, .login-block input:focus {
                border: 1px solid #0095ef;
            }

            .login-block button {
                width: 100%;
                height: 40px;
                background: #0095ef;
                box-sizing: border-box;
                border-radius: 5px;
                border: 1px solid #0095ef;
                color: #fff;
                font-weight: bold;
                text-transform: uppercase;
                font-size: 14px;
                font-family: Montserrat;
                outline: none;
                cursor: pointer;
            }
            .login-block button:hover {
                background: #1569C7;
            }

        </style>
    </head>

    <body >
        <div class="logo"><img src="/images/logo.png" width="350" height="283" /></div>
        <div class="login-block">
            <form id='Login' action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'
                  accept-charset='UTF-8'>
                <h1>Login</h1>
                <input type="text" value="" name='username' placeholder="Username" id="username" required="required"/>
                <input type="password" value=""  name='password' placeholder="Password" id="password" required="required" />

                <button name="submit" value="<?php echo get_client_ip(); ?>">Login</button>
            </form>
        </div>
    </body>
</html>
