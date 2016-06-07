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
        echo "<div class='alert alert-warning' role='alert'><strong>Login Unsuccessful.</strong>" . "</div>";
        break;
    }

    ?>
    <h2 class="page-title">Log in to Wabi</h2>        
    <form role="form" id="wabi-login-form" action="./controllers/user_auth.php" method="POST">
        <div class="form-group">
          <label for="usrname"><span></span> Email</label>
          <input type="text" class="form-control" name="loginusername" id="usrname" placeholder="Enter email" required autocomplete="off">
      </div>
      <div class="form-group">
          <label for="psw"><span></span> Password</label>
          <input type="password" class="form-control" name="loginpassword" id="psw" placeholder="Enter password" required autocomplete="off">
      </div>
      <div class="checkbox">
          <label><input type="checkbox" value="" checked>Remember me</label>
      </div>
      <button type="submit" class="btn btn-default btn-success btn-block"><span></span> Login</button>

    </form>
    <hr>
    <div style="text-align: center;" >
        Don't have an account?
        <a href="./signup.php" class="btn btn-default">Sign Up</a>
    </div>

    </div>
</div>

</div>

<?php include ('footer.php')?>
