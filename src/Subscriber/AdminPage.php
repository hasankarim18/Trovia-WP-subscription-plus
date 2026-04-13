<?php

namespace Hasan\TroviaWpSubscriptionPlus\Subscriber;
if (!defined('ABSPATH')) {
    exit;
}

class AdminPage
{
    public function register()
    {
        add_action('admin_menu', [$this, 'createMenu']);
    }


    public function createMenu()
    {
        $top_menu_item_parent = 'twsp_dashboard_admin_page';

        add_menu_page('List builder', 'List Builder', 'manage_options', 'twsp_dashboard_admin_page', [$this, 'twsp_dashboard_admin_page'], 'dashicons-email-alt', 25);
        //    add_submenu_page( parent_slug, page_title, menu_title, capability, menu_slug, function )
        add_submenu_page($top_menu_item_parent, 'Dashboard', 'Dashboard', 'manage_options', 'twsp_dashboard_admin_page', [$this, 'twsp_dashboard_admin_page']);
        // email lists
        add_submenu_page($top_menu_item_parent, '', 'Email Lists', 'manage_options', 'edit.php?post_type=twsp_list');
        // subscribers
        add_submenu_page($top_menu_item_parent, '', 'Subscribers', 'manage_options', 'edit.php?post_type=twsp_subscriber');

        // import subscribers 
        add_submenu_page($top_menu_item_parent, '', 'Import Subscribers', 'manage_options', 'twsp_import_admin_page', [$this, 'twsp_import_admin_page']);
        // plugin options
        add_submenu_page($top_menu_item_parent, '', 'Plugin Options', 'manage_options', 'twsp_options_admin_page', [$this, 'twsp_options_admin_page']);


    }

    public function twsp_dashboard_admin_page()
    {
        ?>
        <div class="wrap">
            <?php
            screen_icon();
            ?>
            <h2>TWSP List Builder</h2>
            <p>The ultimate email list builder plugin for wordpress. Capture new subscriber. Reward subscriber with a custom
                download upon opt-in. Build unlimited lists. Import and export subscriber easily with .csv</p>
        </div>
        <?php
    }

    public function twsp_import_admin_page()
    {
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Import subscriber</h2>
            <p>Page description...</p>
        </div>
        <?php
    }

    public function twsp_options_admin_page()
    {
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h1>Twsp List Builder Options</h1>
            <p>Page description...</p>
        </div>
        <?php
    }
}