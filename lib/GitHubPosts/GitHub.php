<?php
namespace Tdw\GitHubPosts;

use Exception;
use Symfony\Component\HttpClient\HttpClient;
use Tdw\GitHubPosts\Types\GitHubRepo;
use Tdw\GitHubPosts\Types\GitHubUser;

class GitHub
{
    //Utility Class
    private Utils $utils;

    //Declare our user and repo data
    public GitHubUser $user;
    public array $repos = [];

    //Cache settings
    private string $userdata_cache_file;
    private string $repodata_cache_file;
    private string $username;

    public function __construct()
    {
        //Set our cache file locations
        $this->userdata_cache_file = TDW_GITHUB_POSTS_PLUGIN_DIR.'/cache/userdata.json';
        $this->repodata_cache_file = TDW_GITHUB_POSTS_PLUGIN_DIR.'/cache/repodata.json';

        $this->utils = new Utils();

        //Get the username from our settings page
        $this->username = get_option('tdw-github-posts-settings-username', Constants::USERS_URL);
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
        if ($isCached) return;

        $this->utils->log("Cache expired at " . date('m-j-Y H:i:s', filemtime($this->userdata_cache_file)));

        try {
            //Create our client and send the request
            $client = HttpClient::create();
            $response = $client->request('GET', Constants::USERS_URL.$this->username);

            //Verify the result is successful
            if (!$this->utils->isSuccess($response)) {
                throw new Exception('Failed getting user data');
            }

            //Get and cache the user data
            $userdata = $response->getContent();
            if (!empty($userdata)) {
                file_put_contents($this->userdata_cache_file, $userdata);
            }

            //Create the user object from the JSON retrieved
            $this->user = new GitHubUser($userdata);

            //Verify we have a repos url
            if (!(isset($this->user->repos_url) && !empty($this->user->repos_url))) {
                throw new Exception('The repos url cannot be found');
            }

            //Get the repo data
            $repos_response = $client->request('GET', $this->user->repos_url.'?sort=created&direction=desc');

            //Verify the result was successful
            if (!$this->utils->isSuccess($repos_response)) {
                throw new Exception('There was an error retrieving the list of repos');
            }

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
        } catch (\Exception $e) {
            $this->utils->log($e->getMessage());

            //If we fall here, we try to use cache as a fallback
            $this->getFromCache();
        }
    }

    /**
     * Gets and sets user data from cache
     * @return bool
     */
    private function getFromCache(): bool
    {
        try {
            //First, we check to see if we have cached data
            //Cache is valid for 10 minutes before needing to be refreshed
            if (
                file_exists($this->userdata_cache_file) && filemtime($this->userdata_cache_file) > time() - Constants::CACHE_EXPIRES &&
                file_exists($this->repodata_cache_file) && filemtime($this->repodata_cache_file) > time() - Constants::CACHE_EXPIRES
            ){
                $this->utils->log("Trying cached data");
                $userdata = file_get_contents($this->userdata_cache_file);
                //Get our cached data and generate our user with it
                $this->user = new GitHubUser($userdata);

                //Do the same for the repos
                $repodata = file_get_contents($this->repodata_cache_file);
                $repos = json_decode($repodata);
                foreach($repos as $repo){
                    $this->repos[] = new GitHubRepo($repo);
                }

                return true;
            }
        } catch(Exception $e){
            $this->utils->log("Error getting cached GitHub user data: ".$e->getMessage());
        }

        return false;
    }
}