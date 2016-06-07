<?php
include '../models/database.php';
require('../libr/password_library.php');

session_start();

$userid = $_POST['userid'];
$assetid = $_POST['asset_id'];
$licenseType = $_POST['license_type'];
$price = $_POST['price'];

$DatabaseRequest = new DatabaseRequest;
$response = $DatabaseRequest->purchase($userid, $assetid, $licenseType, $price);

if($response === true) {
  $purchasedData = $DatabaseRequest->getPurchaseData($_SESSION["user-s16g08"]->getUserId());
  $_SESSION['purchase-s16g08'] = $purchasedData;
}

//Response true of success!
echo $response;
?>