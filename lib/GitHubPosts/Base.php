<?php
namespace Tdw\GitHubPosts;

class Base
{
    //Declare our necessary classes
    public Admin $admin;
    public GitHub $gitHub;
    public Shortcodes $shortcodes;
    public Utils $utils;

    public function __construct(){
        //Initialize debug mode, if set
        $this->initDebugMode();

        //Init directories
        $this->initDirectories();

        //Initialize our classes
        $this->admin = new Admin();
        $this->gitHub = new GitHub();
        $this->shortcodes = new Shortcodes();
        $this->utils = new Utils();

        //Get our data
        $this->gitHub->getGitHubData();
    }

    /**
     * Creates any directories we need
     * @return void
     */
    private function initDirectories(): void
    {
        //Make our logs directory if it does not already exist
        if (!file_exists(TDW_GITHUB_POSTS_PLUGIN_DIR.'/logs')) {
            mkdir(TDW_GITHUB_POSTS_PLUGIN_DIR.'/logs', 0777, true);
        }

        //Make our cache directory if it does not already exist
        if (!file_exists(TDW_GITHUB_POSTS_PLUGIN_DIR.'/cache')) {
            mkdir(TDW_GITHUB_POSTS_PLUGIN_DIR.'/cache', 0777, true);
        }
    }

    /**
     * Sets error reporting on or off
     */
    private function initDebugMode(): void
    {
        //Turn warnings and errors on or off
        if (Constants::IS_DEBUG_MODE){
            //Turn on error reporting
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        } else {
            //Turn off all error reporting
            //error_reporting(0);
        }
    }
}