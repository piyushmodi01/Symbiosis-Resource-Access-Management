<?php
/**
 * @file
 * Implements page functions.
 */

/**
 * Implements hook_preprocess_page().
 */
function aether_preprocess_page(&$variables, $hook) {
  $theme = aether_get_theme();
  $theme->page = &$variables;

  // Passing vars as a static variable to be used in process_region
  _aether_var('front_page', $theme->page['front_page']);
  _aether_var('logo', $theme->page['logo']);
  _aether_var('site_name', $theme->page['site_name']);
  _aether_var('site_slogan', $theme->page['site_slogan']);
  _aether_var('secondary_menu', $theme->page['secondary_menu']);
  _aether_var('main_menu', $theme->page['main_menu']);

  static $grid;

  // Initialize grid info once per page.
  if (!isset($grid)) {
    $grid = aether_grid_info();
  }

  if (isset($variables['node_title'])) {
    $variables['title'] = $variables['node_title'];
  }
  $variables['content_attributes_array']['class'][] = 'content-inner';

  // Define variables for class insertion into content area.
  $variables['content_attributes_array']['class'][] = implode(' ', $grid['regions']['content']['width']);

}
