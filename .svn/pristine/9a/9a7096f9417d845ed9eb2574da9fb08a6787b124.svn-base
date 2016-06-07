<?php
    include '../models/database.php';
    $DatabaseRequest = new DatabaseRequest;
    
    //Collect Form
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $biography = $_POST['biography'];
    $personal_link = $_POST['personal_link'];
    $user_id = $_POST['user_id'];
    
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
 
    if(!empty($_FILES["profile_photo"]["name"])){
        //Support vars
        $target_dir = "../profile_portraits/";
        $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOK = 1;
        
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["profile_photo"]["tmp_name"]);
            if($check == false) {
                $uploadOK = 0;
                header("Location: ../editprofile.php?m=2");
                return;            
            } 
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOK = 0;
            header("Location: ../editprofile.php?m=6");
            return;        
        }

        // Check file size
        if ($_FILES["profile_photo"]["size"] > 512000) {
            $uploadOK = 0;
            header("Location: ../editprofile.php?m=3");
            return;        
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            $uploadOK = 0;
            header("Location: ../editprofile.php?m=4");
            return;        
        }        
       
        if ($uploadOK == 1) {
            if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
                generateProfilePhoto(basename($target_file));
                $updatePhoto = $DatabaseRequest->updateProfilePhoto("p_" . basename($target_file), $user_id);
                header("Location: ../editprofile.php?m=1");
                return;
            }
        } else {
            header("Location: ../editprofile.php?m=5");
            return;      
        }
    }
    
    if(!empty($first_name)){
        $updateFirstName = $DatabaseRequest->updateFirstName($first_name, $user_id);
    }
    
    if(!empty($last_name)){
        $updateLastName = $DatabaseRequest->updateLastName($last_name, $user_id);
    }
    
    if(!empty($biography)){
        $updateBio = $DatabaseRequest->updateProfileBio($biography, $user_id);
    }

    if(!empty($personal_link)){
        $updatePersonalLink = $DatabaseRequest->updateProfileLink($personal_link, $user_id);
    }

    header("Location: ../editprofile.php?m=1");
    
?>    
    

