<?php 
    include './models/database.php';
    
    $DatabaseRequest = new DatabaseRequest;
    
    $featured_artist = $DatabaseRequest->getUserDataFromID($DatabaseRequest->getFeaturedArtist());
    $featured_asset = $DatabaseRequest->getArtistAssets($featured_artist->getUserID(), 6);
    
    include './header.php';
    
?>

<div class="page-wrap">
    <?php
    // Account creation verification
    $message = isset($_GET['m']) ? $_GET['m'] : 0;

    switch ($message) {
        case 100:
        echo "<div class='alert alert-warning center-text' role='alert'><strong>Account created successfully</strong>." . "</div>";
        break;
    }
    ?>
    <!-- Full Width Image Header -->
    <header class="header-image">
        <div class="headline">
            <div class="container">
                <h2 class="index-logo center-text">Wabi</h2>
                <h4 class="index-subtitle">The simplest way to buy and sell media licensing on the web.</h4>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <form action="search.php" method="GET">
                            <div id="imaginary_container"> 
                                <div class="input-group stylish-input-group">
                                    <input type="text" class="form-control"  placeholder="Enter keyword to search" name="query">
                                    <span class="input-group-addon">
                                        <button type="submit">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>  
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Page Content -->
    <div class="container lnd-container">

        <div class="row">
            <h3 class="center-text">Featured Artist: 
                <a href="profile.php?id=<?php echo $featured_artist->getUserID() ?>">
                    <?php echo $featured_artist->getUserFirstName() . " " . $featured_artist->getUserLastName(); ?>
                </a>
            </h3>
            <hr>
            <div class="col-sm-12">
                <div class="row">
                    
        <?php
            foreach($featured_asset as $asset){
                $asset_link = "./detail.php?id=" . $asset->getId();
                
                echo    "<div class='col-sm-6 col-lg-4 col-md-4'>
                            <div class='thumbnail shadow'>";                    
                                if ($asset->getType() == 2){
                                    echo " 
                                        <div class='box'>
                                            <video class='center-block video-responsive' preload='metadata' controls>
                                               <source src='images/" . $asset->getOriginalURL() . "' type='video/mp4'>
                                               <source src='images/" . $asset->getOriginalURL() . "' type='video/ogg'>
                                               <source src='images/" . $asset->getOriginalURL() . "' type='video/webm'>
                                               Your browser does not support the video tag
                                            </video>
                                            <div class='watermark-index'>Wabi</div>
                                        </div>";    
                                } else { 
                                    echo "
                                        <a href='$asset_link'>   
                                            <div class='box'>
                                                <img src='images/" . $asset->getThumbURL() ."' alt=''>
                                            </div>
                                        </a>";
                                } 
                echo    "               <div class='caption-small'>
                                            <h4>
                                              <a href='$asset_link'>" . $asset->getTitle() . "</a>
                                            </h4>
                                        </div>
                            </div>
                        </div>";
            }
    ?>                       

                    
                </div>    
            </div>
        </div>
    </div>
</div>
    
    <!-- /.container -->

     <!-- Hidden Navbar -->
    <script src="js/hidden-navbar.js"></script>   

<?php include('footer.php') ?>