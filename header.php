<!DOCTYPE html>
<html lang="en">
<?php    
include_once 'models/User.php';
include_once 'models/Purchase.php';

if(!isset($_SESSION)) { 
    session_start(); 
} 
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Wabi</title>
    
    <!-- Chartist CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Preload jQuery -->
    <script src="js/jquery.min.js"></script>
    <script src="js/custom.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->

        </head>

        <body>
            <!-- Include Modals -->
            <?php include ('./modals/includeModals.php') ?>
            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <a href="index.php" class="navbar-brand navbar-logo">
                                Wabi
                            </a>
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <div class="col-sm-4 col-sm-offset-3">
                                <form action="search.php" method="GET" class="navbar-form" id="search-hide">
                                    <div id="imaginary_container"> 
                                        <div class="input-group stylish-input-group">
                                            <input type="text" class="form-control"  placeholder="Enter keyword to search" name="query">
                                            <span class="input-group-addon" style="width:1%;">
                                                <button type="submit">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>  
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <ul class="nav navbar-nav navbar-right">
                                <!-- Login Session Check -->
                            <?php
                                if (isset($_SESSION["isLoggedIn-s16g08"])) {
                                    echo"<li><a>Welcome ";
                                    echo $_SESSION["user-s16g08"]->getUserFirstName();
                                    echo "!</a></li>";
                                    echo "<li class='dropdown'>
                                            <a class='dropdown-toggle' data-toggle='dropdown' href='#'>My Account
                                            <span class='caret'></span></a>
                                            <ul class='dropdown-menu'>";
                                    if ($_SESSION["user-s16g08"]->getUserType() == 2) {
                                        echo "  <li><a href='./manageassets.php'>Manage Assets</a></li>
                                                <li><a href='./editprofile.php'>Edit Profile</a></li>
                                                <li><a href='./profile.php?id=".$_SESSION["user-s16g08"]->getUserId()."'>View My Profile</a></li>"; 
                                    }
                                    echo "      <li><a href='./orderhistory.php'>Purchase History</a></li>";
                                    echo "      <li role='separator' class='divider'></li>";                                    
                                    echo "      <li><a href='./logout.php'>Logout</a></li>";                                    
                                    echo "    </ul>
                                            </li>";                                 
                                }else {  
                                    echo    "<li>
                                                <a href='./signup.php'>Sign Up</a>
                                            </li>
                                            <li>
                                                <a href='./login.php'>Login</a>
                                            </li>"; 
                                }
                            ?>
                            </ul>   
                        </div>
                        <!-- /.navbar-collapse -->
                </div>
                <!-- /.container -->
            </nav>
            <!-- /.nav -->   