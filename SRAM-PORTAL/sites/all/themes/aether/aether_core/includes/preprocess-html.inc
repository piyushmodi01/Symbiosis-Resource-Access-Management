<?php
/**
 * @file
 * HTML related functions
 */

/**
 * Implements hook_preprocess_html().
 */
function aether_preprocess_html(&$variables, $hook) {
  global $theme_key;
  // Add paths needed for html5shim.
  $variables['base_path'] = base_path();
  $variables['path_to_aether'] = drupal_get_path('theme', 'aether');
  $polyfills = theme_get_setting('aether_polyfills');
  $variables['add_responsive_tables']      = in_array('responsive_tables', $polyfills);
  $variables['add_html5_shim']      = in_array('html5', $polyfills);
  $variables['add_respond_js']      = in_array('respond', $polyfills);
  $variables['add_responsive_meta'] = in_array('meta', $polyfills);
  $variables['add_selectivizr_js']  = in_array('selectivizr', $polyfills);
  $variables['add_imgsizer_js']  = in_array('imgsizer', $polyfills);
  $variables['skip_link_anchor'] = theme_get_setting('aether_skip_link_anchor');
  $variables['skip_link_text'] = theme_get_setting('aether_skip_link_text');

  // Attributes for html element.
  $variables['html_attributes_array'] = array(
    'lang' => $variables['language']->language,
    'dir' => $variables['language']->dir,
  );

  if (in_array('ios_orientation_fix', $polyfills)) {
    drupal_add_js(drupal_get_path('theme', 'aether') . '/js/ios-orientationchange-fix.js' , array('scope' => 'footer'));
  }
  if (in_array('responsive_tables', $polyfills)) {
    drupal_add_js(drupal_get_path('theme', 'aether') . '/js/responsive-tables.js' , array('scope' => 'header'));
  }

  // Classes for body element. Allows advanced theming based on context
  // (home page, node of certain type, etc.)
  if (!$variables['is_front'] && $hook == 'html') {
    // Add unique class for each page.
    $path = drupal_get_path_alias($_GET['q']);
    // Add unique class for each website section.
    list($section,) = explode('/', $path, 2);
    $arg = explode('/', $_GET['q']);
    if ($arg[0] == 'node') {
      if ($arg[1] == 'add') {
        $section = 'node-add';
      }
      elseif (isset($arg[2]) && is_numeric($arg[1]) && ($arg[2] == 'edit' || $arg[2] == 'delete')) {
        $section = 'node-' . $arg[2];
      }
    }
    $variables['classes_array'][] = drupal_html_class('section-' . $section);
  }
  // If media queries are enabled in theme-settings.
  if (in_array('1', theme_get_setting('layout_options'))) {
    $variables['classes_array'][] = 'responsive-all';
  }
  // Adding a class in wireframe mode.
  if (theme_get_setting('wireframe_mode')) {
    $variables['classes_array'][] = 'with-wireframes';
  }
  // If navigation bar links adheres to grid.
  if (in_array('2', theme_get_setting('layout_options'))) {
    $variables['classes_array'][] = 'grid-en-nav';
  }
  // If header adheres to grid.
  else {
    $variables['classes_array'][] = 'grid-dis-nav';
  }
  // Store the menu item since it has some useful information.
  if ($hook == 'html') {
    $variables['menu_item'] = menu_get_item();
    if ($variables['menu_item']) {
      switch ($variables['menu_item']['page_callback']) {
        case 'views_page':
          // Is this a Views page?
          $variables['classes_array'][] = 'page-views';
          break;

        case 'page_manager_page_execute':
        case 'page_manager_node_view':
        case 'page_manager_contact_site':
          // Is this a Panels page?
          $variables['classes_array'][] = 'page-panels';
          break;
      }
    }
  }

  if (in_array('1', theme_get_setting('layout_options'))) {
    // Then load the media queries.
    drupal_add_css(drupal_get_path('theme', $theme_key) . '/css/layout/aether-mediaqueries.css',
      array(
        'group' => CSS_THEME,
        'preprocess' => TRUE,
        'every_page' => TRUE,
        'weight' => '0',
      )
    );
  }

  if (in_array('1', theme_get_setting('grid_background'))) {
    // Then load the media queries.
    drupal_add_css(drupal_get_path('theme', $theme_key) . '/css/layout/aether-debug.css',
      array(
        'group' => CSS_THEME,
        'preprocess' => TRUE,
        'every_page' => TRUE,
        'weight' => '0',
      )
    );
  }

}
