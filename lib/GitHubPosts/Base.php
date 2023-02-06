<?php
namespace Tdw\GitHubPosts;

use Masterminds\HTML5\Exception;
use Symfony\Component\HttpClient\HttpClient;
use Tdw\GitHubPosts\Types\GitHubRepo;
use Tdw\GitHubPosts\Types\GitHubUser;

class Base
{
    //Declare our utility object
    public Utils $utils;

    //Declare our user and repo data
    public GitHubUser $user;
    public array $repos = [];

    private string $userdata_cache_file;
    private string $repodata_cache_file;

    public function __construct(){
        //Set our cache file locations
        $this->userdata_cache_file = TDW_GITHUB_POSTS_PLUGIN_DIR.'/cache/userdata.json';
        $this->repodata_cache_file = TDW_GITHUB_POSTS_PLUGIN_DIR.'/cache/repodata.json';

        //Initialize our utilities class
        $this->utils = new Utils();

        //Initialize debug mode, if set
        $this->initDebugMode();

        //Init directories
        $this->initDirectories();

        //Init our shortcodes
        (Shortcodes::getInstance());

        //Get our data
        $this->getGitHubData();
    }

    /**
     * Gets the data from GitHub
     * @return void
     */
    public function getGitHubData(): void
    {
        //Get from cache and store result
        $isCached = $this->getFromCache();

        //If cache failed then we refresh data from GitHub
        if (!$isCached) {
            $this->utils->log("Cache expired at " . date('m-j-Y H:i:s', filemtime($this->userdata_cache_file)));

            try {
                //Create our client and send the request
                $client = HttpClient::create();
                $response = $client->request('GET', Constants::USERS_URL);

                //Verify the result is successful
                if ($this->utils->isSuccess($response->getStatusCode())) {
                    //Get and cache the user data
                    $userdata = $response->getContent();
                    if (!empty($userdata)) {
                        file_put_contents($this->userdata_cache_file, $userdata);
                    }

                    //Create the user object from the JSON retrieved
                    $this->user = new GitHubUser($userdata);
                    $this->utils->log($this->user);

                    //Verify we have a repos url
                    if (isset($this->user->repos_url) && !empty($this->user->repos_url)) {
                        //Get the repo data
                        $repos_response = $client->request('GET', $this->user->repos_url.'?sort=created&direction=desc');

                        //Verify the result was successful
                        if ($this->utils->isSuccess($repos_response->getStatusCode())) {
                            //Get and cache the data
                            $repojson = $repos_response->getContent();
                            if (!empty($repojson)) {
                                file_put_contents($this->repodata_cache_file, $repojson);
                            }

                            //Instantiate our repos array
                            $repodata = $repos_response->toArray();
                            foreach ($repodata as $repo) {
                                $this->repos[] = new GitHubRepo($repo);
                            }
                            $this->utils->log($this->repos);

                            //Return early
                            return;
                        }

                        $this->utils->log('Error getting repos');
                    }

                    $this->utils->log("Error getting GitHub repo data");
                    return;
                }

                //If we fall here, we try to use cache as a fallback
                $this->getFromCache();

                $this->utils->log("Error getting GitHub user data: " . $response->getStatusCode());
                return;
            } catch (\Exception $e) {
                $this->utils->log("{Error getting GitHub user data: " . $e->getMessage());

                //If we fall here, we try to use cache as a fallback
                $this->getFromCache();
            }
        }
    }

    /**
     * Gets and sets user data from cache
     * @return bool
     */
    private function getFromCache(): bool
    {
        /*$this->utils->log("User Cache Exists: ".file_exists($this->userdata_cache_file));
        $this->utils->log("User Cache Expires: ".date('m-d-Y H:i:s', filemtime($this->userdata_cache_file)));
        $this->utils->log("Repo Cache Exists: ".file_exists($this->userdata_cache_file));
        $this->utils->log("Repo Cache Expires: ".date('m-d-Y H:i:s', filemtime($this->userdata_cache_file)));*/

        try {
            //First, we check to see if we have cached data
            //Cache is valid for 10 minutes before needing to be refreshed
            if (
                file_exists($this->userdata_cache_file) && filemtime($this->userdata_cache_file) > time() - Constants::CACHE_EXPIRES &&
                file_exists($this->repodata_cache_file) && filemtime($this->repodata_cache_file) > time() - Constants::CACHE_EXPIRES
            ){
                $this->utils->log("Getting cached data");
                $userdata = file_get_contents($this->userdata_cache_file);
                //Get our cached data and generate our user with it
                $this->user = new GitHubUser($userdata);

                //Do the same for the repos
                $repodata = file_get_contents($this->repodata_cache_file);
                $repos = json_decode($repodata);
                foreach($repos as $repo){
                    $this->repos[] = new GitHubRepo($repo);
                }

                //Return early to short circuit the rest of the function
                return true;
            }
        } catch(\Exception $e){
            $this->utils->log("{Error getting cached GitHub user data: ".$e->getMessage());
        }

        return false;
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