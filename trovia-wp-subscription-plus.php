<?php

/*
    Plugin Name: Trovia WP Email Subscriber 
    Description: This is a simple plugin that does something Unique.
    Plugin URI: 
    Version: 1.0
    Author: Hasan Karim
    Author URI:
    License: GPL2 or later
    Text Domain: trovia-wp-subscription-plus
*/


if (!defined('ABSPATH')) {
    exit;
}

define('TWSP_PLUGIN_FILE', __FILE__);
define('TWSP_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('TWSP_PLUGIN_URL', plugin_dir_url(__FILE__));



require_once __DIR__ . '/vendor/autoload.php';


use Hasan\TroviaWpSubscriptionPlus\Main;


Main::instance()->init();

