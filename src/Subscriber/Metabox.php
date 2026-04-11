<?php

namespace Hasan\TroviaWpSubscriptionPlus\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}


class Metabox
{
    private $service;

    public function __construct(SubscriberService $service)
    {
        $this->service = $service;

    }



    public function register()
    {
        add_action('add_meta_boxes_twsp_subscriber', [$this, 'addMetaBoxes']);
        add_action('save_post', [$this, 'save_subscriber_meta'], 10, 2);
        //   add_action('admin_head-edit.php', [$this, 'edit_post_change_title']);
    }

    public function addMetaBoxes($post)
    {
        add_meta_box(
            'twsp-subscriber-details',
            'Subscriber details',
            [$this, 'twsp_subscriber_metabox'],
            'twsp_subscriber',
            'normal',
            'default'
        );
    }


    public function twsp_subscriber_metabox()
    {
        wp_nonce_field(basename(__FILE__), 'twsp_subscriber_nonce');
        global $post;

        $post_id = $post->ID;

        $first_name = (!empty(get_post_meta($post_id, 'slb_first_name', true))) ? get_post_meta($post_id, 'slb_first_name', true) : '';
        $last_name = (!empty(get_post_meta($post_id, 'slb_last_name', true))) ? get_post_meta($post_id, 'slb_last_name', true) : '';
        $email = (!empty(get_post_meta($post_id, 'slb_email', true))) ? get_post_meta($post_id, 'slb_email', true) : '';
        $lists = (!empty(get_post_meta($post_id, 'slb_list', false))) ? get_post_meta($post_id, 'slb_list', false) : [];

        ?>
        <style>
            .slb-field-row {
                display: flex;
                flex-flow: row nowrap;
            }

            .slb-field-container {
                position: relative;
                flex: 1 1;
                margin-right: 1em;
                margin-bottom: 1em;

            }

            .slb-field-container label {
                font-weight: bold;
            }

            .slb-field-container label span {
                color: red;
            }

            .slb-field-container label ul {
                list-style: none;
                margin-top: 0;
            }

            .slb-field-container label ul label {
                font-weight: normal;
            }
        </style>
        <div class="slb-field-row">
            <div class="slb-field-container">
                <label for="">First name <span>*</span> </label> <br>
                <input value="<?php echo $first_name; ?>" type="text" name="slb_first_name" class="widefat" required="required"
                    placeholder="First name">
            </div>
            <div class="slb-field-container">
                <label for="">Last name</label><br>
                <input value="<?php echo $last_name; ?>" class="widefat" type="text" name="slb_last_name"
                    placeholder="Last name">
            </div>

        </div>
        <div class="slv-field-row">
            <div class="slb-field-container">
                <label for="">Email <span>*</span></label> <br>
                <input value="<?php echo $email; ?>" class="widefat" type="text" name="slb_email" required="required"
                    placeholder="name@email.com">
            </div>
        </div>
        <div class="slv-field-row">
            <div class="slb-field-container">
                <label for="">Lists</label>
                <ul>
                    <?php
                    global $wpdb;

                    $list_query = $wpdb->get_results("SELECT ID,post_title FROM {$wpdb->posts} WHERE post_type = 'twsp_list' AND post_status IN ('draft', 'publish')");
                    //  foreach ($list_query as $row) {
                    if (!empty($list_query)) {
                        foreach ($list_query as $list) {
                            //  $lists = is_array($lists) ? $lists : [];
                            $checked = (in_array($list->ID, $lists)) ? 'checked="checked"' : '';
                            ?>
                            <li><label for="<?php echo $list->ID; ?>">
                                    <input id="<?php echo $list->ID ?>" type="checkbox" name="slb_list[]"
                                        value="<?php echo $list->ID; ?>" <?php echo $checked; ?> />
                                    <?php echo $list->post_title; ?>
                                </label>
                            </li>
                            <?php
                        }
                    }
                    ?>

                </ul>
            </div>
        </div>
        <?php
    }

    public function save_subscriber_meta($post_id, $post)
    {
        // verify nonce 
        if (!isset($_POST['twsp_subscriber_nonce']) || !wp_verify_nonce($_POST['twsp_subscriber_nonce'], basename(__FILE__))) {
            return $post_id;
        }

        // get the post type object 
        $post_type = get_post_type_object($post->post_type);

        // check if the current user has permission to edit the post 
        if (!current_user_can($post_type->cap->edit_post, $post_id)) {
            return $post_id;
        }

        // GET the posted data and sanitize 
        $first_name = (isset($_POST['slb_first_name'])) ? sanitize_text_field($_POST['slb_first_name']) : "";
        $last_name = (isset($_POST['slb_last_name'])) ? sanitize_text_field($_POST['slb_last_name']) : "";
        $email = (isset($_POST['slb_email'])) ? sanitize_text_field($_POST['slb_email']) : "";
        $lists = (isset($_POST['slb_list'])) ? (array) $_POST['slb_list'] : [];

        // echo '<br>' . $first_name;
        // echo '<br>' . $last_name;
        // echo '<br>' . $email;
        // echo '<br>' . var_dump($lists);
        // exit;


        update_post_meta($post_id, 'slb_first_name', $first_name);
        update_post_meta($post_id, 'slb_last_name', $last_name);
        update_post_meta($post_id, 'slb_email', $email);

        // delete the existing list meta 

        delete_post_meta($post_id, 'slb_list');

        // add new list meta 

        if (!empty($lists)) {
            foreach ($lists as $index => $list_id) {
                add_post_meta($post_id, 'slb_list', $list_id, false); // NOT unique meta key
            }
        }

    }

    public function edit_post_change_title()
    {
        global $post;
        if ($post->post_type == 'twsp_subscriber') {
            add_filter('the_title', [$this, 'subscriber_title'], 100, 2);
        }

    }

    public function subscriber_title($title, $post_id)
    {
        $new_title = get_post_meta($post_id, 'slb_first_name', true) . ' ' . get_post_meta($post_id, 'slb_last_name', true);
        return $new_title;
    }

}


