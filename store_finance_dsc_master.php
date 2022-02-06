<?php
include 'NavBar.php';

require_once 'db_connection.php';

$sbs_no =1;



date_default_timezone_set('Africa/Cairo');
$time = date("H:i:s");
$date = date("Y-m-d");
if($_SESSION['G_Name'] == 'admin' || $_SESSION['G_Name'] == 'TOPManager' || $_SESSION['G_Name'] == 'IT' || $_SESSION['G_Name'] == 'finance')
{
    $access = 1;
}

if($_SESSION['G_Name'] == 'Stores' || $_SESSION['G_Name'] == 'StoreManager')
{
    $access = 2;
}
// var_dump($_SESSION);

if (isset($_SESSION['U_Name']))
{
    if ($access == 1 || $access == 2)
    {
        $userid = $_SESSION['U_ID'];
        $username = $_SESSION['U_Name'];
        $pagename = 'Store Finance Dsc Master';
        $pageapp = 'DejavuPortal';
        $insert_statement =  '';
        $rcvd_status = '';
        $str_code = $_SESSION['S_Code'];
        //echo "str_code".$str_code ;
        $stmt6 = $conn->prepare("SELECT store_code,store_name FROM branches WHERE store_code='$str_code' ");
        $stmt6->execute(array($str_code));
        $row6 = $stmt6->fetch();
        $store_code = $row6['store_code'];
        $store_name = $row6['store_name'];
        // setlogpage($userid, $username, $pagename, $pageapp);
        ?>
<html>

<head>




    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <meta charset="UTF-8">
    <title>Finance Master-store</title>

    <style>
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
        /* background-image: url("pg.jpg"); */
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
    }
    </style>

    <script type="text/javascript" src="js/jquery.min.js"></script>


</head>

<body>
    <h1 class="h1_title">Store Actual Finance Dsc Master</h1>

    <div class="store"></div>
    <div class="store-block">
        <form style="background-color: #fff;padding: 15px;border-radius: 10px;" id="container_form"
            enctype="multipart/form-data" onsubmit="return false">
            <div style="margin-left:6%" id="dsc_container" name="dsc_container">
                <div class="row">
                    <div class="col-md-3">
                        <label style="margin-left:17%">DateTime</label>
                        <input style="float:initial;" type="date" name='date_time_dsc' id="date_time_dsc" require />
                    </div>
                    <div class="col-md-3">
                        <label style="margin-left:15%">Store Code</label>
                        <input style="float:initial;" type="text" name='store_code_dsc' id="store_code_dsc" readonly />

                    </div>
                    <div class="col-md-3">
                        <label style="margin-left:2%">Cash In Branch</label>
                        <input style="width:133px" type="number" value="" name='cash_in_branch'
                            placeholder="cash_in_branch" id="cash_in_branch" readonly/>
                    </div>

                    <div class="col-md-3">
                        <label style="margin-left:2%">NetDeposit Amount</label>
                        <input style="width:133px" type="number" value="" name='NetDeposit_amt'
                            placeholder="dsc_net_deposit_amt" id="dec_net_deposit_amt" />
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-3">
                        <label style="margin-left:26%">Deposit Receipt </label>
                        <input style="width:200px" type="file" name="image[]" id="image" onchange="readURL(this);" />
                    </div>

                    <div class="col-md-3">
                        <label style="margin-left:26%">Note1</label>
                        <input type="text" value="" name='note1' placeholder="note1" id="note1" />
                    </div>

                    <div class="col-md-3">
                        <label style="margin-left:26%">Note2</label>
                        <input type="text" value="" name='note2' placeholder="note2" id="note2" />
                    </div><br>
                    <div style="width: 250px;margin-left: 35%;">
                        <img id="blah" width="200" height="150" src="#" alt="image1" style="display: none" />
                    </div>


                </div>

            </div>
            <!-- <hr style="border-top: 2px solid #ff656c;margin-bottom: 0px;" width="50%" size="10" color="red"/> -->

            <div>
                <!-- <br> -->
                <!-- <h3 style="text-align:center">Add DSC Details</h3> -->




                <div style="background-color:#fff;padding: 10px;border:2px solid #315050;border-radius:10px;margin-bottom:5px;margin-top:5px;"
                    id="details_container" name="details_container">
                    <h4 class="h1_title2">DSC DETAILS</h4>
                    <div style="margin-left: 0px;" class="row">
                        <div class="col-md-3">
                            <label style="margin-left:45%">Sales Type </label>
                            <select style="float:right;" class="it" value="" name='sales_type' placeholder="sales_type"
                                id="sales_type" require>
                                <option value="">Select Type</option>
                                <option value="Visa">Visa</option>
                                <option value="Cash">Cash</option>
                            </select>
                        </div>
                        <div id="visa_name_container" style="display:none;" class="col-md-2">
                            <label style="margin-left:22%">Visa CName </label>
                            <select style="float:right;" class="it" value="" name='visa_cname' placeholder="visa_cname"
                                id="visa_cname">
                                <option value="">Select Visa</option>
                                <option value="QNB">QNB</option>
                                <option value="AHLY">AHLY</option>
                                <option value="CIB">CIB</option>

                            </select>
                        </div>

                        <div class="col-md-2">
                            <label style="margin-left:18%">Amount </label>
                            <input type="number" value="" name="amt" placeholder="amt" id="amt" />
                        </div>

                        <div class="col-md-2">
                            <label style="margin-left:18%">Note </label>
                            <input type="text" value="" name="note" placeholder="note" id="note" />
                        </div>
                        <div id="add_item_dev" style="margin-left: 164px;" class="col-md-2">
                            <button
                                style="margin-right: 5px;margin-top:17px;left:0px;width:100px;height:33px;background-color:#315050;"
                                name="add_item" id="add_item">Add</button>

                        </div>

                    </div>

                    <!-- <br /> -->
                    <div style="margin:10px;">
                        <table name="items_container" id="items_container">
                        </table>
                    </div>
                </div>

                <!-- FIRST OF DEDUCTION-->

                <div style="background-color:#fff;padding: 10px;border:2px solid #315050;border-radius:10px;margin-bottom:5px;margin-top:5px;"
                    id="deductions_container" name="deductions_container">
                    <h4 class="h1_title2">EXPENSE DETAILS</h4>
                    <div class="col-md-3">
                        <label style="margin-left:45%">Deduction Type </label>
                        <select style="float:right;" class="it" value="" name='exp_type' placeholder="expense_type"
                            id="exp_type" require>
                            <option value="">Deduction Type</option>
                            <option value="elecrticity">Elecrticity</option>
                            <option value="water">Water</option>

                        </select>
                    </div>

                    <div class="col-md-3">
                        <label style="margin-left:6%">Deduction Amount </label></br>
                        <input type="number" value="" name="d_amt" placeholder="Deduction Amount " id="d_amt" />
                    </div>

                    <div class="col-md-3">
                        <label style="margin-left:6%">Deduction Reason </label>
                        <textarea type="text" value="" name="d_r" placeholder="Deduction Reason" id="d_r"></textarea>
                    </div>
                    <div style="margin-left: 1%;" class="col-md-2">
                        <button
                            style="margin-right: 5px;margin-top:17px;left:0px;width:100px;height:33px;background-color:#315050;"
                            name="add_deduction_item" id="add_deduction_item">Add</button>

                    </div>


                    <!-- <br /> -->
                    <div style="margin:10px;">
                        <table name="deduction_items_container" id="deduction_items_container">
                        </table>
                    </div>
                </div>

                <!-- END OF DEDUCTION  -->
                <div style="margin-left:8%;margin-right:0px" class="row">
                    <div class="col-md-2">
                        <label style="margin-left:2%">Total Visa Amount</label><br />
                        <input style="text-align:center" type="number" value="" name='dsc_total_visa_amt'
                            placeholder="dsc_total_visa_amt" id="dsc_total_visa_amt" require readonly />
                    </div>
                    <div class="col-md-2">
                        <label style="margin-left:2%">T-Charge Amount</label><br />
                        <input style="text-align:center" type="number" value="" name='dsc_total_charge_amt'
                            placeholder="total_charge_amt" id="dsc_total_charge_amt" require readonly />
                    </div>

                    <div class="col-md-2">
                        <label style="margin-left:2%">Total Cash Amount</label><br />
                        <input style="text-align:center" type="number" value="" name='dsc_total_cash_amt'
                            placeholder="dsc_total_cash_amt" id="dsc_total_cash_amt" require readonly />
                    </div>
                    <div class="col-md-2">
                        <label style="margin-left:4%">Total Amount</label><br />
                        <input style="text-align:center" type="number" value="" name='dec_total_amt'
                            placeholder="dsc_total_amt" id="dec_total_amt" require readonly />
                    </div>
                    <div class="col-md-2">
                        <label style="margin-left:4%">Total Deduction</label><br />
                        <input style="text-align:center" type="number" value="" name='dec_total_deduction'
                            placeholder="dsc_total_deduction" id="dec_total_deduction" require readonly />
                    </div>

                </div>
                <!-- <button  id="add_dsc_details" name="add_dsc_details">Add Details+</button> -->
                <div style="margin-top:10px;margin-left: 5%;">
                    <button style="background-color:#315050;" type="submit" id="submit_1" name="submit_1">Save</button>
                    <button style="background-color:#ff656c;" type="button" value="cancel"
                        onClick="window.location = 'Home.php';">Cancel</button>
                </div>

        </form>
        <div id="loading-div-background">
            <div id="loading-div" class="ui-corner-all">
                <img style="height:150px;width:150px;margin:30px;" src="/images/please_wait.gif"
                    alt="Loading.." /><br>SAVING DATA. PLEASE WAIT...
            </div>
        </div>
    </div>
</body>

<script type="text/javascript">
var total_cash_in_branch_amount = 0;
var img_select = 0;

$(document).ready(function() {

  let today = new Date(new Date().setDate(new Date().getDate() - 1)).toISOString().split('T')[0];
    $("#loading-div-background").css({
        opacity: 1.0
    });

    $('#edit').click(function() {
        console.log($(this).parent("td").index());
    });

    var store_code = "<?php echo $store_code; ?>";
    $('#store_code_dsc').val(store_code);

    var dateTime_test = "<?php echo $date." ".$time; ?>";

    // var today = new Date();
    // var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    // var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    // var dateTime = date+' '+time;
    // $('#date_time_dsc').val(date)
    // var today = new Date().toISOString().split('T')[0];

    $('input[type=date]').val(today); // alert(dateTime);
    // document.getElementById("date_time_dsc").value = dateTime;
    var formData = new FormData();
    var CashData = 'storecode=' + store_code;
    console.log("Cash Data", CashData);


    formData.append("inputCashData", CashData);

    // $("#image").change(function(){
    //     if((document.getElementById("image").files[0]) && ($('#dsc_total_cash_amt').val() > 0)){
    //         img_select =1;
    //         $('#dec_net_deposit_amt').attr("readonly",false);
    //     }else{
    //         img_select =0;
    //         $('#dec_net_deposit_amt').attr("readonly",true);
    //     }
    // });
    //
    // console.log(" total cash data onload :"+$('#dsc_total_cash_amt').val())
    // console.log("image sel onload: "+document.getElementById("image").files[0])
    // if(($('#dsc_total_cash_amt').val() > 0)&&(document.getElementById("image").files[0])){
    //     $('#dec_net_deposit_amt').attr("readonly",false);
    // }else{
    //     $('#dec_net_deposit_amt').attr("readonly",true);
    // }



    $.ajax({
        url: "input.php?get_last_cash",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, status, xhr) {
            console.log(data);
            if (JSON.parse(data).message === "exist_cash") {

                total_cash_in_branch_amount = parseFloat(JSON.parse(data).l_cash);
                $('#cash_in_branch').val(total_cash_in_branch_amount);

                // alert(total_cash_in_branch_amount);

            } else if (JSON.parse(data).message === "notfound_cash") {
                total_cash_in_branch_amount = parseFloat(JSON.parse(data).l_cash);
                $('#cash_in_branch').val(total_cash_in_branch_amount);

                // alert(total_cash_in_branch_amount);
            }
        },
        error: function(jqXHR, status, errorThrown) {
            HideProgressAnimation()
            alert("Failed TO Get Last Cah DATA!");
        }
    });


});

var count_item = 0;
var total_cash = 0;
var total_charge = 0;
var deduction_line_no = 0;
var total_visa = 0;
var total_amount = 0;
var total_deduction = 0;
var total_deduction_amount = 0;
var total_netDeposit_amount = 0;

var details_arr = [];
var deduction_arr = [];
var action = "insert";
var card_names_selected = [];
var sales_types_selected = [];
var exp_types_selected = [];
var uploads_dir = '/dop_images';

var cash_before_deposit = 0;
var cash_after_deposit = 0;




function ShowProgressAnimation() {
    $("#loading-div-background").show();
}

function HideProgressAnimation() {
    $("#loading-div-background").hide();
}

function removeItem(item, index) {
    console.log("details array before remove : ", details_arr);
    console.log("index for remove ", index);
    // console.log("details array after remove",details_arr);

    var sales_type_remove = details_arr[index][1];
    var visa_cname_remove = details_arr[index][2];

    var amount_remove = details_arr[index][3];
    console.log(sales_type_remove);
    console.log(amount_remove);
    var r = confirm("are you sure you want remove this item!");
    if (r == true) {

        // console.log("sales types arr before : ",sales_types_selected);
        // console.log("card names arr before : ",card_names_selected);
        // console.log("details arr before : ",details_arr);

        card_names_selected.splice(card_names_selected.indexOf(visa_cname_remove), 1);
        sales_types_selected.splice(sales_types_selected.indexOf(sales_type_remove), 1);
        console.log("sales types arr after : ", sales_types_selected);
        console.log("card names arr after : ", card_names_selected);
        details_arr[index] = null;
        console.log("details array before remove : ", details_arr);

        if (sales_type_remove == "Visa") {
            total_visa = parseFloat(total_visa) - parseFloat(amount_remove);
            total_amount = parseFloat(total_amount) - parseFloat(amount_remove);
            $('#dsc_total_visa_amt').val(total_visa);
            $('#dec_total_amt').val(total_amount);

        } else if (sales_type_remove == "Cash") {
            total_cash = total_cash - amount_remove;
            total_amount = total_amount - amount_remove;
            total_netDeposit_amount = total_netDeposit_amount - amount_remove;
            $('#dsc_total_cash_amt').val(total_cash);
            console.log("image sel : "+document.getElementById("image").files[0]);
            if(($('#dsc_total_cash_amt').val() > 0)&&(document.getElementById("image").files[0])){
                $('#dec_net_deposit_amt').attr("readonly",false);
            }else{
                $('#dec_net_deposit_amt').attr("readonly",true);
            }
            // $('#dec_net_deposit_amt').val(total_netDeposit_amount);
            $('#cash_in_branch').val(total_cash_in_branch_amount + total_netDeposit_amount);
            cash_before_deposit = total_cash_in_branch_amount + total_netDeposit_amount;
            cash_after_deposit = cash_before_deposit;
            $('#dec_total_amt').val(total_amount);
        } else if (sales_type_remove == "Charge") {
            total_charge = total_charge - amount_remove;
            total_amount = total_amount - amount_remove;
            $('#dsc_total_charge_amt').val(total_charge);
            $('#dec_total_amt').val(total_amount);
        }




        $(item).parent().parent().remove();
    } else {
        return false;
    }

    details_arr.splice(index, 1);
    $(item).parent().parent().remove();

}


function removeDeductionItem(item, index) {
    console.log("deductions array before remove : ", deduction_arr);
    console.log("index for remove ", index);
    // console.log("details array after remove",details_arr);

    var d_amount_remove = deduction_arr[index][0];
    console.log("deduction amount remove : ", d_amount_remove)
    console.log("deduction amount before : ", total_deduction_amount);


    var r = confirm("are you sure you want remove this item!");
    if (r == true) {
        deduction_line_no = deduction_line_no - 1;

        deduction_arr[index] = null;
        console.log("deduction array before remove : ", deduction_arr);

        total_deduction_amount = parseFloat(total_deduction_amount) - parseFloat(d_amount_remove);
        total_netDeposit_amount = parseFloat(total_netDeposit_amount) + parseFloat(d_amount_remove);
        $('#dec_total_deduction').val(total_deduction_amount);
        // $('#dec_net_deposit_amt').val(total_netDeposit_amount);
        $('#cash_in_branch').val(total_cash_in_branch_amount + total_netDeposit_amount);
        cash_before_deposit = total_cash_in_branch_amount + total_netDeposit_amount;
        cash_after_deposit = cash_before_deposit;

        $(item).parent().parent().remove();
    } else {
        return false;
    }

    deduction_arr.splice(index, 1);
    $(item).parent().parent().remove();
}

function readURL(input) {

    if (input.files && input.files[0]) {
        // console.log('image input files : ',input.files);
        // console.log('image input files 0 : ',input.files[0]);

        var reader = new FileReader();
        reader.onload = function(e) {
            $('#blah').attr('src', e.target.result).show();
            $('#blah').css('display', 'block');
            $('#blah').css('margin-left', 'auto');
            $('#blah').css('margin-right', 'auto');

        };
        reader.readAsDataURL(input.files[0]);
    }
}





$('#sales_type').on('change', function() {

    var sales_type_selected = $("#sales_type option:selected").val();
    console.log(sales_type_selected);
    if (sales_type_selected === "Visa") {
        $("#visa_name_container").css({
            display: 'initial'
        })

        $("#add_item_dev").css({
            'margin-left': '0px'
        })
    } else {
        $("#visa_name_container").css({
            display: 'none'
        })

        $("#add_item_dev").css({
            'margin-left': '164px'
        })
    }

});

$('#exp_type').on('change', function() {

    var exp_type_selected = $("#exp_type option:selected").val();
    console.log(exp_type_selected);

});



$("#add_item").click(function() {
    var sales_type = $('#sales_type').val();
    var visa_cname = $('#visa_cname').val();
    var amt = $('#amt').val();
    var note = $('#note').val();


    if (!$.trim(sales_type)) {
        alert("Please Enter Sales Type");
        $("#sales_type").val('');
        $("#visa_cname").val('');
        $("#amt").val('');
        $("#note").val('');

    } else if (!$.trim(visa_cname) && sales_type == "Visa") {
        alert("Please Enter Visa CName");
        $("#sales_type").val('');
        $("#visa_cname").val('');
        $("#amt").val('');
        $("#note").val('');


    } else if (!$.trim(amt)) {
        alert("Please Enter Amount");
        $("#sales_type").val('');
        $("#visa_cname").val('');
        $("#amt").val('');
        $("#note").val('');

    } else if (sales_types_selected.includes(sales_type) && card_names_selected.includes(visa_cname)) {
        alert("this sales type already exist");
        $("#sales_type").val('');
        $("#visa_cname").val('');
        $("#amt").val('');
        $("#note").val('');
    } else {
        sales_types_selected.push(sales_type);
        card_names_selected.push(visa_cname);

        console.log("sales types arr : ", sales_types_selected);
        console.log("card names arr : ", card_names_selected);

        var dateTime = "<?php echo $date." ".$time; ?>";
        details_arr.push([dateTime, sales_type, visa_cname, amt, note])
        console.log("details arr : ", details_arr);

        $("#items_container").append(
            '<tr><td style="text-align:center">' +
            dateTime + '</td><td style="text-align:center">' + sales_type +
            '</td><td style="text-align:center">' + visa_cname + '</td><td style="text-align:center">' +
            amt + '</td><td>' + note +
            '</td><td><input style="max-width: 41px;font-size: 22px;border-radius: 24px;border: 2px solid;text-align: center;align-self: center;margin-top: 7%;" id="deleteItem" type="button" value="X" onclick="removeItem(this,this.parentNode.parentNode.rowIndex)"/></td></tr>'
            );


        total_amount = parseFloat(total_amount) + parseFloat(amt);
        $('#dec_total_amt').val(total_amount);

        if (sales_type == "Visa") {
            total_visa = parseFloat(total_visa) + parseFloat(amt);
            $('#dsc_total_visa_amt').val(total_visa);
        } else if (sales_type == "Cash") {

            total_cash = parseFloat(total_cash) + parseFloat(amt);
            total_netDeposit_amount = parseFloat(total_netDeposit_amount) + parseFloat(amt);
            $('#cash_in_branch').val(total_cash_in_branch_amount + total_netDeposit_amount);
            cash_before_deposit = total_cash_in_branch_amount + total_netDeposit_amount;
            cash_after_deposit = cash_before_deposit;
            $('#dsc_total_cash_amt').val(total_cash);
            console.log("image sel : "+document.getElementById("image").files[0])
            if(($('#dsc_total_cash_amt').val() > 0)&&(document.getElementById("image").files[0])){
                $('#dec_net_deposit_amt').attr("readonly",false);
            }else{
                $('#dec_net_deposit_amt').attr("readonly",true);
            }
            // $('#dec_net_deposit_amt').val(total_netDeposit_amount);

        } else if (sales_type == "Charge") {
            total_charge = parseFloat(total_charge) + parseFloat(amt);
            // total_netDeposit_amount = parseFloat(total_netDeposit_amount) + parseFloat(amt);
            $('#dsc_total_charge_amt').val(total_charge);


        }



        $("#sales_type").val('');
        $("#visa_cname").val('');
        $("#amt").val('');
        $("#note").val('');

    }
});


$("#add_deduction_item").click(function() {
    var deduction_amt = $('#d_amt').val();
    var deduction_reason = $('#d_r').val();
    var exp_type = $('#exp_type').val();

    console.log("test now", sales_types_selected)
    if ($.trim(deduction_amt)) {
        // if (!$.trim(deduction_reason)) {
        //     alert("Please Enter Deduction Reason");
        //     $('#d_amt').val('');
        //     $('#d_r').val('');
        //     $("#exp_type").val('');
        // }else
        if (!sales_types_selected.includes('Cash')) {
            alert("Sorry you don't have cash value");
            $('#d_amt').val('');
            $('#d_r').val('');
            $("#exp_type").val('');
        } else if (total_netDeposit_amount < deduction_amt) {
            alert("Sorry the total cash amount is not enough");
            $('#d_amt').val('');
            $('#d_r').val('');
            $("#exp_type").val('');
        } else {
            deduction_line_no = deduction_line_no + 1;

            var dateTime = "<?php echo $date." ".$time; ?>";
            card_names_selected.push(exp_type);
            exp_types_selected.push([deduction_amt, deduction_reason, dateTime, exp_type])
            console.log("DEDUCTION  ARR : ", deduction_arr);
            deduction_arr.push([deduction_amt, deduction_reason, dateTime, exp_type, deduction_line_no]);
            $("#deduction_items_container").append(
                '<tr><td style="text-align:center">' +
                exp_type + '</td><td style="text-align:center">' +
                deduction_amt + '</td><td style="text-align:center">' + deduction_reason +
                '</td><td style="text-align:center"><input style="max-width: 41px;font-size: 22px;border-radius: 24px;border: 2px solid;text-align: center;align-self: center;margin-top: 2%;margin-left:44%" id="deleteItem" type="button" value="X" onclick="removeDeductionItem(this,this.parentNode.parentNode.rowIndex)"/></td></tr>'
                );

            total_deduction_amount = parseFloat(total_deduction_amount) + parseFloat(deduction_amt);
            total_netDeposit_amount = parseFloat(total_netDeposit_amount) - parseFloat(deduction_amt);
            $('#dec_total_deduction').val(total_deduction_amount);
            // $('#dec_net_deposit_amt').val(total_netDeposit_amount);
            $('#cash_in_branch').val(total_cash_in_branch_amount + total_netDeposit_amount);
            cash_before_deposit = total_cash_in_branch_amount + total_netDeposit_amount;
            cash_after_deposit = cash_before_deposit;

            $('#d_amt').val('');
            $('#d_r').val('');
            $("#exp_type").val('');

        }
    }
});


$("#image").change(function(){
    if((document.getElementById("image").files[0]) && ($('#dsc_total_cash_amt').val() > 0)){
            img_select =1;
            $('#dec_net_deposit_amt').attr("readonly",false);
        }else{
            img_select =0;
            $('#dec_net_deposit_amt').attr("readonly",true);
        }
    });

$('#dec_net_deposit_amt').on("input", function() {
    if(img_select == 1){
    $('#dec_net_deposit_amt').attr("readonly",false);
    var new_cash_val = cash_before_deposit - $('#dec_net_deposit_amt').val();
    if (new_cash_val < 0) {
        alert("sorry you can't deposit this value");
    } else {
        $('#cash_in_branch').val(new_cash_val);
        cash_after_deposit = new_cash_val;
    }
}else{
    alert("sorry you can't ,select deposit image before deposit please!");
    $('#dec_net_deposit_amt').attr("readonly",true);
}

});


$("#submit_1").click(function() {

    // alert("cash before :  "+cash_before_deposit+"cash after  :"+cash_after_deposit);
    ShowProgressAnimation();

    var imageSelector = document.getElementById("image"),
        file1 = imageSelector.files[0];
    file2 = imageSelector.files[0];
    // console.log("file  : ",files);

    var username = "<?php echo $username; ?>";
    var store_code = "<?php echo $store_code; ?>";
    // var store_code = "WHS";
    var dsc_total_visa_amt = $('#dsc_total_visa_amt').val();
    var dsc_total_cash_amt = $('#dsc_total_cash_amt').val();
    var dsc_total_charge_amt = $('#dsc_total_charge_amt').val();
    var dec_total_amt = $('#dec_total_amt').val();
    // var dec_deduction_amt = $('#dec_deduction_amt').val();
    var dec_total_deduction_amt = $('#dec_total_deduction').val();
    var dec_net_deposit_amt = $('#dec_net_deposit_amt').val();
    var cash_in_branch_amt = $('#cash_in_branch').val();


    // var deduction_reason = $('#deduction_reason').val();
    var note1 = $('#note1').val();
    var note2 = $('#note2').val();

    dateTimeSelect = $('input[type=date]').val();


    var minDate = new Date(new Date().setDate(new Date().getDate() - 3)).toISOString().split('T')[0];
    var maxDate = new Date(new Date().setDate(new Date().getDate() + 3)).toISOString().split('T')[0];




    // else if (!$.trim(dec_deduction_amt)) {
    //     HideProgressAnimation()
    //     alert("Please Enter Deduction Amount");
    // } else if (!$.trim(dec_net_deposit_amt)) {
    //     HideProgressAnimation()
    //     alert("Please Enter Net Deposit Amount");
    // } else if (!$.trim(deduction_reason)) {
    //     HideProgressAnimation()
    //     alert("Please Enter The Deduction Reason");
    // }

    // if (!$.trim(dsc_total_visa_amt)) {
    //     HideProgressAnimation();
    //     alert("Please Enter Total Visa Amount");
    // } else
    // if (!$.trim(dsc_total_cash_amt)) {
    //     HideProgressAnimation()
    //     alert("Please Enter Total Cash Amount");
    // } else
    if (!$.trim(dec_total_amt)) {
        HideProgressAnimation()
        alert("Please Enter Total Amount");
    }
    // else if (!(dateTimeSelect > minDate && dateTimeSelect < maxDate )){
    //     HideProgressAnimation()
    //     alert('Out Side range Date  !!')
    // }
    else {

        if (!file1) {
            var fc = confirm("Note, Deposit Receipt Not Selected , Select It !?");
            if (fc == true) {
                HideProgressAnimation();
                return false;
            } else {

                var formData = new FormData();


                var postData = 'action=' + action + '&username=' + username + '&dateTimeSelect=' +
                    dateTimeSelect + '&storecode=' + store_code + '&dsc_total_visa_amt=' +
                    dsc_total_visa_amt + '&dsc_total_charge_amt=' + dsc_total_charge_amt +
                    '&dsc_total_cash_amt=' + dsc_total_cash_amt + '&dec_total_amt=' +
                    dec_total_amt + '&cash_in_branch_amt=' + cash_in_branch_amt + '&dec_total_deduction_amt=' +
                    dec_total_deduction_amt + '&dec_net_deposit_amt=' +
                    dec_net_deposit_amt + '&note1=' + note1 + '&note2=' +
                    note2 + '&cash_before=' + cash_before_deposit + '&cash_after=' + cash_after_deposit +
                    '&details_arr=' + JSON.stringify(details_arr) + '&deduction_arr=' + JSON.stringify(
                        deduction_arr) + '&formImageData=' + JSON.stringify(formData);
                console.log("pooooooost Data", postData);

                formData.append("image", file1);
                formData.append("image", file2);

                formData.append("inputData", postData);


                console.log("form Data  : ", formData);
                $.ajax({
                    url: "input.php?insert_data",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data, status, xhr) {
                        console.log(data);
                        HideProgressAnimation()

                        if (JSON.parse(data).message === "saved") {
                            alert("DATA SAVED SUCCESSFULLY!");
                            action = "insert";
                            $('#dsc_total_visa_amt').val('');
                            $('#dsc_total_cash_amt').val('');
                            $('#dsc_total_charge_amt').val('');
                            $('#dec_total_amt').val('');
                            // $('#dec_deduction_amt').val('');
                            $('#dec_net_deposit_amt').val('');
                            // $('#deduction_reason').val('');
                            $('#dec_total_deduction').val('');
                            $('#image').val('');
                            $('#cash_in_branch').val(cash_after_deposit);
                            total_cash_in_branch_amount = cash_after_deposit;
                            $('#blah').css("display", "none");

                            $('#note1').val('');
                            $('#note2').val('');
                            $("#deduction_items_container > *").remove();
                            $("#items_container > *").remove();

                        } else if (JSON.parse(data).message === "update") {
                            alert("DATA UPDATED SUCCESSFULLY!");
                            action = "insert";
                            $('#dsc_total_visa_amt').val('');
                            $('#dsc_total_cash_amt').val('');
                            $('#dsc_total_charge_amt').val('');
                            $('#dec_total_amt').val('');
                            // $('#dec_deduction_amt').val('');
                            $('#dec_net_deposit_amt').val('');
                            // $('#deduction_reason').val('');
                            $('#dec_total_deduction').val('');
                            $('#cash_in_branch').val(cash_after_deposit);
                            total_cash_in_branch_amount = cash_after_deposit;
                            $('#image').val('');
                            $('#blah').css("display", "none");
                            $('#note1').val('');
                            $('#note2').val('');
                            $("#deduction_items_container > *").remove();
                            $("#items_container > *").remove();
                        } else if (JSON.parse(data).message == "failed") {
                            alert("DATA Failed To SAVED, try again!");
                            action = "insert";
                            $('#dsc_total_visa_amt').val('');
                            $('#dsc_total_cash_amt').val('');
                            $('#dsc_total_charge_amt').val('');
                            $('#dec_total_amt').val('');
                            // $('#dec_deduction_amt').val('');
                            $('#dec_net_deposit_amt').val('');
                            // $('#deduction_reason').val('');
                            $('#dec_total_deduction').val('');
                            $('#cash_in_branch').val('');
                            $('#image').val('');
                            $('#blah').css("display", "none");
                            $('#note1').val('');
                            $('#note2').val('');
                            $("#deduction_items_container > *").remove();
                            $("#items_container > *").remove();

                        } else if (JSON.parse(data).message === "out_range_date_missing") {
                            alert("missing days!! ");
                            action = "insert";
                            $('#dsc_total_visa_amt').val('');
                            $('#dsc_total_cash_amt').val('');
                            $('#dsc_total_charge_amt').val('');
                            $('#dec_total_amt').val('');
                            // $('#dec_deduction_amt').val('');
                            $('#dec_net_deposit_amt').val('');
                            // $('#deduction_reason').val('');
                            $('#dec_total_deduction').val('');
                            $('#cash_in_branch').val('');
                            $('#image').val('');
                            $('#blah').css("display", "none");
                            $('#note1').val('');
                            $('#note2').val('');
                            $("#deduction_items_container > *").remove();
                            $("#items_container > *").remove();
                        } else if (JSON.parse(data).message === "out_range_date_before") {
                            alert("entered a previous date!!");
                            action = "insert";
                            $('#dsc_total_visa_amt').val('');
                            $('#dsc_total_cash_amt').val('');
                            $('#dsc_total_charge_amt').val('');
                            $('#dec_total_amt').val('');
                            // $('#dec_deduction_amt').val('');
                            $('#dec_net_deposit_amt').val('');
                            // $('#deduction_reason').val('');
                            $('#dec_total_deduction').val('');
                            $('#cash_in_branch').val('');
                            $('#image').val('');
                            $('#blah').css("display", "none");
                            $('#note1').val('');
                            $('#note2').val('');
                            $("#deduction_items_container > *").remove();
                            $("#items_container > *").remove();

                        } else {
                            if (JSON.parse(data).message == "exist_no") {

                                alert("Sorry you Can't Update!");
                                action = "insert";
                                $('#dsc_total_visa_amt').val('');
                                $('#dsc_total_cash_amt').val('');
                                $('#dsc_total_charge_amt').val('');
                                $('#dec_total_amt').val('');
                                // $('#dec_deduction_amt').val('');
                                $('#dec_net_deposit_amt').val('');
                                // $('#deduction_reason').val('');
                                $('#dec_total_deduction').val('');
                                $('#cash_in_branch').val(cash_after_deposit);
                                total_cash_in_branch_amount = cash_after_deposit;
                                $('#image').val('');
                                $('#blah').css("display", "none");
                                $('#note1').val('');
                                $('#note2').val('');
                                $("#deduction_items_container > *").remove();
                                $("#items_container > *").remove();

                            } else if (JSON.parse(data).message == "exist_yes") {
                                var c = confirm("Today Already Inserted before , Update It?!");
                                if (c == true) {
                                    var ret_data = JSON.parse(JSON.parse(data).data)[0];
                                    var ret_data_details = JSON.parse(JSON.parse(data).details);
                                    var ret_data_deductions = JSON.parse(JSON.parse(data)
                                        .deductions);
                                    console.log("Impttttttttttt : ", ret_data);
                                    action = "update";
                                    cash_after_deposit = ret_data.dsc_cash_in_branch_adeposit;
                                    cash_before_deposit = ret_data.dsc_cash_in_branch_bdeposit;
                                    $('#dsc_total_visa_amt').val(ret_data.dsc_total_visa_amt);
                                    $('#dsc_total_cash_amt').val(ret_data.dsc_total_cash_amt);

                                    if(ret_data.dsc_total_cash_amt >0 && document.getElementById("image").files[0]){
                                        $('#dec_net_deposit_amt').attr("readonly",false);
                                    }else{
                                        $('#dec_net_deposit_amt').attr("readonly",true);
                                    }
                                    $('#dsc_total_charge_amt').val(ret_data.dsc_total_charge_amt);
                                    $('#dec_total_amt').val(ret_data.dsc_total_amt);
                                    // $('#dec_deduction_amt').val(ret_data.dsc_deduction_amt);
                                    $('#dec_total_deduction').val(ret_data.dsc_total_deduction_amt);
                                    $('#dec_net_deposit_amt').val(ret_data.dsc_net_deposite_amt);
                                    $('#cash_in_branch').val(ret_data.dsc_cash_in_branch_amt);
                                    // $('#deduction_reason').val(ret_data.dsc_deduction_reason);
                                    $('#image').val('');
                                    // $('#blah').css("display", "none");
                                    $('#blah').prop("src", uploads_dir + '/' + ret_data.TIMAGE1);
                                    $('#note1').val(ret_data.dsc_note1);
                                    $('#note2').val(ret_data.dsc_note2);
                                    $("#visa_name_container").css({
                                        display: 'none'
                                    });
                                    $("#deduction_items_container > *").remove();

                                    $("#items_container > *").remove();
                                    details_arr = [];
                                    deduction_arr = [];
                                    card_names_selected = [];
                                    sales_types_selected = [];
                                    total_cash = ret_data.dsc_total_cash_amt;
                                    total_charge = ret_data.dsc_total_charge_amt;
                                    total_visa = ret_data.dsc_total_visa_amt;
                                    total_amount = ret_data.dsc_total_amt;
                                    total_deduction_amount = ret_data.dsc_total_deduction_amt;
                                    total_netDeposit_amount = ret_data.dsc_net_deposite_amt;

                                    var i;
                                    var j;
                                    var n;

                                    var count_item2 = 0;
                                    var d_line_count = 0;



                                    for (j = 0; j < ret_data_deductions.length; j++) {
                                        console.log(ret_data_deductions[j].dsc_store_code);
                                        deduction_arr.push([ret_data_deductions[j].exp_amt,
                                            ret_data_deductions[j].exp_desc,
                                            ret_data_deductions[j].entry_date,
                                            ret_data_deductions[j].exp_type,
                                            ret_data_deductions[j].line_no
                                        ])
                                        d_line_count++;
                                        $("#deduction_items_container").append(
                                            '<tr><td style="text-align:center">' +
                                            ret_data_deductions[j].exp_type +
                                            '</td><td style="text-align:center">' +
                                            ret_data_deductions[j].exp_amt +
                                            '</td><td style="text-align:center">' +
                                            ret_data_deductions[j].exp_desc +
                                            '</td><td style="text-align:center"><input style="max-width: 41px;font-size: 22px;border-radius: 24px;border: 2px solid;text-align: center;align-self: center;margin-top: 2%;margin-left:44%" id="deleteItem" type="button" value="X" onclick="removeDeductionItem(this,this.parentNode.parentNode.rowIndex)"/></td></tr>'
                                            );
                                    }
                                    deduction_line_no = d_line_count;

                                    for (i = 0; i < ret_data_details.length; i++) {
                                        console.log(ret_data_details[i].dsc_store_code);

                                        details_arr.push([ret_data_details[i].dtl_entry_date,
                                            ret_data_details[i].dtl_sales_type,
                                            ret_data_details[i].dtl_visa_cname,
                                            ret_data_details[i].dtl_amt, ret_data_details[i]
                                            .dtl_note
                                        ])

                                        // if (count_item2 == 0) {
                                        $("#items_container").append(
                                            '<tr><td style="text-align:center">' +
                                            ret_data_details[i].dtl_entry_date +
                                            '</td><td style="text-align:center">' +
                                            ret_data_details[i].dtl_sales_type +
                                            '</td><td style="text-align:center">' +
                                            ret_data_details[i].dtl_visa_cname +
                                            '</td><td style="text-align:center">' +
                                            ret_data_details[i].dtl_amt +
                                            '</td><td style="text-align:center">' +
                                            ret_data_details[i].dtl_note +
                                            '</td><td style="text-align:center"><input style="max-width: 41px;font-size: 22px;border-radius: 24px;border: 2px solid;text-align: center;align-self: center;margin-top: 7%;" id="deleteItem" type="button" value="X" onclick="removeItem(this,this.parentNode.parentNode.rowIndex)"/></td></tr>'
                                            );
                                        card_names_selected.push(ret_data_details[i]
                                        .dtl_visa_cname);
                                        sales_types_selected.push(ret_data_details[i]
                                            .dtl_sales_type);
                                        //     count_item2++;
                                        // } else {
                                        //     $("#items_container").append('<tr><td>' + ret_data_details[i].dtl_entry_date + '</td><td>' + ret_data_details[i].dtl_sales_type + '</td><td>' +
                                        //     ret_data_details[i].dtl_visa_cname + '</td><td>' + ret_data_details[i].dtl_amt + '</td><td>' + ret_data_details[i].dtl_note + '</td><td><input style="max-width: 41px;font-size: 22px;border-radius: 24px;border: 2px solid;text-align: center;align-self: center;margin-top: 7%;" id="deleteItem" type="button" value="X" onclick="removeItem(this,this.parentNode.parentNode.rowIndex)"/></td></tr>');
                                        //     card_names_selected.push(ret_data_details[i].dtl_visa_cname);
                                        //     sales_types_selected.push(ret_data_details[i].dtl_sales_type);
                                        // }
                                    }
                                } else {
                                    action = "insert";
                                    $('#dsc_total_visa_amt').val('');
                                    $('#dsc_total_cash_amt').val('');
                                    $('#dsc_total_charge_amt').val('');
                                    $('#dec_total_amt').val('');
                                    // $('#dec_deduction_amt').val('');
                                    $('#dec_net_deposit_amt').val('');
                                    // $('#deduction_reason').val('');
                                    $('#dec_total_deduction').val('');
                                    $('#cash_in_branch').val('');
                                    $('#image').val('');
                                    $('#blah').css("display", "none");
                                    $('#note1').val('');
                                    $('#note2').val('');
                                    $("#deduction_items_container > *").remove();
                                    $("#items_container > *").remove();
                                }

                            }


                        }

                    },
                    error: function(jqXHR, status, errorThrown) {
                        HideProgressAnimation()
                        alert("Failed TO SAVED DATA!");
                    }
                });
                console.log("Final Details Array : ", details_arr);
                console.log("total cash amount : ", total_cash);

                count_item = 0;
                count_item2 = 0;
                total_cash = 0;
                total_charge = 0;
                total_visa = 0;
                total_amount = 0;
                deduction_line_no = 0;
                total_deduction_amount = 0;
                total_netDeposit_amount = 0;
                details_arr = [];
                deduction_arr = [];
                card_names_selected = [];
                sales_types_selected = [];
                exp_types_selected = [];

            }
        } else {
            var formData = new FormData();


            var postData = 'action=' + action + '&username=' + username + '&dateTimeSelect=' + dateTimeSelect +
                '&storecode=' + store_code + '&dsc_total_visa_amt=' +
                dsc_total_visa_amt + '&dsc_total_charge_amt=' + dsc_total_charge_amt + '&dsc_total_cash_amt=' +
                dsc_total_cash_amt + '&dec_total_amt=' +
                dec_total_amt + '&cash_in_branch_amt=' + cash_in_branch_amt + '&dec_total_deduction_amt=' +
                dec_total_deduction_amt + '&dec_net_deposit_amt=' +
                dec_net_deposit_amt + '&note1=' + note1 + '&note2=' +
                note2+ '&cash_before=' + cash_before_deposit + '&cash_after=' + cash_after_deposit + '&details_arr=' + JSON.stringify(details_arr) + '&deduction_arr=' + JSON.stringify(
                    deduction_arr) + '&formImageData=' + JSON.stringify(formData);
            console.log("pooooooost Data", postData);

            formData.append("image", file1);
            formData.append("image", file2);

            formData.append("inputData", postData);


            console.log("form Data  : ", formData);
            $.ajax({
                url: "input.php?insert_data",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(data, status, xhr) {
                    HideProgressAnimation()
                    alert(data);

                    if (JSON.parse(data).message === "saved") {
                        alert("DATA SAVED SUCCESSFULLY!");
                        action = "insert";
                        $('#dsc_total_visa_amt').val('');
                        $('#dsc_total_cash_amt').val('');
                        $('#dsc_total_charge_amt').val('');
                        $('#dec_total_amt').val('');
                        // $('#dec_deduction_amt').val('');
                        $('#dec_net_deposit_amt').val('');
                        // $('#deduction_reason').val('');
                        $('#dec_total_deduction').val('');
                        $('#image').val('');
                        $('#cash_in_branch').val(cash_after_deposit);
                        total_cash_in_branch_amount = cash_after_deposit;
                        $('#blah').css("display", "none");

                        $('#note1').val('');
                        $('#note2').val('');
                        $("#deduction_items_container > *").remove();
                        $("#items_container > *").remove();

                    } else if (JSON.parse(data).message === "update") {
                        alert("DATA UPDATED SUCCESSFULLY!");
                        action = "insert";
                        $('#dsc_total_visa_amt').val('');
                        $('#dsc_total_cash_amt').val('');
                        $('#dsc_total_charge_amt').val('');
                        $('#dec_total_amt').val('');
                        // $('#dec_deduction_amt').val('');
                        $('#dec_net_deposit_amt').val('');
                        // $('#deduction_reason').val('');
                        $('#dec_total_deduction').val('');
                        $('#cash_in_branch').val(cash_after_deposit);
                        total_cash_in_branch_amount = cash_after_deposit;
                        $('#image').val('');
                        $('#blah').css("display", "none");
                        $('#note1').val('');
                        $('#note2').val('');
                        $("#deduction_items_container > *").remove();
                        $("#items_container > *").remove();
                    } else if (JSON.parse(data).message == "failed") {
                        alert("DATA Failed To SAVED, try again!");
                        action = "insert";
                        $('#dsc_total_visa_amt').val('');
                        $('#dsc_total_cash_amt').val('');
                        $('#dsc_total_charge_amt').val('');
                        $('#dec_total_amt').val('');
                        // $('#dec_deduction_amt').val('');
                        $('#dec_net_deposit_amt').val('');
                        // $('#deduction_reason').val('');
                        $('#dec_total_deduction').val('');
                        $('#cash_in_branch').val('');
                        $('#image').val('');
                        $('#blah').css("display", "none");
                        $('#note1').val('');
                        $('#note2').val('');
                        $("#deduction_items_container > *").remove();
                        $("#items_container > *").remove();

                    } else if (JSON.parse(data).message === "out_range_date_missing") {
                        alert("missing days!!");
                        action = "insert";
                        $('#dsc_total_visa_amt').val('');
                        $('#dsc_total_cash_amt').val('');
                        $('#dsc_total_charge_amt').val('');
                        $('#dec_total_amt').val('');
                        // $('#dec_deduction_amt').val('');
                        $('#dec_net_deposit_amt').val('');
                        // $('#deduction_reason').val('');
                        $('#dec_total_deduction').val('');
                        $('#cash_in_branch').val('');
                        $('#image').val('');
                        $('#blah').css("display", "none");
                        $('#note1').val('');
                        $('#note2').val('');
                        $("#deduction_items_container > *").remove();
                        $("#items_container > *").remove();
                    } else if (JSON.parse(data).message === "out_range_date_before") {
                        alert("entered a previous date!!");
                        action = "insert";
                        $('#dsc_total_visa_amt').val('');
                        $('#dsc_total_cash_amt').val('');
                        $('#dsc_total_charge_amt').val('');
                        $('#dec_total_amt').val('');
                        // $('#dec_deduction_amt').val('');
                        $('#dec_net_deposit_amt').val('');
                        // $('#deduction_reason').val('');
                        $('#dec_total_deduction').val('');
                        $('#cash_in_branch').val('');
                        $('#image').val('');
                        $('#blah').css("display", "none");
                        $('#note1').val('');
                        $('#note2').val('');
                        $("#deduction_items_container > *").remove();
                        $("#items_container > *").remove();

                    } else {
                        if (JSON.parse(data).message == "exist_no") {
                            alert("Sorry you Can't Update!");
                            action = "insert";
                            $('#dsc_total_visa_amt').val('');
                            $('#dsc_total_cash_amt').val('');
                            $('#dsc_total_charge_amt').val('');
                            $('#dec_total_amt').val('');
                            // $('#dec_deduction_amt').val('');
                            $('#dec_net_deposit_amt').val('');
                            // $('#deduction_reason').val('');
                            $('#dec_total_deduction').val('');
                            $('#cash_in_branch').val('');
                            $('#image').val('');
                            $('#blah').css("display", "none");
                            $('#note1').val('');
                            $('#note2').val('');
                            $("#deduction_items_container > *").remove();
                            $("#items_container > *").remove();

                        } else if (JSON.parse(data).message == "exist_yes") {
                            var c = confirm("Today Already Inserted before , Update It?!");
                            if (c == true) {
                                var ret_data = JSON.parse(JSON.parse(data).data)[0];
                                var ret_data_details = JSON.parse(JSON.parse(data).details);
                                var ret_data_deductions = JSON.parse(JSON.parse(data).deductions);
                                console.log("Impttttttttttt : ", ret_data);
                                action = "update";
                                cash_after_deposit = ret_data.dsc_cash_in_branch_adeposit;
                                cash_before_deposit = ret_data.dsc_cash_in_branch_bdeposit;
                                if(ret_data.dsc_total_cash_amt >0 && document.getElementById("image").files[0]){
                                        $('#dec_net_deposit_amt').attr("readonly",false);
                                    }else{
                                        $('#dec_net_deposit_amt').attr("readonly",true);
                                    }
                                $('#dsc_total_visa_amt').val(ret_data.dsc_total_visa_amt);
                                $('#dsc_total_cash_amt').val(ret_data.dsc_total_cash_amt);
                                $('#dsc_total_charge_amt').val(ret_data.dsc_total_charge_amt);
                                $('#dec_total_amt').val(ret_data.dsc_total_amt);
                                // $('#dec_deduction_amt').val(ret_data.dsc_deduction_amt);
                                $('#dec_total_deduction').val(ret_data.dsc_total_deduction_amt);
                                $('#dec_net_deposit_amt').val(ret_data.dsc_net_deposite_amt);
                                $('#cash_in_branch').val(ret_data.dsc_cash_in_branch_amt);
                                // $('#deduction_reason').val(ret_data.dsc_deduction_reason);
                                $('#image').val('');
                                // $('#blah').css("display", "none");
                                $('#blah').prop("src", uploads_dir + '/' + ret_data.TIMAGE1);
                                $('#note1').val(ret_data.dsc_note1);
                                $('#note2').val(ret_data.dsc_note2);
                                $("#visa_name_container").css({
                                    display: 'none'
                                });
                                $("#deduction_items_container > *").remove();

                                $("#items_container > *").remove();
                                details_arr = [];
                                deduction_arr = [];
                                card_names_selected = [];
                                sales_types_selected = [];
                                total_cash = ret_data.dsc_total_cash_amt;
                                total_charge = ret_data.dsc_total_charge_amt;
                                total_visa = ret_data.dsc_total_visa_amt;
                                total_amount = ret_data.dsc_total_amt;
                                total_deduction_amount = ret_data.dsc_total_deduction_amt;
                                total_netDeposit_amount = ret_data.dsc_net_deposite_amt;

                                var i;
                                var j;
                                var n;

                                var count_item2 = 0;
                                var d_line_count = 0;



                                for (j = 0; j < ret_data_deductions.length; j++) {
                                    console.log(ret_data_deductions[j].dsc_store_code);
                                    deduction_arr.push([ret_data_deductions[j].exp_amt,
                                        ret_data_deductions[j].exp_desc,
                                        ret_data_deductions[j].entry_date,
                                        ret_data_deductions[j].exp_type,
                                        ret_data_deductions[j].line_no
                                    ])
                                    d_line_count++;
                                    $("#deduction_items_container").append(
                                        '<tr><td style="text-align:center">' +
                                        ret_data_deductions[j].exp_type +
                                        '</td><td style="text-align:center">' +
                                        ret_data_deductions[j].exp_amt +
                                        '</td><td style="text-align:center">' +
                                        ret_data_deductions[j].exp_desc +
                                        '</td><td style="text-align:center"><input style="max-width: 41px;font-size: 22px;border-radius: 24px;border: 2px solid;text-align: center;align-self: center;margin-top: 2%;margin-left:44%" id="deleteItem" type="button" value="X" onclick="removeDeductionItem(this,this.parentNode.parentNode.rowIndex)"/></td></tr>'
                                        );
                                }
                                deduction_line_no = d_line_count;

                                for (i = 0; i < ret_data_details.length; i++) {
                                    console.log(ret_data_details[i].dsc_store_code);

                                    details_arr.push([ret_data_details[i].dtl_entry_date,
                                        ret_data_details[i].dtl_sales_type,
                                        ret_data_details[i].dtl_visa_cname,
                                        ret_data_details[i].dtl_amt, ret_data_details[i]
                                        .dtl_note
                                    ])

                                    // if (count_item2 == 0) {
                                    $("#items_container").append(
                                        '<tr><td style="text-align:center">' +
                                        ret_data_details[i].dtl_entry_date +
                                        '</td><td style="text-align:center">' +
                                        ret_data_details[i].dtl_sales_type +
                                        '</td><td style="text-align:center">' +
                                        ret_data_details[i].dtl_visa_cname +
                                        '</td><td style="text-align:center">' +
                                        ret_data_details[i].dtl_amt +
                                        '</td><td style="text-align:center">' +
                                        ret_data_details[i].dtl_note +
                                        '</td><td style="text-align:center"><input style="max-width: 41px;font-size: 22px;border-radius: 24px;border: 2px solid;text-align: center;align-self: center;margin-top: 7%;" id="deleteItem" type="button" value="X" onclick="removeItem(this,this.parentNode.parentNode.rowIndex)"/></td></tr>'
                                        );
                                    card_names_selected.push(ret_data_details[i].dtl_visa_cname);
                                    sales_types_selected.push(ret_data_details[i].dtl_sales_type);
                                    //     count_item2++;
                                    // } else {
                                    //     $("#items_container").append('<tr><td>' + ret_data_details[i].dtl_entry_date + '</td><td>' + ret_data_details[i].dtl_sales_type + '</td><td>' +
                                    //     ret_data_details[i].dtl_visa_cname + '</td><td>' + ret_data_details[i].dtl_amt + '</td><td>' + ret_data_details[i].dtl_note + '</td><td><input style="max-width: 41px;font-size: 22px;border-radius: 24px;border: 2px solid;text-align: center;align-self: center;margin-top: 7%;" id="deleteItem" type="button" value="X" onclick="removeItem(this,this.parentNode.parentNode.rowIndex)"/></td></tr>');
                                    //     card_names_selected.push(ret_data_details[i].dtl_visa_cname);
                                    //     sales_types_selected.push(ret_data_details[i].dtl_sales_type);
                                    // }
                                }
                            } else {
                                action = "insert";
                                $('#dsc_total_visa_amt').val('');
                                $('#dsc_total_cash_amt').val('');
                                $('#dsc_total_charge_amt').val('');
                                $('#dec_total_amt').val('');
                                // $('#dec_deduction_amt').val('');
                                $('#dec_net_deposit_amt').val('');
                                // $('#deduction_reason').val('');
                                $('#dec_total_deduction').val('');
                                $('#cash_in_branch').val(cash_after_deposit);
                                total_cash_in_branch_amount = cash_after_deposit;
                                $('#image').val('');
                                $('#blah').css("display", "none");
                                $('#note1').val('');
                                $('#note2').val('');
                                $("#deduction_items_container > *").remove();
                                $("#items_container > *").remove();
                            }

                        }


                    }

                },
                error: function(jqXHR, status, errorThrown) {
                    HideProgressAnimation()
                    alert("Failed TO SAVED DATA!");
                }
            });
            console.log("Final Details Array : ", details_arr);
            count_item = 0;
            count_item2 = 0;
            total_cash = 0;
            total_charge = 0;
            total_visa = 0;
            total_amount = 0;
            deduction_line_no = 0;
            total_deduction_amount = 0;
            total_netDeposit_amount = 0;
            details_arr = [];
            deduction_arr = [];
            card_names_selected = [];
            sales_types_selected = [];
            exp_types_selected = [];
        }

    }

    console.log("action : ", action);

});
</script>

</html>


<?php


    }
    else
    {
        header('location:Home.php');
        exit();
    }
}
else if (!isset($_SESSION['U_Name']))
{
    // echo "You don't have a permision to access this page " . " , " . "Please Login First ";
    // header("refresh:3;url=login.php");
}
?>
