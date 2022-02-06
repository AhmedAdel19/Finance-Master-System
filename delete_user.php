<?php
session_start();
include 'Config.php';
include 'db_connection.php';
if (isset($_SESSION['U_Name']))
{
    if ($_SESSION['G_Name'] == 'admin')
    {
        if (isset($_GET['User_ID']))
        {
            $User_ID  =  $_GET['User_ID'];
        }
        try {
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "DELETE FROM users WHERE User_ID=".$User_ID;
            // use exec() because no results are returned
            $conn->exec($sql);
            echo "Record deleted successfully";
            ?>
            <script type="text/javascript">
                window.location = "ManageUsers.php?action=Edit";
            </script>
            <?php
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;
        ?>
        <?php
    }
}
else if (
    !isset($_SESSION['U_Name']) && $_SESSION['G_Name'] != 'admin' || $_SESSION['G_Name'] != 'Stores' ||
    $_SESSION['G_Name'] != 'IT' || $_SESSION['G_Name'] != 'TManagers' ||
    $_SESSION['G_Name'] != 'StoreManager')
{
    header('location:Home.php');
}
else if (!isset($_SESSION['U_Name']))
{
    echo "You don't have a permision to access this page " . " , " . "Please Login First ";
    header("refresh:3;url=login.php");
}
?>
