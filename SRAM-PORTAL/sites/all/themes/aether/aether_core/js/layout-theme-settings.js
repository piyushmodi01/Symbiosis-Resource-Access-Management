$ = jQuery.noConflict();
/*
 * Simple bit of JS to make the form easier to use
 */
$(function() {

  $('#edit-layout-options-1').click(function() {
    if ($(this).attr('checked')) {
      $("#edit-layout.ui-tabs .ui-tabs-nav li:not(:first-child), .form-item-layout-options-query1").fadeIn();
    } else {
      $("#edit-layout.ui-tabs .ui-tabs-nav li:not(:first-child), .form-item-layout-options-query1").fadeOut();
    }
  });

  $('#edit-layout-options-2').click(function() {
    if ($(this).attr('checked')) {
      $('div[class^="form-item form-type-select form-item-nav-link-width"]').fadeIn();
    } else {
      $('div[class^="form-item form-type-select form-item-nav-link-width"]').fadeOut();
    }
  });

  $('#edit-layout fieldset').click(function() {
    if ($(this).find('input.form-radio[value=9]').attr('checked')) {
      $(this).parent().parent().find('fieldset[class^="sidebar-layouts"]').fadeOut();
    }
    if ($(this).find('input.form-radio[value=8]').attr('checked')) {
      $(this).parent().parent().find('fieldset[class^="sidebar-layouts"]').fadeIn();
      $(this).parent().parent().find('div[class^="form-item form-type-select form-item-sidebar-second"]').fadeOut();
    }
    if ($(this).find('input.form-radio[value=7]').attr('checked')) {
      $(this).parent().parent().find('fieldset[class^="sidebar-layouts"]').fadeIn();
      $(this).parent().parent().find('div[class^="form-item form-type-select form-item-sidebar-second"]').fadeOut();
    }
    if ($(this).find('input.form-radio[value=6]').attr('checked')) {
      $(this).parent().parent().find('fieldset[class^="sidebar-layouts"]').fadeIn();
      $(this).parent().parent().find('div[class^="form-item form-type-select form-item-sidebar-second"]').fadeOut();
    }
    if ($(this).find('input.form-radio[value=5]').attr('checked')) {
      $(this).parent().parent().find('fieldset[class^="sidebar-layouts"]').fadeIn();
      $(this).parent().parent().find('div[class^="form-item form-type-select form-item-sidebar-second"]').fadeOut();
    }
    if ($(this).find('input.form-radio[value=4]').attr('checked')) {
      $(this).parent().parent().find('fieldset[class^="sidebar-layouts"]').fadeIn();
      $(this).parent().parent().find('div[class^="form-item form-type-select form-item-sidebar-second"]').fadeOut();
    }
    if ($(this).find('input.form-radio[value|=3]').attr('checked')) {
      $(this).parent().parent().find('fieldset[class^="sidebar-layouts"]').fadeIn();
      $(this).parent().parent().find('div[class^="form-item form-type-select form-item-sidebar-second"]').fadeIn();
    }
    if ($(this).find('input.form-radio[value|=2]').attr('checked')) {
      $(this).parent().parent().find('fieldset[class^="sidebar-layouts"]').fadeIn();
      $(this).parent().parent().find('div[class^="form-item form-type-select form-item-sidebar-second"]').fadeIn();
    }
    if ($(this).find('input.form-radio[value|=1]').attr('checked')) {
      $(this).parent().parent().find('fieldset[class^="sidebar-layouts"]').fadeIn();
      $(this).parent().parent().find('div[class^="form-item form-type-select form-item-sidebar-second"]').fadeIn();
    }
  });

});
