<?php

namespace Hasan\TroviaWpSubscriptionPlus\App\Trait;

if (!defined('ABSPATH')) {
    exit;
}

trait Singleton
{
    private static $instances = [];

    final public static function instance()
    {
        $called_class = static::class;

        if (!isset(self::$instances[$called_class])) {
            self::$instances[$called_class] = new static();
        }

        return self::$instances[$called_class];
    }

    final private function __construct()
    {
    }

    final private function __clone()
    {
    }

    final public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}