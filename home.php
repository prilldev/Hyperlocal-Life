<?php

add_action( 'genesis_meta', 'locallife_home_genesis_meta' );
/*
 * Add widget support for homepage.
 */
function locallife_home_genesis_meta() {

	/* Remove the Genesis Loop for now (so custom home page stuff can come first) */
	remove_action( 'genesis_loop', 'genesis_do_loop' ); 
	
	add_action( 'genesis_after_header', 'locallife_home_top_helper' );
	add_action( 'genesis_after_header', 'locallife_home_loop_helper' );

	add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
	add_filter( 'body_class', 'add_body_class' );
	
	function add_body_class( $classes ) {
		$classes[] = 'locallife';
		return $classes;
	}

	/* OPTION 1: Add the Genesis Loop back in (Get all Posts) 
	 * This allows Bill Erickson's 'Genesis Grid' plugin to do all the work
	 * (with a settings admin menu under 'Genesis' for each site owner).
	 *
	 * OPTION 2: Add custom loop to filter posts (by post-type,category, etc)
	 * instead of calling default genesis_do_loop.
	 *
	 * OPTION 3: Just some other custom grid formatting that works well
	 * This code is now handled by the 'Genesis Grid' plugin (Option 1)
	 * and can probably be removed in release version of this theme.
	 *
	 * OPTION 4: Don't do an "add_action" at all resulting in NO LOOP on the
	 * Home page. Content would then be handled solely by 'Home Widgets'.
	 */	
	add_action( 'genesis_loop', 'genesis_do_loop' );  /* OPTION 1 */
	//add_action( 'genesis_loop', 'locallife_home_loop_data' ); /* OPTION 2 */
	//add_action( 'genesis_loop', 'locallife_child_grid_loop_helper' ); /* OPTION 3 */
	
}

/*
 * Top section Widget layout
 *
 */
function locallife_home_top_helper() {

	echo '<div id="home-featured">';
	
	/* featured top slider and top right */
	echo '<div class="featured-top">';

	if ( is_active_sidebar( 'home-slider' ) ) {
		echo '<div class="slider-left">';
		dynamic_sidebar( 'home-slider' );
		echo '</div><!-- end .slider-left -->';
	}

	if ( is_active_sidebar( 'home-top-right' ) ) {
		echo '<div class="featured-right dark-widget-area">';
		dynamic_sidebar( 'home-top-right' );
		echo '</div><!-- end .featured-right -->';
	}

	echo '</div><!-- end .featured-top -->' ;
	
}

/*
 * Middle section Widget layout
 *
 */
function locallife_home_loop_helper() {

	/* featured middle section (CSS ".featured" class styles widgets as 3-column grid) */
	if ( is_active_sidebar( 'home-middle' ) ) {
		echo '<div class="featured home-middle">';
		dynamic_sidebar( 'home-middle' );
		echo '</div><!-- end .featured -->';	
	}
	/* featured bottom section (CSS ".featured" class styles widgets as 3-column grid) */
	if ( is_active_sidebar( 'home-bottom' ) ) {
		echo '<div class="featured home-bottom">';
		dynamic_sidebar( 'home-middle-bottom' );
		echo '</div><!-- end .featured -->';	
	}	
	
	echo '</div><!-- end #home-featured -->' ;
	
	/* home widget for content to appear after featured content (full width?) */
	echo '<div id="home-after-featured">';
	if ( is_active_sidebar( 'home-after-featured' ) ) {
		echo '<div class="after-featured">';
		dynamic_sidebar( 'home-after-featured' );
		echo '</div><!-- end .after-featured -->';
	}
	echo '</div><!-- end #home-after-featured -->' ;
	
}

//* Remove the post meta function (use on frontpage only) */
remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
 

genesis();