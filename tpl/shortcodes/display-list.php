<?php
    global $tdw_github_posts;
?>
<style>
    .tdw-github-posts-shortcode-display-list{
        margin-top: 1rem;
    }
    .tdw-github-posts-shortcode-display-list h2,
    .tdw-github-posts-shortcode-display-list h3{
        margin-bottom: 0;
        padding-top: 0;
        padding-bottom: 0;
    }
    .tdw-github-posts-shortcode-display-list i{
        font-size: 0.8rem;
    }
    .tdw-github-posts-shortcode-display-list-item{
        margin-top: 1rem;
    }
</style>
<div class="tdw-github-posts-shortcode tdw-github-posts-shortcode-display-list">
    <?php
        try{
            echo !empty($header) ? "<h2>{$header}</h2>" : '';

            echo !empty($intro) ? "<div>{$intro}</div>" : '';

            foreach($repos as $repo){
                $repo_name = $display_repo_user && isset($repo->name) ? $repo->name : $repo->full_name ?? '';
                $description = isset($repo->description) ? str_replace(['[code]', '[/code]'], '', $repo->description) : "(No description provided)";
                ?>
                <div class="tdw-github-posts-shortcode-display-list-item">
                    <h3><a href="<?php echo $repo->html_url; ?>" target="_blank"><?php echo $repo_name; ?></a></h3>
                    <?php echo isset($repo->language) ? "<i>Laguage: {$repo->language}</i>" : "" ?>
                    <div><?php echo $description; ?></div>
                </div>
                <?php
            }
        } catch(Exception $e){
            ?><h3>There was an error retrieving repos from GitHub</h3><?php
        }
    ?>
</div>