<?php
namespace Tdw\GitHubPosts;

class Admin
{
    public function __construct()
    {
        $this->initOptions();
    }

    public function initOptions(): void
    {
        add_action('admin_menu', function(){
            add_options_page('GitHub Posts Settings', 'GitHub Posts', 'manage_options', 'tdw-github-posts-settings', function(){
                //Start the output buffer to put the template code into a variable
                ob_start();

                //Include our template
                include(TDW_GITHUB_POSTS_PLUGIN_DIR.'/tpl/pages/admin/settings.php');

                //Echo the contents of the output buffer and clean it
                echo ob_get_clean();
            });
        }, 10);

        add_action('admin_init', function(){
            register_setting('tdw-github-posts-settings', 'tdw-github-posts-settings-username');
            add_settings_section('tdw-github-posts-settings-section', 'GitHub Posts Settings', function(){

            }, 'tdw-github-posts-settings');

            add_settings_field('tdw-github-posts-settings-username', 'GitHub Username', function(){
                $username = get_option('tdw-github-posts-settings-username', '');

                echo "<input id='tdw-github-posts-settings-username' name='tdw-github-posts-settings-username' type='text' value='" . esc_attr( $username ?? '' ) . "' />";
            }, 'tdw-github-posts-settings', 'tdw-github-posts-settings-section');
        }, 10);
    }
}