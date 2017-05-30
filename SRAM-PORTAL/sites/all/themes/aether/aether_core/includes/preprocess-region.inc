<?php
/**
 * @file
 * Implements region preprocess functions.
 */

/**
 * Preprocess variables for region.tpl.php.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("region" in this case).
 */
function aether_preprocess_region(&$variables, $hook) {
  static $grid;

  // Initialize grid info once per page.
  if (!isset($grid)) {
    $grid = aether_grid_info();
  }

  $theme = aether_get_theme();

  $variables['main_menu'] = _aether_var('main_menu');

  // Sidebar regions get some extra classes and a common template suggestion.
  if (strpos($variables['region'], 'sidebar_') === 0) {
    $variables['classes_array'][] = 'column';
    $variables['classes_array'][] = 'sidebar';
    $variables['content_attributes_array']['class'][] = 'sidebar-inner';
    // Allow a region-specific template to override aether's region--sidebar.
    array_unshift($variables['theme_hook_suggestions'], 'region__sidebar');
  }

  // Add sidebar classes.
  if (strpos($variables['region'], 'sidebar_first') === 0) {
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['sidebar_first']['width']);
  }
  if (strpos($variables['region'], 'sidebar_second') === 0) {
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['sidebar_second']['width']);
    $variables['classes_array'][] = implode(' ', $grid['regions']['sidebar_second']['offset']);
  }

  // Branding region gets a common template suggestion.
  if (strpos($variables['region'], 'branding') === 0) {
    $variables['content_attributes_array']['class'][] = 'branding-inner';
    // Allow a region-specific template to override aether's region--branding.
    array_unshift($variables['theme_hook_suggestions'], 'region__branding');
  }

  if (strpos($variables['region'], 'branding') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['branding']['grid_width']);
  }

  // main_menu region gets a common template suggestion.
  if (strpos($variables['region'], 'main_menu') === 0) {
    $variables['content_attributes_array']['class'][] = 'main-menu-inner';
    // Allow a region-specific template to override aether's region--main_menu.
    array_unshift($variables['theme_hook_suggestions'], 'region__main_menu');
  }

  if (strpos($variables['region'], 'main_menu') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    // Add full grid width if nav-to-grid option isn't checked.
    if (!in_array('2', theme_get_setting('layout_options'))) {
      $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['main_menu']['grid_width']);
    }
    // Add nav-to-grid option if checked.
    if (in_array('2', theme_get_setting('layout_options'))) {
      foreach ($variables['main_menu'] as $key => $value) {
        $variables['main_menu'][$key]['attributes']['class'][] = implode(' ', $grid['regions']['main_menu']['other_width']);
      }
    }
  }

  // User regions get a common template suggestion.
  if (strpos($variables['region'], 'user') === 0) {
    $variables['content_attributes_array']['class'][] = 'user-inner';
    // Allow a region-specific template to override aether's region--user.
    array_unshift($variables['theme_hook_suggestions'], 'region__user');
  }

  // Add user classes.
  if (strpos($variables['region'], 'user_first') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['user_first']['width']);
  }
  if (strpos($variables['region'], 'user_second') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['user_second']['width']);
  }

  // Header regions get a common template suggestion.
  if (strpos($variables['region'], 'header') === 0) {
    $variables['content_attributes_array']['class'][] = 'header-inner';
    // Allow a region-specific template to override aether's region--header.
    array_unshift($variables['theme_hook_suggestions'], 'region__header');
  }

  // Add header classes.
  if (strpos($variables['region'], 'header_first') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['header_first']['width']);
  }
  if (strpos($variables['region'], 'header_second') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['header_second']['width']);
  }
  if (strpos($variables['region'], 'header_third') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['header_third']['width']);
  }

  // Preface regions get a common template suggestion.
  if (strpos($variables['region'], 'preface') === 0) {
    $variables['content_attributes_array']['class'][] = 'preface-inner';
    // Allow a region-specific template to override aether's region--preface.
    array_unshift($variables['theme_hook_suggestions'], 'region__preface');
  }

  // Add preface classes.
  if (strpos($variables['region'], 'preface_first') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['preface_first']['width']);
  }
  if (strpos($variables['region'], 'preface_second') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['preface_second']['width']);
  }
  if (strpos($variables['region'], 'preface_third') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['preface_third']['width']);
  }

  // navigation regions gets a common template suggestion.
  if (strpos($variables['region'], 'navigation') === 0) {
    $variables['content_attributes_array']['class'][] = 'navigation-inner';
    // Allow a region-specific template to override aether's region--sidebar.
    array_unshift($variables['theme_hook_suggestions'], 'region__navigation');
  }

  // Add navigation classes.
  if (strpos($variables['region'], 'navigation_first') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['navigation_first']['width']);
  }
  if (strpos($variables['region'], 'navigation_second') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['navigation_second']['width']);
  }

  // Feature regions get a common template suggestion.
  if (strpos($variables['region'], 'feature') === 0) {
    $variables['content_attributes_array']['class'][] = 'feature-inner';
    // Allow a region-specific template to override aether's region--header.
    array_unshift($variables['theme_hook_suggestions'], 'region__feature');
  }
  if ($variables['region'] == 'feature') {
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['feature']['grid_width']);
  }

  // Postscript regions get a common template suggestion.
  if (strpos($variables['region'], 'postscript') === 0) {
    $variables['content_attributes_array']['class'][] = 'postscript-inner';
    // Allow a region-specific template to override aether's region--postscript.
    array_unshift($variables['theme_hook_suggestions'], 'region__postscript');
  }

  // Add postscript classes.
  if (strpos($variables['region'], 'postscript_first') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['postscript_first']['width']);
  }
  if (strpos($variables['region'], 'postscript_second') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['postscript_second']['width']);
  }
  if (strpos($variables['region'], 'postscript_third') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['postscript_third']['width']);
  }
  if (strpos($variables['region'], 'postscript_fourth') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['postscript_fourth']['width']);
  }

  // Footer regions gets a common template suggestion.
  if (strpos($variables['region'], 'footer') === 0) {
    $variables['content_attributes_array']['class'][] = 'footer-inner';
    // Allow a region-specific template to override aether's region--sidebar.
    array_unshift($variables['theme_hook_suggestions'], 'region__footer');
  }

  // Add footer classes.
  if (strpos($variables['region'], 'footer_first') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['footer_first']['width']);
  }
  if (strpos($variables['region'], 'footer_second') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['footer_second']['width']);
  }
  if (strpos($variables['region'], 'footer_third') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['footer_third']['width']);
  }
  if (strpos($variables['region'], 'footer_fourth') === 0) {
    // $variables['classes_array'][] = $offset_prefix . '';
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['footer_fourth']['width']);
  }
  if ($variables['region'] == 'footer') {
    $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['footer']['grid_width']);
  }

  // Set region variables.
  // $variables['region_style'] = $variables['fluid_width'] = '';
  $variables['region_name'] = str_replace('_', '-', $variables['region']);
  $variables['classes_array'][] = $variables['region_name'];

}
