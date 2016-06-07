<?php
include '../models/database.php';
require('../libr/password_library.php');

session_start();

$DatabaseRequest = new DatabaseRequest;

$username = $_POST['loginusername'];
$password = $_POST['loginpassword'];
$user = $DatabaseRequest->getUserData($username);

if(empty($user)) {
    header('Location: ../login.php?m=401');
}

$pass_hash = $user->getUserPassword();

$purchases = array();

if (password_verify($password, $pass_hash)) {
  $_SESSION['isLoggedIn-s16g08'] = true;
  $_SESSION['user-s16g08'] = $user;
  $purchasedData = $DatabaseRequest->getPurchaseData($_SESSION["user-s16g08"]->getUserId());
  $_SESSION['purchase-s16g08'] = $purchasedData;

  //Redirect
  header('Location: ../index.php');
  
} else {
  header('Location: ../login.php?m=401');
}

?>