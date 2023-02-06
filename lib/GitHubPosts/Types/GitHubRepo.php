<?php
namespace Tdw\GitHubPosts\Types;
class GitHubRepo extends BaseClass
{
    public ?int $id;
    public ?string $node_id;
    public ?string $name;
    public ?string $full_name;
    public ?bool $private;
    public ?object $owner;
    public ?string $html_url;
    public ?string $description;
    public ?bool $fork;
    public ?string $url;
    public ?string $forks_url;
    public ?string $keys_url;
    public ?string $collaborators_url;
    public ?string $teams_url;
    public ?string $hooks_url;
    public ?string $issue_events_url;
    public ?string $events_url;
    public ?string $assignees_url;
    public ?string $branches_url;
    public ?string $tags_url;
    public ?string $blobs_url;
    public ?string $git_tags_url;
    public ?string $git_refs_url;
    public ?string $trees_url;
    public ?string $statuses_url;
    public ?string $languages_url;
    public ?string $stargazers_url;
    public ?string $contributors_url;
    public ?string $subscribers_url;
    public ?string $subscription_url;
    public ?string $commits_url;
    public ?string $git_commits_url;
    public ?string $comments_url;
    public ?string $issue_comment_url;
    public ?string $contents_url;
    public ?string $compare_url;
    public ?string $merges_url;
    public ?string $archive_url;
    public ?string $downloads_url;
    public ?string $issues_url;
    public ?string $pulls_url;
    public ?string $milestones_url;
    public ?string $notifications_url;
    public ?string $labels_url;
    public ?string $releases_url;
    public ?string $deployments_url;
    public ?string $created_at;
    public ?string $updated_at;
    public ?string $pushed_at;
    public ?string $git_url;
    public ?string $ssh_url;
    public ?string $clone_url;
    public ?string $svn_url;
    public ?string $homepage;
    public ?int $size;
    public ?int $stargazers_count;
    public ?int $watchers_count;
    public ?string $language;
    public ?bool $has_issues;
    public ?bool $has_projects;
    public ?bool $has_downloads;
    public ?bool $has_wiki;
    public ?bool $has_pages;
    public ?bool $has_discussions;
    public ?int $forks_count;
    public ?Object $mirror_url;
    public ?bool $archived;
    public ?bool $disabled;
    public ?int $open_issues_count;
    public ?Object $license;
    public ?bool $allow_forking;
    public ?bool $is_template;
    public ?bool $web_commit_signoff_required;
    public ?array $topics;
    public ?string $visibility;
    public ?int $forks;
    public ?int $open_issues;
    public ?int $watchers;
    public ?string $default_branch;

    public function __construct(string | object | array | null $json_data = null)
    {
        parent::__construct($json_data);
    }
}