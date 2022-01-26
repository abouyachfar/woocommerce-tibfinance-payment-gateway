<?php
/**
 * Settings for TIB FINANCE GATEWAY.
 *
 * @package plugins\woocommerce-tibfinance-payment-gateway
 */

return array(
    "enabled" => array(
        "title" => __("Enable/Disable", "tibfinance-pay-woo"),
        "type" => "checkbox",
        "label" => __("Enable or Disable", "tibfinance_pay_woo"),
        "default" => "no"
    ),
    'api_informations'           => array(
        'title'       => __('TIB FINANCE API INFORMATIONS & CREDENTIALS', 
            'woocommerce'
        ),
        'type'        => 'title',
        'description' => __('Enter your TIB FINANCE API 
        information and credentials.', 'woocommerce'
        ),
    ),
    'TIBFINANCE_URL' => array(
            'title'             => __('URL'),
            'type'              => 'text',
            'description'       => __('Enter URL'),
            'desc_tip'          => true,
            'default'           => '',
            'css'      => 'width:400px;',
    ),
    'TIBFINANCE_Service_ID' => array(
            'title'             => __('Service ID'),
            'type'              => 'text',
            'description'       => __('Enter Service ID'),
            'desc_tip'          => true,
            'default'           => '',
            'css'      => 'width:400px;',
    ),
    'TIBFINANCE_Merchant_ID' => array(
            'title'             => __('Merchant ID'),
            'type'              => 'text',
            'description'       => __('Enter Merchant ID'),
            'desc_tip'          => true,
            'default'           => '',
            'css'      => 'width:400px;',
    ),
    'TIBFINANCE_Client_ID' => array(
            'title'             => __('Client ID'),
            'type'              => 'text',
            'description'       => __('Enter Client ID'),
            'desc_tip'          => true,
            'default'           => '',
            'css'      => 'width:400px;',
    ),
    'TIBFINANCE_User_Name' => array(
            'title'             => __('User Name'),
            'type'              => 'text',
            'description'       => __('Enter User Name'),
            'desc_tip'          => true,
            'default'           => '',
            'css'      => 'width:400px;',
    ),
    'TIBFINANCE_Password' => array(
            'title'             => __('Password'),
            'type'              => 'text',
            'description'       => __('Enter Password'),
            'desc_tip'          => true,
            'default'           => '',
            'css'      => 'width:400px;',
    ),
    'api_url_redirection'           => array(
        'title'       => __('URL redirections', 
            'woocommerce'
        ),
        'type'        => 'title',
        'description' => __('Specify your preferred redirect urls', 'woocommerce'
        ),
    ),
    'SUCCESS_URL' => array(
            'title'             => __('Success URL'),
            'type'              => 'text',
            'description'       => __('Enter URL'),
            'desc_tip'          => true,
            'default'           => '',
            'css'      => 'width:400px;',
    ),
    'ERROR_URL' => array(
            'title'             => __('Error URL'),
            'type'              => 'text',
            'description'       => __('Enter URL'),
            'desc_tip'          => true,
            'default'           => '',
            'css'      => 'width:400px;',
    ),
    'api_style'           => array(
        'title'       => __('TIB FINANCE API components style', 
            'woocommerce'
        ),
        'type'        => 'title',
        'description' => __('Customise TIB FINANCE API component fields.',
            'woocommerce'
        ),
    ),
    'TIBFINANCE_style' => array(
    'title'                     => __('Style'),
    'type'                      => 'textarea',
    'description'               => __('Enter Style'),
    'desc_tip'                  => true,
    'default'                   => "
    {
        text_bottomline_color: 'gray',
        account_type_selection: {
                font_style: 'Arial',
                font_color: '#FF934D',
                font_size: '12px',
                hover_color: '#fff',
                background_color: 'gray',
                selected_background_color: 'blue',
                selected_font_color: '#fff'
        },
        button_style: {
                background_color: 'gray',
                font_color: '#fff',
                font_style: 'Arial'
        },
        transit_number_label: {
                font_style: 'Arial',
                font_color: 'black',
                font_size: '16px'
        }
    }",
    'css'                       => 'width:400px;height:500px',
    )
);