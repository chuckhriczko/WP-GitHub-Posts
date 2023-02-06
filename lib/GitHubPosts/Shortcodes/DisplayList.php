<?php

namespace Tdw\GitHubPosts\Shortcodes;

class DisplayList
{
    //Declare our singleton instances array
    private static array $instances;

    protected function __construct(){
        //Add our shortcode
        add_shortcode('GitHubPostsDisplayList', array($this, 'display'), 10, 2);
    }

    public function display($atts = array(), $content = null, $tag = '' )
    {
        //Extract our shortcode attributes passed by the user
        extract(shortcode_atts(array(
            'header' => '',
            'display_repo_user' => "false",
        ), $atts));

        //Process booleans
        $display_repo_user = $display_repo_user === 'true' || $display_repo_user === true;

        //Start the output buffer
        ob_start();

        //Generate our template directory and filename
        $tpl = '/tpl/shortcodes/display-list.php';

        //See if the template file exists in our theme directory
        //This allows the user to create the above file structure in their theme
        //to customize without modifying core plugin code
        $template_file = (file_exists(get_template_directory() . $tpl) ? get_template_directory() : TDW_GITHUB_POSTS_PLUGIN_DIR).$tpl;

        //Include our template
        include($template_file);

        //Get the processed HTML and clean the output buffer
        return ob_get_clean();
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