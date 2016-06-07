<?php 

    include './models/database.php';
    $DatabaseRequest = new DatabaseRequest;
    include './header.php';
    
    $user = $_SESSION["user-s16g08"];
 ?>

<div class="page-wrap">
    <h2 class="page-title">Purchase History</h2>


    <div class="container lnd-container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <table class="table">
                  <thead>
                    <tr>
                      <th class="col-md-3">Order ID</th>
                      <th class="col-md-3">Date Purchased</th>
                      <th class="col-md-3">Item Name</th>
                      <th class="col-md-3">Price</th>
                    </tr>
                  </thead>
                  <tbody>
                <?php                  
                    foreach($DatabaseRequest->getPurchaseData($user->getUserId()) as $purchase){
                        $order_id = $purchase->getId();
                        $purchase_date = $purchase->getCreated();
                        $price = $purchase->getAmount();
                        $asset_data = $DatabaseRequest->getAssetData($purchase->getAssetId());
                        $artist_id = $asset_data->getUserId();
                        $author = $DatabaseRequest->getUserDataFromId($artist_id);

                        if ($purchase->getLicenseType() == 'W'){
                            $license = "Web License";
                        } else if($purchase->getLicenseType() == 'P') {
                            $license = "Print License";
                        } else {
                            $license = "Unlimited License";
                        }

                        echo    "   <tr>
                                        <td>$order_id</td>
                                        <td>$purchase_date</td>
                                        <td><a href='./detail.php?id=".$purchase->getAssetId()."'>".$asset_data->getTitle()." by ".$author->getUserFirstName()." ".$author->getUserLastName()." - $license</a></td>
                                        <td>$$price</td>
                                    </tr>
                                ";

                    }
                ?>  
                  </tbody>
                </table>  
            </div>
        </div>       
    </div>
</div>

<!-- Footer -->
<?php include ('footer.php')?>


