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
            new Metabox($service),
            new ModifyColumnForMetabox()
        ];

        foreach ($features as $feature) {
            if (method_exists($feature, 'register')) {
                $feature->register();
            }
        }



    }

    public function init()
    {


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



