<?php
/**
 * @package Slickity
 * @version 1.0.3
 */
/*
Plugin Name: Slickity
Plugin URI:
Description: Slickity is <strong>the last WordPress carousel plugin you'll ever need!</strong> Easily add fully customizable carousels and sliders to your theme using a simple shortcode. Fully responsive and loaded with a ton of customizable features including lazy loading, navigation, theming and more. Uses Key Wheeler's hugely popular <a href="http://kenwheeler.github.io/slick/">slick</a> library.
Author: Ben Marshall
Version: 1.0.3
Author URI: https://benmarshall.me
*/

// Define constants
if ( ! defined( 'SLICKITY' ) )
{
  define( 'SLICKITY', __FILE__ );
}

/**
 * Required plugins
 */
require plugin_dir_path( SLICKITY ) . '/inc/required-plugins.php';

// Check if the Advanced Custom Fields is available.
if ( function_exists( 'get_field' ) )
{
  /**
   * Enqueues scripts and styles.
   *
   * @since For Slickity 1.0.0
   */
  add_action( 'wp_enqueue_scripts', 'slickity_scripts' );
  function slickity_scripts()
  {
    wp_register_script( 'slickity-slick',  plugin_dir_url( SLICKITY ) . 'js/slick.min.js', array( 'jquery' ), '1.6.0', true );
    wp_register_style( 'slickity-slick',  plugin_dir_url( SLICKITY ) . 'css/slick.css' );
    wp_register_style( 'slickity-icons',  plugin_dir_url( SLICKITY ) . 'css/fontello.css' );
    wp_register_style( 'slickity-style',  plugin_dir_url( SLICKITY ) . 'css/style.css' );
  }

  // Add shortcode filters to text widget.
  add_filter( 'widget_text', 'shortcode_unautop' );
  add_filter( 'widget_text', 'do_shortcode' );

  // Add contet filters to slide content.
  add_filter( 'slickity_content_filter', 'wptexturize' );
  add_filter( 'slickity_content_filter', 'convert_smilies' );
  add_filter( 'slickity_content_filter', 'convert_chars' );
  add_filter( 'slickity_content_filter', 'wpautop' );
  add_filter( 'slickity_content_filter', 'shortcode_unautop' );
  add_filter( 'slickity_content_filter', 'do_shortcode' );

  /**
   * Advanced Custom Fields PRO fields.
   */
  require plugin_dir_path( SLICKITY ) . '/inc/acf.php';

  /**
   * Shortcodes
   */
  require plugin_dir_path( SLICKITY ) . '/inc/shortcodes.php';

  /**
   * Slideshow post type
   */
  require plugin_dir_path( SLICKITY ) . '/inc/slideshow-post-type.php';
}
