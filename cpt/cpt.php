<?php
function cptui_register_my_cpts_twsp_subscriber() {

	/**
	 * Post Type: Subscribers.
	 */

	$labels = [
		"name" => esc_html__( "Subscribers", "twentytwentyfive" ),
		"singular_name" => esc_html__( "Subscriber", "twentytwentyfive" ),
	];

	$args = [
		"label" => esc_html__( "Subscribers", "twentytwentyfive" ),
		"labels" => $labels,
		"description" => "",
		"public" => false,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "twsp_subscriber", "with_front" => false ],
		"query_var" => true,
		"supports" => false,
		"show_in_graphql" => false,
	];

	register_post_type( "twsp_subscriber", $args );
}

add_action( 'init', 'cptui_register_my_cpts_twsp_subscriber' );

function cptui_register_my_cpts_twsp_list() {

	/**
	 * Post Type: Lists.
	 */

	$labels = [
		"name" => esc_html__( "Lists", "twentytwentyfive" ),
		"singular_name" => esc_html__( "List", "twentytwentyfive" ),
	];

	$args = [
		"label" => esc_html__( "Lists", "twentytwentyfive" ),
		"labels" => $labels,
		"description" => "",
		"public" => false,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => [ "slug" => "twsp_list", "with_front" => false ],
		"query_var" => true,
		"supports" => [ "title" ],
		"show_in_graphql" => false,
	];

	register_post_type( "twsp_list", $args );
}

add_action( 'init', 'cptui_register_my_cpts_twsp_list' );