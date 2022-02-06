<?php
$dsn= 'mysql:host=localhost;dbname=finance_dsc_db';
$user= 'root';
$password='DejavuIt@150519';
global $conn;
$options=array
(
    PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8 '
);
try
{
    $conn=new PDO($dsn,$user,$password,$options);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (Exception $ex)
{
    echo "not connected".$ex->getMessage();
}
