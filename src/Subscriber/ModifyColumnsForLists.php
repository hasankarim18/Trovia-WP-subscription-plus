<?php
namespace Hasan\TroviaWpSubscriptionPlus\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}



class ModifyColumnsForLists
{
    public function register()
    {
        add_action('admin_init', [$this, 'admin_init']);
    }


    public function admin_init()
    {

        add_filter('manage_twsp_list_posts_columns', [$this, 'lists_column_headers']);
    }

    public function lists_column_headers($columns)
    {

        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => "List name",
        );

        return $columns;

    }



}