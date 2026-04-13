<?php
namespace Hasan\TroviaWpSubscriptionPlus\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}



class ModifyColumnForAcf
{
    public function register()
    {
        add_action('admin_init', [$this, 'admin_init']);
    }


    public function admin_init()
    {

        add_filter('manage_twsp_subscriber_posts_columns', [$this, 'subscriber_column_headers']);
        add_action('manage_twsp_subscriber_posts_custom_column', [$this, 'twsp_subscriber_column_data'], 10, 2);
        add_filter('the_title', [$this, 'subscriber_title_modify'], 10, 2);
    }

    public function subscriber_column_headers($columns)
    {

        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => "Subscriber name",
            'email' => "Email",
            'Subscriber_id' => 'Subscriber Id'
        );

        return $columns;
    }

    public function subscriber_title_modify($title, $post_id)
    {
        $screen = get_current_screen();
        //  echo $screen->post_type;

        if ($screen && $screen->post_type === 'twsp_subscriber') {
            if (get_post_type($post_id) === 'twsp_subscriber') {
                $new_title = get_field('twsp_fname', $post_id) . ' ' . get_field('twsp_lname', $post_id);
                $title = $new_title;
            }
        }

        return $title;
    }

    // Adding data to the columns / twsp_subscriber 

    public function twsp_subscriber_column_data($column, $post_id)
    {
        //  var_dump("sda;lkf;;;;;;;;;;

        // echo $column;
        $output = '';

        switch ($column) {

            case 'email':
                $output = get_field('twsp_email', $post_id);
                break;
            case 'Subscriber_id':
                $output = $post_id;
                break;
            default:
                break;
        }



        echo $output;

    }


}