( function( $ ) {
  // Lightbox functionality
  $( '.slickity-lightbox' ).each( function() {
    var id = $( this ).attr( 'id' );
    id = id.replace( 'slickity-', '' );

    $( '.slickity-slide', $( '#slickity-' + id ) ).click( function() {
      $( '#slickity-lightbox-gallery-' + id ).toggleClass( 'slickity-lightbox-gallery--active' );
    });
  });

  $( '.slickity-lightbox-gallery' ).click( function() {
    $( this ).removeClass( 'slickity-lightbox-gallery--active' );
  });

  $( '.slickity-lightbox-gallery .slickity' ).click( function( e ) {
    e.stopPropagation();
  });
})( jQuery );
