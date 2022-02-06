<?php
if(isset($_GET['insert_data'])){
    insert_data();
}

if(isset($_GET['close'])){
    close();
}

if(isset($_GET['unClose'])){
    unClose();
}

if(isset($_GET['closeRange'])){
    closeRange();
}

if(isset($_GET['unCloseRange'])){
    unCloseRange();
}


if(isset($_GET['get_last_cash'])){
    get_last_cash();
}

function get_last_cash(){

    // print_r($_FILES["image"]);

    include 'Config.php';
    include 'db_connection.php';

    parse_str($_POST["inputCashData"], $outputCashData);

    $stmt_last_cash = $conn->prepare("SELECT dsc_cash_in_branch_amt FROM actual_financedsc_mst WHERE dsc_store_code = '$outputCashData[storecode]' ORDER BY dsc_date DESC LIMIT 1");
    $stmt_last_cash->execute();
    $row_last_cash= $stmt_last_cash->fetch();

    $last_cash = $row_last_cash['dsc_cash_in_branch_amt'];

    if(!empty($last_cash)){
        $response["message"] ="exist_cash";
        $response["l_cash"] =$last_cash;
    }else{
        $response["message"] ="notfound_cash";
        $response["l_cash"] =0;
    }

    echo json_encode($response);

    }





function insert_data(){

// print_r($_FILES["image"]);

parse_str($_POST["inputData"], $outputFormData);


date_default_timezone_set('Africa/Cairo');
$time = date("H:i:s");
$d = date("Y-m-d");
$dateTime = $outputFormData['dateTimeSelect']." ".$time;
$date_selected =$outputFormData['dateTimeSelect'];
$action =$outputFormData['action'];
$time_selected = $time;

$image_date = str_replace("-","",$outputFormData['dateTimeSelect']);


include 'Config.php';
include 'db_connection.php';

$con = mysqli_connect("localhost","root","DejavuIt@150519","finance_dsc_db");
mysqli_set_charset($con , "utf8");

if(mysqli_connect_errno()){
    echo "Failed to connect to MYSQL : ". mysqli_connect_error();
}

$details_arr = json_decode(stripslashes($outputFormData['details_arr']));
$deduction_arr = json_decode(stripslashes($outputFormData['deduction_arr']));

$check_q = "SELECT * FROM actual_financedsc_mst
WHERE d_date = '$date_selected'
AND dsc_store_code ='$outputFormData[storecode]' ";

$check_d= "SELECT * FROM actual_financedsc_dtl WHERE d_date ='$date_selected' AND dsc_store_code ='$outputFormData[storecode]'";
$check_deduction= "SELECT * FROM actual_financedsc_exp WHERE d_date ='$date_selected' AND dsc_store_code ='$outputFormData[storecode]'";

if ($check_q != "")
{
    $stmt_check = $conn->prepare($check_q);
    $stmt_check_d = $conn->prepare($check_d);
    $stmt_check_deduction = $conn->prepare($check_deduction);

    $stmt_check->execute();
    $stmt_check_d->execute();
    $stmt_check_deduction->execute();


}


$count = $stmt_check->rowCount();

// echo "Query : ".$check_q."<br/>";
// echo "Count : ".$count."<br/>";

// $row = $stmt_check->fetchAll(PDO::FETCH_ASSOC);
$stmt_last_date = $conn->prepare("SELECT dsc_date FROM actual_financedsc_mst WHERE dsc_store_code = '$outputFormData[storecode]' ORDER BY dsc_date DESC LIMIT 1");
$stmt_last_date->execute();
$row_last_date= $stmt_last_date->fetch();
$row_date_explode = explode(" ",$row_last_date['dsc_date'])[0];

$startDatedt = date( 'Y-m-d',(strtotime ( '-2 day' , strtotime ( $row_date_explode) )));

// $endDatedt = date('Y-m-d',(strtotime('+2 days' ,strtotime ( $row_date_explode) )));

if(empty($row_date_explode )){
    $endDatedt = date('Y-m-d',(strtotime('+2 days' ,strtotime ( "2021-04-24") )));
}else{
    $endDatedt = date('Y-m-d',(strtotime('+2 days' ,strtotime ( $row_date_explode) )));

}

$usrDatedt = $date_selected;

function fn_resize($image_resource_id, $width, $height)
{
    $target_width = 600;
    $target_height = 800;
    $target_layer = imagecreatetruecolor($target_width, $target_height);
    imagecopyresampled($target_layer, $image_resource_id, 0, 0, 0, 0, $target_width, $target_height, $width, $height);
    return $target_layer;
}

if($action === "insert"){

if($count > 0){
    $row = $stmt_check->fetchAll(PDO::FETCH_ASSOC);
    $row2 = $stmt_check_d->fetchAll(PDO::FETCH_ASSOC);
    $row3 = $stmt_check_deduction->fetchAll(PDO::FETCH_ASSOC);

    // $response["message"] ="exist";
    // $response["data"] =json_encode($row);
    // $response["details"] =json_encode($row2);
    // $response["deductions"] =json_encode($row3);

    $stmt_closed= $conn->prepare("SELECT finance_closed FROM actual_financedsc_mst WHERE d_date = '$date_selected' AND dsc_store_code ='$outputFormData[storecode]' LIMIT 1");
    $stmt_closed->execute();
    $row_closed = $stmt_closed->fetch();

    if($row_closed['finance_closed'] === "no"){
        $response["message"] ="exist_no";
        $response["data"] ="";
        $response["details"] ="";
        $response["deductions"] ="";
    }else if($row_closed['finance_closed'] === "yes"){
        $response["message"] ="exist_yes";
        $response["data"] =json_encode($row);
        $response["details"] =json_encode($row2);
        $response["deductions"] =json_encode($row3);
    }

}

// else if(!($usrDatedt < $endDatedt))
// {
//     $response["message"] ="out_range_date_missing";
//     $response["data"] ="";
//     $response["details"] ="";
//     $response["deductions"] ="";
// }
// else if(!($usrDatedt > $startDatedt))
// {
//     $response["message"] ="out_range_date_before_till";
//     $response["data"] ="";
//     $response["details"] ="";
//     $response["deductions"] ="";
// }
else{
        $mst_q = "INSERT INTO actual_financedsc_mst
        (dsc_date,d_date,d_time,dsc_entry_user,dsc_store_code,dsc_total_visa_amt,
        dsc_total_cash_amt,dsc_total_charge_amt,dsc_total_amt,dsc_total_deduction_amt,
        dsc_net_deposite_amt,dsc_cash_in_branch_amt,dsc_cash_in_branch_bdeposit,dsc_cash_in_branch_adeposit,dsc_note1,
        dsc_note2)
        VALUES ('$dateTime','$date_selected','$time_selected','$outputFormData[username]','$outputFormData[storecode]','$outputFormData[dsc_total_visa_amt]',
        '$outputFormData[dsc_total_cash_amt]','$outputFormData[dsc_total_charge_amt]','$outputFormData[dec_total_amt]','$outputFormData[dec_total_deduction_amt]','$outputFormData[dec_net_deposit_amt]','$outputFormData[cash_in_branch_amt]','$outputFormData[cash_before]','$outputFormData[cash_after]','$outputFormData[note1]','$outputFormData[note2]') ";

        if(mysqli_query( $con, $mst_q)){
            if($details_arr){
                for($i =0 ;$i<count($details_arr) ; $i++){
                    $dtl_datTime =$details_arr[$i][0];
                    $sales_type =$details_arr[$i][1];
                    $visa_name =$details_arr[$i][2];
                    $amt =$details_arr[$i][3];
                    $note =$details_arr[$i][4];
                    $dtl_q = "INSERT INTO actual_financedsc_dtl
                    (d_date,dsc_store_code,dsc_dtl_entry_user,dtl_entry_date,
                    dtl_sales_type,dtl_visa_cname,dtl_amt,
                    dtl_note)
                    VALUES ('$date_selected','$outputFormData[storecode]','$outputFormData[username]','$dtl_datTime',
                    '$sales_type','$visa_name','$amt','$note') ";

                    mysqli_query( $con, $dtl_q);
                }

            }

            if($deduction_arr){
                for($j =0 ;$j<count($deduction_arr) ; $j++){
                    $d_amt =$deduction_arr[$j][0];
                    $d_r =$deduction_arr[$j][1];
                    // $deduction_q = "INSERT INTO actual_financedsc_exp
                    // (d_date,dsc_store_code,deduction_amt,deduction_desc)
                    // VALUES ('$date_selected','$outputFormData[storecode]','$d_amt','$d_r') ";

                    $d_date_time =$deduction_arr[$j][2];
                    $d_exp_type =$deduction_arr[$j][3];
                    $d_line_no =$deduction_arr[$j][4];
                    $stmt1 = $conn->prepare("SELECT line_no FROM  actual_financedsc_exp ORDER BY line_no DESC LIMIT 1;");
                    $stmt1->execute();
                    $row1 = $stmt1->fetch();
                    $line_no= $row1['line_no'] + 1;
                    $deduction_q = "INSERT INTO actual_financedsc_exp
                    (d_date,dsc_store_code,exp_amt,exp_desc,line_no,exp_type,entry_date,entry_user)
                    VALUES ('$date_selected','$outputFormData[storecode]','$d_amt','$d_r','$d_line_no','$d_exp_type','$d_date_time','$outputFormData[username]') ";

                    mysqli_query( $con, $deduction_q);
                }

            }



            if($_FILES){
                if (($_FILES['image']))
                {
                    $im1 = $_FILES['image']['tmp_name'];

                    $uploads_dir = 'F:/XAMPP/htdocs/DejavuPortal/dop_images';

                        $file_name = $_FILES['image']['name'];
                        $ext = substr("$file_name", -4);
                        $find='.';
                        $pos = strpos($ext, $find);
                        if($pos===false)
                        {
                            $ext = substr("$file_name", -5);
                        }
                        $image =  $outputFormData['storecode'].$image_date."_1" . $ext;
                        if ($ext == '')
                        {
                            $image = '';
                        }
                        $file = $_FILES['image']['tmp_name'];
                        $source_properties = getimagesize($file);
                        if ($_FILES['image']['size'] > 200000)
                        {
                            $image_type = $source_properties[2];
                            if ($image_type == IMAGETYPE_JPEG)
                            {
                                $image_resource_id = imagecreatefromjpeg($file);
                                $target_layer = fn_resize($image_resource_id, $source_properties[0],$source_properties[1]);
                                imagejpeg($target_layer, "F:/XAMPP/htdocs/DejavuPortal/dop_images/" . $image);
                            }
                            elseif ($image_type == IMAGETYPE_GIF)
                            {
                                $image_resource_id = imagecreatefromgif($file);
                                $target_layer = fn_resize($image_resource_id, $source_properties[0], $source_properties[1]);
                                imagegif($target_layer, "F:/XAMPP/htdocs/DejavuPortal/dop_images/" . $image);
                            }
                            elseif ($image_type == IMAGETYPE_PNG)
                            {
                                $image_resource_id = imagecreatefrompng($file);
                                $target_layer = fn_resize($image_resource_id, $source_properties[0], $source_properties[1]);
                                imagepng($target_layer, "F:/XAMPP/htdocs/DejavuPortal/dop_images/" . $image);
                            }
                            elseif ($image_type == IMAGETYPE_BMP)
                            {
                                $image_resource_id = imagecreatefrombmp($file);
                                $target_layer = fn_resize($image_resource_id, $source_properties[0], $source_properties[1]);
                                imagebmp($target_layer, "F:/XAMPP/htdocs/DejavuPortal/dop_images/" . $image);
                            }

                        }
                        else {
                            $file = $_FILES['image']['tmp_name'];
                            move_uploaded_file($file, "$uploads_dir/$image");
                        }

                        if (isset($im1))
                        {
                            $stmtImage1 = $conn->prepare("UPDATE actual_financedsc_mst
                                SET TIMAGE1='$image',TIMAGE2='' WHERE d_date ='$date_selected' AND dsc_store_code ='$outputFormData[storecode]'  ");
                            $stmtImage1->execute();
                        }


                }
            }


                $response["message"] ="saved";
                $response["data"] ="";
                $response["details"] ="";


        } else{
            $response["message"] ="failed";
            $response["data"] ="";
            $response["details"] ="";

        }

}
}else if($action === "update"){


    $mst_q_delete = "DELETE FROM actual_financedsc_mst WHERE d_date = '$date_selected' AND dsc_store_code ='$outputFormData[storecode]'";
    $dtl_q_delete = "DELETE FROM actual_financedsc_dtl WHERE d_date = '$date_selected' AND dsc_store_code ='$outputFormData[storecode]'";
    $deduction_q_delete = "DELETE FROM actual_financedsc_exp WHERE d_date = '$date_selected' AND dsc_store_code ='$outputFormData[storecode]'";

       if(mysqli_query( $con, $dtl_q_delete)){
        if(mysqli_query( $con, $mst_q_delete)){
            if(mysqli_query( $con, $deduction_q_delete)){
        $mst_q = "INSERT INTO actual_financedsc_mst
        (dsc_date,d_date,d_time,dsc_entry_user,dsc_store_code,dsc_total_visa_amt,
        dsc_total_cash_amt,dsc_total_charge_amt,dsc_total_amt,dsc_total_deduction_amt,
        dsc_net_deposite_amt,dsc_cash_in_branch_amt,dsc_cash_in_branch_bdeposit,dsc_cash_in_branch_adeposit,dsc_note1,
        dsc_note2)
        VALUES ('$dateTime','$date_selected','$time_selected','$outputFormData[username]','$outputFormData[storecode]','$outputFormData[dsc_total_visa_amt]',
        '$outputFormData[dsc_total_cash_amt]','$outputFormData[dsc_total_charge_amt]','$outputFormData[dec_total_amt]','$outputFormData[dec_total_deduction_amt]','$outputFormData[dec_net_deposit_amt]','$outputFormData[cash_in_branch_amt]','$outputFormData[cash_before]','$outputFormData[cash_after]','$outputFormData[note1]','$outputFormData[note2]') ";


        if(mysqli_query( $con, $mst_q)){
            if($details_arr){
                for($i =0 ;$i<count($details_arr) ; $i++){
                    $dtl_datTime =$details_arr[$i][0];
                    $sales_type =$details_arr[$i][1];
                    $visa_name =$details_arr[$i][2];
                    $amt =$details_arr[$i][3];
                    $note =$details_arr[$i][4];
                    $dtl_q = "INSERT INTO actual_financedsc_dtl
                    (d_date,dsc_store_code,dsc_dtl_entry_user,dtl_entry_date,
                    dtl_sales_type,dtl_visa_cname,dtl_amt,
                    dtl_note)
                    VALUES ('$date_selected','$outputFormData[storecode]','$outputFormData[username]','$dtl_datTime',
                    '$sales_type','$visa_name','$amt','$note') ";

                    mysqli_query( $con, $dtl_q);
                }


            }

            if($deduction_arr){
                for($j =0 ;$j<count($deduction_arr) ; $j++){
                    $d_amt =$deduction_arr[$j][0];
                    $d_r =$deduction_arr[$j][1];
                    $d_date_time =$deduction_arr[$j][2];
                    $d_exp_type =$deduction_arr[$j][3];
                    $d_line_no =$deduction_arr[$j][4];
                    $stmt1 = $conn->prepare("SELECT line_no FROM  actual_financedsc_exp ORDER BY line_no DESC LIMIT 1;");
                    $stmt1->execute();
                    $row1 = $stmt1->fetch();
                    $line_no= $row1['line_no'] + 1;
                    $deduction_q = "INSERT INTO actual_financedsc_exp
                    (d_date,dsc_store_code,exp_amt,exp_desc,line_no,exp_type,entry_date,entry_user)
                    VALUES ('$date_selected','$outputFormData[storecode]','$d_amt','$d_r','$d_line_no','$d_exp_type','$d_date_time','$outputFormData[username]') ";

                    mysqli_query( $con, $deduction_q);
                }

            }

            if($_FILES){
            if (($_FILES['image']))
            {
                $im1 = $_FILES['image']['tmp_name'];

                $uploads_dir = 'F:/XAMPP/htdocs/DejavuPortal/dop_images';

                    $file_name = $_FILES['image']['name'];
                    $ext = substr("$file_name", -4);
                    $find='.';
                    $pos = strpos($ext, $find);
                    if($pos===false)
                    {
                        $ext = substr("$file_name", -5);
                    }
                    $image =  $outputFormData['storecode'].$image_date."_1" . $ext;
                    if ($ext == '')
                    {
                        $image = '';
                    }
                    $file = $_FILES['image']['tmp_name'];
                    $source_properties = getimagesize($file);
                    if ($_FILES['image']['size'] > 200000)
                    {
                        $image_type = $source_properties[2];
                        if ($image_type == IMAGETYPE_JPEG)
                        {
                            $image_resource_id = imagecreatefromjpeg($file);
                            $target_layer = fn_resize($image_resource_id, $source_properties[0],$source_properties[1]);
                            imagejpeg($target_layer, "F:/XAMPP/htdocs/DejavuPortal/dop_images/" . $image);
                        }
                        elseif ($image_type == IMAGETYPE_GIF)
                        {
                            $image_resource_id = imagecreatefromgif($file);
                            $target_layer = fn_resize($image_resource_id, $source_properties[0], $source_properties[1]);
                            imagegif($target_layer, "F:/XAMPP/htdocs/DejavuPortal/dop_images/" . $image);
                        }
                        elseif ($image_type == IMAGETYPE_PNG)
                        {
                            $image_resource_id = imagecreatefrompng($file);
                            $target_layer = fn_resize($image_resource_id, $source_properties[0], $source_properties[1]);
                            imagepng($target_layer, "F:/XAMPP/htdocs/DejavuPortal/dop_images/" . $image);
                        }
                        elseif ($image_type == IMAGETYPE_BMP)
                        {
                            $image_resource_id = imagecreatefrombmp($file);
                            $target_layer = fn_resize($image_resource_id, $source_properties[0], $source_properties[1]);
                            imagebmp($target_layer, "F:/XAMPP/htdocs/DejavuPortal/dop_images/" . $image);
                        }

                    }
                    else {
                        $file = $_FILES['image']['tmp_name'];
                        move_uploaded_file($file, "$uploads_dir/$image");
                    }

                    if (isset($im1))
                    {
                        $stmtImage1 = $conn->prepare("UPDATE actual_financedsc_mst
                            SET TIMAGE1='$image',TIMAGE2='' WHERE d_date ='$date_selected' AND dsc_store_code ='$outputFormData[storecode]'  ");
                        $stmtImage1->execute();
                    }


            }
        }
            $response["message"] ="update";
            $response["data"] ="";
            $response["details"] ="";

        } else{
            $response["message"] ="failed";
            $response["data"] ="";
            $response["details"] ="";

        }
       }
    }
   }

}
echo json_encode($response);
}

function close(){
    parse_str($_POST["inputClosedData"], $outputClosed);


    date_default_timezone_set('Africa/Cairo');
    $date_to_close = $outputClosed['date_to_close'];
    $store_to_close =$outputClosed['store_to_close'];

    include 'Config.php';
    include 'db_connection.php';

    $con = mysqli_connect("localhost","root","DejavuIt@150519","finance_dsc_db");
    mysqli_set_charset($con , "utf8");

    if(mysqli_connect_errno()){
        echo "Failed to connect to MYSQL : ". mysqli_connect_error();
    }

    $check_to_close = "SELECT * FROM actual_financedsc_mst
    WHERE d_date = '$date_to_close'
    AND dsc_store_code ='$store_to_close' ";

        if ($check_to_close != "")
        {
            $stmt_check_close = $conn->prepare($check_to_close);
            $stmt_check_close->execute();

        }
        $count_close = $stmt_check_close->rowCount();

        if($count_close > 0){
            $stmtClose = $conn->prepare("UPDATE actual_financedsc_mst
            SET finance_closed='no' WHERE d_date ='$date_to_close' AND dsc_store_code ='$store_to_close' ");
            $stmtClose->execute();
            $response["message"] ="closedDone";

        }else{
            $response["message"] ="failed";
        }


        echo json_encode($response);
    }
function unClose(){
    parse_str($_POST["inputClosedData"], $outputClosed);


    date_default_timezone_set('Africa/Cairo');
    $date_to_close = $outputClosed['date_to_close'];
    $store_to_close =$outputClosed['store_to_close'];

    include 'Config.php';
    include 'db_connection.php';

    $con = mysqli_connect("localhost","root","DejavuIt@150519","finance_dsc_db");
    mysqli_set_charset($con , "utf8");

    if(mysqli_connect_errno()){
        echo "Failed to connect to MYSQL : ". mysqli_connect_error();
    }

    $check_to_close = "SELECT * FROM actual_financedsc_mst
    WHERE d_date = '$date_to_close'
    AND dsc_store_code ='$store_to_close' ";

        if ($check_to_close != "")
        {
            $stmt_check_close = $conn->prepare($check_to_close);
            $stmt_check_close->execute();

        }
        $count_close = $stmt_check_close->rowCount();

        if($count_close > 0){
            $stmtClose = $conn->prepare("UPDATE actual_financedsc_mst
            SET finance_closed='yes' WHERE d_date ='$date_to_close' AND dsc_store_code ='$store_to_close' ");
            $stmtClose->execute();
            $response["message"] ="unClosedDone";

        }else{
            $response["message"] ="failed";
        }


        echo json_encode($response);
}


function closeRange(){
    parse_str($_POST["inputClosedRangeData"], $outputClosedRange);


    date_default_timezone_set('Africa/Cairo');
    $date_close_from = $outputClosedRange['date_close_from'];
    $date_close_to =$outputClosedRange['date_close_to'];
    $store_close =$outputClosedRange['store_close'];
    include 'Config.php';
    include 'db_connection.php';

    $con = mysqli_connect("localhost","root","DejavuIt@150519","finance_dsc_db");
    mysqli_set_charset($con , "utf8");

    if(mysqli_connect_errno()){
        echo "Failed to connect to MYSQL : ". mysqli_connect_error();
    }

    if($store_close != ''){
        $check_to_close_range = "SELECT * FROM actual_financedsc_mst WHERE dsc_store_code ='$store_close' AND (d_date BETWEEN '$date_close_from' AND '$date_close_to') ";
    }else{
        $check_to_close_range = "SELECT * FROM actual_financedsc_mst WHERE (d_date BETWEEN '$date_close_from' AND '$date_close_to') ";
    }


        if ($check_to_close_range != "")
        {
            $stmt_check_close_range = $conn->prepare($check_to_close_range);
            $stmt_check_close_range->execute();

        }
        $count_close_range = $stmt_check_close_range->rowCount();

        if($count_close_range > 0){

            if($store_close != ''){
                $stmtCloseRange = $conn->prepare("UPDATE actual_financedsc_mst SET finance_closed='no' WHERE dsc_store_code ='$store_close' AND (d_date BETWEEN '$date_close_from' AND '$date_close_to')");
            }else{
                $stmtCloseRange = $conn->prepare("UPDATE actual_financedsc_mst
                SET finance_closed='no' WHERE (d_date BETWEEN '$date_close_from' AND '$date_close_to') ");
            }


            $stmtCloseRange->execute();
            $response["message"] ="ClosedRangeDone";

        }else{
            $response["message"] ="failed";
        }


        echo json_encode($response);
}

function unCloseRange(){
    parse_str($_POST["inputClosedRangeData"], $outputClosedRange);


    date_default_timezone_set('Africa/Cairo');
    $date_close_from = $outputClosedRange['date_close_from'];
    $date_close_to =$outputClosedRange['date_close_to'];
    $store_close =$outputClosedRange['store_close'];

    include 'Config.php';
    include 'db_connection.php';

    $con = mysqli_connect("localhost","root","DejavuIt@150519","finance_dsc_db");
    mysqli_set_charset($con , "utf8");

    if(mysqli_connect_errno()){
        echo "Failed to connect to MYSQL : ". mysqli_connect_error();
    }

        if($store_close != ''){
            $check_to_close_range = "SELECT * FROM actual_financedsc_mst WHERE dsc_store_code ='$store_close' AND (d_date BETWEEN '$date_close_from' AND '$date_close_to') ";
        }else{
            $check_to_close_range = "SELECT * FROM actual_financedsc_mst WHERE (d_date BETWEEN '$date_close_from' AND '$date_close_to') ";
        }


        if ($check_to_close_range != "")
        {
            $stmt_check_close_range = $conn->prepare($check_to_close_range);
            $stmt_check_close_range->execute();

        }
        $count_close_range = $stmt_check_close_range->rowCount();

        if($count_close_range > 0){


            if($store_close != ''){
                $stmtCloseRange = $conn->prepare("UPDATE actual_financedsc_mst SET finance_closed='yes' WHERE dsc_store_code ='$store_close' AND (d_date BETWEEN '$date_close_from' AND '$date_close_to') ");
        }else{
                $stmtCloseRange = $conn->prepare("UPDATE actual_financedsc_mst SET finance_closed='yes' WHERE (d_date BETWEEN '$date_close_from' AND '$date_close_to') ");
        }
        $stmtCloseRange->execute();

            $response["message"] ="unClosedRangeDone";

        }else{
            $response["message"] ="failed";
        }


        echo json_encode($response);
}


?>
