/*
This snippet fixes a UI bug where the Select button doesn't appear correctly in the Media Selector dialog when choosing and image file for an ACF image field for directory tags (wpbdp_tag) or directory categories (wpbdp_category) in the WordPress admin portal.
*/

add_action( 'admin_head', function () {
    $bdp_tag_taxonomy = 'wpbdp_tag';
    $bdp_category_taxonomy = 'wpbdp_category';

    $screen = get_current_screen();
    if ( $screen && isset( $screen->taxonomy ) && ($screen->taxonomy === $bdp_tag_taxonomy || $screen->taxonomy === $bdp_category_taxonomy)) {
        error_log("BDP ACF fix snippet is running");

        echo '<style>
/* Fix layout for Select button in media modal on wpbdp taxonomy screens */

/* Unhide button container hidden by admin.min.css */
.media-modal .search-form {
    display: block !important;
}

/* Ensure toolbar is positioned correctly */
.media-frame-toolbar .media-toolbar {
    top: -1px !important;
}
</style>';

        error_log("BDP ACF fix style snippet is complete");
    }
});
