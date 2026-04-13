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
define('TWSP_PLUGIN_URI', plugin_dir_url(__FILE__));
define('TWSP_ACF_PATH', plugin_dir_path(__FILE__) . '/lib/advanced-custom-fields/');
define('TWSP_ACF_URL', plugin_dir_url(__FILE__) . '/lib/advanced-custom-fields/');

$twsp_show_acf_admin = false;

if (class_exists('ACF')) {
    $twsp_show_acf_admin = true;
}

include_once(TWSP_ACF_PATH . 'acf.php');

add_action('views_edit-twsp_subscriber', 'twsp_older_acf_warning');
add_action('views_edit-twsp_list', 'twsp_older_acf_warning');


function twsp_older_acf_warning($views)
{
    global $acf;
    $acf_ver = (float) $acf->settings['version'];
    $acf_ver_required = (float) 5.8;
    if ($acf_ver < $acf_ver_required) {
        ?>
        <div style="color:red; font-size:14px; font-weight:700;">
            -- You are using and older version of ACF (VERSION: <?php echo $acf_ver; ?>) <br> --
            Some functions of our plugin may not work properly. <br>
            *Please update ACF. Mninimum ACF required VERSION: <?php echo $acf_ver_required; ?>
        </div>
        <?php
    }

    return $views;
}


require_once __DIR__ . '/vendor/autoload.php';

include_once(plugin_dir_path(__FILE__) . '/cpt/twsp_subscriber.php');
include_once(plugin_dir_path(__FILE__) . '/cpt/cpt.php');

use Hasan\TroviaWpSubscriptionPlus\Main;


Main::instance()->init();

add_filter('acf/settings/url', 'xyz_acf_settings_url');
add_filter('acf/settings/show_admin', 'xyz_acf_settings_show_admin');

function xyz_acf_settings_url($url)
{

    return TWSP_ACF_URL;

}

function xyz_acf_settings_show_admin($twsp_admin)
{
    global $twsp_show_acf_admin;
    return $twsp_show_acf_admin;
    // return true;
}

