<?php
namespace Tdw\GitHubPosts;

class Utils{
    //Declare our instances array
    private static array $instances = array();

    public function __construct(){

    }

    /**
     * Prints out the contents of any variable
     * @param $var
     * @param bool|null $log_name
     * @return void
     */
    public function log($var, bool | null $log_name = null): void
    {
        $file = TDW_GITHUB_POSTS_PLUGIN_DIR.'/logs/'.($log_name ?? 'log');
        file_put_contents($file, "\r\n------------".date("Y-m-d H:i:s")." --------------------------------------------------\r\n", FILE_APPEND);
        file_put_contents($file, print_r($var,true)."\r\n", FILE_APPEND);
    }

    /**
     * Records any variable to the error log
     * @param $var
     * @return void
     */
    public function elog($var): void
    {
        error_log(print_r($var,true));
    }

    /**
     * Determines if a status code is a success
     * @param int $statusCode
     * @return bool
     */
    public function isSuccess(int $statusCode): bool{
        return $statusCode >= 200 && $statusCode < 400;
    }

    /**
     * Gets the instance of our singlton object so we don't have to instantiate it
     * @return mixed|static
     */
    public static function getInstance()
    {
        if (!isset(self::$instances[static::class])) {
            self::$instances[static::class] = new static();
        }

        return self::$instances[static::class];
    }

    //Seal off the clone and wakeup functions as they are not usable in a singleton pattern
    private function __clone() {}
    private function __wakeup() {}
}