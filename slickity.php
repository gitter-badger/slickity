<?php

/*
Plugin Name: Slickity
Plugin URI: https://wordpress.org/plugins/slickity/
Description: Slickity is <strong>the last WordPress carousel plugin you'll ever need!</strong> Easily add fully customizable carousels and sliders to your theme using a simple shortcode. Fully responsive and loaded with a ton of customizable features. Uses Key Wheeler's hugely popular <a href="http://kenwheeler.github.io/slick/">slick</a> library.
Version: 2.0.1
Author: Ben Marshall
Author URI: https://benmarshall.me
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: slickity
Domain Path: /languages

Slickity is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Slickity is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Slickity. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if ( !function_exists( 'slickity_setup_post_type' ) ) {
  function slickity_setup_post_type() {
    // Register the slideshow post type.
    $labels = array(
      'name'                  => _x( 'Slideshows', 'Post Type General Name', 'slickity' ),
      'singular_name'         => _x( 'Slideshow', 'Post Type Singular Name', 'slickity' ),
      'menu_name'             => __( 'Slideshows', 'slickity' ),
      'name_admin_bar'        => __( 'Slideshows', 'slickity' ),
      'archives'              => __( 'Slideshow Archives', 'slickity' ),
      'attributes'            => __( 'Slideshow Attributes', 'slickity' ),
      'parent_item_colon'     => __( 'Parent Slideshow:', 'slickity' ),
      'all_items'             => __( 'All Slideshows', 'slickity' ),
      'add_new_item'          => __( 'Add New Slideshow', 'slickity' ),
      'add_new'               => __( 'Add New', 'slickity' ),
      'new_item'              => __( 'New Slideshow', 'slickity' ),
      'edit_item'             => __( 'Edit Slideshow', 'slickity' ),
      'update_item'           => __( 'Update Slideshow', 'slickity' ),
      'view_item'             => __( 'View Slideshow', 'slickity' ),
      'view_items'            => __( 'View Slideshows', 'slickity' ),
      'search_items'          => __( 'Search Slideshow', 'slickity' ),
      'not_found'             => __( 'Not found', 'slickity' ),
      'not_found_in_trash'    => __( 'Not found in Trash', 'slickity' ),
      'featured_image'        => __( 'Featured Image', 'slickity' ),
      'set_featured_image'    => __( 'Set featured image', 'slickity' ),
      'remove_featured_image' => __( 'Remove featured image', 'slickity' ),
      'use_featured_image'    => __( 'Use as featured image', 'slickity' ),
      'insert_into_item'      => __( 'Insert into slideshow', 'slickity' ),
      'uploaded_to_this_item' => __( 'Uploaded to this slideshow', 'slickity' ),
      'items_list'            => __( 'Slideshows list', 'slickity' ),
      'items_list_navigation' => __( 'Slideshows list navigation', 'slickity' ),
      'filter_items_list'     => __( 'Filter slideshows list', 'slickity' ),
    );
    $args = array(
      'label'                 => __( 'Slideshow', 'slickity' ),
      'description'           => __( 'Used to create embeddable slideshows.', 'slickity' ),
      'labels'                => $labels,
      'supports'              => array( 'title', 'revisions' ),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 5,
      'menu_icon'             => 'dashicons-slides',
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => false,
      'exclude_from_search'   => true,
      'publicly_queryable'    => true,
      'capability_type'       => 'post',
      'show_in_rest'          => false,
    );
    register_post_type( 'slickity_slideshow', $args );
  }
}
add_action( 'init', 'slickity_setup_post_type' );

if ( !function_exists( 'slickity_install' ) ) {
  function slickity_install() {
    // Register the custom post type.
    slickity_setup_post_type();

    // Clear permalinks after the post type has been registered to avoid 404 errors.
    // @TODO - Getting a 'Fatal error: Call to a member function flush_rules() on a non-object in /wp-includes/rewrite.php on line 273'
    //flush_rewrite_rules();
  }
}
register_activation_hook( __FILE__, 'slickity_install' );

if ( !function_exists( 'slickity_deactivation' ) ) {
  // Clear the permalinks to remove the post type's rules.
  // @TODO - Getting a 'Fatal error: Call to a member function flush_rules() on a non-object in /wp-includes/rewrite.php on line 273'
  //flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'slickity_deactivation' );

/**
 * Load plugin textdomain.
 *
 * @since 2.0.0
 */
function slickity_load_textdomain() {
  load_plugin_textdomain( 'slickity', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'slickity_load_textdomain' );

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/includes/class-tgm-plugin-activation.php';

/**
 * Include the config for Advanced Custom Fields.
 */
if ( !defined( 'SLICKITY_DEV' ) || ( defined( 'SLICKITY_DEV' ) && !SLICKITY_DEV ) ) {
  require_once dirname( __FILE__ ) . '/includes/acf.php';
}

/**
 * Register the required plugins for this theme.
 */
if ( !function_exists( 'slickity_register_required_plugins' ) ) {
  function slickity_register_required_plugins() {
    $plugins = array(
      array(
        'name'               => 'Advanced Custom Fields PRO',
        'slug'               => 'advanced-custom-fields-pro',
        'source'             => dirname( __FILE__ ) . '/includes/advanced-custom-fields-pro.zip',
        'required'           => true,
        'version'            => '5.6.7',
        'force_activation'   => true,
      ),
    );

    $config = array(
      'id'           => 'slickity',
      'menu'         => 'slickity-install-plugins',
      'parent_slug'  => 'plugins.php',
      'capability'   => 'manage_options',
      'has_notices'  => true,
      'dismissable'  => false,
      'is_automatic' => true,
      'strings'      => array(
        'page_title'                      => __( 'Install Required Plugins for Slickity', 'slickity' ),
        'notice_can_install_required'     => _n_noop(
          /* translators: 1: plugin name(s). */
          'Slickity requires the following plugin: %1$s.',
          'Slickity requires the following plugins: %1$s.',
          'slickity'
        ),
        'notice_ask_to_update'            => _n_noop(
          /* translators: 1: plugin name(s). */
          'The following plugin needs to be updated to its latest version to ensure maximum compatibility with Slickity: %1$s.',
          'The following plugins need to be updated to their latest version to ensure maximum compatibility with Slickity: %1$s.',
          'slickity'
        ),
        /* translators: 1: plugin name. */
        'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for Slickity. Please update the plugin.', 'slickity' ),
      ),
    );

    tgmpa( $plugins, $config );
  }
}
add_action( 'tgmpa_register', 'slickity_register_required_plugins' );

/**
 * Enqueue scripts and styles.
 */
if ( !function_exists( 'slickity_scripts' ) ) {
  function slickity_scripts() {
    global $post;

    // Register Slick JS
    wp_register_script( 'slickity-slick', plugin_dir_url( __FILE__ ) . 'public/js/slick.min.js', array( 'jquery' ), '1.8.0', true );

    // Register Slick CSS
    wp_register_style( 'slickity-slick', plugin_dir_url( __FILE__ ) . 'public/css/slick.css', array(), '1.8.0' );
    wp_register_style( 'slickity-theme', plugin_dir_url( __FILE__ ) . 'public/css/slick-theme.css', array( 'slickity-slick' ), '1.8.0' );

    // @TODO - Find a better way to load scripts only if a slideshow is present on the page.
    wp_enqueue_script( 'slickity-slick' );
    wp_enqueue_style( 'slickity-slick' );
    wp_enqueue_style( 'slickity-theme' );
  }
}
add_action( 'wp_enqueue_scripts', 'slickity_scripts' );

if ( !function_exists( 'slickity_shortcode_init' ) ) {
  function slickity_shortcode_init() {
    function slickity_shortcode( $atts = [], $content = null ) {
      $attr = shortcode_atts( array(
        'id' => false, // Post ID
      ), $atts );

      // Check if post ID supplied
      if ( $attr['id'] ) {
        $query = new WP_Query( array(
          'post_type' => 'slickity_slideshow',
          'p'         => $attr['id'],
        ));

        if ( $query->have_posts() ) {
          ob_start();
          while ( $query->have_posts() ):
            $query->the_post();

            // Get the slides
            $slides = get_field( 'slickity_slides' );

            if ( $slides ):
              // Get slideshow settings
              $settings = get_field( 'slickity_main_settings' );

              // Get thumbnail settings
              $thumbnail_settings = false;
              if ( get_field( 'slickity_thumbnail' ) ) {
                $thumbnail_settings = get_field( 'slickity_thumbnail_settings' );
              }
              ?>
              <div class="slickity <?php echo $settings['css']; ?>" id="slickity-<?php the_ID(); ?>">
                <?php foreach( $slides as $key => $slide ): ?>
                  <div class="slickity-slide <?php echo $slide['css']; ?>" id="slickity-slide-<?php echo $key; ?>">
                    <?php echo $slide['slide_content']; ?>
                  </div>
                <?php endforeach; ?>
              </div>

              <?php if ( $thumbnail_settings ): ?>
                <div class="slickity slickity--thumbnail <?php echo $thumbnail_settings['css']; ?>" id="slickity-thumbnail-<?php the_ID(); ?>">
                  <?php foreach( $slides as $key => $slide ): ?>

                    <?php if ( $slide['thumbnail_content'] ): ?>
                      <div class="slickity-slide <?php echo $slide['thumbnail_css']; ?>" id="slickity-thumbnail-slide-<?php echo $key; ?>">
                        <?php echo apply_filters( 'the_content', $slide['thumbnail_content'] ); ?>
                      </div>
                    <?php else: ?>
                      <div class="slickity-slide <?php echo $slide['css']; ?>" id="slickity-thumbnail-slide-<?php echo $key; ?>">
                        <?php echo apply_filters( 'the_content', $slide['slide_content'] ); ?>
                      </div>
                    <?php endif; ?>

                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
              <script>
                jQuery(function( $ ) {
                  $( '#slickity-<?php the_ID(); ?>' ).slick({
                    <?php if ( $thumbnail_settings ): ?>
                      asNavFor: '#slickity-thumbnail-<?php the_ID(); ?>',
                    <?php endif; ?>

                    <?php if (
                      isset( $settings['responsive'] ) &&
                      isset( $settings['responsive_options'] ) &&
                      is_array( $settings['responsive_options'] ) &&
                      count( $settings['responsive_options'] )
                    ): ?>
                    responsive: [
                      <?php foreach( $settings['responsive_options'] as $key => $ary ): ?>
                      {
                        breakpoint: <?php echo $ary['breakpoint']; ?>,
                        settings: {
                          <?php echo slickity_process_js_settings( slickity_process_responsive_js_settings( $ary['settings'] ) ); ?>
                        }
                      }
                      <?php endforeach; ?>
                    ],
                    <?php endif; ?>
                    <?php echo slickity_process_js_settings( $settings ); ?>
                  });

                  <?php if ( $thumbnail_settings ): ?>
                    $( '#slickity-thumbnail-<?php the_ID(); ?>' ).slick({
                      asNavFor: '#slickity-<?php the_ID(); ?>',
                      <?php echo slickity_process_js_settings( $thumbnail_settings ); ?>
                    });
                  <?php endif; ?>
                });
              </script>
              <?php
            endif;
          endwhile;

          // Restore original post data
          wp_reset_postdata();

          return ob_get_clean();
        }
      }
    }
    add_shortcode( 'slickity', 'slickity_shortcode' );
  }
}
add_action( 'init', 'slickity_shortcode_init' );

/**
 * Convert responsive settings array.
 */
if ( !function_exists( 'slickity_process_responsive_js_settings' ) ) {
  function slickity_process_responsive_js_settings( $settings ) {
    $array = array();

    foreach( $settings as $key => $ary ) {
      $array[ $ary['setting'] ] = $ary['value'];
    }

    return $array;
  }
}

/**
 * Processes slick settings array.
 * @TODO - Create helder function to create individual settings.
 */
if ( !function_exists( 'slickity_process_js_settings' ) ) {
  function slickity_process_js_settings( $settings ) {
    $output = false;

    // Convert additional settings
    if (
      isset( $settings['additional_settings'] ) &&
      is_array( $settings['additional_settings'] ) &&
      count( $settings['additional_settings'] )
    ) {
      foreach( $settings['additional_settings'] as $num => $ary ) {
        $settings[ $ary['setting'] ] = $ary['value'];
      }
    }

    // accessibility
    if ( isset( $settings['accessibility'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['accessibility'] ) {
        $output .= 'accessibility: true';
      } else {
        $output .= 'accessibility: false';
      }
    }

    // adaptiveHeight
    if ( isset( $settings['adaptiveHeight'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['adaptiveHeight'] ) {
        $output .= 'adaptiveHeight: true';
      } else {
        $output .= 'adaptiveHeight: false';
      }
    }

    // autoplay
    if ( isset( $settings['autoplay'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['autoplay'] ) {
        $output .= 'autoplay: true';
      } else {
        $output .= 'autoplay: false';
      }
    }

    // autoplay
    if ( isset( $settings['autoplaySpeed'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= 'autoplaySpeed: ' . $settings['autoplaySpeed'];
    }

    // arrows
    if ( isset( $settings['arrows'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['arrows'] ) {
        $output .= 'arrows: true';
      } else {
        $output .= 'arrows: false';
      }
    }

    // appendArrows
    if ( isset( $settings['appendArrows'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= 'appendArrows: ' . $settings['appendArrows'];
    }

    // appendDots
    if ( isset( $settings['appendDots'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= 'appendDots: ' . $settings['appendDots'];
    }

    // prevArrow
    if ( isset( $settings['prevArrow'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "prevArrow: '" . $settings['prevArrow'] . "'";
    }

    // nextArrow
    if ( isset( $settings['nextArrow'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "nextArrow: '" . $settings['nextArrow'] . "'";
    }

    // centerMode
    if ( isset( $settings['centerMode'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['centerMode'] ) {
        $output .= 'centerMode: true';
      } else {
        $output .= 'centerMode: false';
      }
    }

    // centerPadding
    if ( isset( $settings['centerPadding'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "centerPadding: '" . $settings['centerPadding'] . "'";
    }

    // cssEase
    if ( isset( $settings['cssEase'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "cssEase: '" . $settings['cssEase'] . "'";
    }

    // customPaging
    if ( isset( $settings['customPaging'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "customPaging: " . $settings['customPaging'];
    }

    // dots
    if ( isset( $settings['dots'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['dots'] ) {
        $output .= 'dots: true';
      } else {
        $output .= 'dots: false';
      }
    }

    // dotsClass
    if ( isset( $settings['dotsClass'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "dotsClass: '" . $settings['dotsClass'] . "'";
    }

    // draggable
    if ( isset( $settings['draggable'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['draggable'] ) {
        $output .= 'draggable: true';
      } else {
        $output .= 'draggable: false';
      }
    }

    // fade
    if ( isset( $settings['fade'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['fade'] ) {
        $output .= 'fade: true';
      } else {
        $output .= 'fade: false';
      }
    }

    // focusOnSelect
    if ( isset( $settings['focusOnSelect'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['focusOnSelect'] ) {
        $output .= 'focusOnSelect: true';
      } else {
        $output .= 'focusOnSelect: false';
      }
    }

    // easing
    if ( isset( $settings['easing'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "easing: '" . $settings['easing'] . "'";
    }

    // edgeFriction
    if ( isset( $settings['edgeFriction'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "edgeFriction: " . $settings['edgeFriction'];
    }

    // infinite
    if ( isset( $settings['infinite'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['infinite'] ) {
        $output .= 'infinite: true';
      } else {
        $output .= 'infinite: false';
      }
    }

    // initialSlide
    if ( isset( $settings['initialSlide'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "initialSlide: " . $settings['initialSlide'];
    }

    // lazyLoad
    if ( isset( $settings['lazyLoad'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "lazyLoad: '" . $settings['lazyLoad'] . "'";
    }

    // mobileFirst
    if ( isset( $settings['mobileFirst'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['mobileFirst'] ) {
        $output .= 'mobileFirst: true';
      } else {
        $output .= 'mobileFirst: false';
      }
    }

    // pauseOnFocus
    if ( isset( $settings['pauseOnFocus'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['pauseOnFocus'] ) {
        $output .= 'pauseOnFocus: true';
      } else {
        $output .= 'pauseOnFocus: false';
      }
    }

    // pauseOnHover
    if ( isset( $settings['pauseOnHover'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['pauseOnHover'] ) {
        $output .= 'pauseOnHover: true';
      } else {
        $output .= 'pauseOnHover: false';
      }
    }

    // pauseOnDotsHover
    if ( isset( $settings['pauseOnDotsHover'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['pauseOnDotsHover'] ) {
        $output .= 'pauseOnDotsHover: true';
      } else {
        $output .= 'pauseOnDotsHover: false';
      }
    }

    // respondTo
    if ( isset( $settings['respondTo'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "respondTo: '" . $settings['respondTo'] . "'";
    }

    // rows
    if ( isset( $settings['rows'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "rows: " . $settings['rows'];
    }

    // slide
    if ( isset( $settings['slide'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "slide: '" . $settings['slide'] . "'";
    }

    // slidesPerRow
    if ( isset( $settings['slidesPerRow'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "slidesPerRow: " . $settings['slidesPerRow'];
    }

    // slidesToShow
    if ( isset( $settings['slidesToShow'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "slidesToShow: " . $settings['slidesToShow'];
    }

    // slidesToScroll
    if ( isset( $settings['slidesToScroll'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "slidesToScroll: " . $settings['slidesToScroll'];
    }

    // speed
    if ( isset( $settings['speed'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "speed: " . $settings['speed'];
    }

    // swipe
    if ( isset( $settings['swipe'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['swipe'] ) {
        $output .= 'swipe: true';
      } else {
        $output .= 'swipe: false';
      }
    }

    // swipeToSlide
    if ( isset( $settings['swipeToSlide'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['swipeToSlide'] ) {
        $output .= 'swipeToSlide: true';
      } else {
        $output .= 'swipeToSlide: false';
      }
    }

    // touchMove
    if ( isset( $settings['touchMove'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['touchMove'] ) {
        $output .= 'touchMove: true';
      } else {
        $output .= 'touchMove: false';
      }
    }

    // touchThreshold
    if ( isset( $settings['touchThreshold'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "touchThreshold: " . $settings['touchThreshold'];
    }

    // useCSS
    if ( isset( $settings['useCSS'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['useCSS'] ) {
        $output .= 'useCSS: true';
      } else {
        $output .= 'useCSS: false';
      }
    }

    // useTransform
    if ( isset( $settings['useTransform'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['useTransform'] ) {
        $output .= 'useTransform: true';
      } else {
        $output .= 'useTransform: false';
      }
    }

    // variableWidth
    if ( isset( $settings['variableWidth'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['variableWidth'] ) {
        $output .= 'variableWidth: true';
      } else {
        $output .= 'variableWidth: false';
      }
    }

    // vertical
    if ( isset( $settings['vertical'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['vertical'] ) {
        $output .= 'vertical: true';
      } else {
        $output .= 'vertical: false';
      }
    }

    // verticalSwiping
    if ( isset( $settings['verticalSwiping'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['verticalSwiping'] ) {
        $output .= 'verticalSwiping: true';
      } else {
        $output .= 'verticalSwiping: false';
      }
    }

    // rtl
    if ( isset( $settings['rtl'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['rtl'] ) {
        $output .= 'rtl: true';
      } else {
        $output .= 'rtl: false';
      }
    }

    // waitForAnimate
    if ( isset( $settings['waitForAnimate'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      if ( $settings['waitForAnimate'] ) {
        $output .= 'waitForAnimate: true';
      } else {
        $output .= 'waitForAnimate: false';
      }
    }

    // zIndex
    if ( isset( $settings['zIndex'] ) ) {
      if ( $output ) {
        $output .= ',';
      }

      $output .= "zIndex: " . $settings['zIndex'];
    }

    return $output;
  }
}
