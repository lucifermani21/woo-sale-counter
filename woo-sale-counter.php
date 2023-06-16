<?php

/**
* Plugin Name: WooCommerce Sales Counter
* Plugin URI: https://github.com/lucifermani21/woo-sale-counter.git
* Description: WooCommerce sale counter or timer for products.
* Version: 1.0.2
* Author: Manpreet Singh
* Author URI: https://github.com/lucifermani21/woo-sale-counter.git
**/

if ( ! defined( 'ABSPATH' ) ) {
     die;
}
define( 'WSALE_SETTING_VERSION', '1.0.2' );
define( 'WSALE_SETTING_TEXT_DOMAIN', 'woo-sales-counter' );
define( 'WSALE_DIR__NAME', dirname( __FILE__ ) );
define( 'WSALE_EDITING__URL', plugin_dir_url( __FILE__ ) );
define( 'WSALE_EDITING__DIR', plugin_dir_path( __FILE__ ) );
define( 'WSALE_SETTING_PLUGIN', __FILE__ );
define( 'WSALE_SETTING_PLUGIN_BASENAME', plugin_basename( WSALE_SETTING_PLUGIN ) );

if( !class_exists( 'WOO_SALES_COUNTER'. false ) ) {
    require_once WSALE_EDITING__DIR .  '/include/class-sale_hooks.php';
    require_once WSALE_EDITING__DIR .  '/include/class-sale_variables.php';
}
$obj = new WOO_SALES_COUNTER();
add_action( 'init',  array($obj, "init") );
