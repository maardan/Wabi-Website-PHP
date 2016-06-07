<?php
    include '../models/database.php';
    
    session_start();
    $user_id = $_SESSION["user-s16g08"]->getUserId();
    
    $DatabaseRequest = new DatabaseRequest;
    
    $asset_id = $_POST['asset_id'];
    
    if (!is_numeric($asset_id)) {
        header('Location: ../manageassets.php?m=101#disable');
        break;
    }
   
    $response = $DatabaseRequest->disableAsset($user_id, $asset_id);
    
    if ($response == 1) {
        header('Location: ../manageassets.php?m=100#disable');
        break;
    } else {
        header('Location: ../manageassets.php?m=102#disable'); 
        break;   
    }
  
?>


