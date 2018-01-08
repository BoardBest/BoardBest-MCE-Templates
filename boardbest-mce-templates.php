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


