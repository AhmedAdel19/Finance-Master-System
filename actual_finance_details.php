<?php
include 'NavBar.php';
require_once 'db_connection.php';

if($_SESSION['G_Name'] == 'admin' || $_SESSION['G_Name'] == 'TOPManager' || $_SESSION['G_Name'] == 'IT' || $_SESSION['G_Name'] == 'finance' || $_SESSION['G_Name'] == "area_manager_b" || $_SESSION['G_Name'] == "TManagers" || $_SESSION['G_Name'] == 'Stores' || $_SESSION['G_Name'] == 'StoreManager')
{
    $access = 1;
}




$actionform = '';
$dsc_dtl_date ='';
$s_code ='';
$close_status ='';



if (isset($_GET['actionform'])) {$actionform = $_GET['actionform'];}
if (isset($_GET['dsc_dtl_date'])) {$dsc_dtl_date = $_GET['dsc_dtl_date'];}
if (isset($_GET['s_code'])) {$s_code = $_GET['s_code'];}
if (isset($_GET['close_status'])) {$close_status = $_GET['close_status'];}



if (isset($_SESSION['U_Name']))
{
    if ($access == 1)
    {
        $userid = $_SESSION['U_ID'];
        $username = $_SESSION['U_Name'];
        $pagename = 'Actual Finance Details';
        $pageapp = 'DejavuPortal';

        ?>
<html>
<div class="container">


    <head>
      <title>Finance Master-Details</title>

        <script src="js/jquery.fancybox.js"></script>

        <link rel="stylesheet" href="css/table2.css" />
        <style>
        div {
            display: block;
        }

        form {
            /* Just to center the form on the page */
            margin: 0 auto;
            /* width: 400px; */
            /* To see the outline of the form */
            padding: 1em;
            border: 4px solid #CCC;
            border-radius: 1em;
            color: #000;
        }

        form div+div {
            margin-top: 1em;
        }

        label {
            /* To make sure that all labels have the same size and are properly aligned */
            display: inline-block;
            /* width: 90px; */
            text-align: left;
        }

        input,
        select {
            /* To make sure that all text fields have the same font settings
                                   By default, textareas have a monospace font */
            font: 1em sans-serif;
            /* To give the same size to all text field */
            width: 300px;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            /* To harmonize the look & feel of text field border */
            border: 1px solid #999;
        }

        input:focus {
            /* To give a little highlight on active elements */
            border-color: #000;
        }

        .button {
            /* To position the buttons to the same position of the text fields */
            padding-left: 120px;
            /* same size as the label elements */
        }

        button {
            /* This extra margin represent roughly the same space as the space
                                   between the labels and their text fields */
            margin-left: .5em;
            width: 100px;
            color: #000;
        }

        #num {
            text-align: right;
        }

        table th {
            text-align: center
        }

        table.center {

            margin-left: auto;
            margin-right: auto;
        }

         button {
            width: 120px;
            height: 30px;
            background: #6c7ae0;
            box-sizing: border-box;
            border-radius: 5px;
            border: 1px solid #333;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
            font-family: Montserrat;
            outline: none;
            cursor: pointer;
            position: relative;
            left: 310px;
            }

            button:hover {
            background: #ff7b81;
            }

            .store {
        width: 230px;
    }

    .store-block {
        width: 1020px;
        /* padding: 20px; */
        /* background: #fff; */
        border-radius: 5px;
        border-top: 2px solid #315050;
        margin: 0 auto;
    }

    .store-block h1 {
        text-align: center;
        font-size: 17px;
        text-transform: uppercase;
        margin-top: 0;
        margin-bottom: 20px;
        background-color: aqua;
        padding: 15px;
        border-radius: 27px;
    }

    .h1_title {
        text-align: center;
        font-size: 17px;
        text-transform: uppercase;
        margin-top: 0;
        background-color: #e1e1ff;
        color: #3c3644;
        padding: 8px;
        border-radius: 27px;
        margin: 0 auto;
        width: 500px;
        margin-bottom: 10px;
    }

    .h1_title2 {
        text-align: center;
        font-size: 14px;
        text-transform: uppercase;
        margin-top: 0;
        background-color: #e1e1ff;
        color: #3c3644;
        padding: 3px;
        border-radius: 27px;
        margin: 0 auto;
        width: 200px;
        margin-bottom: 4px;
    }

    .store-block input {
        width: 150px;
        height: 30px;
        box-sizing: border-box;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        font-size: 14px;
        font-family: Montserrat;
        /* padding: 0 20px 0 50px; */
        outline: none;
        /* float: right; */
    }

    .store-block select {
        width: 150px;
        height: 30px;
        box-sizing: border-box;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        font-size: 14px;
        font-family: Montserrat;
        /* padding: 0 20px 0 50px; */
        outline: none;
        /* float: right; */
    }

    .store-block datalist {
        width: 180px;
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

    .store-block li {
        width: 230px;
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

    .store-block input:active,
    .store-block input:focus {
        border: 1px solid #ff656c;
    }

    .store-block select:active,
    .store-block select:focus {
        border: 1px solid #ff656c;
    }

    .store-block button {

        width: 120px;
        height: 30px;
        background: #6c7ae0;
        box-sizing: border-box;
        border-radius: 5px;
        border: 1px solid #333;
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 14px;
        font-family: Montserrat;
        outline: none;
        cursor: pointer;
        position: relative;
        left: 310px;
    }

    .storen-block button:hover {
        background: #ff7b81;
    }

    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    #loading-div-background {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        background: #fff;
        width: 100%;
        height: 100%;
    }

    #loading-div {
        width: 300px;
        height: 150px;
        background-color: #fff;
        text-align: center;
        font-size: 20px;
        font-family: 'arial';
        color: #202020;
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -150px;
        margin-top: -100px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        behavior: url("/css/pie/PIE.htc");
        /* HANDLES IE */
    }

    label {
        /* display: inline-block; */
        /* max-width: 100%; */
        margin-bottom: 1px;
        font-weight: 100;
    }

    body {
        background-image: url("pg.jpg");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
    }
    .h1_title {
        text-align: center;
        font-size: 17px;
        text-transform: uppercase;
        margin-top: 0;
        background-color: #e1e1ff;
        color: #3c3644;
        padding: 8px;
        border-radius: 27px;
        margin: 0 auto;
        width: 500px;
        margin-bottom: 10px;
    }
        </style>
    </head>

    <body bgcolor='#fff'>
        <?php if($actionform == 'show_details'){
            ?>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="h1_title" align="center" font-size="4em">Actual Finance Details </h4>
                    </div>
                </div>
            <?php

                $sting = "SELECT * FROM actual_financedsc_dtl WHERE d_date ='$dsc_dtl_date' AND dsc_store_code ='$s_code'";

                $stingDeduction = "SELECT * FROM actual_financedsc_exp WHERE d_date ='$dsc_dtl_date' AND dsc_store_code ='$s_code'";

                if ($sting != "")
                {
                    $stmt = $conn->prepare($sting);
                    $stmt->execute();
                }

                if ($stingDeduction != "")
                {
                    $stmt_d = $conn->prepare($stingDeduction);
                    $stmt_d->execute();
                }
                $count = $stmt->rowCount();
                $count_d = $stmt_d->rowCount();



            if ($count > 0)
            {
                echo "<table class='center' style='width: 100%;'>\n";
                echo "<tr style='line-height: 17px !important'>\n";
                echo "<th > Date </th>";
                echo "<th > Sales Type </th>";
                echo "<th > Visa CName </th>";
                echo "<th > Amount </th>";
                echo "<th > Note </th>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    echo "<tr>\n";
                    echo " <td  >" . $row['dtl_entry_date'] . "</td>";
                    echo " <td  >" . $row['dtl_sales_type'] . "</td>";
                    $type = $row['dtl_sales_type'];
                    if($type === "Visa"){
                        echo " <td  >" . $row['dtl_visa_cname'] . "</td>";
                    }else{
                        echo " <td  >----</td>";

                    }
                    echo " <td  >" .number_format($row['dtl_amt'] ,null,null,',') . "</td>";
                    echo " <td  >" . $row['dtl_note']  . "</td>";
                    echo "</tr>\n";
                }

                echo "</table>\n";
            }
            else {
                ?>
        <div class="row">
            <div class="col-md-12">
                <h1 align="center" font-size="4em">No DCS Details found</h1>
            </div>
        </div>
        <?php
            }

            if($count_d > 0){
                echo '<h4 align="center" font-size="4em">Deduction Details</h4>';
                echo "<table class='center' style='width: 100%;'>\n";
                echo "<tr style='line-height: 17px !important'>\n";
                echo "<th > Deduction Type </th>";
                echo "<th > Deduction Amount </th>";
                echo "<th > Description </th>";

                while ($row_d = $stmt_d->fetch(PDO::FETCH_ASSOC))
                {
                    echo "<tr>\n";
                    echo " <td  >" . $row_d['exp_type']  . "</td>";
                    echo " <td  >" .number_format($row_d['exp_amt'] ,null,null,',') . "</td>";
                    echo " <td  >" . $row_d['exp_desc']  . "</td>";
                    echo "</tr>\n";
                }

                echo "</table>\n";
            }

            if($_SESSION['G_Name'] == 'admin' || $_SESSION['G_Name'] == 'TOPManager' || $_SESSION['G_Name'] == 'IT' || $_SESSION['G_Name'] == 'finance'){
            ?>

    <button style="background-color:#ff656c;margin-left: 17%; margin-top: 3%;margin-bottom:2%;display:none;" type="button" name="close" id="close" value="close">Close</button>
    <button style="background-color:#315050;margin-left: 17%; margin-top: 3%;margin-bottom:2%;display:none;" type="button" name="unClose" id="unClose" value="unClose">unClose</button>
    <?php
            }
    ?>
</div>


</body>

</html>
<?php
        }else if($actionform == 'edit_dsc'){
            $sting_edit = "SELECT * FROM actual_financedsc_mst WHERE d_date ='$dsc_dtl_date' AND dsc_store_code ='$s_code'";
            if ($sting_edit != "")
            {
                $stmt_edit = $conn->prepare($sting_edit);
                $stmt_edit->execute();
                $row_edit = $stmt_edit->fetch();
            }
            ?>
            <div class="row">
                    <div class="col-md-12">
                        <h4 class="h1_title" align="center" font-size="4em">EDIT Actual Finance DSC</h4>
                    </div>
                </div>

            <div class="store"></div>
            <div class="store-block">
                <form method="post" style="background-color: #fff;padding: 15px;border-radius: 10px;" id="container_form"
                    enctype="multipart/form-data" action="<?php echo "?actionform=update_dsc"; ?>">
                    <div style="margin-left:6%" id="dsc_container" name="dsc_container">
                        <div class="row">
                            <div class="col-md-3">
                                <label style="margin-left:17%">DateTime</label>
                                <input style="float:initial;text-align:center" type="date" name='date_time_dsc' id="date_time_dsc" value="<?php echo $row_edit['d_date']?>" require readonly/>
                            </div>
                            <div class="col-md-3">
                                <label style="margin-left:15%">Store Code</label>
                                <input style="float:initial;text-align:center" type="text" name='store_code_dsc' value="<?php echo $row_edit['dsc_store_code']?>" id="store_code_dsc" readonly />

                            </div>

                            <div class="col-md-3">
                                <label style="margin-left:12%">Entry User</label>
                                <input style="float:initial;text-align:center" type="number" value="<?php echo $row_edit['dsc_entry_user']?>" name='NetDeposit_amt'
                                    placeholder="dsc_entry_user" id="dsc_entry_user" readonly />
                            </div>
                            <div class="col-md-3">
                                <label style="margin-left:2%">Cash In Branch</label>
                                <input style="width:133px;text-align:center" type="number" value="<?php echo $row_edit['dsc_cash_in_branch_amt']?>" name='cash_in_branch'
                                    placeholder="cash_in_branch" id="cash_in_branch"/>
                            </div>



                        </div>


                    </div>

                    <div style="margin-left:6%" id="dsc_container" name="dsc_container">
                        <div class="row">
                        <div class="col-md-3">
                                <label style="margin-left:15%">Cash B-Deposit</label>
                                <input placeholder="cash_in_branch_b_deposit" style="float:initial;text-align:center" type="text" value="<?php echo $row_edit['dsc_cash_in_branch_bdeposit']?>" name='cash_in_branch_b_deposit' id="cash_in_branch_b_deposit"  />

                            </div>

                            <div class="col-md-3">
                                <label style="margin-left:2%">NetDeposit Amount</label>
                                <input  style="width:133px;text-align:center" type="number" value="<?php echo $row_edit['dsc_net_deposite_amt']?>" name='NetDeposit_amt'
                                    placeholder="dsc_net_deposit_amt" id="dec_net_deposit_amt" />
                            </div>
                            <div class="col-md-3">
                                <label style="margin-left:15%">Cash A-Deposit</label>
                                <input placeholder="cash_in_branch_a_deposit" style="float:initial;text-align:center" type="text" value="<?php echo $row_edit['dsc_cash_in_branch_adeposit']?>" name='cash_in_branch_a_deposit' id="cash_in_branch_a_deposit"  />

                            </div>

                            <div class="col-md-3">
                                <label style="margin-left:6%">Total Cash Amount</label><br />
                                <input style="float:initial;text-align:center" type="number" value="<?php echo $row_edit['dsc_total_cash_amt']?>" name='dsc_total_cash_amt'
                                    placeholder="dsc_total_cash_amt" id="dsc_total_cash_amt"   />
                            </div>



                        </div>


                    </div>

                    <div style="margin-left:6%" id="dsc_container" name="dsc_container">
                        <div class="row">
                        <div class="col-md-3">
                                <label style="margin-left:6%">Total Visa Amount</label><br />
                                <input style="float:initial;text-align:center" type="number" value="<?php echo $row_edit['dsc_total_visa_amt']?>" name='dsc_total_visa_amt'
                                    placeholder="dsc_total_visa_amt" id="dsc_total_visa_amt"   />
                            </div>
                            <div class="col-md-3">
                                <label style="margin-left:12%">Total Amount</label><br />
                                <input style="float:initial;text-align:center" type="number" value="<?php echo $row_edit['dsc_total_amt']?>" name='dec_total_amt'
                                    placeholder="dsc_total_amt" id="dec_total_amt"   />
                            </div>

                            <div class="col-md-3">
                                <label style="margin-left:6%">T-Charge Amount</label><br />
                                <input style="float:initial;text-align:center" type="number" value="<?php echo $row_edit['dsc_total_charge_amt']?>" name='dsc_total_charge_amt'
                                    placeholder="total_charge_amt" id="dsc_total_charge_amt"   />
                            </div>
                            <div class="col-md-3">
                                <label style="margin-left:12%">Total Deduction</label><br />
                                <input style="float:initial;text-align:center" type="number" value="<?php echo $row_edit['dsc_total_deduction_amt']?>" name='dec_total_deduction'
                                    placeholder="dsc_total_deduction" id="dec_total_deduction"   />
                            </div>



                        </div>


                    </div>

                        <!-- <button  id="add_dsc_details" name="add_dsc_details">Add Details+</button> -->
                        <div style="margin-top:10px;margin-left: 5%;">
                            <button style="background-color:#315050;" type="submit" id="submit_1" name="submit_1">UPDATE</button>
                            <button style="background-color:#ff656c;" type="button" value="cancel"
                                onClick="window.location = 'Home.php';">Cancel</button>
                        </div>

                </form>
                <div id="loading-div-background">
                    <div id="loading-div" class="ui-corner-all">
                        <img style="height:150px;width:150px;margin:30px;" src="/image/please_wait.gif"
                            alt="Loading.." /><br>SAVING DATA. PLEASE WAIT...
                    </div>
                </div>
            </div>
        <?php

        }else if($actionform == 'update_dsc'){
            // Post Request form
            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                $cash_in = $_POST['cash_in_branch'];
                $cash_b = $_POST['cash_in_branch_b_deposit'];
                $cash_a = $_POST['cash_in_branch_a_deposit'];
                $netDeposit = $_POST['NetDeposit_amt'];
                $total_cash = $_POST['dsc_total_cash_amt'];
                $total_visa = $_POST['dsc_total_visa_amt'];
                $total_deduction = $_POST['dec_total_deduction'];
                $total_charge = $_POST['dsc_total_charge_amt'];
                $total_amt = $_POST['dec_total_amt'];
                $dsc_dtl_date_f = $_POST['date_time_dsc'];
                $s_code_f = $_POST['store_code_dsc'];



                try {

                    $sql_update = "UPDATE actual_financedsc_mst
                    SET
                    dsc_cash_in_branch_amt='$cash_in',
                    dsc_cash_in_branch_bdeposit='$cash_b',
                    dsc_cash_in_branch_adeposit='$cash_a',
                    dsc_net_deposite_amt='$netDeposit',
                    dsc_total_cash_amt='$total_cash',
                    dsc_total_visa_amt='$total_visa',
                    dsc_total_deduction_amt='$total_deduction',
                    dsc_total_charge_amt='$total_charge',
                    dsc_total_amt='$total_amt'
                    WHERE d_date ='$dsc_dtl_date_f' AND dsc_store_code ='$s_code_f'";
                    // echo $sql_update; die();

                    $stmt_update = $conn->prepare($sql_update);

                    $stmt_update->execute();

                    echo '<script language="javascript">';
                    echo 'alert("UPDATED successfully")';
                    echo '</script>';
                    echo '<script type="text/javascript">'.
                    "window.location = 'actual_finance_dsc_report.php';"
                    .'</script>';

                    } catch(PDOException $e) {
                    echo '<script language="javascript">';
                    echo 'alert("Error In Update Try Again!")';
                    echo '</script>';
                    echo '<script type="text/javascript">'.
                    "window.location = 'actual_finance_details.php?actionform=edit_dsc&dsc_dtl_date=$dsc_dtl_date_f&s_code=$s_code_f';"
                    .'</script>';
                  }

            }
            ?>
            <?php
        }
    }
    else
    {
        header('location:Home.php');
        exit();
    }

}
else if (!isset($_SESSION['U_Name']))
{
    echo "You don't have a permision to access this page " . " , " . "Please Login First ";
    header("refresh:3;url=login.php");
}
?>
<script type="text/javascript" src="js/jquery.min.js"></script>



<script type="text/javascript">

$(document).ready(function() {
    var close_status = "<?php echo $close_status; ?>";

    if(close_status === 'yes'){
        $("#unClose").css({
            display:'none'
        });
        $("#close").css({
            display:'initial'
        });
    }else if(close_status === 'no'){
        $("#unClose").css({
            display:'initial'
        });
        $("#close").css({
            display:'none'
        });
    }



});

$("#close").click(function() {
    var r = confirm("are you sure you want close this item!");
    if (r == true) {
        console.log("closed");

        var date = "<?php echo $dsc_dtl_date; ?>";
        var store_code = "<?php echo $s_code; ?>";

        var postData = 'date_to_close=' +date+ '&store_to_close=' + store_code;
        var formData2 = new FormData();
        formData2.append("inputClosedData", postData);
        $.ajax({
        url: "input.php?close",
        type: "POST",
        data: formData2,
        processData: false,
        contentType: false,
        success: function(data, status, xhr) {
            console.log(data);
            if(JSON.parse(data).message === "closedDone"){
                alert("Item Closed Successfully!");
                close_status = 'no';
                $("#unClose").css({
                display:'initial'
                });
                $("#close").css({
                    display:'none'
                });
                window.location = 'actual_finance_dsc_report.php';

            }else{
                alert("Item Failed Closed!");
            }
    },
    error: function(jqXHR, status, errorThrown) {
        alert("Failed TO Close This Item!");
    }
});

    }else{
        console.log("Not closed");

    }
});

$("#unClose").click(function() {
    var r = confirm("are you sure you want unClose this item!");
    if (r == true) {
            console.log("unClosed");

            var date = "<?php echo $dsc_dtl_date; ?>";
            var store_code = "<?php echo $s_code; ?>";

            var postData = 'date_to_close=' +date+ '&store_to_close=' + store_code;
            var formData2 = new FormData();
            formData2.append("inputClosedData", postData);
            $.ajax({
            url: "input.php?unClose",
            type: "POST",
            data: formData2,
            processData: false,
            contentType: false,
            success: function(data, status, xhr) {
                console.log(data);
                if(JSON.parse(data).message === "unClosedDone"){
                    alert("Item unClosed Successfully!");
                    close_status = 'yes';
                    $("#unClose").css({
                        display:'none'
                    });
                    $("#close").css({
                        display:'initial'
                    });
                    window.location = 'actual_finance_dsc_report.php';

                }else{
                    alert("Item Failed unClosed!");
                }
        },
        error: function(jqXHR, status, errorThrown) {
            alert("Failed TO Close This Item!");
        }
    });



    }else{
        console.log("Not unClosed");

    }
});
</script>
