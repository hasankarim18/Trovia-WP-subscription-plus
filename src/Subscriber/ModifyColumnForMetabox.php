<?php
namespace Hasan\TroviaWpSubscriptionPlus\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}



class ModifyColumnForMetabox
{
    public function register()
    {
        add_action('admin_init', [$this, 'admin_init']);
    }


    public function admin_init()
    {

        add_filter('manage_twsp_subscriber_posts_columns', [$this, 'subscriber_column_headers']);
        add_action('manage_twsp_subscriber_posts_custom_column', [$this, 'twsp_subscriber_column_data'], 100, 2);
    }

    public function subscriber_column_headers($columns)
    {



        $columns = array(
            'cb' => '<input type="checkbox" />',
            'subscriber_name' => "Subscriber name",
            'email' => "Email",
        );

        return $columns;
    }

    // Adding data to the columns / twsp_subscriber 

    public function twsp_subscriber_column_data($column, $post_id)
    {
        //  var_dump("sda;lkf;;;;;;;;;;

        // echo $column;
        $output = '';

        switch ($column) {
            case 'subscriber_name':
                $output = get_post_meta($post_id, 'slb_first_name', true) . ' ' . get_post_meta($post_id, 'slb_last_name', true);
                //  $output = "Subscriber name";
                break;
            case 'email':
                $output = get_post_meta($post_id, 'slb_email', true);
                break;
            default:
                break;
        }



        echo $output;

    }


}