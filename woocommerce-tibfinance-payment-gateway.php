<?php
/**
 * Plugin Name:       WooCommerce TIB FINANCE Payment Gateway
 * Description:       Take card payments on your store
 * Version:           1.0.0
 * Author:            Abdelmalik Bouyachfar
 * Author E-MAIL:     abdelmalik.bouyachfar@gmail.com
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

require "TibFinanceIntSDK_V2.0.1/vendor/autoload.php";

use TibFinanceSDK\ServerCaller;

require "TibFinanceIntSDK_V2.0.1/src/Crypto/ServerCaller.php";

 // Make sure WooCommerce is active
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) return;

add_action('plugins_loaded', 'woocommerce_tibtinance_payment_gateway_init', 11);
add_filter("woocommerce_payment_gateways", "add_to_woo_tibfinance_gateway");

/**
 * Add Gateway to woo
 * @param string $gateways
 */
function add_to_woo_tibfinance_gateway($gateways)
{
    $gateways[] = "WC_Tibfinance_pay_Gateway";
    return $gateways;
}

function woocommerce_tibtinance_payment_gateway_init()
{
    if (class_exists('WC_Payment_Gateway')) {
        class WC_Tibfinance_pay_Gateway extends WC_Payment_Gateway
        {
            // Constant attributes
            const CREDIT_CARD_PAYMENT_METHOD = 3;

            /**
             * Constructor of plugin main class
             */
            public function __construct() 
            {
                $this->id = "tibfinance_payment";
                $this->icon = apply_filters("woocommerce_tibfinance_icon", plugins_url(null, __FILE__) . "/assets/images/icon.png");
                $this->has_fields = true;
                $this->method_title = __("TIB Finance Payment Gateway", 
                    "tibfinance-pay-woo"
                );
                $this->method_description = __("TIB Finance Payment Gateway", 
                    "tibfinance-pay-woo"
                );

                //Load the settings
                $this->init_form_fields();
                $this->init_settings();

                // Define user set variables.
                $this->title = "TIB Finance Payment Gateway";

                // This action hook saves the settings
                if (is_admin()) {
                    add_action('woocommerce_update_options_payment_gateways_' . $this->id,
                        array($this, 'process_admin_options')
                    );
                }
            }

            /**
             * Initialise Gateway Settings Form Fields.
             */
            public function init_form_fields() {
                $this->form_fields = include __DIR__ . '/includes/settings.php';
            }

            /**
             * Prepare iframe
             */
            public function payment_fields() 
            {
                // Get params from plugin setting
                $url = $this->get_option("TIBFINANCE_URL");
                $userName = $this->get_option("TIBFINANCE_User_Name");
                $password = $this->get_option("TIBFINANCE_Password");
                $clientId = $this->get_option("TIBFINANCE_Client_ID");
                $serviceId = $this->get_option("TIBFINANCE_Service_ID");
                $merchantId = $this->get_option("TIBFINANCE_Merchant_ID");
                $style = $this->get_option("TIBFINANCE_Style");

                // Initialize Tib Finance Server Caller
                $serverCaller = new ServerCaller($url, $serviceId, $merchantId, 
                    $clientId,
                    $userName,
                    $password
                );

                // Initialize payment params
                $amount = $this->get_order_total();
                $dropInAuthorizedPaymentMethod = 1;
                $language = strpos(get_locale(), 'fr_') === 0 ? 1 : 2;
                $ajax_language = explode("_", get_locale());
                $transferType = self::CREDIT_CARD_PAYMENT_METHOD;

                // Get DropIn Public Token
                $result = $serverCaller->getDropInPublicToken($merchantId, $amount, 
                    $dropInAuthorizedPaymentMethod, 
                    $language, 
                    $transferType
                );

                if ($result->HasError) {
                    echo 'Error : ' . $result->Messages;
                    exit;
                }

                // Add html iframe component 
                echo '<input type="hidden" id="tibfinanceStyle" value="' . $style . '" /><input id="TibFinancePublicToken" type="hidden" value="' . $result->PublicTokenId . '" /><div id="tibfinance"></div>';

                // Load javascript files
                wp_enqueue_script('dropInMainjs', '/wp-content/plugins/woocommerce-tibfinance-payment-gateway/assets/js/main.js');
                wp_enqueue_script('dropInajs', 'http://sandboxpublic.tib.finance/CDN/Dropin/DropIn_1.0.js');
                wp_enqueue_script('dropInbjs', '/wp-content/plugins/woocommerce-tibfinance-payment-gateway/assets/js/dropIn.js');
                wp_localize_script('dropInbjs', 'tibfinance_ajax_object', array('ajax_language' => $ajax_language[0], 'create_order_url'=>admin_url('admin-ajax.php'), 'success_url' => $this->get_option("SUCCESS_URL"), 'error_url' => $this->get_option("ERROR_URL")));
            }
        }
    }
}

// Process Payment
include __DIR__ . '/includes/process_payment.php';