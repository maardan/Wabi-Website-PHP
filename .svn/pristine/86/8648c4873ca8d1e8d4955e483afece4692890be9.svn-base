//Just populating the modal pops up.
$(document).on("click", ".open-buy-dialog-with-license", function () {
  var webprice = $(this).data('webprice');
  var printprice = $(this).data('printprice');
  var unlimitedprice = $(this).data('unlimitedprice');
  document.getElementById('webpricemodal').innerHTML = "Web - $" + webprice;
  document.getElementById('webpricemodal').value = webprice;
  document.getElementById('webpricemodal').setAttribute("data-licensetype", 'W');
  document.getElementById('printpricemodal').innerHTML = "Print - $" + printprice;
  document.getElementById('printpricemodal').value = printprice;
  document.getElementById('printpricemodal').setAttribute("data-licensetype", 'P');
  document.getElementById('unlimitedpricemodal').innerHTML = "Unlimited - $" + unlimitedprice;
  document.getElementById('unlimitedpricemodal').value = unlimitedprice;
  document.getElementById('unlimitedpricemodal').setAttribute("data-licensetype", 'U');

});

$(document).ready(function(){
  var assetid = 0;

  $("[id='buy_now']").click (function(e){
    assetid = $(this).data('id');
  });

  $("#modal_buy").click(function(e){
    e.preventDefault();
    var license = $('#sel1 option:selected').attr('data-licensetype');
    $.ajax({type: "POST",
      url: "/~s16g08/controllers/purchase_asset_page.php",
      data: { userid: userid, asset_id: assetid, license_type: license, price: $("#sel1").val() },
      success:function(result){
        location.reload();
      }
    });
  });
});
