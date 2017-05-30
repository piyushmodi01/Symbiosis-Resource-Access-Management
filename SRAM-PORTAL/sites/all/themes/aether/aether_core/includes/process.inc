<?php
/**
 * @file
 * Implements preprocess functions.
 */

/**
 * Override or insert variables into the html templates.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("html" in this case.)
 */
function aether_process_html(&$variables, $hook) {
  // Flatten out html_attributes.
  $variables['html_attributes'] = drupal_attributes($variables['html_attributes_array']);
}

/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
function aether_process_maintenance_page(&$variables, $hook) {
  aether_process_html($variables, $hook);
  aether_process_region($variables, $hook);
  // Ensure default regions get a variable. Theme authors often forget to remove
  // a deleted region's variable in maintenance-page.tpl.
  foreach (array('branding','user_first','user_second','header_first','header_second','header_third','main_menu','navigation_first','navigation_second','feature','preface_first','preface_second','preface_third','highlighted','help','content', 'sidebar_first', 'sidebar_second','postscript_first','postscript_second','postscript_third','postscript_fourth','footer','footer_first','footer_second','footer_third','footer_fourth') as $region) {
    if (!isset($variables[$region])) {
      $variables[$region] = '';
    }
  }
}

/**
 * Implements hook_process_region().
 */
function aether_process_region(&$variables) {
  $theme = aether_get_theme();

  $variables['front_page'] = _aether_var('front_page');
  $variables['primary_links'] = _aether_var('main_menu');
  $variables['main_menu'] = $variables['primary_links'] ? theme('links', array(
        'links' => $variables['main_menu'],
        'attributes' => array(
          'id' => 'primary',
          'class' => array(
            'links',
            'clearfix',
            'main-menu')
            )
          )
        ) : '';
  $variables['secondary_menu'] = _aether_var('secondary_menu');
  $variables['site_name'] = _aether_var('site_name');
  $variables['site_slogan'] = _aether_var('site_slogan');
  $variables['linked_site_name'] = l($variables['site_name'], '<front>', array('attributes' => array('title' => t('Home')), 'html' => TRUE));
  $variables['logo'] = _aether_var('logo');
  $variables['logo_img'] = $variables['logo'] ? '<img src="' . $variables['logo'] . '" alt="' . check_plain($variables['site_name']) . '" id="logo" />' : '';
  $variables['linked_logo_img'] = $variables['logo'] ? l($variables['logo_img'], '<front>',
    array(
      'attributes' => array(
        'rel' => 'home',
        'title' => check_plain($variables['site_name'])),
      'html' => TRUE)) : '';

}

/**
 * Override or insert variables in the html_tag theme function.
 */
function aether_process_html_tag(&$variables) {
  $tag = &$variables['element'];

  if ($tag['#tag'] == 'style' || $tag['#tag'] == 'script') {
    // Remove redundant type attribute and CDATA comments.
    unset($tag['#attributes']['type'], $tag['#value_prefix'], $tag['#value_suffix']);

    // Remove media="all" but leave others unaffected.
    if (isset($tag['#attributes']['media']) && $tag['#attributes']['media'] === 'all') {
      unset($tag['#attributes']['media']);
    }
  }
}
