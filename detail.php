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

    if ($asset->getId() == '') {
        echo '<meta http-equiv="refresh" content="0; URL=404.php">';
    }
        
    $author = $DatabaseRequest->getUserDataFromID($asset->getUserId());
                
    $purchases = array();
    //Check if logged in
    if (isset($_SESSION["isLoggedIn-s16g08"])) {
        $purchasedData = $_SESSION['purchase-s16g08'];
        foreach ($purchasedData as $purchase) {
            $purchases[] = $purchase->getAssetId();
        }
        $currUserID = $_SESSION['user-s16g08']->getUserId();
    }
    else {
        $currUserID = 0;
    }
?>

<!-- License Modal -->
<?php include ('./modals/licenseModal.php')?>

<div class="page-wrap">
    <div class="container lnd-container">
        <h2 class="page-title">Asset Details</h2>  
        <div class="row">
            <div id="asset-display" class="col-md-12">
                
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
                    }
                    else echo " <img class='img-responsive center-block' src='images/" . $asset->getOriginalURL() . "' />"
                            . "<div class='watermark-detail'>Wabi</div>"; ?>
            </div>
        </div>

        <div class="row">
            <div id="asset-metadata" class="col-md-6 col-md-offset-3 col-sm-12">
                <p>
                    <span id="asset-title"><?php echo $asset->getTitle(); ?></span>
                    <span id="asset-author"> 
                        <a href="profile.php?id=<?php echo $author->getUserID() ?>">
                            <?php echo " by " . $author->getUserFirstName() . " " . $author->getUserLastName(); ?>
                        </a>
                    </span>
                </p>
                <p id="asset-description"><b>Asset ID: </b><?php echo $asset->getId(); ?>                
                <p id="asset-description"><b>Description:</b><br><?php echo $asset->getDescription(); ?>
                <p id="asset-dimensions">
                <!-- Process for getting image dimensions -->
                <?php
                    if($asset->getType() == 2) {
                        $width = 600;
                        $height = 540;
                        echo "<b>Dimensions (pixels): </b><br>" . $width ."x". $height;
                                
                    } else {
                        $dimensions = getimagesize("images/" . $asset->getOriginalURL());
                        $width = $dimensions[0];
                        $height = $dimensions[1];            

                        echo "<b>Dimensions (pixels): </b><br>" . $width ."x". $height;
                    }
                ?>
                </p>

                <!-- Begin Form -->
                <form id="asset-purchase">
                    <h4>
                        Purchase License
                        <a href="#licenseModal" data-toggle="modal">
                            <span class="glyphicon glyphicon-question-sign"></span>
                        </a>
                    </h4>
                <?php
                    if($asset->getType() == 1) {  
                        ?>                  
                    <div id='license-selector-group' class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" id="license-web-button" data-licensetype="W" data-price="<?php echo $asset->getWebPrice(); ?>" class="btn btn-default active"><?php echo "Web $" . $asset->getWebPrice(); ?></button>
                        <button type="button" id="license-print-button" data-licensetype="P" data-price="<?php echo $asset->getPrintPrice(); ?>" class="btn btn-default"><?php echo "Print $" . $asset->getPrintPrice(); ?></button>
                        <button type="button" id="license-unlimited-button" data-licensetype="U" data-price="<?php echo $asset->getUnlimitedPrice(); ?>" class="btn btn-default"><?php echo"Unlimited $" .  $asset->getUnlimitedPrice(); ?></button>
                    </div>
                    <?php
                    } else { ?>
                    <div id='license-selector-group' aria-label="Basic example">
                        <button type="button" id="license-web-button" data-licensetype="W" data-price="<?php echo $asset->getWebPrice(); ?>" class="btn btn-default active vid-web-btn"><?php echo "Web $" . $asset->getWebPrice(); ?></button>
                    </div>   
                    <?php
                    }   
                        if ($currUserID == $author->getUserID()){
                            echo '<a href="./editasset.php?id='.$asset->getId().'" id="buy-asset-button" type="button" class="btn btn-default">Edit Asset</a>';
                        } else if (in_array($asset_id, $purchases)) {
                            echo '<button href="" type="button" id="buy-asset-button" class="btn btn-default" data-toggle="modal">Download Now</button>';
                        } else {
                            echo '<button href="#buy_modal_asset" type="button" id="buy-asset-button" class="btn btn-default" data-toggle="modal">Buy Now</button>';
                        }
                    ?>
                </form>
                <!-- End Form -->
            </div>
        </div>
    </div>
</div>
<?php

echo "<script>
    $(document).ready(function(){
    var activePrice = $('#license-web-button');
    
    $('#license-selector-group > button').on('click', function() {
        $('#license-selector-group > button').removeClass('active');
        $(this).addClass('active');
        activePrice = $(this);
    });";

    if (isset($_SESSION["isLoggedIn-s16g08"])) {
        echo "$('#modal_buy_asset').click(function(e){
            e.preventDefault();
            $.ajax({type: 'POST',
                url: '/~s16g08/controllers/purchase_asset_page.php',
                data: { userid:  " . $_SESSION['user-s16g08']->getUserId() . ", asset_id: " . $asset->getId() . ", license_type: activePrice.data('licensetype'), price: activePrice.data('price') },
                success:function(result){
                    location.reload();
                }
            });
          });
        ";
    }
echo "}); </script>";
?>

<?php
    include './footer.php';
?>