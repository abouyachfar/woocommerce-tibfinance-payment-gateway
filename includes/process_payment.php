<?php
/**
 * Settings for TIB FINANCE GATEWAY.
 *
 * @package plugins\woocommerce-tibfinance-payment-gateway
 */

// register the ajax action for process payment
add_action('wp_ajax_process_payment', 'process_payment');
// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_process_payment', 'process_payment');

/**
 * Process Payment: Create order, Billing address and clear cart
 * 
 * @return void
 */
function process_payment()
{
    global $woocommerce;
    
    // Create order from cart for admin
    $cart = WC()->cart;
    $checkout = WC()->checkout();
    $order_id = $checkout->create_order(array());
    $order = wc_get_order($order_id);

    //Create addresses
    $address = array();

    if (!empty($_POST["frm"])) {
        foreach ($_POST["frm"] as $frm) {
            $address[str_replace("billing_", "", $frm["name"])] = $frm["value"];
        }
    }

    // Set Billing Address
    $order->set_address($address, 'billing');

    // Set order status at processing and complete checkout
    update_post_meta($order_id, '_customer_user', get_current_user_id());
    $order->calculate_totals();
    $order->payment_complete();

    // clear cart
    $woocommerce->cart->empty_cart();
}