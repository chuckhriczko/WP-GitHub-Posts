<?php
namespace Tdw\GitHubPosts;

use Tdw\GitHubPosts\Shortcodes\DisplayList;

class Shortcodes
{
    private DisplayList $displayList;

    public function __construct(){
        //Display List shortcode
        $this->displayList = new DisplayList();
    }
}