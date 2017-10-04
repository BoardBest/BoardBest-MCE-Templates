<?php
/*
Plugin Name: BoardBest MCE Templates
Description: Boardbest TinnyMCE templates
Version:     0.0.1
Author:      dadmor@gmail.com

Copyright © 2017-2017 FutureNet.club

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

/* Register scripts */
$ajax_url = admin_url( 'admin-ajax.php' );
wp_register_script( 'ajax-script', plugin_dir_url(__FILE__) . 'js/mce-templates.js', array (), false, true );
$wp_vars = array(
  'ajax_url' => admin_url( 'admin-ajax.php' ) ,
);
wp_localize_script( 'ajax-script', 'wp_vars', $wp_vars );
wp_enqueue_script( 'ajax-script' );


/* Register postype */
function register_mce_templates_posttype() {
    $args = array(
      'public' => true,
      'label'  => 'MceTemplates',
      'supports' => array( 'title', 'editor', 'author', 'thumbnail')
    );
    register_post_type( 'mcetemplates', $args );
}
add_action( 'init', 'register_mce_templates_posttype' );


/* Register postype taxonomy*/
function create_mce_templates_tax() {
	register_taxonomy(
		'tpl-type',
		'mcetemplates',
		array(
			'label' => __( 'Template Type' ),
			'rewrite' => array( 'slug' => 'tpltype' ),
			'hierarchical' => true,
		)
	);
}
add_action( 'init', 'create_mce_templates_tax' );


/* WP AJAX get template */
add_action( 'wp_ajax_bbGETtemplate', 'bbGETtemplate' );
add_action( 'wp_ajax_nopriv_bbGETtemplate', 'bbGETtemplate' );
function bbGETtemplate(){
	$data = (json_decode(stripslashes($_POST['data']), true));
	$post = get_post( $data['id'] ); 
	$temp_post = array(
		'post_id' => $post->ID,
		'post_content' => $post->post_content,
		'post_thumbnail' => get_the_post_thumbnail_url($post,'thumbnail')
		);
	wp_send_json( $temp_post );
}

/* WP AJAX get template */
add_action( 'wp_ajax_bbGETtemplates', 'bbGETtemplates' );
add_action( 'wp_ajax_nopriv_bbGETtemplates', 'bbGETtemplates' );
function bbGETtemplates(){
	
	$data = (json_decode(stripslashes($_POST['data']), true));
	$output = array();
	foreach ($data['types'] as $key) {

		$query = new WP_Query( array(
			'post_type' => 'mcetemplates',
			'posts_per_page' => -1,
			'tax_query' => array(
			        array (
			            'taxonomy' => 'tpl-type',
			            'field' => 'slug',
			            'terms' => $key,
			        )
			    ),
			) );
		
		if ( $query->have_posts() ) {

			while ( $query->have_posts() ) {

				$query->the_post();
				$output[$key] = $query->posts;
				// now $query->post is WP_Post Object, use:
				// $query->post->ID, $query->post->post_title, etc.

			}

		}	
	}
	
	wp_send_json( $output );
}
