<?php

    $asset_id = $_GET['id'];
    
    // If a value we don't like gets passed in, send them to 404
    if (is_null($asset_id) || is_nan($asset_id)) {
        header('Location: http://sfsuswe.com/~s16g08/404.php');
    }
    
    include './models/database.php';
    include './header.php';
    
    $DatabaseRequest = new DatabaseRequest;
    
    $asset = $DatabaseRequest->getAssetData($asset_id);
    
    $user = $DatabaseRequest->getUserDataFromId($_SESSION["user-s16g08"]->getUserId());
    
    if($asset->getUserId() != $user->getUserId()){
        echo '<meta http-equiv="refresh" content="0; URL=404.php">';
    }    
    
    $message = isset($_GET['m']) ? $_GET['m'] : 0;
    
?>
<!-- License Modal -->
<?php include ('./modals/licenseModal.php')?>

<div class="page-wrap">
    <div class="container lnd-container">
        <h2 class="page-title">Edit Asset</h2>  
        <div class="row">
            <div id="asset-display" class="col-md-6">
                
                <?php 
                    if($asset->getType() == 2) {
                         echo "
                                <video class='video-responsive center-block' width='600px' height='540px' preload='metadata' controls>
                                    <source src='images/" . $asset->getOriginalURL() . "' type='video/mp4'>
                                    <source src='images/" . $asset->getOriginalURL() . "' type='video/ogg'>
                                    <source src='images/" . $asset->getOriginalURL() . "' type='video/webm'>
                                    Your browser does not support the video tag
                                </video>
                                <div class='watermark-detail'>Wabi</div>"; ?>
                <?php
                    } else { 
                        echo " <img class='img-responsive center-block' src='images/" . $asset->getOriginalURL() . "' />"; 
                    }?>
            </div>
            
            <form action="./controllers/edit_asset.php" method="POST" class="col-md-6 core-input" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="asset_title">Title:</label>
                    <input type="text" class="form-control" id="asset_title" name="asset_title" value="<?php echo $asset->getTitle(); ?>">
                </div>    
                <div class="form-group">
                    <label for="asset_description">Description:</label>
                    <textarea class="form-control" rows="5" id="asset_description" name="asset_description" style="resize:vertical"><?php echo $asset->getDescription(); ?></textarea>
                </div>
                <h4 class="center-text">Update the prices for your licenses (in USD)
                    <a href="#licenseModal" data-toggle="modal">
                        <span class="glyphicon glyphicon-question-sign"></span>
                    </a>
                </h4>
                <div class="form-horizontal form-group">
                    <label for="asset_web" class="col-md-2">Web:</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="asset_web" name="asset_web" value="<?php echo $asset->getWebPrice(); ?>">                    
                    </div>
                    <label for="asset_print" class="col-md-2">Print:</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="asset_print" name="asset_print" value="<?php echo $asset->getPrintPrice(); ?>">                    
                    </div>
                    <label for="asset_unlimited" class="col-md-2">Unlimited:</label>
                    <div class="col-md-2">
                        <input type="text" class="form-control" id="asset_unlimited" name="asset_unlimited" value="<?php echo $asset->getUnlimitedPrice(); ?>">                    
                    </div>
                </div>
                <div class="form-group">
                    <label for="updateAsset" style="padding-top:15px;">Select File:</label>
                    <input type="file" id="updateAsset" name="updateAsset">
                    <p class="help-block">File must be under 50MB. 
                        <?php 
                        if($asset->getType()==1){ 
                            echo "Acceptable formats: JPG, JPEG, PNG, GIF";                           
                        } else { 
                            echo "Acceptable formats: MP4, OGG, WEBM.";
                        }?></p>
                </div>
                <?php
                    switch ($message) {
                        case 1:
                            echo "<div class='alert alert-success' role='alert'>Your changes have been saved.</div>";
                            break;
                        case 2:
                            echo "<div class='alert alert-danger' role='alert'><b>Asset update failed.</b> The file you are uploading is not an image.</div>";
                            break;
                        case 3:
                            echo "<div class='alert alert-danger' role='alert'><b>Asset update failed.</b> The file you are uploading is larger than the maximum of 50mb.</div>";
                            break;
                        case 4:
                            echo "<div class='alert alert-danger' role='alert'><b>Asset update failed.</b> The file you are uploading is not a JPG, JPEG, GIF, PNG, MP4, OGG, or WEBM file.</div>";
                            break;
                        case 5:
                            echo "<div class='alert alert-danger' role='alert'><b>Asset update failed.</b> An unknown error occured while processing your file.</div>";
                            break;
                        case 6:
                            echo "<div class='alert alert-danger' role='alert'><b>Asset update failed.</b> The file you are uploading already exists on the server.</div>";
                            break;                            
                        default:
                            break;
                    }

                ?>
                  <button type="submit" name="submit" class="btn btn-primary pull-right">Save Changes</button>
                  <button type="reset" class="btn btn-default">Reset</button>
                  <input type="hidden" name="user_id" value="<?php echo $user->getUserId(); ?>">
                  <input type="hidden" name="asset_id" value="<?php echo $asset->getId(); ?>">                  
            </form>            
        </div>

    </div>
</div>

<?php include ('footer.php') ?>