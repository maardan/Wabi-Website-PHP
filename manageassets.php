<?php 

    include './models/database.php';
    $DatabaseRequest = new DatabaseRequest;
    include './header.php';
    
    $user = $_SESSION["user-s16g08"];
    
    $message = isset($_GET['m']) ? $_GET['m'] : 0;

 ?>
<!-- License Modal -->
 <?php include ('./modals/licenseModal.php')?>

<div class="page-wrap">
    <h2 class="page-title">Manage Assets</h2>
    
    <!-- Artist Earnings -->
    <?php 
        
        $earnings = $DatabaseRequest->getArtistEarnings($user->getUserId());
        
        $labels = '';
        $amounts = '';
        
        foreach ($earnings as $e) {
            $labels = $labels . "'" . $e["date"] . "',";
            $amounts = $amounts . ($e["amount"]==NULL ? "0" : $e["amount"]) . ",";
        }
        
        $chartistData = "{labels:[$labels],series:[[$amounts]]}";
        
    ?>
    
    <script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
    
    <div class='container dashboard-top-spacing'>
        <div class='row'>
            <div class='col-md-6 col-md-offset-3 core panel panel-default'>
                <h3 class='center-text'>Today's Earnings</h3>
                <div class='row earnings-today'>
                    <div class='col-md-6 col-md-offset-3 col-sm-12'>
                        <p><?php echo "$" . $earnings[sizeof($earnings) - 1]["amount"] ?></p>
                    </div>
                </div>
                <h4 class='center-text' style='color:rgb(130,130,130);'>Past 7 Days</h4>
                <div class="ct-chart ct-major-eleventh"></div>
                    <script>
                        var data = <?php echo $chartistData ?>; 
                        var options = {high:1000};        
                        new Chartist.Line('.ct-chart', data, options);
                    </script>
                </div>
            </div>
        </div>
    
    <!-- Upload Form -->
    <div class="container">
        <div class="row">
            <form id='upload-asset-form' action="./controllers/uploadImage.php" method="POST" class="col-md-6 col-md-offset-3 core-input panel panel-default" enctype="multipart/form-data">
                <h3 class="center-text">Upload A New Asset</h3>
                <div class="form-group">
                    <label for="asset_type">Select your asset type:</label>
                    <label class="radio-inline"><input type="radio" name="asset_type" id="select_image" value="1" required/>Image</label>
                    <label class="radio-inline"><input type="radio" name="asset_type" id="select_video" value="2" required/>Video</label>
                </div>
                <div class="form-group">
                    <label for="asset_title">Title (Tip: Use descriptive keywords in your title!):</label>
                    <input type="text" class="form-control" id="asset_title" placeholder="Enter a title for your asset..." name="asset_title" required>
                </div>    
                <div class="form-group">
                    <label for="asset_description">Description:</label>
                    <textarea class="form-control" rows="5" id="asset_description" placeholder="Enter a description for your asset..." name="asset_description" style="resize:vertical;" required></textarea>
                </div>
                <h4 class="center-text">Please set the prices for your licenses
                    <a href="#licenseModal" data-toggle="modal">
                        <span class="glyphicon glyphicon-question-sign"></span>
                    </a>
                </h4>
                <div class="form-horizontal form-group">
                    <label for="asset_web" class="col-md-2">Web:</label>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="asset_web" name="asset_web" placeholder="$" required>                    
                    </div>
                    <label for="asset_print" class="col-md-2">Print:</label>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="asset_print" name="asset_print" placeholder="$" required>                    
                    </div>
                    <label for="asset_unlimited" class="col-md-2">Unlimited:</label>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="asset_unlimited" name="asset_unlimited" placeholder="$" required>                    
                    </div>
                </div>
                <div class="form-group">
                    <label for="fileUpload" style="padding-top:15px;">Select File:</label>
                    <input type="file" id="fileUpload" name="fileUpload">
                    <p class="help-block">File must be under 50MB. Acceptable formats: JPG, JPEG, PNG, GIF, MP4, OGG, WEBM.</p>
                </div>
                <?php
                    switch ($message) {
                        case 1:
                            $newest_asset = $DatabaseRequest->getArtistAssets($user->getUserId());
                            $newest_asset = $newest_asset[0];
                            $linkout = "<a href='./detail.php?id=" . $newest_asset->getId() . "'> View Now</a>";
                            echo "<div class='alert alert-success' role='alert'>Upload successful." . $linkout . "</div>";
                            break;
                        case 2:
                            echo "<div class='alert alert-danger' role='alert'><b>Upload failed.</b> The file you are uploading is not an image.</div>";
                            break;
                        case 3:
                            echo "<div class='alert alert-danger' role='alert'><b>Upload failed.</b> The file you are uploading is larger than the maximum of 50mb.</div>";
                            break;
                        case 4:
                            echo "<div class='alert alert-danger' role='alert'><b>Upload failed.</b> The file you are uploading is not a JPG, JPEG, GIF, PNG, MP4, OGG, or WEBM file.</div>";
                            break;
                        case 5:
                            echo "<div class='alert alert-danger' role='alert'><b>Upload failed.</b> An unknown error occured while processing your file.</div>";
                            break;
                        case 6:
                            echo "<div class='alert alert-danger' role='alert'><b>Upload failed.</b> The file you are uploading already exists on the server.</div>";
                            break;                            
                        default:
                            break;
                    }

                ?>
                <div class="text-right">
                    <button id='upload-asset-button' type="submit" name="submit" class="btn btn-primary" style="margin-bottom:15px;">Upload</button>
                    <img id='upload-asset-ajax-gif' src='./materials/ajax-loader.gif' class='hidden'>
                </div>
                    <input type="hidden" name="userid" value="<?php echo $user->getUserId(); ?>">

            </form>
        </div>
    </div>

    <!-- Disable Asset Module -->
    <div class="container" id="disable">
        <div class="row">
            <form action="./controllers/disableAsset.php" method="post" class="col-md-6 col-md-offset-3 core-input panel panel-default" enctype="multipart/form-data">
                <h3 class="center-text">Disable Asset</h3>
                <div class="form-group">
                    <label for="asset_id">Asset ID:</label>
                    <input type="text" class="form-control" id="asset_id" placeholder="Enter ID..." name="asset_id" required>
                </div>
                <?php
                    switch($message) {
                        case 100:
                            echo "<div class='alert alert-success' role='alert'>Asset Disabled.</div>";    
                            break;
                        case 101:
                            echo "<div class='alert alert-danger' role='alert'>Please input a numeric Asset ID</div>";
                            break;
                        case 102:
                            echo "<div class='alert alert-danger' role='alert'>The Asset could not be found, or you do not have permission to disable that Asset.</div>";
                            break;
                        default:
                            break; 
                    }
                ?>
                <div class="text-right">
                    <button type="submit" name="disable" class="btn btn-primary" style="margin-bottom:15px;">Disable</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Recent Uploads -->
    <div class="container lnd-container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h3 class="center-text">All of your enabled uploads:</h3>
                <h5 class="center-text" style="color: gray">(Tip: Use the media ID number when disabling assets)</h5>
            </div>
        </div>
    
    <?php

        echo '<div class="row">'; 
        echo '<div class="col-md-6 col-md-offset-3">';
        
        $numAssets = 99;

        foreach ($DatabaseRequest->getArtistAssets($user->getUserId(), $numAssets) as $asset) {
           
                $asset_link = "./detail.php?id=" . $asset->getId();
            
                echo '  <div class="col-md-6 col-sm-6 col-xs-12">';
                echo "      <div class='thumbnail shadow' style='border:none'>";

                if ($asset->getType() == 2){
                    echo "      <div class='box-small'>
                                    <video class='video-responsive center-block' preload='metadata' controls>
                                        <source src='images/" . $asset->getOriginalURL() . "' type='video/mp4'>
                                        <source src='images/" . $asset->getOriginalURL() . "' type='video/ogg'>
                                        <source src='images/" . $asset->getOriginalURL() . "' type='video/webm'>
                                        Your browser does not support the video tag
                                    </video>
                                </div>";                                  
                }
                else {
                    echo "        <a href='$asset_link'>";
                    echo "           <div class='box-small'>";
                    echo "               <img src='images/" . $asset->getThumbURL() . "' alt=''>";
                    echo "           </div>";
                    echo "        </a>";                                                         
                }
                

                echo "         <div class='caption-small'>";
                echo "             <h5><a href='$asset_link'>" . $asset->getTitle() . "</a><span class='pull-right id-text'>ID ".$asset->getId()."</span></h5>";
                echo "         </div>";
                echo "      </div>";  
                echo "  </div>";
            
            
        }
        
   
        echo "</div>";
        echo "</div>";
        
    ?>
    <hr>  
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $("#select_image, #select_video").change(function(){
            $("#asset_web, #asset_print, #asset_unlimited").val("").attr("disabled",true);
            if($("#select_image").is(":checked")){
                $("#asset_web").removeAttr("disabled");
                $("#asset_print").removeAttr("disabled");
                $("#asset_unlimited").removeAttr("disabled");
                $("#asset_title").focus();
            } else if ($("#select_video").is(":checked")){
                $("#asset_web").removeAttr("disabled");
                $("#asset_title").focus();
            }
        });
    });

    $('#upload-asset-form').on('submit', function() {
        $('#upload-asset-button').addClass('hidden');
        $('#upload-asset-ajax-gif').removeClass('hidden');
    });
</script>


<!-- Footer -->
<?php include ('footer.php')?>
