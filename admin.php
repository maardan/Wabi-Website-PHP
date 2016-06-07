<?php include('header.php'); ?>
  

<h3 class="dashboard-title">Admin Dashboard</h3>
  

<!-- Features Module -->
<div class="container dashboard-top-spacing">
    <div class="row">
        <form action="#" method="post" class="col-md-6 col-md-offset-3 core-input panel panel-default" enctype="multipart/form-data">
            <h3 class="center-text">Set Featured Artist and Asset</h3>
            <div class="form-group">
                    <label for="account_id">Account ID:</label>
                    <input type="text" class="form-control" id="account_id" placeholder="Enter ID..." name="account_id" required>
            </div>
            <div class="form-group">
                <label for="asset_id">Asset ID:</label>
                <input type="text" class="form-control" id="asset_id" placeholder="Enter ID..." name="asset_id" required>
            </div>
            <div class="text-right">
                <button type="submit" name="featured" class="btn btn-default" style="margin-bottom:15px;">Set Featurettes</button>
            </div>
        </form>
    </div>
</div>

<!-- Disable Asset Module -->
<div class="container">
    <div class="row">
        <form action="#" method="post" class="col-md-6 col-md-offset-3 core-input panel panel-default" enctype="multipart/form-data">
            <h3 class="center-text">Disable Asset</h3>
            <div class="form-group">
                    <label for="asset_id">Asset ID:</label>
                    <input type="text" class="form-control" id="asset_id" placeholder="Enter ID..." name="asset_id" required>
            </div>
            <div class="text-right">
                <button type="submit" name="disable_asset" class="btn btn-default" style="margin-bottom:15px;">Disable</button>
            </div>
        </form>
    </div>
</div>

<!-- Suspend Account Module -->
<div class="container">
    <div class="row">
        <form action="#" method="post" class="col-md-6 col-md-offset-3 core-input panel panel-default" enctype="multipart/form-data">
            <h3 class="center-text">Suspend Account</h3>
            <div class="form-group">
                <label for="account_id">Account ID:</label>
                <input type="text" class="form-control" id="account_id" placeholder="Enter ID..." name="account_id" required>
            </div>
            <div class="form-group">
                <label for="suspension_reason">Reason:</label>
                <textarea class="form-control" rows="5" id="suspension_reason" placeholder="Enter description..." name="suspension_reason" required></textarea>
            </div>
            <div class="text-right">                
                <button type="submit" name="suspend_acct" class="btn btn-default" style="margin-bottom:15px;">Suspend</button>
            </div>
        </form>
    </div>
</div>

<!-- Suspended Accounts -->    
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3 class="wabi-page-header">Suspended Accounts</h3>
        </div>
        <div class="col-md-6 col-md-offset-3">
            <table class="table">
                <thead>
                <tr>
                    <th class="col-md-3">Account ID</th>
                    <th class="col-md-3">Date</th>
                    <th class="col-md-3">Username</th>
                    <th class="col-md-3">Reason</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>12345</td>
                    <td>April 1, 2016</td>
                    <td>johncii@wabi.com</td>
                    <td>Inappropriate Image</td>
                </tr>
                <tr>
                    <td>67890</td>
                    <td>Jan 30, 2016</td>
                    <td>lisa123@wabi.com</td>
                    <td>Inappropriate Image</td>
                </tr>
                </tbody>
            </table>  
        </div>
    </div>       
</div>
  
   
<!-- Footer -->
<?php include ('footer.php')?>
