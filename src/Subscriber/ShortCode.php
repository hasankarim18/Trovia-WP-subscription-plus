<?php

namespace Hasan\TroviaWpSubscriptionPlus\Subscriber;

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
    }
    public function init()
    {
        add_shortcode('twsp_subscriber_form', [$this, 'shortCode']);
    }

    public function shortCode($atts = [], $content = null)
    {
        // setup our output variable - the form html 
        $atts = shortcode_atts([
            'title' => 'Subscribe to our newslatter'
        ], $atts);

        ob_start();
        ?>
                <div class="slb">

                    <h3><?php echo esc_html($atts['title']); ?></h3>
                    <form id="slb_form" name="slb_form" class="slb-form" action="" method="POST">
                        <p class="slb-input-container mb-2">
                            <label for="">Your Name</label> <br>
                            <input type="text" name="slb_fname" placeholder="First Name"> <br>
                            <input type="text" name="slb_lname" placeholder="Last Name"> <br>

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
                            <input type="email" name="slb_email" placeholder="ex.you@email.com"> <br>


                        </p>
                        <p class="slb-input-container">
                            <input type="submit" value="Sign me up" name="slb_submit">
                        </p>
                    </form>
                </div>
                <?php
                return ob_get_clean();


    }
}
