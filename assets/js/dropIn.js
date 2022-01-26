jQuery( document ).ajaxStop(function() {
    TIB_Dropin.LoadIframe({
        //style: jQuery("#tibfinanceStyle").val(),
        elementid: "tibfinance",
        publictoken: jQuery("#TibFinancePublicToken").val(),
        lang: tibfinance_ajax_object.ajax_language,

        successcallback: function (success) {
            if(!success.HasError)
            {
                var frm = jQuery(".woocommerce-checkout").serializeArray();

                jQuery.ajax({
                    type: "POST",
                    url: tibfinance_ajax_object.create_order_url,
                    data: {
                        action: 'process_payment',
                        frm: frm
                    },
                    success: function (output) {
                        if(tibfinance_ajax_object.success_url != "")
                        {
                            window.location.href = tibfinance_ajax_object.success_url;
                        }
                    },
                    error: function (output) {
                        if(tibfinance_ajax_object.error_url != "")
                        {
                            window.location.href = tibfinance_ajax_object.error_url;
                        }
                    }
                });
            }
        },
        errorcallback: function (error) {
            console.log(error);
        }
    });
});

//Récuperer l'URL du site WORDPRESS
function getHomeUrl() {
  var href = window.location.href;
  var index = href.indexOf('/checkout/');
  var homeUrl = href.substring(0, index);
  return homeUrl;
}