<?php

include './header.php';

?>

<div class="page-wrap">
  <div class="container lnd-container">

    <div class="row">
        <?php
            // Login Success/Failure Messaging
        $message = isset($_GET['m']) ? $_GET['m'] : 0;

        switch ($message) {
            case 401:
                echo "<div class='alert alert-warning' role='alert'><strong>Sign Up Unsuccessful.</strong>" . "</div>";
                break;
            case 1:
                echo "<div class='alert alert-danger' role='alert'><b>Upload failed.</b> The file you uploaded was not an image.</div>";
                break;
            case 2:
                echo "<div class='alert alert-danger' role='alert'><b>Upload failed.</b> The image you uploaded was larger than the maximum of 512kb.</div>";
                break;
            case 3:
                echo "<div class='alert alert-danger' role='alert'><b>Upload failed.</b> The image you uploaded was not a JPG, GIF, or PNG.</div>";
                break;
            case 4:
                echo "<div class='alert alert-danger' role='alert'><b>Upload failed.</b> An unknown error occured while processing your image.</div>";
                break;
            case 5:
                echo "<div class='alert alert-danger' role='alert'><b>Upload failed.</b> The image you are uploading already exists on the server.</div>";
                break;            
            default:
                break;        
        }

        ?>
        <h2 class="page-title">Create a Wabi Account</h2>        
        <form name="signUpForm" role="form" id="wabi-login-form" action="./controllers/user_register.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="firstname"><span></span> First Name</label>
                <input type="text" class="form-control" name="firstname" id="first_name" placeholder="First Name" required autocomplete="off">
            </div>            
            <div class="form-group">
                <label for="psw"><span></span> Last Name </label>
                <input type="text" class="form-control" name="lastname" id="last_name" placeholder="Last Name" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="usrname"><span></span> Email</label>
                <input type="email" class="form-control" name="email" id="usrname" placeholder="Enter Email" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="psw"><span></span> Password</label>
                <div id="pswerror" style="color: red;"></div>
                <input type="password" class="form-control" name="password" id="psw" placeholder="Enter Password" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="psw"><span></span> Password</label>
                <input type="password" class="form-control" name="password2" id="pswconfirm" placeholder="Re-enter Password" required autocomplete="off">
            </div>
            <div class="form-group">
                <label for="sel1">Select Account Type:</label>
                <select class="form-control" name="accountType" id="accountType" onchange="PicBioHandler(this)">
                    <option value="customer">Customer</option>     
                    <option value="artist">Artist</option>
                </select>
            </div>
            <div class="form-group" style="display: none" id="show_Pic_Bio">
                <label for="profilePic"><span></span> Select profile image to upload (optional):</label>
                <input type="file" name="profilePic" id="profilePic">
                <p class="help-block">Acceptable formats: jpg, jpeg, gif, png.</p>
            </div>
            <div class="form-group" style="display: none" id="show_Pic_Bio1">
                <label for="biography"><span></span> Please write a short biography (optional):</label>
                <textarea class="form-control" rows="4" name="biography" id="biography" style="resize:vertical" placeholder="Tell us about yourself..."></textarea>
            </div>
            <div class="form-group" style="display: none" id="show_Pic_Bio2">
                <label for="personalLink"><span></span>Enter a personal URL (optional):</label>
                <input type="url" name="personalLink" class="form-control" name="personalLink" id="personalLink" placeholder="Enter a url (http://www.example.com)...">
            </div>            
            <p> By clicking "Sign Up" you agree to our <a href="#privacyModal" data-toggle="modal">Privacy Policy</a> 
                and <a href="#tosModal" data-toggle="modal">Terms of Service</a>
            </p>
            <br>
            <button type="submit" name="submit" class="btn btn-default btn-success btn-block" onclick="return signUpFormValidate()"><span></span> Sign Up</button>
        </form>
        <hr>
        <div style="text-align: center;" >
            Already own an account?
            <a href="./login.php" class="btn btn-default">Sign In</a>
        </div>
    </div>
</div>
</div>
<script>  
    
    function signUpFormValidate() {
        var firstnameLength = document.getElementById("first_name").value.length;
        var lastnameLength = document.getElementById("last_name").value.length;
        var usernameLength = document.getElementById("usrname").value.length;
        var pass1 = document.getElementById("psw").value;
        var pass1Length = document.getElementById("psw").value.length;
        var pass2 = document.getElementById("pswconfirm").value;
        var pass2Length = document.getElementById("pswconfirm").value.length;
        
        if (firstnameLength  == 0) {
            document.getElementById("first_name").style.borderColor = "#E34234";

        } else if (lastnameLength == 0) {
            document.getElementById("last_name").style.borderColor = "#E34234";

        } else if (usernameLength == 0) {
            document.getElementById("usrname").style.borderColor = "#E34234";

        } else if (pass1 != pass2 || pass1Length == 0 || pass2Length == 0) {
            document.getElementById("psw").style.borderColor = "#E34234";
            document.getElementById("pswconfirm").style.borderColor = "#E34234";
            document.getElementById("pswerror").innerHTML = "Password isn't identical";
        } else {
            document.getElementById("wabi-login-form").submit();
        }     
    }
    
    function PicBioHandler(select) {
        if(select.value == 'artist') {
            var PicBio = document.getElementById('show_Pic_Bio');
            PicBio.style.display = 'block';
            var PicBio1 = document.getElementById('show_Pic_Bio1');
            PicBio1.style.display = 'block';  
            var PicBio2 = document.getElementById('show_Pic_Bio2');
            PicBio2.style.display = 'block';                
        } else if(select.value == 'customer') {
            var PicBio = document.getElementById('show_Pic_Bio');
            PicBio.style.display = 'none';
            var PicBio1 = document.getElementById('show_Pic_Bio1');
            PicBio1.style.display = 'none';
            var PicBio2 = document.getElementById('show_Pic_Bio2');
            PicBio2.style.display = 'none';            
        }
    }
</script>

<?php include ('footer.php')?>