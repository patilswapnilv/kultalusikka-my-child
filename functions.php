<?php
/**
 * This is child themes functions.php file. All modifications should be made in this file.
 *
 * All style changes should be in child themes style.css file.
 *
 * @package KultalusikkaMyChild
 * @subpackage Functions
 */

/* Adds the child theme setup function to the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'kultalusikka_my_child_theme_setup', 11 );

/**
 * Setup function.  All child themes should run their setup within this function.  The idea is to add/remove 
 * filters and actions after the parent theme has been set up.  This function provides you that opportunity.
 *
 * @since 0.1.0
 */
function kultalusikka_my_child_theme_setup() {

	/* Get the theme prefix ("kultalusikka"). */
	$prefix = hybrid_get_prefix();

	/* Example action. */
	// add_action( "{$prefix}_header", 'kultalusikka_my_child_example_action' );

	/* Example filter. */
	// add_filter( "{$prefix}_site_title", 'kultalusikka_my_child_example_filter' );
	
	/* Add button for new topic. */
	add_action( "{$prefix}_before_topic_loop", 'kultalusikka_my_child_add_new_topic' );
	
	/* Load template for not Foxnet Theme club members. */
	add_filter( 'template_include', 'kultalusikka_my_child_club_member_template', 99 );
	
	/* Show only downloads from 'themes' category. Taxonomy is called 'download_category'. */
	add_filter( 'kultalusikka_front_page_download_arguments', 'kultalusikka_my_child_front_page_arguments' );
	
	/* Change front page url and text to point 'themes' category. */
	add_filter( 'kultalusikka_front_page_download_url', 'kultalusikka_my_child_front_page_download_url' );
	add_filter( 'kultalusikka_front_page_latest', 'kultalusikka_my_child_front_page_latest' );
	
	/* Enqueue scripts. */
	add_action( 'wp_enqueue_scripts', 'kultalusikka_my_child_scripts_styles' );
	
	/* Filter breadcrumb in dowload_category page. There is wrong post type. */
	add_filter( 'breadcrumb_trail_items', 'kultalusikka_my_child_breadcrumb_trail_items' );
	
	/* Show doc_category on singular doc page. */
	add_filter( 'breadcrumb_trail_args', 'kultalusikka_my_child_breadcrumb_trail_args' );
	
}

/**
 * Add button for new topic.
 *
 * @since 0.1.0
 */
function kultalusikka_my_child_add_new_topic() {

	$kultalusikka_my_child_add_new_topic_url = esc_url( home_url( '/'. 'add-new-topic' ) );
	$kultalusikka_my_child_add_new_topic = esc_attr(  __( 'Add new topic', 'kultalusikka' ) ); ?>
	<div id="kultalusikka-add-new-topic"><p><?php printf( __( '<a href="%1$s" class="kultalusikka-add-new-topic button theme-green edd-submit">%2$s</a>', 'kultalusikka' ), $kultalusikka_my_child_add_new_topic_url, $kultalusikka_my_child_add_new_topic ); ?></p></div>
	
	<?php
}

/**
 * Load template for not Foxnet Theme club members.
 *
 * @since 0.1.0
 */
function kultalusikka_my_child_club_member_template( $template ) {

	/* Get current user id. */
	$user_id = get_current_user_id();
	
	/* Current date in timestamp format. */
	$current_date = current_time( 'timestamp' );
	
	/* Test date. */
	$test_date = strtotime ( '+3 year' , strtotime ( $current_date ) ) ;
	
	/* Get current user id. */
	$user_id = get_current_user_id();
		
	/* Get expire date. */
	$expire_date = get_user_meta( $user_id, 'expire_date', true );
	
	/* If is admin return. */
	if ( current_user_can( 'administrator' ) ) {
		return $template;
	}
	else if ( is_singular( array( 'tutorial', 'doc', 'topic', 'reply' ) ) && $expire_date < $current_date ) {
		$template = locate_template( array( 'foxnet-club-content-no.php' ) );
		return $template;
	}
	else if ( is_singular( array( 'tutorial', 'doc', 'topic', 'reply' ) ) && !current_user_can( 'view_foxnet_club_content' ) ) {
		$template = locate_template( array( 'foxnet-club-content-no.php' ) );
		return $template;
	}
	else {
		return $template;
	}
}

/**
 * Show only downloads from 'themes' category. Taxonomy is called 'download_category'.
 *
 * @since 0.1.0
 */
function kultalusikka_my_child_front_page_arguments( $download_args ) {

	$download_args['tax_query'] = array( 
		array(
			'taxonomy' => 'download_category',
			'field' => 'slug',
			'terms' => 'themes'
			)
		);

	return $download_args;
}

/**
 * Change front page url to point 'themes' category.
 *
 * @since 0.1.0
 */
function kultalusikka_my_child_front_page_download_url( $url ) {
	
	$url = home_url( '/' . 'downloads/category/themes' );
	
	return $url;

}

/**
 * Change front page text to 'Latest themes'.
 *
 * @since 0.1.0
 */
function kultalusikka_my_child_front_page_latest( $text ) {

	$text = __( 'Latest themes', 'kultalusikka-my-child' );
	
	return $text;

}

/**
 * Enqueues scripts and styles.
 *
 * @since 0.1.0
 */
function kultalusikka_my_child_scripts_styles() {

	if ( !is_admin() ) {
	
		/* Dequeue  EDD styles. These are added in a theme to save extra load. */
		wp_dequeue_style( 'edd-styles' );
		
		/* Dequeue  EDD software license css. These are added in a theme to save extra load. */
		wp_dequeue_style( 'edd-sl' );
		
	}
}

/**
 * Filter breadcrumb in dowload_category page. There is wrong post type.
 *
 * @since 0.1.0
 */
function kultalusikka_my_child_breadcrumb_trail_items( $items ) {

	if ( is_tax( 'download_category' ) || is_category() || is_tag() ) {

		$items = array_splice( $items, 0, -2 ); // Take second last argument of from breadcrumb.
		$items[] = single_term_title( '', false ); // Add single term title.
		
	}

	return $items;
}

/**
 * Show doc_category on singular doc page.
 *
 * @since 0.1.0
 */
function kultalusikka_my_child_breadcrumb_trail_args( $args ) {

	$args['singular_doc_taxonomy'] = 'doc_category';

	return $args;
}

?>