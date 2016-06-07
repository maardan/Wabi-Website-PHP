<?php
    
    $artist_id = $_GET['id'];
    
    // If a value we don't like gets passed in, send them to 404
    if (is_null($artist_id) || is_nan($artist_id)) {
        header('Location: http://sfsuswe.com/~s16g08/404.php');
    }
    
    include './models/database.php';

    
    $DatabaseRequest = new DatabaseRequest;
    
    $artist = $DatabaseRequest->getUserDataFromId($artist_id);

    //Checks if the id being accessed is for an artist.
    if($artist->getUserType() != 2){
        echo '<meta http-equiv="refresh" content="0; URL=404.php">';
    }
    
    include './header.php'; 
    
    $purchases = array();
     
    //Check if logged in
    if (isset($_SESSION["isLoggedIn-s16g08"])) {

      $purchasedData = $_SESSION['purchase-s16g08'];
      foreach ($purchasedData as $purchase) {
        $purchases[] = $purchase->getAssetId();
      }
      $currUserID = $_SESSION['user-s16g08']->getUserId();
    } else {
        $currUserID = 0;
    }
   
?>

<div class="page-wrap">
    <!-- Page Content -->
    <div class="container lnd-container">
        <h2 class="page-title">Artist Profile</h2> 
        
         <!-- Portfolio Item Row -->
        <div class="row">

            <div class="col-lg-2 col-md-2 col-sm-4">
                <?php
                    $user_profile = $artist->getUserProfilePhoto();
                    if ($user_profile != "") {
                        echo "<img class='img-responsive img-circle center-block' src='./profile_portraits/".$artist->getUserProfilePhoto()."' alt=''>";
                    } else {
                        echo "<img src='./materials/placeholder.png' class='center-block img-responsive img-circle' alt=''>";
                    }
                ?>
            </div>

            <div class="col-lg-10 col-md-10 col-sm-8">
                <h3><?php echo $artist->getUserFirstName() . " " . $artist->getUserLastName(); ?></h3>
                <p><?php echo $artist->getUserBiography();?></p>
                <p><h3>Links</h3></p>
            <b>Contact: </b><a href="<?php echo $artist->getUserPersonalLink(); ?>"><?php echo $artist->getUserPersonalLink(); ?></a>
            </div>

        </div>
        <!-- /.row --> 

        <!-- Recent Uploads Header -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Recent Uploads</h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Projects Row -->
        <div class="row">

            <?php
                $numAssets = 99;

                foreach ($DatabaseRequest->getArtistAssets($artist_id, $numAssets) as $asset) {                
                        $asset_link = "./detail.php?id=" . $asset->getId();
                        $id = $asset->getId();
                        $authorID = $asset->getUserId();
                        $web_price = $asset->getWebPrice();
                        $print_price = $asset->getPrintPrice();
                        $unlimted_price = $asset->getUnlimitedPrice();
                            echo "  <div class='col-sm-6 col-lg-4 col-md-4'>";
                            echo "      <div class='thumbnail shadow'>";

                        if($asset->getType() == 2){                            
                            echo "           <div class='box'>";
                            echo "              <video class='video-responsive center-block' preload='metadata' controls>
                                                    <source src='images/" . $asset->getOriginalURL() . "' type='video/mp4'>
                                                    <source src='images/" . $asset->getOriginalURL() . "' type='video/ogg'>
                                                    <source src='images/" . $asset->getOriginalURL() . "' type='video/webm'>
                                                    Your browser does not support the video tag
                                                 </video>
                                                 <div class='watermark-thumb'>Wabi</div>";
                            echo "           </div>";                            
                        } else {
                            echo "          <a href='$asset_link'>";
                            echo "              <div class='box'>";
                            echo "                  <img src='images/" . $asset->getThumbURL() . "' alt=''>";
                            echo "              </div>";
                            echo "          </a>";
                        }
                            echo "          <div class='caption'>";
                            echo "              <h4><a href='$asset_link'>" . $asset->getTitle() . "</a></h4>";
                            echo "              <p>".$asset->getDescription()."</p>";
                            echo "          </div>";
                            echo "          <div class='thumbnail-btns'>";
                        
                        if (in_array($id, $purchases)) {
                            echo "          <a href='$asset_link' class='btn btn-primary pull-right' data-toggle='modal'>View Purchase!</a>";
                        } else if ($currUserID == $authorID) {
                            echo "          <a href='./editasset.php?id=".$id."' class='btn btn-primary pull-right' data-toggle='modal'>Edit Asset</a>";
                        } else {
                            echo "          <a href='#buy_modal' id='buy_now' data-id=" . $id . " data-webprice=" . $web_price . " data-printprice=" . $print_price . " data-unlimitedprice=" . $unlimted_price . " class='open-buy-dialog-with-license btn btn-primary pull-right' data-toggle='modal'>Buy Now!</a>";
                        }   
                        
                        echo "              <a href='$asset_link' class='btn btn-default'>More Info</a>";                    
                        echo "         </div>";
                        echo "      </div>";  
                        echo "  </div>";
                    }
            ?> 
            
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
</div> 
<!-- Footer -->
<?php include ('footer.php') ?>
<script type="text/javascript">
    <?php echo 'var userid = "'.$_SESSION['user-s16g08']->getUserId().'";';?>
</script>
<script src="js/search-page-buy.js" type="text/javascript">
</script>

