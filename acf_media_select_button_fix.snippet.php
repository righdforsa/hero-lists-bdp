/*
This snippet fixes a UI bug where the Select button in the ACF image field doesn’t appear correctly when editing directory tags (wpbdp_tag) in the WordPress admin.

If you renamed or replaced the default Business Directory "tag" taxonomy, update the $directory_tag_taxonomy variable near the top of the snippet to match your custom taxonomy name.
*/
add_action( 'admin_head', function () {
    // Customize this if you renamed the default Business Directory "tag" taxonomy
    $directory_tag_taxonomy = 'wpbdp_tag';

    $screen = get_current_screen();

    if ( $screen && isset( $screen->taxonomy ) && $screen->taxonomy === $directory_tag_taxonomy ) {
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
