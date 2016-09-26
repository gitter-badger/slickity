<?php
/**
 * Slideshow post type
 *
 * @package Slickity
 * @version 1.0.0
 */

if ( ! function_exists( 'slickity_slideshow_post_type' ) )
{

  // Register Custom Post Type
  function slickity_slideshow_post_type()
  {

    $labels = array(
      'name'                  => _x( 'Slideshows', 'Post Type General Name', 'slickity' ),
      'singular_name'         => _x( 'Slideshow', 'Post Type Singular Name', 'slickity' ),
      'menu_name'             => __( 'Slideshows', 'slickity' ),
      'name_admin_bar'        => __( 'Slideshow', 'slickity' ),
      'archives'              => __( 'Slideshow Archives', 'slickity' ),
      'parent_item_colon'     => __( 'Parent Slideshow:', 'slickity' ),
      'all_items'             => __( 'All Slideshows', 'slickity' ),
      'add_new_item'          => __( 'Add New Slideshow', 'slickity' ),
      'add_new'               => __( 'Add New', 'slickity' ),
      'new_item'              => __( 'New Slideshow', 'slickity' ),
      'edit_item'             => __( 'Edit Slideshow', 'slickity' ),
      'update_item'           => __( 'Update Slideshow', 'slickity' ),
      'view_item'             => __( 'View Slideshow', 'slickity' ),
      'search_items'          => __( 'Search Slideshow', 'slickity' ),
      'not_found'             => __( 'Not found', 'slickity' ),
      'not_found_in_trash'    => __( 'Not found in Trash', 'slickity' ),
      'featured_image'        => __( 'Slide Image', 'slickity' ),
      'set_featured_image'    => __( 'Set slide image', 'slickity' ),
      'remove_featured_image' => __( 'Remove slide image', 'slickity' ),
      'use_featured_image'    => __( 'Use as slide image', 'slickity' ),
      'insert_into_item'      => __( 'Insert into slide', 'slickity' ),
      'uploaded_to_this_item' => __( 'Uploaded to this slide', 'slickity' ),
      'items_list'            => __( 'Slides list', 'slickity' ),
      'items_list_navigation' => __( 'Slides list navigation', 'slickity' ),
      'filter_items_list'     => __( 'Filter slides list', 'slickity' ),
    );
    $args = array(
      'label'                 => __( 'Slideshow', 'slickity' ),
      'description'           => __( 'Used to create slick slideshows.', 'slickity' ),
      'labels'                => $labels,
      'supports'              => array( 'title', 'author', 'revisions' ),
      'taxonomies'            => array(),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 5,
      'menu_icon'             => 'dashicons-slides',
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => false,
      'can_export'            => true,
      'has_archive'           => false,
      'exclude_from_search'   => true,
      'publicly_queryable'    => true,
      'capability_type'       => 'page',
    );
    register_post_type( 'slickity-slideshow', $args );

  }
  add_action( 'init', 'slickity_slideshow_post_type', 0 );

}