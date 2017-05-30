<?php
/**
 * @file
 * Contains theme override functions for Theme Settings.
 */

/**
 * Implements hook_form_system_theme_settings_alter().
 *
 * @param $form
 *   Nested array of form elements that comprise the form.
 * @param $form_state
 *   A keyed array containing the current state of the form.
 */
function aether_form_system_theme_settings_alter(&$form, $form_state) {

  // Collapse fieldsets
  $form_elements = element_children($form);
  foreach ($form_elements as $element) {
    if ($form[$element]['#type'] == 'fieldset') { //Identify fieldsets and collapse them
      $form[$element]['#collapsible'] = TRUE;
      $form[$element]['#collapsed']   = TRUE;
    }
  }

  global $base_path;
  $theme_name = $GLOBALS['theme_key'];

  // Get default theme settings from .info file.
  // get data for all themes.
  $theme_data = list_themes();
  $defaults = ($theme_name && isset($theme_data[$theme_name]->info['settings'])) ? $theme_data[$theme_name]->info['settings'] : array();

  $subject_theme = arg(count(arg()) - 1);
  $aether_theme_path = drupal_get_path('theme', 'aether') . '/';
  $theme_path = drupal_get_path('theme', $subject_theme) . '/';

  drupal_add_library('system', 'ui.tabs');
  drupal_add_js('jQuery(function () {jQuery("#edit-layout").fieldset_tabs();});', 'inline');
  drupal_add_js($aether_theme_path . "js/jquery.autotabs.js", 'file');
  drupal_add_js($aether_theme_path . "js/layout-theme-settings.js", 'file');
  drupal_add_css('themes/seven/vertical-tabs.css', array('group' => CSS_THEME, 'weight' => 9));
  drupal_add_css('themes/seven/jquery.ui.theme.css', array('group' => CSS_THEME, 'weight' => 9));
  drupal_add_css($aether_theme_path . 'css/layout/layout-theme-settings.css', array('group' => CSS_THEME, 'weight' => 10));

  $header  = '<div class="themesettings-header">';
  $header .= '<h3>' . drupal_ucfirst($theme_name) . ' ' . t('Configuration') . '</h3>';
  $header .= '</div>';

  $form['aether_settings'] = array(
    '#type' => 'vertical_tabs',
    '#weight' => 0,
    '#prefix' => $header,
  );

if (theme_get_setting('show_layout') == 1) {

  $form['aether_settings']['layout'] = array(
    '#title' => t('Aether Layout'),
    '#type' => 'fieldset',
  );

  $form['aether_settings']['layout']['layout_options'] = array(
    '#type'          => 'checkboxes',
    '#title'         => t('Layout Options'),
    '#default_value' => theme_get_setting('layout_options'),
    '#options'       => array(
      '1' => t("Enable additional device media queries that aid in making your design !responsive. If you wish to use a fixed width desktop layout, uncheck this option. WARNING: if you disable media queries, you will need to also disable the responsive meta and polyfills.", array('!responsive' => l(t('responsive'), 'http://www.alistapart.com/articles/responsive-web-design/'))),
      '2' => t("Enable the alignment of each main menu link to the current grid."),
    ),
    '#description'   => t('Enable or disable various grid and responsive layout options'),
  );

  if (in_array('1', theme_get_setting('layout_options'))) {
    $media = array();
    $media_queries = theme_get_setting('media_queries');
    if ($media_queries && is_numeric($media_queries)) {
      for ($i = 1; $i <= $media_queries; $i++) {
        $media[] = 'Media' . $i;
      }
    }
  }
  else {
    $media = array(t('Default'));
    $media_queries = 1;
  }

  for ($media_count = 1; $media_count <= $media_queries; $media_count++) {
    $medium = theme_get_setting('media_name' . $media_count);

    $form['aether_settings']['layout']["media" . $media_count] = array(
      '#title' => t('@media', array('@media' => $medium)),
      '#type' => 'fieldset',
      '#attributes' => array('class' => array('device-layouts')),
    );

    // Grid type.
    // Generate grid type options.
    $grid_options = array();
    if (isset($defaults["theme_grid_options" . $media_count])) {
      foreach ($defaults["theme_grid_options" . $media_count] as $grid_option) {
        $grid_type = t('grid') . ' [' . drupal_substr($grid_option, 7) . 'px]';
        $grid_options[$grid_option] = (int) drupal_substr($grid_option, 4, 2) . ' ' . t('column') . ' ' . $grid_type;
      }
    }
    $layout_title = drupal_substr(((theme_get_setting("theme_grid" . $media_count)) ? theme_get_setting("theme_grid" . $media_count) : theme_get_setting("theme_grid" . $media_count)), 7, 4);
    $form['aether_settings']['layout']["media" . $media_count]["theme_grid" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('Select a grid for this width'),
      '#default_value' => (theme_get_setting("theme_grid" . $media_count)) ? theme_get_setting("theme_grid" . $media_count) : theme_get_setting("theme_grid" . $media_count),
      '#options'       => $grid_options,
      '#prefix' => '<h2>' . t('@media', array('@media' => $medium)) . ' ' . decode_entities('&mdash;') . ' ' . $layout_title . 'px' . '</h2>',
    );
    $form['aether_settings']['layout']["media" . $media_count]["theme_grid" . $media_count]['#options'][$defaults["theme_grid" . $media_count]] .= ' ' . t('- Theme Default');

    // Sidebar layout.
    $form['aether_settings']['layout']["media" . $media_count]["sidebar_layout" . $media_count] = array(
      '#type'          => 'radios',
      '#attributes'    => array('class' => array('sidebar-layout')),
      '#title'         => t('Choose a @media sidebar layout', array('@media' => $medium)),
      '#default_value' => (theme_get_setting("sidebar_layout" . $media_count)) ? theme_get_setting("sidebar_layout" . $media_count) : theme_get_setting("sidebar_layout" . $media_count),
      '#suffix'        => '<label>' . t('Set column widths within rows') . '</label>',
      '#options'       => array(
        1 => t('Split sidebars'),
        2 => t('Both sidebars first'),
        3 => t('Both sidebars last'),
        4 => t('Sidebar1 left, sidebar2 bottom'),
        5 => t('Sidebar1 right, sidebar2 bottom'),
        6 => t('Sidebar1 left, sidebar2 under content'),
        7 => t('Sidebar1 right, sidebar2 under content'),
        8 => t('Sidebar1 and sidebar2 stacked right'),
        9 => t('Full width'),
      ),
    );

    $form['aether_settings']['layout']["media" . $media_count]["sidebar_layout" . $media_count]['#options'][$defaults["sidebar_layout" . $media_count]] .= ' ' . t('- Theme Default');

    // Calculate header width options.
    $gutter_width = (int) drupal_substr(theme_get_setting("gutter_width"), 0, 2);
    $grid_width = (int) drupal_substr(theme_get_setting("theme_grid" . $media_count), 4, 2);
    $grid_type = drupal_substr(theme_get_setting("theme_grid" . $media_count), 7);
    $grid_width_options = array();
    for ($i = 1; $i <= floor($grid_width); $i++) {
      $grid_units = $i . (($i == 1) ? ' ' . t('grid unit:') . ' ' : ' ' . t('grid units:') . ' ');
      $grid_width_options[$i] = $grid_units . ((($i * (((int) $grid_type - $gutter_width) / $grid_width)) - $gutter_width) . 'px');
    }

    $form['aether_settings']['layout']["media" . $media_count]['user'] = array(
      '#title' => t('user Row'),
      '#type' => 'fieldset',
      '#description' => t('Select the number of columns for each region in this row.'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
      '#attributes' => array('class' => array('user-layouts')),
    );

    // user group first width.
    $form['aether_settings']['layout']["media" . $media_count]['user']["user_first_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('user 1'),
      '#default_value' => (theme_get_setting("user_first" . $media_count)) ? theme_get_setting("user_first_width" . $media_count) : theme_get_setting("user_first_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['user']["user_first_width" . $media_count]['#options'][$defaults["user_first_width" . $media_count]] .= ' ' . t('- Theme Default');
    // user group second width.
    $form['aether_settings']['layout']["media" . $media_count]['user']["user_second_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('user 2'),
      '#default_value' => (theme_get_setting("user_second" . $media_count)) ? theme_get_setting("user_second_width" . $media_count) : theme_get_setting("user_second_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['user']["user_second_width" . $media_count]['#options'][$defaults["user_second_width" . $media_count]] .= ' ' . t('- Theme Default');

    $form['aether_settings']['layout']["media" . $media_count]['header'] = array(
      '#title' => t('Header Row'),
      '#type' => 'fieldset',
      '#description' => t('Select the number of columns for each region in this row.'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
      '#attributes' => array('class' => array('header-layouts')),
    );

    // Header group first width.
    $form['aether_settings']['layout']["media" . $media_count]['header']["header_first_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('Header 1'),
      '#default_value' => (theme_get_setting("header_first" . $media_count)) ? theme_get_setting("header_first_width" . $media_count) : theme_get_setting("header_first_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['header']["header_first_width" . $media_count]['#options'][$defaults["header_first_width" . $media_count]] .= ' ' . t('- Theme Default');
    // Header group second width.
    $form['aether_settings']['layout']["media" . $media_count]['header']["header_second_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('Header 2'),
      '#default_value' => (theme_get_setting("header_second" . $media_count)) ? theme_get_setting("header_second_width" . $media_count) : theme_get_setting("header_second_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['header']["header_second_width" . $media_count]['#options'][$defaults["header_second_width" . $media_count]] .= ' ' . t('- Theme Default');
    // Header group first width.
    $form['aether_settings']['layout']["media" . $media_count]['header']["header_third_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('Header 3'),
      '#default_value' => (theme_get_setting("header_third" . $media_count)) ? theme_get_setting("header_third_width" . $media_count) : theme_get_setting("header_third_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['header']["header_third_width" . $media_count]['#options'][$defaults["header_third_width" . $media_count]] .= ' ' . t('- Theme Default');

    // Calculate width options.
    $nav_width_options = array();
    for ($i = 1; $i <= floor($grid_width); $i++) {
      $grid_units = $i . (($i == 1) ? ' ' . t('grid unit:') . ' ' : ' ' . t('grid units:') . ' ');
      $nav_width_options[$i] = $grid_units . ((($i * (((int) $grid_type - $gutter_width) / $grid_width)) - $gutter_width) . 'px');
    }

    $form['aether_settings']['layout']["media" . $media_count]['navigation'] = array(
      '#title' => t('Navigation Row'),
      '#type' => 'fieldset',
      '#description' => t('Select the number of columns for each link and/or region.'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
      '#attributes' => array('class' => array('navigation-layouts')),
    );

    // Navigation link width.
    $form['aether_settings']['layout']["media" . $media_count]['navigation']["nav_link_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('Each Main Menu Link'),
      '#default_value' => (theme_get_setting("nav_link_width" . $media_count)) ? theme_get_setting("nav_link_width" . $media_count) : theme_get_setting("nav_link_width" . $media_count),
      '#options'       => $nav_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['navigation']["nav_link_width" . $media_count]['#options'][$defaults["nav_link_width" . $media_count]] .= ' ' . t('- Theme Default');

    // Navigation first width.
    $form['aether_settings']['layout']["media" . $media_count]['navigation']["navigation_first_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('navigation 1'),
      '#default_value' => (theme_get_setting("navigation_first" . $media_count)) ? theme_get_setting("navigation_first_width" . $media_count) : theme_get_setting("navigation_first_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['navigation']["navigation_first_width" . $media_count]['#options'][$defaults["navigation_first_width" . $media_count]] .= ' ' . t('- Theme Default');
    // Navigation second width.
    $form['aether_settings']['layout']["media" . $media_count]['navigation']["navigation_second_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('navigation 2'),
      '#default_value' => (theme_get_setting("navigation_second" . $media_count)) ? theme_get_setting("navigation_second_width" . $media_count) : theme_get_setting("navigation_second_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['navigation']["navigation_second_width" . $media_count]['#options'][$defaults["navigation_second_width" . $media_count]] .= ' ' . t('- Theme Default');

    // Calculate sidebar width options.
    $width_options = array();
    for ($i = 1; $i <= floor($grid_width / 2); $i++) {
      $grid_units = $i . (($i == 1) ? ' ' . t('grid unit:') . ' ' : ' ' . t('grid units:') . ' ');
      $width_options[$i] = $grid_units . ((($i * (((int) $grid_type - $gutter_width) / $grid_width)) - $gutter_width) . 'px');
    }

    $form['aether_settings']['layout']["media" . $media_count]['main'] = array(
      '#title' => t('Main Row'),
      '#type' => 'fieldset',
      '#description' => t('Select the number of columns for each sidebar in this row, the content area is automatically adjusted.'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
      '#attributes' => array('class' => array('main-layouts')),
    );

    $form['aether_settings']['layout']["media" . $media_count]['main']['preface'] = array(
      '#title' => t('Preface Row'),
      '#type' => 'fieldset',
      '#description' => t('Select the number of columns for each preface region in this row.'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
      '#attributes' => array('class' => array('preface-layouts')),
    );

    // Preface group first width.
    $form['aether_settings']['layout']["media" . $media_count]['main']['preface']["preface_first_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('preface 1'),
      '#default_value' => (theme_get_setting("preface_first" . $media_count)) ? theme_get_setting("preface_first_width" . $media_count) : theme_get_setting("preface_first_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['main']['preface']["preface_first_width" . $media_count]['#options'][$defaults["preface_first_width" . $media_count]] .= ' ' . t('- Theme Default');
    // Preface group second width.
    $form['aether_settings']['layout']["media" . $media_count]['main']['preface']["preface_second_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('preface 2'),
      '#default_value' => (theme_get_setting("preface_second" . $media_count)) ? theme_get_setting("preface_second_width" . $media_count) : theme_get_setting("preface_second_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['main']['preface']["preface_second_width" . $media_count]['#options'][$defaults["preface_second_width" . $media_count]] .= ' ' . t('- Theme Default');
    // Preface group third width.
    $form['aether_settings']['layout']["media" . $media_count]['main']['preface']["preface_third_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('preface 3'),
      '#default_value' => (theme_get_setting("preface_third" . $media_count)) ? theme_get_setting("preface_third_width" . $media_count) : theme_get_setting("preface_third_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['main']['preface']["preface_third_width" . $media_count]['#options'][$defaults["preface_third_width" . $media_count]] .= ' ' . t('- Theme Default');

    $form['aether_settings']['layout']["media" . $media_count]['main']['sidebar'] = array(
      '#title' => t('Sidebars'),
      '#type' => 'fieldset',
      '#description' => t('Select the number of columns for sidebar in this row, the content area is automatically adjusted.'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
      '#attributes' => array('class' => array('sidebar-layouts')),
    );

    // Sidebar first width.
    $form['aether_settings']['layout']["media" . $media_count]['main']['sidebar']["sidebar_first_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('Sidebar 1'),
      '#default_value' => (theme_get_setting("sidebar_first_width" . $media_count)) ? theme_get_setting("sidebar_first_width" . $media_count) : theme_get_setting("sidebar_first_width" . $media_count),
      '#options'       => $width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['main']['sidebar']["sidebar_first_width" . $media_count]['#options'][$defaults["sidebar_first_width" . $media_count]] .= ' ' . t('- Theme Default');
    // Sidebar last width.
    $form['aether_settings']['layout']["media" . $media_count]['main']['sidebar']["sidebar_second_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('Sidebar 2'),
      '#default_value' => (theme_get_setting("sidebar_second_width" . $media_count)) ? theme_get_setting("sidebar_second_width" . $media_count) : theme_get_setting("sidebar_second_width" . $media_count),
      '#options'       => $width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['main']['sidebar']["sidebar_second_width" . $media_count]['#options'][$defaults["sidebar_second_width" . $media_count]] .= ' ' . t('- Theme Default');

    $form['aether_settings']['layout']["media" . $media_count]['main']['postscript'] = array(
      '#title' => t('Postscript Row'),
      '#type' => 'fieldset',
      '#description' => t('Select the number of columns for the postscript regions in this row.'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
      '#attributes' => array('class' => array('postscript-layouts')),
    );

    // Postscript first column width.
    $form['aether_settings']['layout']["media" . $media_count]['main']['postscript']["postscript_first_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('Postscript 1'),
      '#default_value' => (theme_get_setting("postscript_first_width" . $media_count)) ? theme_get_setting("postscript_first_width" . $media_count) : theme_get_setting("postscript_first_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['main']['postscript']["postscript_first_width" . $media_count]['#options'][$defaults["postscript_first_width" . $media_count]] .= ' ' . t('- Theme Default');
    // Postscript second column width.
    $form['aether_settings']['layout']["media" . $media_count]['main']['postscript']["postscript_second_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('Postscript 2'),
      '#default_value' => (theme_get_setting("postscript_second_width" . $media_count)) ? theme_get_setting("postscript_second_width" . $media_count) : theme_get_setting("postscript_second_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['main']['postscript']["postscript_second_width" . $media_count]['#options'][$defaults["postscript_second_width" . $media_count]] .= ' ' . t('- Theme Default');
    // Postscript third column width.
    $form['aether_settings']['layout']["media" . $media_count]['main']['postscript']["postscript_third_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('Postscript 3'),
      '#default_value' => (theme_get_setting("postscript_third_width" . $media_count)) ? theme_get_setting("postscript_third_width" . $media_count) : theme_get_setting("postscript_third_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['main']['postscript']["postscript_third_width" . $media_count]['#options'][$defaults["postscript_third_width" . $media_count]] .= ' ' . t('- Theme Default');
    // Postscript fourth column width.
    $form['aether_settings']['layout']["media" . $media_count]['main']['postscript']["postscript_fourth_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('Postscript 4'),
      '#default_value' => (theme_get_setting("postscript_fourth_width" . $media_count)) ? theme_get_setting("postscript_fourth_width" . $media_count) : theme_get_setting("postscript_fourth_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['main']['postscript']["postscript_fourth_width" . $media_count]['#options'][$defaults["postscript_fourth_width" . $media_count]] .= ' ' . t('- Theme Default');

    $form['aether_settings']['layout']["media" . $media_count]['footer'] = array(
      '#title' => t('Footer Row'),
      '#type' => 'fieldset',
      '#description' => t('Select the number of columns for each region in this row.'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
      '#attributes' => array('class' => array('footer-layouts')),
    );

    // Footer first column width.
    $form['aether_settings']['layout']["media" . $media_count]['footer']["footer_first_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('Footer 1'),
      '#default_value' => (theme_get_setting("footer_first_width" . $media_count)) ? theme_get_setting("footer_first_width" . $media_count) : theme_get_setting("footer_first_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['footer']["footer_first_width" . $media_count]['#options'][$defaults["footer_first_width" . $media_count]] .= ' ' . t('- Theme Default');
    // Footer second column width.
    $form['aether_settings']['layout']["media" . $media_count]['footer']["footer_second_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('Footer 2'),
      '#default_value' => (theme_get_setting("footer_second_width" . $media_count)) ? theme_get_setting("footer_second_width" . $media_count) : theme_get_setting("footer_second_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['footer']["footer_second_width" . $media_count]['#options'][$defaults["footer_second_width" . $media_count]] .= ' ' . t('- Theme Default');
    // Footer third column width.
    $form['aether_settings']['layout']["media" . $media_count]['footer']["footer_third_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('Footer 3'),
      '#default_value' => (theme_get_setting("footer_third_width" . $media_count)) ? theme_get_setting("footer_third_width" . $media_count) : theme_get_setting("footer_third_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['footer']["footer_third_width" . $media_count]['#options'][$defaults["footer_third_width" . $media_count]] .= ' ' . t('- Theme Default');
    // Footer fourth column width.
    $form['aether_settings']['layout']["media" . $media_count]['footer']["footer_fourth_width" . $media_count] = array(
      '#type'          => 'select',
      '#title'         => t('Footer 4'),
      '#default_value' => (theme_get_setting("footer_fourth_width" . $media_count)) ? theme_get_setting("footer_fourth_width" . $media_count) : theme_get_setting("footer_fourth_width" . $media_count),
      '#options'       => $grid_width_options,
    );
    $form['aether_settings']['layout']["media" . $media_count]['footer']["footer_fourth_width" . $media_count]['#options'][$defaults["footer_fourth_width" . $media_count]] .= ' ' . t('- Theme Default');
  }
}

  $form['aether_settings']['polyfills'] = array(
    '#title' => t('Polyfills'),
    '#type' => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#weight' => 10,
  );
  $form['aether_settings']['polyfills']['aether_polyfills'] = array(
    '#type'          => 'checkboxes',
    '#title'         => t('Add HTML5 and responsive scripts and meta tags to every page.'),
    '#default_value' => theme_get_setting('aether_polyfills'),
    '#options'       => array(
      'html5' => t('Add HTML5 shim JavaScript to add support to IE 6-8.'),
      'respond' => t('Add Respond.js JavaScript to add basic CSS3 media query support to IE 6-8.'),
      'meta' => t('Add meta tags to support responsive design on mobile devices.'),
      'selectivizr' => t('Add pseudo class support to IE6-8.'),
      'imgsizer' => t('Add imgsizer fluid image support to IE6-8.'),
      'ios_orientation_fix' => t('Add fix for the iOS orientationchange zoom bug.'),
      'responsive_tables' => t('Adds js for responsive tables, use the class .responsive on a table to activate.'),
    ),
    '#description'   => t('IE 6-8 require a JavaScript polyfill solution to add basic support of HTML5 and CSS3 media queries. If you prefer to use another polyfill solution, such as <a href="!link">Modernizr</a>, you can disable these options. Mobile devices require a few meta tags for responsive designs.', array('!link' => 'http://www.modernizr.com/')),
  );
  $form['aether_settings']['drupal'] = array(
    '#title' => t('Drupal core options'),
    '#type' => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#weight' => 11,
  );
  $form['aether_settings']['drupal']['aether_breadcrumb'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Breadcrumb settings'),
    '#attributes'    => array('id' => 'aether-breadcrumb'),
  );
  $form['aether_settings']['drupal']['aether_breadcrumb']['aether_breadcrumb'] = array(
    '#type'          => 'select',
    '#title'         => t('Display breadcrumb'),
    '#default_value' => theme_get_setting('aether_breadcrumb'),
    '#options'       => array(
      'yes'   => t('Yes'),
      'admin' => t('Only in admin section'),
      'no'    => t('No'),
    ),
  );
  $form['aether_settings']['drupal']['aether_breadcrumb']['aether_breadcrumb_separator'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Breadcrumb separator'),
    '#description'   => t('Text only. Don’t forget to include spaces.'),
    '#default_value' => theme_get_setting('aether_breadcrumb_separator'),
    '#size'          => 5,
    '#maxlength'     => 10,
    '#prefix'        => '<div id="div-aether-breadcrumb-collapse">',
    // Jquery hook to show/hide optional widgets.
  );
  $form['aether_settings']['drupal']['aether_breadcrumb']['aether_breadcrumb_home'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Show home page link in breadcrumb'),
    '#default_value' => theme_get_setting('aether_breadcrumb_home'),
  );
  $form['aether_settings']['drupal']['aether_breadcrumb']['aether_breadcrumb_trailing'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Append a separator to the end of the breadcrumb'),
    '#default_value' => theme_get_setting('aether_breadcrumb_trailing'),
    '#description'   => t('Useful when the breadcrumb is placed just before the title.'),
  );
  $form['aether_settings']['drupal']['aether_breadcrumb']['aether_breadcrumb_title'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Append the content title to the end of the breadcrumb'),
    '#default_value' => theme_get_setting('aether_breadcrumb_title'),
    '#description'   => t('Useful when the breadcrumb is not placed just before the title.'),
    '#suffix'        => '</div>',
  );
  $form['aether_settings']['themedev'] = array(
    '#title' => t('Debugging'),
    '#type' => 'fieldset',
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#weight' => 12,
  );
  $form['aether_settings']['themedev']['aether_skip_link_anchor'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Anchor ID for the “skip link”'),
    '#default_value' => theme_get_setting('aether_skip_link_anchor'),
    '#field_prefix'  => '#',
    '#description'   => t('Specify the HTML ID of the element that the accessible-but-hidden “skip link” should link to. (<a href="!link">Read more about skip links</a>.)', array('!link' => 'http://drupal.org/node/467976')),
  );
  $form['aether_settings']['themedev']['grid_background'] = array(
    '#type'          => 'checkboxes',
    '#title'         => t('Grid debugging'),
    '#default_value' => theme_get_setting('grid_background'),
    '#options'       => array(
      '1' => t("Enable grid background to aid the design process."),
    ),
    '#description'   => t('Enable or disable various grid and responsive layout options'),
  );
  $form['aether_settings']['themedev']['wireframe_mode'] = array(
  '#type' => 'checkbox',
  '#title' =>  t('Wireframe Mode: Display borders around layout elements'),
  '#description' => t('Wireframes are useful when prototyping a website'),
  '#default_value' => theme_get_setting('wireframe_mode'),
  );
  $form['aether_settings']['themedev']['clear_registry'] = array(
    '#type' => 'checkbox',
    '#title' =>  t('Rebuild theme registry on every page.'),
    '#description'   => t('During theme development, it can be very useful to continuously <a href="!link">rebuild the theme registry</a>. WARNING: this is a huge performance penalty and must be turned off on production websites.', array('!link' => 'http://drupal.org/node/173880#theme-registry')),
    '#default_value' => theme_get_setting('clear_registry'),
  );
}
