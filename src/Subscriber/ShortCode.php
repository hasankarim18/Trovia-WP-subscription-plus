<?php

namespace Hasan\TroviaWpSubscriptionPlus\Subscriber;

use Exception;

if (!defined('ABSPATH')) {
    exit;
}

class ShortCode
{
    private $service;
    public function __construct(SubscriberService $service)
    {
        $this->service = $service;
    }
    public function register()
    {
        add_action('init', [$this, 'init']);

        add_action('wp_ajax_save_twsp_subscriber_form', [$this, 'handle_form']);
        add_action('wp_ajax_nopriv_save_twsp_subscriber_form', [$this, 'handle_form']);
    }
    public function init()
    {
        add_shortcode('twsp_subscriber_form', [$this, 'shortCode']);
        //   $this->save_twsp_subscriber_form();


    }

    public function shortCode($atts = [], $content = null)
    {
        // setup our output variable - the form html 
        $atts = shortcode_atts([
            'title' => 'Subscribe to our newslatter',
            'id' => 0
        ], $atts);



        ob_start();
        ?>
        <style>
            .slb {
                max-width: 420px;
                margin: 30px auto;
                padding: 25px;
                border-radius: 10px;
                background: #ffffff;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
                font-family: Arial, sans-serif;
            }

            .slb h3 {
                margin-bottom: 20px;
                font-size: 22px;
                text-align: center;
                color: #333;
            }

            .slb-form {
                width: 100%;
            }

            .slb-input-container {
                margin-bottom: 15px;
            }

            .slb-input-container label {
                font-size: 14px;
                color: #555;
                margin-bottom: 5px;
                display: inline-block;
            }

            /* Inputs */
            .slb-input-container input[type="text"],
            .slb-input-container input[type="email"] {
                width: 100%;
                padding: 10px 12px;
                margin-top: 5px;
                border: 1px solid #ddd;
                border-radius: 6px;
                font-size: 14px;
                transition: all 0.3s ease;
            }

            /* First + Last name spacing */
            .slb-input-container input[name="slb_fname"] {
                margin-bottom: 8px;
            }

            /* Focus effect */
            .slb-input-container input:focus {
                border-color: #0073aa;
                outline: none;
                box-shadow: 0 0 0 2px rgba(0, 115, 170, 0.1);
            }

            /* Content area */
            .slb-content {
                margin-bottom: 15px;
                font-size: 14px;
                color: #666;
                line-height: 1.5;
            }

            /* Submit Button */
            .slb-input-container input[type="submit"] {
                width: 100%;
                padding: 12px;
                background: #0073aa;
                color: #fff;
                border: none;
                border-radius: 6px;
                font-size: 15px;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            /* Hover */
            .slb-input-container input[type="submit"]:hover {
                background: #005f8d;
            }

            /* Responsive */
            @media (max-width: 480px) {
                .slb {
                    padding: 20px;
                }

                .slb h3 {
                    font-size: 20px;
                }
            }
        </style>
        <div class="slb">
            <h3><?php echo esc_html($atts['title']); ?></h3>
            <form id="twsp_form" name="twsp_form" class="slb-form" method="POST">
                <!-- list_id -->
                <input type="number" readonly="readonly" name="twsp_list" value="<?php echo (int) $atts['id']; ?>">
                <p class="slb-input-container mb-2">
                    <label for="">Your Name</label> <br>
                    <input type="text" name="twsp_fname" placeholder="First Name"> <br>
                    <input type="text" name="twsp_lname" placeholder="Last Name"> <br>

                </p>
                <!--  -->
                <?php
                if (!empty($content)):
                    ?>
                    <div class="slb-content">
                        <?php echo wp_kses_post($content) ?>
                    </div>
                    <?php
                endif;
                ?>
                <p class="slb-input-container">
                    <label for="">Your Email</label> <br>
                    <input type="email" name="twsp_email" placeholder="ex.you@email.com"> <br>


                </p>
                <p class="slb-input-container">
                    <input type="submit" value="Sign me up" name="twsp_submit">
                </p>
            </form>
            <div style="margin-top:20px;" class="twsp-message"></div>
        </div>
        <?php
        return ob_get_clean();


    }


    //** #ajax form handler */

    public function handle_form()
    {
        $fname = sanitize_text_field($_POST['fname']);
        $lname = sanitize_text_field($_POST['lname']);
        $email = sanitize_email($_POST['email']);
        $list = intval($_POST['list_id']);

        echo $fname;
        echo '<br>';
        echo $lname;
        echo '<br>';
        echo $email;
        echo '<br>';
        echo $list;
        // wp_send_json_success([
        //     'message' => 'Saved successfully'
        // ]);
    }



    public function save_twsp_subscriber_form()
    {
        $result = [
            'status' => 0,
            'message' => 'Subscription was not saved. '
        ];

        try {
            $list_id = (int) $_POST['twsp_list'];
            // prepare subscriber data
            $subscriber_data = [
                'fname' => esc_attr($_POST['twsp_fname']),
                'lname' => esc_attr($_POST['twsp_lname']),
                'email' => esc_attr($_POST['twsp_email']),
            ];
            // #fn_1 attempt to create/save subscriber
            $subscribar_id = twsp_save_subscriber($subscriber_data);

            // if subscriber was saved successfully $subscriber_id will be greater than 0
            if ($subscribar_id):

                // #fn_2 If subscriber already has this subscription 
                if (twsp_subscriber_has_subscription($subscribar_id, $list_id)):
                    // get list object
                    $list = get_post($list_id);
                    // return detailed Error
                    $result['message'] .= esc_attr($subscriber_data['email'] . ' is already subscribed to ' . $list->post_title . '.');
                else:
                    // #fn_3 save new subscription
                    $subscription_saved = twsp_add_subscription($subscribar_id, $list_id);

                    // IF subscription was saved successfully
                    if ($subscription_saved):

                        // subscription saved!
                        $result['status'] = 1;
                        $result['message'] = 'Subscription saved';
                    endif;

                endif;
            endif;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        /** */
        function twsp_save_subscriber($subscriber_data)
        {

            // setup default subscriber id
            // 0 means the subscriber was not saved
            $subscriber_id = 0;

            try {

                $subscriber_id = twsp_get_subscriber_id($subscriber_data['email']);

                // IF the subscriber does not already exists...
                if (!$subscriber_id):

                    // add new subscriber to database	
                    $subscriber_id = wp_insert_post(
                        array(
                            'post_type' => 'slb_subscriber',
                            'post_title' => $subscriber_data['fname'] . ' ' . $subscriber_data['lname'],
                            'post_status' => 'publish',
                        ),
                        true
                    );

                endif;

                // add/update custom meta data
                update_field(slb_get_acf_key('slb_fname'), $subscriber_data['fname'], $subscriber_id);
                update_field(slb_get_acf_key('slb_lname'), $subscriber_data['lname'], $subscriber_id);
                update_field(slb_get_acf_key('slb_email'), $subscriber_data['email'], $subscriber_id);

            } catch (Exception $e) {

                // a php error occurred

            }

            // return subscriber_id
            return $subscriber_id;

        }


        // #fn_2
        function twsp_subscriber_has_subscription($subscriber_id, $list_id)
        {
            return 0;
        }

        // #fn_3  //twsp_add_subscription
        function twsp_add_subscription($subscriber_id, $list_id)
        {
            return 0;
        }



        /** */

        // #fn_1.1 

        function twsp_get_subscriber_id($email)
        {
            $subscriber_id = 0;

            try {

                // check if subscriber already exists
                $subscriber_query = new WP_Query(
                    array(
                        'post_type' => 'slb_subscriber',
                        'posts_per_page' => 1,
                        'meta_key' => 'slb_email',
                        'meta_query' => array(
                            array(
                                'key' => 'slb_email',
                                'value' => $email,  // or whatever it is you're using here
                                'compare' => '=',
                            ),
                        ),
                    )
                );

                // IF the subscriber exists...
                if ($subscriber_query->have_posts()):

                    // get the subscriber_id
                    $subscriber_query->the_post();
                    $subscriber_id = get_the_ID();

                endif;

            } catch (Exception $e) {

                // a php error occurred

            }

            // reset the Wordpress post object
            wp_reset_query();

            return (int) $subscriber_id;
        }


    }

}
