jQuery( function()
{

  var targets = jQuery( '.keyword-to-tooltip-lite' ),
      target  = false,
      tooltip = false,
      title   = false,
      tip     = false;

  targets.bind( 'mouseenter', function() {
    if(target != false) {
      if(!jQuery(this).is(target)) {
        tooltip.remove();
      } else {
        target.addClass('hover');
        return;
      }
    }

    jQuery('#tooltip').remove();

    target  = jQuery( this );
    tip     = target.find( '> .tip').html();
    tooltip = jQuery( '<div id="tooltip" class="' + jQuery(this).attr('data-skin') + ' animated ' + jQuery(this).attr('data-animation') + '"></div>' );

    if( !tip || tip == "" )
      return;

    target.addClass('hover');

    tooltip.css( 'opacity', 0 )
           .html( tip )
           .appendTo( 'body' );

    var init_tooltip = function()
    {
      if( jQuery( window ).width() < tooltip.outerWidth() * 1.5 )
        tooltip.css( 'max-width', jQuery( window ).width() / 2 );
      else
        tooltip.css( 'max-width', 340 );

      var pos_left = target.offset().left + ( target.outerWidth() / 2 ) - ( tooltip.outerWidth() / 2 ),
          pos_top  = target.offset().top - tooltip.outerHeight() - 20;

      if( pos_left < 0 )
      {
        pos_left = target.offset().left + target.outerWidth() / 2 - 20;
        tooltip.addClass( 'left' );
      }
      else
        tooltip.removeClass( 'left' );

      if( pos_left + tooltip.outerWidth() > jQuery( window ).width() )
      {
        pos_left = target.offset().left - tooltip.outerWidth() + target.outerWidth() / 2 + 20;
        tooltip.addClass( 'right' );
      }
      else
        tooltip.removeClass( 'right' );

      if( pos_top < 0 )
      {
        var pos_top  = target.offset().top + target.outerHeight();
        tooltip.addClass( 'top' );
      }
      else
        tooltip.removeClass( 'top' );

      tooltip.css( { left: pos_left, top: pos_top, visibility : "visible"} );

      if(target.attr('data-animation') == '' || target.attr('data-animation') == 'None(Default)') {
        tooltip.animate( { top: '+=10', opacity: 1 }, 50 );
      } else {
        tooltip.css({top : pos_top + 10, opacity:1});
      }
    };

    init_tooltip();

    jQuery( window ).resize( init_tooltip );

    var remove_tooltip = function() {
      tooltip.animate( { top: '-=10', opacity: 0 }, 50, function()
      {
        jQuery( this ).remove();
        tooltip = false;
        target  = false;
        title   = false;
        tip     = false;
      });
    };

    var removeTooltipAfterCheck = function() {
      if(target.hasClass('hover') || tooltip.hasClass('hover')) {
        // do Nothing
      } else {
        remove_tooltip();
      }
    };


    target.bind( 'mouseleave', function(){
      jQuery(this).removeClass('hover');

      setTimeout(removeTooltipAfterCheck, 100);
    });

    tooltip.bind('mouseenter', function(){
      jQuery(this).addClass('hover');
    });

    tooltip.bind('mouseleave', function(){
      jQuery(this).removeClass('hover');

      setTimeout(removeTooltipAfterCheck, 100);
    });

    tooltip.bind( 'click', remove_tooltip );
  });
});