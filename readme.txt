=== Slickity ===
Contributors: bmarshall511
Tags: slick, slickjs, slick-slider, slick-plugin, slider, slider-plugin, sliders, slideshow, slideshows, slideshow-gallery, slideshow-maker, carousel, carousel-plugin
Requires at least: 4.7
Tested up to: 4.9.1
Stable tag: 2.0.0
License: GPLv2 or later

Slickity is the last WordPress carousel plugin you'll ever need! Easily add fully customizable carousels and sliders to your theme using a simple shortcode. Fully responsive and loaded with a ton of customizable features.

== Description ==

Slickity is **the last WordPress carousel plugin you'll ever need**. Easily add carousels and sliders to your theme using a simple shortcode. Fully responsive and loaded with a ton of customizable features like lazy loading, navigation, theming and more.

Major features in Slickity include:

* Uses Key Wheeler's hugely popular [slick](http://kenwheeler.github.io/slick/) library
* Fully responsive &mdash; scales with its container
* Separate settings per breakpoint
* Uses CSS3 when available, fully functional when not
* Swipe enabled &mdash; or disabled, if you prefer
* Desktop mouse dragging
* Infinite looping
* Fully accessible with arrow key navigation
* Autoplay, dots, arrows, callbacks, etc...

Use <code>[slickity id="1"]</code> to display slideshows in posts, pages and widgets; <code>id</code> being the ID of the slideshow.

== Installation ==

1. Upload the `slickity` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= I wanna contribute, but can't get my Advanced Custom Fields to take. =
You can disable the core Advanced Custom Fields configuration by adding `define( 'SLICKITY_DEV', true );` in your `wp-config.php` file. Then you'll need to import the config into your database by using the .json file in the plugin's includes folder.

== Changelog ==

= 2.0.0 (December 6, 2017) =
* A complete rewrite with more options!
