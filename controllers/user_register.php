<?php
include '../models/database.php';
require('../libr/password_library.php');

session_start();

$DatabaseRequest = new DatabaseRequest;

$salt = "$2a$07$aauabiquytqiuewgaskdfasdhfadbvblajsdfahgdkfahsgd";

$username = $_POST['email']; //also email
$password = $_POST['password'];
$password2 = $_POST['password2'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$accountType = $_POST['accountType'];
$bio = $_POST['biography'];
$link = $_POST['personalLink'];

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$url = 'http://' . $_SERVER['HTTP_HOST'] .  "/~s16g08";

//Set account type
if($accountType == "artist") {
  $dbAccountType = 2;
} else {
  $dbAccountType = 3;
} 
 
function generateProfilePhoto($filename) {

    $file_prefix = "p_";

    // Establish file path
    $file_dir = "../profile_portraits/";
    $filepath = $file_dir . $filename;

    // Establish current image dimensions
    list($width, $height) = getimagesize($filepath);

    // Determine new dimensions
    if ($width > $height) {
        $y = 0;
        $x = ($width - $height)/2;
        $smallest = $height;
    } else {
        $x = 0;
        $y = ($height - $width)/2;
        $smallest = $width;
    }

    $profile_size = 250;
    $image_p = imagecreatetruecolor($profile_size, $profile_size);

    // Roll with the appropriate file extension
    switch(strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {

        case "jpeg":
            $image = imagecreatefromjpeg($filepath);
            break;
        case "jpg":
            $image = imagecreatefromjpeg($filepath);
            break;
        case "gif":
            $image = imagecreatefromgif($filepath);
            break;
        case "png":
            $image = imagecreatefrompng($filepath);
            break;
        default:
            echo "Invalid file. This shouldn't occur.";
            break;   

    }   // endswitch

    imagecopyresampled($image_p, $image, 0, 0, $x, $y, $profile_size, $profile_size, $smallest, $smallest);

    imagejpeg($image_p, $file_dir . $file_prefix . $filename);

}

if(!empty($_FILES["profilePic"]["name"])){

    $target_dir = "../profile_portraits/";
    $target_file = $target_dir . basename($_FILES["profilePic"]["name"]);
    $uploadOK = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["profilePic"]["tmp_name"]);
        if($check == false) {
            $uploadOK = 0;
            header("Location: ../signup.php?m=1");
            return;            
        } 
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOK = 0;
        header("Location: ../signup.php?m=5");
        return;        
    }

    // Check file size
    if ($_FILES["profilePic"]["size"] > 512000) {
        $uploadOK = 0;
        header("Location: ../signup.php?m=2");
        return;        
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $uploadOK = 0;
        header("Location: ../signup.php?m=3");
        return;        
    }

    // if everything is ok, try to upload file
    if ($uploadOK == 1 && $dbAccountType == 2) {
        if ((move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_file))) {    
            generateProfilePhoto(basename($target_file));

            if ($DatabaseRequest->signup($dbAccountType, $username, $hashedPassword, $firstname, $lastname, "p_" . basename($target_file), $bio, $link) == 1) {
                $user = $DatabaseRequest->getUserData($username);
                $pass_hash = $user->getUserPassword();

                if(password_verify($password, $hashedPassword)) {
                    $_SESSION['isLoggedIn-s16g08'] = true;
                    $_SESSION['user-s16g08'] = $user;
                    $purchasedData = $DatabaseRequest->getPurchaseData($_SESSION["user-s16g08"]->getUserId());
                    $_SESSION['purchase-s16g08'] = $purchasedData;
                }
                header('Location: ' . $url . '/index.php?m=100');
            } else { //error
              header('Location: ' . $url . '/signup.php?m=401');
            }
        } else {
            header("Location: ../signup.php?m=4");            
        }
    } else {
        header("Location: ../signup.php?m=4");
    }
} else {
    if ($DatabaseRequest->signup($dbAccountType, $username, $hashedPassword, $firstname, $lastname, "", $bio, $link) == 1) {
        $user = $DatabaseRequest->getUserData($username);
        $pass_hash = $user->getUserPassword();

        if(password_verify($password, $hashedPassword)) {
            $_SESSION['isLoggedIn-s16g08'] = true;
            $_SESSION['user-s16g08'] = $user;
            $purchasedData = $DatabaseRequest->getPurchaseData($_SESSION["user-s16g08"]->getUserId());
            $_SESSION['purchase-s16g08'] = $purchasedData;
        }
        header('Location: ' . $url . '/index.php?m=100');
    } else { //error
      header('Location: ' . $url . '/signup.php?m=401');
    }  
}
?>