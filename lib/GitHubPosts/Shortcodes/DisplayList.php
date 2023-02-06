<?php

namespace Tdw\GitHubPosts\Shortcodes;

class DisplayList
{
    public function __construct(){
        //Add our shortcode
        add_shortcode('GitHubPostsDisplayList', array($this, 'display'), 10, 2);
    }

    public function display($atts = array(), $content = null, $tag = '' )
    {
        global $tdw_github_posts;

        //Extract our shortcode attributes passed by the user
        extract(shortcode_atts(array(
            'header'            => '',
            'intro'            => '',
            'display_repo_user' => "false",
            'per_page'          => null
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

        //Process the results for the shortcode
        $repos = $per_page === null ? $tdw_github_posts->repos : array_slice($tdw_github_posts->repos, 0, (int)$per_page);

        //Include our template
        include($template_file);

        //Get the processed HTML and clean the output buffer
        return ob_get_clean();
    }
}