<?php
/**
 * Shortcodes
 *
 * @package Slickity
 * @version 1.0.0
 */

// [slickity id="1"]
function slickity_slideshow_shortcode( $atts )
{
    $a = shortcode_atts( array(
        'id' => false, // Post ID
    ), $atts );

    // Check if post ID supplied
    if ( $a['id'] )
    {
      $query = new WP_Query( array(
        'post_type' => 'slickity-slideshow',
        'p'         => $a['id'],
      ) );

      if ( $query->have_posts() )
      {
        ob_start();
        while ( $query->have_posts() )
        {
          $query->the_post();

          // Get slides.
          $slides = get_field( 'slickity_slides' );

          if ( $slides )
          {
            // Enqueue CSS & JS
            wp_enqueue_style( 'slickity-slick' );
            wp_enqueue_style( 'slickity-style' );
            wp_enqueue_script( 'slickity-slick' );
            ?>
            <div class="slickity" id="slickity-<?php echo the_ID(); ?>">
              <?php
              foreach( $slides as $key => $ary )
              {
                $display = true;

                // Check if schedule enabled
                if ( $ary['slickity_enable_schedule'] )
                {
                  $display = false;

                  $today = new DateTime();

                  // Date range
                  if ( $ary['slickity_show_slide_yearly'] )
                  {
                    // Yearly
                    $start = new DateTime( date( 'Y-' ) . date( 'm-d G:i:s', strtotime( $ary['slickity_start_date'] ) ) );
                    $stop  = new DateTime( date( 'Y-' ) . date( 'm-d G:i:s', strtotime( $ary['slickity_slide_stop_date'] ) ) );
                  }
                  else
                  {
                    // Once
                    $start = new DateTime( $ary['slickity_start_date'] );
                    $stop  = new DateTime( $ary['slickity_slide_stop_date'] );
                  }

                  if (
                    $today->getTimestamp() > $start->getTimestamp() &&
                    $today->getTimestamp() < $stop->getTimestamp()
                  ) {
                    $display = true;
                  }
                }

                if ( $display )
                {
                  $style = '';
                  $class = '';

                  if( $ary['slickity_style'] )
                  {
                    if ( $ary['slickity_style'] === 'custom-css' && $ary['slickity_custom_css'] )
                    {
                      // Custom CSS
                      wp_add_inline_style( 'slickity-style', $ary['slickity_custom_css'] );
                    }
                    else
                    {
                      // Predefined style
                      $class = ' slickity__slide--' . $ary['slickity_style'];
                      wp_enqueue_style( 'slickity-' . $ary['slickity_style'], plugin_dir_url( SLICKITY ) . 'css/' . $ary['slickity_style'] . '.css' );
                    }
                  }

                  // If has slide content & image, use image as background.
                  if ( $ary['slickity_slide_content'] && $ary['slickity_slide_image'] ) {
                    $style = ' style="background-image: url(\'' . $ary['slickity_slide_image']['url'] . '\');"';
                  }
                  ?>
                  <div class="slickity__slide<?php echo $class; ?>" id="slickity-slide-<?php echo $key; ?>"<?php echo $style; ?>>
                    <?php
                    // If has no content, but an image, use as an image slide.
                    if ( ! $ary['slickity_slide_content'] && $ary['slickity_slide_image'] )
                    {
                      ?>
                        <img src="<?php echo esc_url( $ary['slickity_slide_image']['url'] ); ?>" alt="<?php echo esc_attr( $ary['slickity_slide_image']['title'] ); ?>" width="<?php echo esc_attr( $ary['slickity_slide_image']['width'] ); ?>" height="<?php echo esc_attr( $ary['slickity_slide_image']['height'] ); ?>">
                      <?
                    }
                    // If has slide content.
                    elseif ( $ary['slickity_slide_content'] )
                    {
                      // Apply content filters
                      $content = apply_filters( 'slickity_content_filter', $ary['slickity_slide_content'] );
                      ?>
                      <div class="slickity__slide-content">
                        <?php echo $content; ?>
                      </div>
                      <?php
                    }
                    ?>
                  </div>
                <?php } ?>
              <?php } ?>
            </div>
            <script>
            ( function( $ ) {
              $(function() {
                $( '#slickity-<?php echo $a['id']; ?>' ).slick({
                  <?php if ( get_field( 'slickity_accessibility' ) ) { ?>
                    accessibility: true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_adaptive_height' ) ) { ?>
                    adaptiveHeight: true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_autoplay' ) ) { ?>
                    autoplay: true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_autoplay_speed' ) ) { ?>
                    autoplaySpeed:  <?php echo get_field( 'slickity_autoplay_speed' ); ?>,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_arrows' ) ) { ?>
                    arrows: true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_as_nav_for' ) ) { ?>
                    asNavFor: '<?php echo get_field( 'slickity_as_nav_for' ); ?>',
                  <?php } ?>
                  <?php if ( get_field( 'slickity_append_arrows' ) ) { ?>
                    appendArrows: '<?php echo get_field( 'slickity_append_arrows' ); ?>',
                  <?php } ?>
                  <?php if ( get_field( 'slickity_append_dots' ) ) { ?>
                    appendDots: '<?php echo get_field( 'slickity_append_dots' ); ?>',
                  <?php } ?>
                  <?php if ( get_field( 'slickity_previous_arrow' ) ) { ?>
                    prevArrow: '<?php echo get_field( 'slickity_previous_arrow' ); ?>',
                  <?php } ?>
                  <?php if ( get_field( 'slickity_next_arrow' ) ) { ?>
                    nextArrow: '<?php echo get_field( 'slickity_next_arrow' ); ?>',
                  <?php } ?>
                  <?php if ( get_field( 'slickity_center_mode' ) ) { ?>
                    centerMode: true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_center_padding' ) ) { ?>
                    centerPadding: '<?php echo get_field( 'slickity_center_padding' ); ?>',
                  <?php } ?>
                  <?php if ( get_field( 'slickity_css_ease' ) ) { ?>
                    cssEase: '<?php echo get_field( 'slickity_css_ease' ); ?>',
                  <?php } ?>
                  <?php if ( get_field( 'slickity_dots' ) ) { ?>
                    dots: true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_dots_class' ) ) { ?>
                    dotsClass: '<?php echo get_field( 'slickity_dots_class' ); ?>',
                  <?php } ?>
                  <?php if ( get_field( 'slickity_draggable' ) ) { ?>
                    draggable: true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_fade' ) ) { ?>
                    fade: true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_focus_on_select' ) ) { ?>
                    focusOnSelect: true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_easing' ) ) { ?>
                    easing: '<?php echo get_field( 'slickity_easing' ); ?>',
                  <?php } ?>
                  <?php if ( get_field( 'slickity_edge_friction' ) ) { ?>
                    edgeFriction: <?php echo get_field( 'slickity_edge_friction' ); ?>,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_infinite' ) ) { ?>
                    infinite: true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_lazy_load' ) ) { ?>
                    lazyLoad: '<?php echo get_field( 'slickity_lazy_load' ); ?>',
                  <?php } ?>
                  <?php if ( get_field( 'slickity_mobile_first' ) ) { ?>
                    mobileFirst: true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_pause_on_focus' ) ) { ?>
                    pauseOnFocus: true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_pause_on_hover' ) ) { ?>
                    pauseOnHover: true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_pause_on_dots_hover' ) ) { ?>
                    pauseOnDotsHover: true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_respond_to' ) ) { ?>
                    respondTo: '<?php echo get_field( 'slickity_respond_to' ); ?>',
                  <?php } ?>
                  <?php if ( get_field( 'slickity_rows' ) ) { ?>
                    rows:  <?php echo get_field( 'slickity_rows' ); ?>,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_slides_per_row' ) ) { ?>
                    slidesPerRow:  <?php echo get_field( 'slickity_slides_per_row' ); ?>,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_slides_to_show' ) ) { ?>
                    slidesToShow:  <?php echo get_field( 'slickity_slides_to_show' ); ?>,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_slides_to_scroll' ) ) { ?>
                    slidesToScroll:  <?php echo get_field( 'slickity_slides_to_scroll' ); ?>,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_speed' ) ) { ?>
                    speed:  <?php echo get_field( 'slickity_speed' ); ?>,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_swipe' ) ) { ?>
                    swipe:  true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_swipe_to_slide' ) ) { ?>
                    swipeToSlide:  true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_touch_move' ) ) { ?>
                    touchMove:  true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_touch_threshold' ) ) { ?>
                    touchThreshold:  <?php echo get_field( 'slickity_touch_threshold' ); ?>,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_use_css' ) ) { ?>
                    useCSS:  true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_use_transform' ) ) { ?>
                    useTransform:  true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_variable_width' ) ) { ?>
                    variableWidth:  true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_vertical' ) ) { ?>
                    vertical:  true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_vertical_swiping' ) ) { ?>
                    verticalSwiping:  true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_right-to-left' ) ) { ?>
                    rtl:  true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_wait_for_animate' ) ) { ?>
                    waitForAnimate:  true,
                  <?php } ?>
                  <?php if ( get_field( 'slickity_z-index' ) ) { ?>
                    zIndex:  <?php echo get_field( 'slickity_z-index' ); ?>,
                  <?php } ?>
                });
              });
            })( jQuery );
            </script>
          <?
          }
        }
        /* Restore original Post Data */
        wp_reset_postdata();

        return ob_get_clean();
      }
    }
}
add_shortcode( 'slickity', 'slickity_slideshow_shortcode' );

// [year]
function slickity_slideshow_year_shortcode()
{
  return date( 'Y' );
}
add_shortcode( 'slickity_year', 'slickity_slideshow_year_shortcode' );