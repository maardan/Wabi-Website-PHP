<?php
    
    include '../models/database.php';
    
    $DatabaseRequest = new DatabaseRequest;
    define('MB', 1048576);
    
    function generateThumbnail($filename) {

        $file_prefix = "thumb_";
        $max_dimension = 400;
        
        // Establish file path
        $file_dir = "../images/";
        $filepath = $file_dir . $filename;
        
        // Establish current image dimensions
        list($width, $height) = getimagesize($filepath);
        
        // Determine new dimensions
        if ($width > $height) {
            $new_width = $max_dimension;
            $new_height = ($height/$width) * $max_dimension;
        } else {
            $new_width = ($width/$height) * $max_dimension;
            $new_height = $max_dimension;
        }
        
        $image_p = imagecreatetruecolor($new_width, $new_height);
        
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
        
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        
        imagejpeg($image_p, $file_dir . $file_prefix . $filename);
        
    }
    
    // AJAX image sourced from preloaders.net - free for any use
    echo "<div style='margin:200px auto;'><img src='./materials/284.gif'></div>";
  
    // POST
    $asset_title = $_POST['asset_title'];
    $asset_description = $_POST['asset_description'];
    $asset_type = $_POST['asset_type'];
    $asset_web = $_POST['asset_web'];
    $asset_print = $_POST['asset_print'];
    $asset_unlimited = $_POST['asset_unlimited'];
    $user_id = $_POST['userid'];
    
    // Support Vars
    $target_dir = "../images/";
    $target_file = $target_dir . basename($_FILES["fileUpload"]["name"]);
    $uploadOK = 1;
    
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    if ($asset_id == 1){
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileUpload"]["tmp_name"]);
            if ($check == false) {
                $uploadOK = 0;
                header("Location: ../manageassets.php?m=2#upload");
                return;
            }
        } 
    }
    
    //Check if file already exists
    if (file_exists($target_file)){
        $uploadOK = 0;
        header("Location: ../manageassets.php?m=6#upload");
        return;
    }
    
    // Assert file size under limit
    if ($_FILES["fileUpload"]["size"] > 50*MB) {
        echo "File size was " . $_FILES["fileUpload"]["size"];
        $uploadOK = 0;
        header("Location: ../manageassets.php?m=3#upload");
        return;
    }
    
    // Assert appropriate file type
    if ($imageFileType != "gif" && $imageFileType != "png" 
            && $imageFileType != "jpg" && $imageFileType != "jpeg" 
            && $imageFileType != "mp4" && $imageFileType != "ogg" && $imageFileType != "webm") {
        $uploadOK = 0;
        header("Location: ../manageassets.php?m=4#upload");
        return;
    }
    
    if ($uploadOK == 1) {
        // Attempt migration
        if (move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $target_file)) {
            if($asset_type == '1'){
                generateThumbnail(basename($target_file));
                // write to database
                $response = $DatabaseRequest->addAsset($user_id, $asset_type, $asset_title, $asset_description, "thumb_" . basename($target_file), basename($target_file), $asset_web, $asset_print, $asset_unlimited);
                header("Location: ../manageassets.php?m=1#upload");
                return;
            } else {
                // write to database
                $response = $DatabaseRequest->addAsset($user_id, $asset_type, $asset_title, $asset_description, "none", basename($target_file), $asset_web, 0, 0);
                header("Location: ../manageassets.php?m=1#upload");
                return;
            }    
        } else {
            header("Location: ../manageassets.php?m=5#upload");
            return;
        }    
    }
    
?>
    
    
    