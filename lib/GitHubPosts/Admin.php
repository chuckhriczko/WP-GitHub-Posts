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
            //Register our settings group and section
            register_setting('tdw-github-posts-settings', 'tdw-github-posts-settings-username');
            add_settings_section('tdw-github-posts-settings-section', 'GitHub Posts Settings', function(){

            }, 'tdw-github-posts-settings');

            //Username field
            add_settings_field('tdw-github-posts-settings-username', 'GitHub Username', function(){
                $username = get_option('tdw-github-posts-settings-username', '');

                echo "<input id='tdw-github-posts-settings-username' name='tdw-github-posts-settings-username' type='text' value='" . esc_attr( $username ?? '' ) . "' />";
            }, 'tdw-github-posts-settings', 'tdw-github-posts-settings-section');

            //Sort field
            add_settings_field('tdw-github-posts-settings-sort', 'Sort By', function(){
                $sort = get_option('tdw-github-posts-settings-sort', 'created');

                echo "
                    <select id='tdw-github-posts-settings-sort' name='tdw-github-posts-settings-sort' type='text' value='" . esc_attr( $sort ?? 'created' ) . "'>
                        <option value='forks'".($sort === 'forks' ? ' selected="true"' : '').">Forks</option>
                        <option value='stars'".($sort === 'stars' ? ' selected="true"' : '').">Stars</option>
                        <option value='created'".($sort === 'created' ? ' selected="true"' : '').">Created Date</option>
                        <option value='updated'".($sort === 'updated' ? ' selected="true"' : '').">Updated Date</option>
                    </select>
                ";
            }, 'tdw-github-posts-settings', 'tdw-github-posts-settings-section');

            //Sort Direction
            add_settings_field('tdw-github-posts-settings-sort-direction', 'Sort Direction', function(){
                $sort_direction = get_option('tdw-github-posts-settings-sort-direction', '');

                echo "
                    <select id='tdw-github-posts-settings-sort-direction' name='tdw-github-posts-settings-sort-direction' type='text' value='" . esc_attr( $sort_direction ?? '' ) . "'>
                        <option value='desc'".($sort_direction === 'desc' ? ' selected="true"' : '').">Descending</option>
                        <option value='asc'".($sort_direction === 'asc' ? ' selected="true"' : '').">Ascending</option>
                    </select>
                ";
            }, 'tdw-github-posts-settings', 'tdw-github-posts-settings-section');
        }, 10);
    }
}