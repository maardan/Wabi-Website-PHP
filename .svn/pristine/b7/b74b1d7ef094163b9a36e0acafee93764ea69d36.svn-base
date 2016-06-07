<?php
    include './models/database.php';
    $DatabaseRequest = new DatabaseRequest;
    include './header.php';
    
    $user = $DatabaseRequest->getUserDataFromId($_SESSION["user-s16g08"]->getUserId());
    
    if ($user->getUserType() != 2) {
        echo '<meta http-equiv="refresh" content="0; URL=404.php">';
    }
    
    $message = isset($_GET['m']) ? $_GET['m'] : 0;
    
?>
<div class="page-wrap">

    <div class="container lnd-container">
        <h2 class="page-title">Edit Profile</h2>
        <hr>
        <div class="row">

            <form class="form-horizontal" action="./controllers/update_profile.php" method="POST" enctype="multipart/form-data">
                <div class="col-md-3">
                    <div class="text-center">
                    <?php
                        $user_photo = $user->getUserProfilePhoto();
                        if (!empty($user_photo)) {
                            echo    "<img class='avatar img-circle' src='./profile_portraits/".$user->getUserProfilePhoto()."' alt=''>";
                        } else {
                            echo    "<img src='./profile_portraits/placeholder.png' class='avatar img-circle' alt='avatar'>";
                        }
                    ?>
                      <h6>Upload a different photo...</h6>

                      <input type="file" id="profile_photo" name="profile_photo">
                      <p class="help-block">Image must be under 512Kb.<br>Acceptable formats: jpg, jpeg, gif, png.</p>
                    </div>
                </div>
                <div class="col-md-9 personal-info">
                    <h3>Personal info</h3>
                    <div class="form-group">
                    <label class="col-lg-3 control-label">First name:</label>
                    <div class="col-lg-8">
                      <input class="form-control" type="text" id="first_name" name="first_name" value="<?php echo $user->getUserFirstName(); ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-3 control-label">Last name:</label>
                    <div class="col-lg-8">
                      <input class="form-control" type="text" id="last_name" name="last_name" value="<?php echo $user->getUserLastName(); ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-lg-3 control-label">Biography:</label>
                    <div class="col-lg-8">
                        <textarea class="form-control" rows="5" style="resize:vertical" id="biography" name="biography" type="text"><?php echo $user->getUserBiography(); ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label">Personal Link:</label>
                    <div class="col-md-8">
                      <input class="form-control" type="text" id="personal_link" name="personal_link" value="<?php echo $user->getUserPersonalLink(); ?>">
                    </div>
                  </div>
                    <?php
                        switch ($message) {
                            case 1:
                                echo "<div class='alert alert-success' role='alert'>Your changes have been saved.</div>";
                                break;
                            case 2:
                                echo "<div class='alert alert-danger' role='alert'><b>Changes failed.</b> The file you selected is not an image file.</div>";
                                break;
                            case 3:
                                echo "<div class='alert alert-danger' role='alert'><b>Changes failed.</b> The profile image you selected was larger than the maximum of 512kb.</div>";
                                break;
                            case 4:
                                echo "<div class='alert alert-danger' role='alert'><b>Changes failed.</b> The profile image you selected was not a JPG, JPEG, GIF, or PNG file.</div>";
                                break;
                            case 5:
                                echo "<div class='alert alert-danger' role='alert'><b>Changes failed.</b> An unknown error occured while processing your file.</div>";
                                break;
                            case 6:
                                echo "<div class='alert alert-danger' role='alert'><b>Changes failed.</b> The profile image you are uploading already exists on the server. Please rename the file.</div>";
                                break;                           
                            default:
                                break;
                        }
                    ?>                
                  <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                      <button type="submit" name="submit" class="btn btn-primary pull-right">Save Changes</button>
                      <button type="reset" class="btn btn-default">Reset</button>
                    </div>
                  </div>
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $user->getUserId(); ?>">
                </div>
            </form>
        </div>
    </div>

</div>

<?php include ('footer.php') ?>