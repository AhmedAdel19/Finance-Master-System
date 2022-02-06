<?php
include 'NavBar.php';
include 'error_handler.php';
error();
date_default_timezone_set('Africa/Cairo');

if ($_SESSION['G_Name'] == 'admin' || $_SESSION['G_Name'] == 'TOPManager' || $_SESSION['G_Name'] == 'IT' || $_SESSION['G_Name'] == 'finance' || $_SESSION['G_Name'] == "area_manager_b" || $_SESSION['G_Name'] == "TManagers" )
{
    $access = 1;
}
if($_SESSION['G_Name'] == 'Stores' || $_SESSION['G_Name'] == 'StoreManager')
{
    $access = 2;
}


if (isset($_SESSION['U_Name']))
{
    if ($access == 1 || $access == 2)
    {
        $store_code_action = $_SESSION["Store_Code"];

        $dateFrom ="";
        $dateTo="";
        $dateFromIn ="";
        $dateToIn="";
        $sting='';

        $all_total_sales = 0;
        $onl_amount = 0;

        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $DateFrom = $_POST['myDate'];
            $DateTo = $_POST['myDate2'];

            $dateFrom = str_replace('-', '/', $DateFrom);
            $dateTo = str_replace('-', '/', $DateTo);

            $dateFromIn = $DateFrom;
            $dateToIn = $DateTo;
            $select_store_code = $_POST['select_store_code'];
        }

        ?>
        <div >
            <div class="row">
                <div class="col-md-12">
                    <h4 align="center" font-size="4em">Actual Finance DSC Report </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <head>
                      <title>Finance Master-Report</title>

                        <script src="js/jquery.fancybox.js"></script>

                        <link rel="stylesheet" href="css/table2.css"/>
                        <style>
                            div {
                                display: block;
                            }
                            form {
                                /* Just to center the form on the page */
                                margin: 0 auto;
                                width: 400px;
                                /* To see the outline of the form */
                                padding: 1em;
                                border: 4px solid #CCC;
                                border-radius: 1em;
                                color: #000;
                            }
                            form div + div {
                                margin-top: 1em;
                            }
                            label {
                                /* To make sure that all labels have the same size and are properly aligned */
                                display: inline-block;
                                width: 90px;
                                text-align: left;
                            }
                            input,select {
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
                                padding-left: 120px; /* same size as the label elements */
                            }
                            button {
                                /* This extra margin represent roughly the same space as the space
                                   between the labels and their text fields */
                                margin-left: .5em;
                                width: 100px;
                                color:#000;
                            }
                            #num {
                                text-align: right;
                            }
                            table th {
                                text-align:center;
                                position: sticky;
                                top: 0;
                                }
                            table.center{

                                margin-left:auto;
                                margin-right:auto;
                            }

                            .button_close {
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

                                .button_close:hover {
                                background: #ff7b81;
                                }

                                .button_not_done {
                                    width: 255px;
                                    height: 30px;
                                    background: #222222;
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
                                }

                                .button_not_done:hover {
                                    background: #fff;
                                    color: #222222;
                                }

                        </style>
                    </head>
                    <body bgcolor='#fff'>
                    <form id='Filter By Date' action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post' accept-charset='UTF-8'>
                        <legend>Date Filter</legend>
                        <div style="height:33px;" >
                            <label for="From">From:</label>
                            <input type="date" id="From" name="myDate" value="<?php echo $dateFromIn ?>"  />
                        </div>

                        <div style="height:33px;" >
                            <label for="To">To:</label>
                            <input type="date" id="To" name="myDate2" value="<?php echo $dateToIn ?>" />
                        </div>
                            <div style="height:33px;" >
                                <label >Store:</label>
                                <?php if($_SESSION['G_Name'] == 'Stores' || $_SESSION['G_Name'] == 'StoreManager') { ?>
                                    <input type="text"  value="<?php echo $store_code_action ?>" readonly />

                                <?php
                                }else{
                                    ?>
                                <select value="<?php echo $select_store_code;?>" name='select_store_code' placeholder="Store Code">
                                    <option value="">Select Store</option>
                                    <?php

                                if($_SESSION['G_Name'] == "area_manager_b" || $_SESSION['G_Name'] == "TManagers" ){
                                    $username = $_SESSION['U_Name'];
                                    $regStoresStmt = $conn->prepare("SELECT  Regional_Stores FROM users WHERE User_name = '$username'  LIMIT 1");
                                    $regStoresStmt->execute();
                                    $regStoresRow = $regStoresStmt->fetch();
                                    $regStores = $regStoresRow['Regional_Stores'];
                                    echo "<h1>Hereeeee</h1>";
                                    var_dump('test Regional Stores',$regStores);
                                    $stmt2 = $conn->prepare("SELECT * FROM `branches` WHERE (store_no >= 0 AND store_no <= 99) AND store_type != 'InActive' AND store_no IN ($regStores) ORDER BY sort_option1 ASC");

                                }else{
                                    $stmt2 = $conn->prepare("SELECT * FROM `branches` WHERE (store_no >= 0 AND store_no <= 99) AND store_type != 'InActive' AND store_type != 'ONL' ORDER BY store_code ASC");
                                }

                                    $stmt2->execute();
                                    $row2 = $stmt2->fetchAll();
                                    $count2 = $stmt2->rowCount();
                                    $all_stores_array=array();
                                    if ($count2 > 0) {
                                        foreach ($row2 as $rowss)
                                        {
                                            array_push($all_stores_array,$rowss['store_code']);

                                            ?>
                                            <option value="<?php echo $rowss['store_code']; ?>"
                                                <?php
                                                $store_codeST = strtoupper($rowss['store_code']);
                                                if ($select_store_code == $store_codeST)
                                                {
                                                    echo 'selected';
                                                }
                                                ?>><?php echo $rowss['store_code']."   -   ".$rowss['store_name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <?php
                                }
                                ?>
                            </div>



                        <br><br>
                        <div class="button" style=" height:20px;">
                            <button type="submit" name='Submit'>Filter</button>
                        </div>
                    </form>
                    <br>
                    </body>
                </div>
            </div>
            <?php

                 if($access == 1){


                    $con = mysqli_connect("localhost","root","DejavuIt@150519","finance_dsc_db");
                    mysqli_set_charset($con , "utf8");
                    $finance_control_sql = "SELECT finance_control FROM users WHERE User_name = '$_SESSION[U_Name]' AND G_Name = '$_SESSION[G_Name]' LIMIT 1";
                    if($result_finance_control_sql = mysqli_query($con, $finance_control_sql)){
                    $f_control = $result_finance_control_sql->fetch_assoc()["finance_control"] ;
                    }
                if (!empty($DateFrom) && !empty($DateTo))
                {
                    if (!empty($select_store_code)) {
                        $sting = "SELECT * FROM actual_financedsc_mst
                                    WHERE (d_date BETWEEN '$dateFrom' AND '$dateTo')
                                    AND dsc_store_code ='$select_store_code' ";

                    } else {
                        if($_SESSION['G_Name'] == 'admin' || $_SESSION['G_Name'] == 'TOPManager' || $_SESSION['G_Name'] == 'IT' || $_SESSION['G_Name'] == 'finance'){

                            $sting = "SELECT * FROM actual_financedsc_mst
                                        WHERE (d_date BETWEEN '$dateFrom' AND '$dateTo') ";
                        }
                    }

                }
                else {
                    if (!empty($select_store_code)) {
                        $sting = "SELECT * FROM actual_financedsc_mst WHERE dsc_store_code ='$select_store_code' AND DATE(d_date) = CURDATE() - INTERVAL 1 DAY ";
                    } else {
                        if($_SESSION['G_Name'] == 'admin' || $_SESSION['G_Name'] == 'TOPManager' || $_SESSION['G_Name'] == 'IT' || $_SESSION['G_Name'] == 'finance'){

                            $sting = "SELECT * FROM actual_financedsc_mst WHERE DATE(d_date) = CURDATE() - INTERVAL 1 DAY  ";

                        }
                    }

                }

            //  echo $sting;die();
                if ($sting != "")
                {
                    $stmt = $conn->prepare($sting);
                    $stmt->execute();
                }
                $count = $stmt->rowCount();
            }else if($access == 2){

                if (!empty($DateFrom) && !empty($DateTo))
                {
                    $sting = "SELECT * FROM actual_financedsc_mst
                                WHERE (d_date BETWEEN '$dateFrom' AND '$dateTo')
                                AND dsc_store_code ='$store_code_action' ";
                }
                else {
                        $sting = "SELECT * FROM actual_financedsc_mst WHERE dsc_store_code ='$store_code_action' AND DATE(d_date) = CURDATE() - INTERVAL 1 DAY ";

                }

            //  echo $sting;die();
                if ($sting != "")
                {
                    $stmt = $conn->prepare($sting);
                    $stmt->execute();
                }
                $count = $stmt->rowCount();
            }



            if ($count > 0)
            {
                if (!empty($DateFrom) && !empty($DateTo))
                {
                    if ($_SESSION['G_Name'] == 'admin' || $_SESSION['G_Name'] == 'TOPManager' || $_SESSION['G_Name'] == 'IT' || $_SESSION['G_Name'] == 'finance'){
                        echo "
                        <button  class='button_close' style='background-color:#ff656c;margin-left: 13%; margin-top: 3%;margin-bottom:2%' type='button' name='closeRange' id='closeRange' value='closeRange'>Close</button>
                        <button class='button_close' style='background-color:#315050;margin-left: 10%; margin-top: 3%;margin-bottom:2%' type='button' name='unCloseRange' id='unCloseRange' value='unCloseRange'>unClose</button>";
                    }

                }

                $done_stores_array = array();

                // while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                // {
                //     array_push($done_stores_array,$row['dsc_store_code']);

                // }
                // var_dump($all_stores_array);
                // echo"<br/>";
                // var_dump($done_stores_array);
                echo "<h4 style='margin-left:2%'>Count : ".$count."</h4>";
                echo "<table class='center' style='width: 95%;margin-bottom: 2%'>\n";
                echo "<tr style='line-height: 17px !important'>\n";
                echo "<th > Date_Time </th>";
                echo "<th > Entry User </th>";
                echo "<th > Store Code </th>";
                echo "<th > Total Visa Amount </th>";
                echo "<th > Total Cash Amount </th>";
                echo "<th > Total Charge Amount </th>";

                echo "<th > Total Amount </th>";
                echo "<th >Total Deduction Amount </th>";
                echo "<th > Cash-B Deposit </th>";
                echo "<th > NetDeposit Amount </th>";
                echo "<th > Cash-A Deposit </th>";
                echo "<th > Deposit Receipt </th>";
                echo "<th > Note1 </th>";
                echo "<th > Note2 </th>";
                echo "<th > Details </th>";
                if($f_control == "yes"){
                    echo "<th > Edit </th>";
                }

                $all_total_visa_amt=0;
                $all_total_cash_amt=0;
                $all_total_charge_amt=0;
                $all_total_amt=0;
                $all_net_deposite_amt=0;
                $all_deduction_amt=0;
                $store_code='';
                $total_cash_in_branch =0;
                $done_stores_array_cash=[];

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    $stringSalesDate = $row['sales_date'];
                    $convert_Sales_date = str_replace('-', '/', $stringSalesDate);
                    echo "<tr>\n";
                    array_push($done_stores_array,$row['dsc_store_code']);
                    echo " <td  >" . $row['dsc_date'] . "</td>";
                    echo " <td  >" . $row['dsc_entry_user']  . "</td>";
                    echo " <td  >" . $row['dsc_store_code'] . "</td>";
                    echo " <td  >" .number_format($row['dsc_total_visa_amt'] ,null,null,',') . "</td>";
                    echo " <td  >" .number_format($row['dsc_total_cash_amt'] ,null,null,',') . "</td>";
                    echo " <td  >" .number_format($row['dsc_total_charge_amt'] ,null,null,',') . "</td>";
                    echo " <td  >" .number_format($row['dsc_total_amt'] ,null,null,',') . "</td>";
                    echo " <td  >" .number_format($row['dsc_total_deduction_amt'] ,null,null,',') . "</td>";
                    echo " <td  >" .number_format($row['dsc_cash_in_branch_bdeposit'] ,null,null,',') . "</td>";
                    echo " <td  >" .number_format($row['dsc_net_deposite_amt'] ,null,null,',') . "</td>";
                    echo " <td  >" .number_format($row['dsc_cash_in_branch_adeposit'] ,null,null,',') . "</td>";
                    $imageName =$row['TIMAGE1'];
                    echo " <td  ><img id='blah'  width='120' height='100' src='/dop_images/$imageName' alt='image1'  /></td>";
                    echo " <td  >" . $row['dsc_note1']  . "</td>";
                    echo " <td  >" . $row['dsc_note2']  . "</td>";

                    $rowId = $row['dsc_date'];
                    echo "<td> <a href='actual_finance_details.php?actionform=show_details&dsc_dtl_date=".$row['d_date']."&s_code=".$row['dsc_store_code']."&close_status=".$row['finance_closed']." ' class='btn btn-info'> Details </a> </td>";
                    if($f_control == "yes"){
                    echo "<td> <a href='actual_finance_details.php?actionform=edit_dsc&dsc_dtl_date=".$row['d_date']."&s_code=".$row['dsc_store_code']."&close_status=".$row['finance_closed']." ' class='btn btn-success'> Edit </a> </td>";
                    }


                    echo "</tr>\n";
                    if(!in_array($row['dsc_store_code'],$done_stores_array_cash)){
                        array_push($done_stores_array_cash,$row['dsc_store_code']);
                    }





                    $all_total_visa_amt =$all_total_visa_amt  +$row['dsc_total_visa_amt'];
                    $all_total_cash_amt = $all_total_cash_amt + $row['dsc_total_cash_amt'] ;
                    $all_total_charge_amt = $all_total_charge_amt + $row['dsc_total_charge_amt'] ;

                    $all_total_amt = $all_total_amt + $row['dsc_total_amt'] ;
                    $all_net_deposite_amt = $all_net_deposite_amt + $row['dsc_net_deposite_amt'] ;
                    $all_deduction_amt = $all_deduction_amt + $row['dsc_total_deduction_amt'] ;
                    $store_code = $row['dsc_store_code'];
                }



                echo "</table>\n";


                if (!empty($select_store_code)) {

                    $stmt_last_cash = $conn->prepare("SELECT dsc_cash_in_branch_amt FROM actual_financedsc_mst WHERE dsc_store_code = '$select_store_code' ORDER BY dsc_date DESC LIMIT 1");
                    $stmt_last_cash->execute();
                    $row_last_cash= $stmt_last_cash->fetch();

                    $last_cash = $row_last_cash['dsc_cash_in_branch_amt'];
                echo "
                <div style=' width: 70%;margin-left: 21%;'>
                    <div style='border-radius: 10px;padding: 2px;margin-right: 20%;border:1px solid #000;color: #fff ;text-align:center;background-color:#222222; font-family: Arial '>
                        <div style='width: 59%;display:inline-block;font-size: 18px;margin-right: 25%;'>Store Code </div>
                        <div style='max-width: 30%;display:inline-block;font-size: 18px;'>". $store_code."</div>
                    </div>
                    <div style='border-radius: 10px;padding: 2px;margin-right: 20%;border:1px solid #000;color: #000 ;text-align:center;background-color:#fff; font-family: Arial '>
                        <div style='width: 59%;display:inline-block;font-size: 18px;margin-right: 25%;'>Total Visa Amount </div>
                        <div style='max-width: 30%;display:inline-block;font-size: 18px;'>".number_format(  $all_total_visa_amt,null,null,',') ."</div>
                    </div>
                    <div style='border-radius: 10px;padding: 2px;margin-right: 20%;border:1px solid #000;color: #fff ;text-align:center;background-color:#222222; font-family: Arial '>
                        <div style='width: 59%;display:inline-block;font-size: 18px;margin-right: 25%;'>Total Cash Amount </div>
                        <div style='max-width: 30%;display:inline-block;font-size: 18px;'>".number_format(  $all_total_cash_amt,null,null,',') ."</div>
                    </div>
                <div style='border-radius: 10px;padding: 2px;margin-right: 20%;border:1px solid #000;color: #000 ;text-align:center;background-color:#fff; font-family: Arial '>
                    <div style='width: 59%;display:inline-block;font-size: 18px;margin-right: 25%;'>Total Charge Amount </div>
                    <div style='max-width: 30%;display:inline-block;font-size: 18px;'>".number_format( $all_total_charge_amt ,null,null,',') ."</div>
                </div>
                    <div style='border-radius: 10px;padding: 2px;margin-right: 20%;border:1px solid #000;color: #fff ;text-align:center;background-color:#222222; font-family: Arial '>
                        <div style='width: 59%;display:inline-block;font-size: 18px;margin-right: 25%;'>Total Amount </div>
                        <div style='max-width: 30%;display:inline-block;font-size: 18px;'>".number_format( $all_total_amt ,null,null,',') ."</div>
                    </div>

                    <div style='border-radius: 10px;padding: 2px;margin-right: 20%;border:1px solid #000;color: #000 ;text-align:center;background-color:#fff; font-family: Arial '>
                        <div style='width: 59%;display:inline-block;font-size: 18px;margin-right: 25%;'>Cash in Branch </div>
                        <div style='max-width: 30%;display:inline-block;font-size: 18px;'>".number_format( $last_cash  ,null,null,',') ."</div>
                    </div>
                    <div style='border-radius: 10px;padding: 2px;margin-right: 20%;border:1px solid #000;color: #fff ;text-align:center;background-color:#222222; font-family: Arial '>
                        <div style='width: 59%;display:inline-block;font-size: 18px;margin-right: 25%;'>Total Deduction Amount </div>
                        <div style='max-width: 30%;display:inline-block;font-size: 18px;'>".number_format( $all_deduction_amt ,null,null,',') ."</div>
                    </div>

                    <div style='border-radius: 10px;padding: 2px;margin-right: 20%;border:1px solid #000;color: #000 ;text-align:center;background-color:#fff; font-family: Arial '>
                        <div style='width: 59%;display:inline-block;font-size: 18px;margin-right: 25%;'>Total NetDeposit Amount </div>
                        <div style='max-width: 30%;display:inline-block;font-size: 18px;'>".number_format( $all_net_deposite_amt ,null,null,',') ."</div>
                    </div>
                    </div>
                ";
            }else{

                // var_dump($done_stores_array_cash);

                for($i=0;$i<count($done_stores_array_cash);$i++)
                {
                    $stmt_last_cash_all = $conn->prepare("SELECT dsc_cash_in_branch_amt FROM actual_financedsc_mst WHERE dsc_store_code = '$done_stores_array_cash[$i]' ORDER BY dsc_date DESC LIMIT 1");
                    $stmt_last_cash_all->execute();
                    $row_last_cash_all= $stmt_last_cash_all->fetch();

                    $last_cash_all = $row_last_cash_all['dsc_cash_in_branch_amt'];
                    $total_cash_in_branch = $total_cash_in_branch + $last_cash_all;
                    // echo $last_cash_all;

                }


            echo "
            <div style=' width: 70%;margin-left: 21%;'>
                <div style='border-radius: 10px;padding: 2px;margin-right: 20%;border:1px solid #000;color: #000 ;text-align:center;background-color:#fff; font-family: Arial '>
                    <div style='width: 59%;display:inline-block;font-size: 18px;margin-right: 25%;'>Total Visa Amount </div>
                    <div style='max-width: 30%;display:inline-block;font-size: 18px;'>".number_format(  $all_total_visa_amt,null,null,',') ."</div>
                </div>
                <div style='border-radius: 10px;padding: 2px;margin-right: 20%;border:1px solid #000;color: #fff ;text-align:center;background-color:#222222; font-family: Arial '>
                    <div style='width: 59%;display:inline-block;font-size: 18px;margin-right: 25%;'>Total Cash Amount </div>
                    <div style='max-width: 30%;display:inline-block;font-size: 18px;'>".number_format(  $all_total_cash_amt,null,null,',') ."</div>
                </div>
            <div style='border-radius: 10px;padding: 2px;margin-right: 20%;border:1px solid #000;color: #000 ;text-align:center;background-color:#fff; font-family: Arial '>
                <div style='width: 59%;display:inline-block;font-size: 18px;margin-right: 25%;'>Total Charge Amount </div>
                <div style='max-width: 30%;display:inline-block;font-size: 18px;'>".number_format( $all_total_charge_amt ,null,null,',') ."</div>
            </div>
                <div style='border-radius: 10px;padding: 2px;margin-right: 20%;border:1px solid #000;color: #fff ;text-align:center;background-color:#222222; font-family: Arial '>
                    <div style='width: 59%;display:inline-block;font-size: 18px;margin-right: 25%;'>Total Amount </div>
                    <div style='max-width: 30%;display:inline-block;font-size: 18px;'>".number_format( $all_total_amt ,null,null,',') ."</div>
                </div>

                <div style='border-radius: 10px;padding: 2px;margin-right: 20%;border:1px solid #000;color: #000 ;text-align:center;background-color:#fff; font-family: Arial '>
                    <div style='width: 59%;display:inline-block;font-size: 18px;margin-right: 25%;'>Cash in Branch </div>
                    <div style='max-width: 30%;display:inline-block;font-size: 18px;'>".number_format( $total_cash_in_branch  ,null,null,',') ."</div>
                </div>
                <div style='border-radius: 10px;padding: 2px;margin-right: 20%;border:1px solid #000;color: #fff ;text-align:center;background-color:#222222; font-family: Arial '>
                    <div style='width: 59%;display:inline-block;font-size: 18px;margin-right: 25%;'>Total Deduction Amount </div>
                    <div style='max-width: 30%;display:inline-block;font-size: 18px;'>".number_format( $all_deduction_amt ,null,null,',') ."</div>
                </div>

                <div style='border-radius: 10px;padding: 2px;margin-right: 20%;border:1px solid #000;color: #000 ;text-align:center;background-color:#fff; font-family: Arial '>
                    <div style='width: 59%;display:inline-block;font-size: 18px;margin-right: 25%;'>Total NetDeposit Amount </div>
                    <div style='max-width: 30%;display:inline-block;font-size: 18px;'>".number_format( $all_net_deposite_amt ,null,null,',') ."</div>
                </div>
                </div>
            ";
            }
           echo "<button style='margin-left: 39%;' class='button_not_done'  type='button' name='not_done_stores_btn' id='not_done_stores_btn'>Check not done Stores</button>";
          ?>
            <div class="not_done_stores_container" id="not_done_stores_container" style='margin-left: 44%;margin-top:10px;max-width:110px;
    background-color: #e1e3e6;padding:3px;border-radius: 10px;display:none'>
            <ul>
            <?php

            $filtered_stores_array = array();
            for($i=0;$i<count($all_stores_array);$i++)
            {
                if(!in_array($all_stores_array[$i],$done_stores_array)){
                    array_push($filtered_stores_array,$all_stores_array[$i]);
                }
            }
            foreach ($filtered_stores_array as $store) {
              ?>
              <h4><li><?php echo $store ?></li></h4>
              <?php
            }
            ?>
            </ul>
            </div>

          <?php




                // echo "<div style='background-color: #6c7ae0;max-width: 30%;padding: 2px; margin-left: 35%;margin-right: 20%'><h4 style='color: #000 ;text-align:center;background-color:#fff; font-family: Arial '>Total Visa Amount ; ". $all_total_visa_amt."</h4></div>";
                // echo "<div style='background-color: #6c7ae0;max-width: 30%;padding: 2px; margin-left: 35%;margin-right: 20%'><h4 style='color: #000 ;text-align:center;background-color:#fff; font-family: Arial '>Total Cash Amount ; ". $all_total_cash_amt."</h4></div>";
                // echo "<div style='background-color: #6c7ae0;max-width: 30%;padding: 2px; margin-left: 35%;margin-right: 20%'><h4 style='color: #000 ;text-align:center;background-color:#fff; font-family: Arial '>Total Amount ; ". $all_total_amt."</h4></div>";
                // echo "<div style='background-color: #6c7ae0;max-width: 30%;padding: 2px; margin-left: 35%;margin-right: 20%'><h4 style='color: #000 ;text-align:center;background-color:#fff; font-family: Arial '>Total NetDeposit Amount ; ". $all_net_deposite_amt."</h4></div>";
                // echo "<div style='background-color: #6c7ae0;max-width: 30%;padding: 2px; margin-left: 35%;margin-right: 20%'><h4 style='color: #000 ;text-align:center;background-color:#fff; font-family: Arial '>Total Deduction Amount ; ". $all_deduction_amt."</h4></div>";

            }
            else {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <h1 align="center" font-size="4em">No data found For This Period</h1>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
    else {
        header('location:Home.php');
    }
}
if (!isset($_SESSION['U_Name']))
{
    echo "You don't have a permision to access this page " . " , " . "Please Login First ";
    header("refresh:3;url=login.php");
}
?>
<script type="text/javascript">

    function delete_Request(id)
    {
        var  confirm2  = confirm("Are you sure?");
        if (confirm2)
        {
            event.preventDefault();
            url1 = 'request_delete.php?id=' +id;
            $.ajax
            ({
                type:'GET',
                url: url1,
                success: function (response)
                {
                    console.log(response);
                    alert("Request Successfully deleted.");
                    location.reload();
                },
                error: function (response)
                {
                    console.log(response);
                }
            });
        }
    }

    $("#not_done_stores_btn").click(function() {
        $("#not_done_stores_container").css({"margin-left":"44%" , "margin-top":"10px","max-width":"110px","background-color": "#e1e3e6","padding":"3px","border-radius": "10px","display":"list-item"});
    });
    $("#closeRange").click(function() {
    var r = confirm("are you sure you want Close this Range!");
    if (r == true) {
            console.log("Closed");

            var dateCloseFrom = "<?php echo $DateFrom; ?>";
            var dateCloseTo = "<?php echo $DateTo; ?>";
            var storeClose = "<?php echo $select_store_code; ?>";

            var postData = 'date_close_from=' +dateCloseFrom+ '&date_close_to=' + dateCloseTo+ '&store_close=' + storeClose;
            var formData2 = new FormData();
            formData2.append("inputClosedRangeData", postData);
            $.ajax({
            url: "input.php?closeRange",
            type: "POST",
            data: formData2,
            processData: false,
            contentType: false,
            success: function(data, status, xhr) {
                console.log(data);
                if(JSON.parse(data).message === "ClosedRangeDone"){
                    alert("Range Closed Successfully!");
                    window.location = 'actual_finance_dsc_report.php';

                }else{
                    alert("Range Failed Closed!");
                }
        },
        error: function(jqXHR, status, errorThrown) {
            alert("Failed TO Close This Range!");
        }
    });



    }else{
        console.log("Range Not unClosed");

    }
});

$("#unCloseRange").click(function() {
    var r = confirm("are you sure you want unClose this Range!");
    if (r == true) {
            console.log("unClosed");

            var dateCloseFrom = "<?php echo $DateFrom; ?>";
            var dateCloseTo = "<?php echo $DateTo; ?>";
            var storeClose = "<?php echo $select_store_code; ?>";


            var postData = 'date_close_from=' +dateCloseFrom+ '&date_close_to=' + dateCloseTo+ '&store_close=' + storeClose;
            var formData2 = new FormData();
            formData2.append("inputClosedRangeData", postData);
            $.ajax({
            url: "input.php?unCloseRange",
            type: "POST",
            data: formData2,
            processData: false,
            contentType: false,
            success: function(data, status, xhr) {
                console.log(data);
                if(JSON.parse(data).message === "unClosedRangeDone"){
                    alert("Range unClosed Successfully!");
                    window.location = 'actual_finance_dsc_report.php';

                }else{
                    alert("Range Failed unClosed!");
                }
        },
        error: function(jqXHR, status, errorThrown) {
            alert("Failed TO Close This Range!");
        }
    });



    }else{
        console.log("Range Not unClosed");

    }
});
</script>
