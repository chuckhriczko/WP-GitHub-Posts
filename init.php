<?php
/*
Plugin Name: GitHub Posts
Description: Retrieves and displays GitHub projects using a shortcode
Version: 1.0
Author: Chuck Hriczko
License: GPLv2 or later
Text Domain: tdw-github-posts
*/
global $tdw_github_posts;
const TDW_GITHUB_POSTS_PLUGIN_FILE = __FILE__;

//Prefer to use const but define is necessary to use dirname in the definition
define("TDW_GITHUB_POSTS_PLUGIN_DIR", dirname(__FILE__));

//Include our Composer classes
require_once("vendor/autoload.php");

//Instantiate our API class
$tdw_github_posts = new Tdw\GitHubPosts\Base();