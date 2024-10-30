jQuery(document).ready(function(){
  var container = jQuery('#keyword_to_tooltip-container');

  container.find('.colorpicker').not('.triggered').addClass('triggered').wpColorPicker();

  container.find('a.close-edit').bind('click', function(event){
    event.preventDefault();

    jQuery('#ap-edit-' + jQuery(this).attr('entry-id')).hide();
    jQuery('#ap-information-' + jQuery(this).attr('entry-id')).fadeIn('slow');
  });

  container.find('a.open-edit').bind('click', function(event){
    event.preventDefault();

    jQuery('#ap-edit-' + jQuery(this).attr('entry-id')).fadeIn('slow', function(){
      jQuery(this).find('.colorpicker-smart').not('.triggered').addClass('triggered').wpColorPicker();
    });

    jQuery('#ap-information-' + jQuery(this).attr('entry-id')).hide();
  });

});