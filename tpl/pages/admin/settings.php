<form action="options.php" method="post">
    <?php
    settings_fields( 'tdw-github-posts-settings' );
    do_settings_sections( 'tdw-github-posts-settings' ); ?>
    <input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
</form>
    