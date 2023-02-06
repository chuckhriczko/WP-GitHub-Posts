<?php
//Namespace our code for our application
namespace Tdw\GitHubPosts;

//Instantiate our class
class Constants
{
    //Development constants
    public const IS_DEBUG_MODE = false;

    //Instantiate our global application constants
    public const MIN_WP_VERSION          = '5.0';
    public const MIN_PHP_VERSION         = '7.4';
    public const APP_VERSION             = '1.0';
    public const APP_NAME                = 'tdw-github-posts';

    //API Constants
    public const USERS_URL = 'https://api.github.com/users/chuckhriczko';
    public const REPOS_URL = 'https://api.github.com/users/chuckhriczko/repos?sort=created&direction=desc';
    public const API_USERNAME = 'chuckhriczko';

    //Caching Constants
    public const CACHE_EXPIRES = 60 * 10;
}