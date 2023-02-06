<?php
namespace Tdw\GitHubPosts\Types;

class GitHubUser extends BaseClass
{
    public ?string $login;
    public ?int $id;
    public ?string $node_id;
    public ?string $avatar_url;
    public ?string $gravatar_id;
    public ?string $url;
    public ?string $html_url;
    public ?string $followers_url;
    public ?string $following_url;
    public ?string $gists_url;
    public ?string $starred_url;
    public ?string $subscriptions_url;
    public ?string $organizations_url;
    public ?string $repos_url;
    public ?string $events_url;
    public ?string $received_events_url;
    public ?string $type;
    public ?bool $site_admin;
    public ?string $name;
    public ?string $company;
    public ?string $blog;
    public ?string $location;
    private object $email;
    public ?bool $hireable;
    public ?string $bio;
    public ?string $twitter_username;
    public ?int $public_repos;
    public ?int $public_gists;
    public ?int $followers;
    public ?int $following;
    public ?string $created_at;
    public ?string $updated_at;

    public function __construct(string | object | array | null $json_data = null)
    {
        parent::__construct($json_data);
    }
}