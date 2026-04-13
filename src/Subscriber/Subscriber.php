<?php

namespace Hasan\TroviaWpSubscriptionPlus\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}





class Subscriber
{
    public function register()
    {
        //  var_dump('subsssssssssssssssssssssssssssssssscer');
        //  $this->shortCode();

        add_action('init', [$this, 'init']);



        $service = new SubscriberService();

        $features = [
            new ShortCode($service),
            //  new Metabox($service),
            //  new ModifyColumnForMetabox(),
            new ModifyColumnForAcf(),
            new ModifyColumnsForLists(),
            new AdminPage()
        ];

        foreach ($features as $feature) {
            if (method_exists($feature, 'register')) {
                $feature->register();
            }
        }



    }

    public function init()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);

    }


    public function enqueue_scripts()
    {
        wp_enqueue_script('jquery'); // VERY IMPORTANT
        wp_enqueue_script('subscriber-form-handler', TWSP_PLUGIN_URI . 'src/js/subscriber-form-handler.js', ['jquery'], '1.0.0', true);
        wp_localize_script('subscriber-form-handler', 'twsp', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('twsp_subscriber_form_nonce'),
            'action' => 'save_twsp_subscriber_form',
            'admin_url' => admin_url()

        ]);
    }

    public function admin_enqueue_scripts()
    {
        // snappy-list-builder-admin.js
        wp_enqueue_script('snappy-list-builder-admin', TWSP_PLUGIN_URI . '/src/js/snappy-list-builder-admin.js', ['jquery'], true);
    }

}




/* !0. TABLE OF CONTENTS */

/*

    1. HOOKS

    2. SHORTCODES

    3. FILTERS

    4. EXTERNAL SCRIPTS

    5. ACTIONS

    6. HELPERS

    7. CUSTOM POST TYPES

    8. ADMIN PAGES

    9. SETTINGS

    10. MISCELLANEOUS 

*/




/* !1. HOOKS */




/* !2. SHORTCODES */




/* !3. FILTERS */




/* !4. EXTERNAL SCRIPTS */




/* !5. ACTIONS */




/* !6. HELPERS */




/* !7. CUSTOM POST TYPES */




/* !8. ADMIN PAGES */




/* !9. SETTINGS */




/* !10. MISCELLANEOUS */



