<?php
include 'Config.php';
include 'db_connection.php';

?>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="css/charts.png" type="image/png">


</head>
<body>


        <!-- Brand and toggle get grouped for better mobile display -->
<nav class="navbar navbar-inverse">
  <div class="navbar-header">
      <a style="color:#fff;" class="navbar-brand active" href="Home.php">Finance Master System</a>
  </div>
    <div style="background-color: #222222;float:right;" class="container-fluid">

        <ul style="margin-right: 120px;" class="nav navbar-nav">
            <li class="active"><a href="Home.php">Home</a></li>
            <?php
            session_start();

            if (isset($_SESSION['U_Name']) && isset($_SESSION['G_Name']))
            {
                ///Admin
                if ( $_SESSION['G_Name'] == 'admin'  )
                {
                        ?>
                        <li class="active" class="active">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                Manage Users<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="registration.php">Add New Usre</a></li>
                                <li><a href="ManageUsers.php?action=Edit">Update User</a></li>
                            </ul>
                        </li>

                        <li class="active" class="active">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                Finance DSC<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="store_finance_dsc_master.php">Store Finance DSC</a></li>
                                <li><a href="actual_finance_dsc_report.php">DSC Report</a></li>
                            </ul>
                        </li>
                        <?php

                }
                ?>

                <?php
            }


            if (isset($_SESSION['U_Name']) && isset($_SESSION['G_Name']))
            {
                ///Admin
                if ( $_SESSION['G_Name'] == 'finance'  )
                {
                    ?>
                    <li class="active" class="active">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Finance DSC<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="store_finance_dsc_master.php">Store Finance DSC</a></li>
                            <li><a href="actual_finance_dsc_report.php">DSC Report</a></li>
                        </ul>
                    </li>

                    <?php
                }
            }



            // StoreManager
            if (isset($_SESSION['U_Name'])) {
                if($_SESSION['G_Name'] == 'StoreManager' ){
                  ?>


                      <li class="active">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Actual Finance DSC<span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li class="active" class="active"><a href="store_finance_dsc_master.php">Store Finance DSC</a></li>
                            <li><a href="actual_finance_dsc_report.php">DSC Report</a></li>
                        </ul>
                    </li>
                     <?php

                    }



            }



            //Stores
            if (isset($_SESSION['U_Name'])) {

                if($_SESSION['G_Name'] == 'Stores' ){

                    ?>

                    <li class="active">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Actual Finance DSC<span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li class="active" class="active"><a href="store_finance_dsc_master.php">Store Finance DSC</a></li>
                        </ul>
                    </li>

                    <?php
                }
            }
            ?>

        </ul>
        <ul style="margin-right: 30px;" class="nav navbar-nav ">
            <?php if (isset($_SESSION['U_Name'])) { ?>
                <i class="fas fa-sign-out-alt"></i>
                <li class="active">
                    <a href="logout.php">
                        Logout</a></li>
            <?php }
            ?>

        </ul>
    </div>
</nav>

</body>
</html>
