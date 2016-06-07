<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="buy_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Purchase </h4>
            </div>
            <div class="modal-body">
                <div class="panel-body wabi-text">
                    <?php
                        if (isset($_SESSION["isLoggedIn-s16g08"])) {
                           echo  "<p>Please select from one of the following licenses and click Confirm Purchase. "
                           ."Your purchase will be added to your account and be available for download. Thank you for your business!</p>"
                           ."<form role='form'>"
                           ."<div class='sel1'>"
                           ."<label for='sel1'>Select License Type:</label>"
                           ."<select class='form-control' id='sel1'>"
                           ."<option id='webpricemodal' value='' data-licensetype=''>Web       - $100</option>"
                           ."<option id='printpricemodal' value='' data-licensetype=''>Print     - $150</option>" 
                           ."<option id='unlimitedpricemodal' value='' data-licensetype=''>Unlimited - $200</option>"
                           ."</select>"
                           ."</div>"
                           ."</form>";
                        } else {
                            echo "<p>Thank you for your interest. You may login, create an account, or call 1-800-555-1212 to complete your transaction</p>";
                        }
                    ?>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel Purchase</button>
            <button type="button" id="modal_buy" class="btn btn-default" data-dismiss="modal">Confirm Purchase</button>
        </div>
    </div>
</div>
</div>