<?php
/**
 * main-box.tpl.php
 * Top-level wrapper for BDP directory pages.
 * Overridden in hero-lists-bdp theme to inject a hero section before search bar.
 * cjp, 2025-04-02
 */
?>
<?php
echo "\n<!-- 🔍 BDP Template: " . basename(__FILE__) . " from hero-lists-bdp theme -->\n";
?>

<?php
// begin CP custom code - cjp, 2025-04-02
// display custom hero section: show featured image and description, if present

$term = get_queried_object();

if ( $term && ! is_wp_error( $term ) && isset( $term->taxonomy ) ) :
    $term_name = $term->name;
    $term_description = term_description( $term );

    if(!function_exists('get_fields') || !function_exists('get_field')) :
        echo "\n<!-- Failed to find ACF (advanced custom fields) function. Check plugin status. -->\n";
    else :
        $term_key = $term->taxonomy . '_' . $term->term_id;
        $fields = function_exists('get_fields') ? get_fields($term_key) : false;
        if($fields) :
            echo "\n<!-- DEBUG: get_fields for " . esc_html($term_key) . " found fields: " . json_encode(array_keys($fields)) . " -->\n";
        endif;

        $image_field_name = 'directory_tag_featured_image';
        $featured_image = function_exists( 'get_field' ) ? get_field( $image_field_name, $term_key ) : false;
        if ( !$featured_image ) :
            echo "\n<!-- DEBUG: failed to find featured_image for term_key " . esc_html( $term_key ) . "-->\n";
        else:
            echo "\n<!-- DEBUG: found featured_image " . json_encode( $featured_image['id'] ) . "-->\n";
        endif;

        $hero_headline_field_name = 'directory_tag_hero_headline';
        $hero_headline = function_exists( 'get_field' ) ? get_field( $hero_headline_field_name, $term_key ) : false;
        if ( !$hero_headline ) :
            echo "\n<!-- DEBUG: failed to find hero_headline for term_key " . esc_html( $term_key ) . "-->\n";
        else:
            echo "\n<!-- DEBUG: found hero_headline " . json_encode( $hero_headline ) . "-->\n";
        endif;

    endif;

    if ( $hero_headline || $term_description || $featured_image ) :
    ?>
        <section class="bdp-hero-section">
            <div class="bdp-hero-content">
                <?php if ( $hero_headline || $term_description ) : ?>
                    <div class="bdp-hero-text">
                        <?php if ($hero_headline) : echo wp_kses_post( '<h2>' . $hero_headline . '</h2>' ); endif; ?>
                        <?php if ($term_description) : echo wp_kses_post( wpautop( $term_description ) ); endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ( $featured_image && is_array( $featured_image ) && isset( $featured_image['url'] ) ) : ?>
                    <div class="bdp-hero-image">
                        <img src="<?php echo esc_url( $featured_image['url'] ); ?>" alt="<?php echo esc_attr( $term_name ); ?>" />
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php
    else:
        echo "\n<!-- DEBUG: hero-lists-bdp template: " . basename(__FILE__) . " failed to find term_description or featured_image -->\n";
    endif;
else:
    echo "\n<!-- DEBUG: hero-lists-bdp template: " . basename(__FILE__) . " failed to find term or term was an error -->\n";
    echo "\n<!-- error: " . $term . " -->\n";
endif;
// end CP custom code
?>

<div id="wpbdp-main-box" class="wpbdp-main-box" data-breakpoints='{"tiny": [0,360], "small": [360,560], "medium": [560,710], "large": [710,999999]}' data-breakpoints-class-prefix="wpbdp-main-box">
<?php
    if ( isset( $_GET['inactive_listing'] ) && (int) $_GET['inactive_listing'] === 1 ) {
	echo wpbdp_render_msg( __( 'The listing you are trying to access is currently inactive or no longer available.', 'business-directory-plugin' ), 'notice' );
    }
?>

<?php if ( wpbdp_get_option( 'show-search-listings' ) || $in_shortcode ) : ?>
<div class="main-fields box-row cols-2">
	<form action="<?php echo esc_url( $search_url ); ?>" method="get">
		<input type="hidden" name="wpbdp_view" value="search" />
		<?php echo $hidden_fields; ?>
		<?php if ( ! wpbdp_rewrite_on() ) : ?>
		<input type="hidden" name="page_id" value="<?php echo wpbdp_get_page_id(); ?>" />
		<?php endif; ?>
		<div class="box-col search-fields">
			<div class="box-row cols-<?php echo $no_cols; ?>">
				<div class="box-col main-input">
					<label for="wpbdp-main-box-keyword-field" style="display:none;">Keywords:</label>
					<input type="text" id="wpbdp-main-box-keyword-field" title="Quick search keywords" class="keywords-field" name="kw" placeholder="<?php esc_attr_e( 'Search Listings', 'business-directory-plugin' ); ?>" />
				</div>
				<?php echo $extra_fields; ?>
			</div>
		</div>

		<div class="box-col submit-btn">
			<input type="submit" value="<?php echo esc_attr_x( 'Find Listings', 'main box', 'business-directory-plugin' ); ?>" class="button wpbdp-button"/>

			<a class="wpbdp-advanced-search-link" title="<?php esc_attr_e( 'Advanced Search', 'business-directory-plugin' ); ?>" href="<?php echo esc_url( $search_url ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 21v-7m0-4V3m8 18v-9m0-4V3m8 18v-5m0-4V3M1 14h6m2-6h6m2 8h6"/>
				</svg>
				<span class="wpbdp-sr-only"><?php esc_html_e( 'Advanced Search', 'business-directory-plugin' ); ?></span>
			</a>
		</div>
	</form>
</div>

<div class="box-row separator"></div>
<?php endif; ?>

<?php $main_links = wpbdp_main_links( $buttons ); ?>
<?php if ( $main_links ) : ?>
<div class="box-row"><?php echo $main_links; ?></div>
<?php endif; ?>

</div>
