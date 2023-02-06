<?php
namespace Tdw\GitHubPosts;

class Shortcodes
{
    //Declare our singleton instances array
    private static array $instances;

    protected function __construct(){
        //Display list shortcode
        (Shortcodes\DisplayList::getInstance());
    }

    /**
     * Gets the instance of our singleton object, so we don't have to instantiate it
     * @return mixed|static
     */
    public static function getInstance()
    {
        if (!isset(self::$instances[static::class])) {
            self::$instances[static::class] = new static();
        }

        return self::$instances[static::class];
    }
}