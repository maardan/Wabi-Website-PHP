<?php
include './header.php';

include './models/database.php';

$mysqli = Database::getInstance()->getConnection();
	// Execute Search
$search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_GET['query']);
$DatabaseRequest = new DatabaseRequest;

//Check for Empty string before doing query..
if ( Trim ( $search_string ) !== '' ) {
	$result_array = $DatabaseRequest->findAssets($search_string);

}
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

echo "<div class='page-wrap'>"
. "<div class='container lnd-container'>"
. "<h2 class='page-title'>Search Results</h2>"
. "<div class='row'> ";

// Check If We Have Results
if (!empty($result_array)) {

  $num = count($result_array);

  echo "<div class='center-text'><h4>$num result(s) for '$search_string'<h4></div><hr>";


  foreach ($result_array as $result_object) {
    $title = $result_object->getTitle();
    $id = $result_object->getId();
    $authorID = $result_object->getUserId();
    $thumb_url = $result_object->getThumbURL();
    $description = $result_object->getDescription();
    $web_price = $result_object->getWebPrice();
    $print_price = $result_object->getPrintPrice();
    $unlimted_price = $result_object->getUnlimitedPrice();

    $html = "<div class='col-sm-6 col-lg-4 col-md-4'>";
    $html .= "<div class='thumbnail shadow'>";
    if ($result_object->getType() == 2){
        $html .=  " <div class='box'>
                        <video class='video-responsive center-block' preload='metadata' controls>
                            <source src='images/" . $result_object->getOriginalURL() . "' type='video/mp4'>
                            <source src='images/" . $result_object->getOriginalURL() . "' type='video/ogg'>
                            <source src='images/" . $result_object->getOriginalURL() . "' type='video/webm'>
                            Your browser does not support the video tag
                        </video>
                        <div class='watermark-thumb'>Wabi</div>
                    </div>";                                  
    }
    else {
        $html .= "<a href='./detail.php?id=". $id ."' '>";
        $html .= "  <div class='box'>";
        $html .= "      <img src='./images/".$thumb_url."' alt=''>";
        $html .= "  </div>";
        $html .= "</a>";
    }
    $html .= "<div class='caption'>";
    $html .= "  <h4><a href='./detail.php?id=" . $id . "'>" . $title . "</a></h4>";
    $html .= "  <p>". $description ."</p>";
    $html .= "</div>";
    $html .= "<div class='thumbnail-btns'>";

    if (in_array($id, $purchases)) {
      $html .= "<a href='./detail.php?id=".$id."' class='btn btn-primary pull-right' data-toggle='modal'>View Purchase!</a>";

    } 
    else if ($currUserID == $authorID) {
        $html .= "<a href='./editasset.php?id=".$id."' class='btn btn-primary pull-right' data-toggle='modal'>Edit Asset</a>";
    }
    else {
      $html .= "<a href='#buy_modal' id='buy_now' data-webprice=" . $web_price . " data-printprice=" . $print_price . " data-unlimitedprice=" . $unlimted_price . " class='open-buy-dialog-with-license btn btn-primary pull-right' data-id=" . $id . " data-toggle='modal'>Buy Now!</a>";
    }

    $html .= "<a href='./detail.php?id=".$id."' class='btn btn-default'>More Info</a>";
    $html .= "</div>";
    $html .= "</div>";		
    $html .= "</div>\n";

    echo $html;
  }

} else {
	    // Output
 echo "<h4 style='text-align:center;'>0 results for '$search_string'</h4>";
}

echo "</div>"
. "</div>"
. "</div>";
?>
<?php
include './footer.php';
?>

<script type="text/javascript">
    <?php echo 'var userid = "'.$_SESSION['user-s16g08']->getUserId().'";';?>
</script>
<script src="js/search-page-buy.js" type="text/javascript">
</script>