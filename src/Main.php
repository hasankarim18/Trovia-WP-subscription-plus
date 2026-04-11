<?php






namespace Hasan\TroviaWpSubscriptionPlus;

use Hasan\TroviaWpSubscriptionPlus\App\Trait\Singleton;
use Hasan\TroviaWpSubscriptionPlus\Subscriber\Subscriber;

if (!defined('ABSPATH')) {
    exit;
}


class Main
{
    use Singleton;

    public $subscriber;

    public function init()
    {
        add_action('plugins_loaded', [$this, 'loadTextDomain']);
        add_action('plugins_loaded', [$this, 'boot']);
    }

    public function loadTextDomain()
    {
        load_plugin_textdomain(
            'trovia-wp-subscription-plus',
            false,
            dirname(plugin_basename(TWSP_PLUGIN_FILE)) . '/i18n'
        );
    }

    public function boot()
    {
        // Initialize features, hooks, services
        $this->subscriber = new Subscriber();
        $this->subscriber->register();



    }
}