<?php
/**
 * @file
 * Implements theme functions.
 */

/**
 * Assigns variables to a static variable to pass them around.
 *
 * @return
 *   A variable from another function.
 */
function _aether_var($var_name, $new_val = NULL) {
  $variables = &drupal_static(__FUNCTION__, array());

  // If a new value has been passed.
  if ($new_val) {
    $variables[$var_name] = $new_val;
  }

  return isset($variables[$var_name]) ? $variables[$var_name] : NULL;
}

/**
 * Returns the theme container object for the current theme.
 *
 * @return
 *   An object representing the current theme.
 */
function aether_get_theme() {
  $container = &drupal_static(__FUNCTION__);

  $key = $theme = $GLOBALS['theme_key'];
  $delta = NULL;

  if (module_exists('delta') && $delta = delta_get_current($theme)) {
    $key .= ':' . $delta;
  }

  if (!isset($container[$key])) {
    foreach (array_keys(aether_theme_trail($theme)) as $item) {
      if (class_exists($item . '_theme_container')) {
        $class = $item . '_theme_container';
      }
    }

    if (isset($class)) {
      $container[$key] = new $class($theme, $delta);
    }
  }

  return $container[$key];
}

/**
 * Builds the full theme trail (deepest base theme first, subtheme last).
 *
 * @param $theme
 *   The key (machin-readable name) of a theme.
 *
 * @return
 *   An array of all themes in the trail, keyed by theme key.
 */
function aether_theme_trail($theme) {
  $static = &drupal_static(__FUNCTION__);

  if (!isset($static)) {
    $themes = list_themes();

    if (isset($themes[$theme]->info['base theme'])) {
      foreach (system_find_base_themes($themes, $theme) as $base => $name) {
        if ($name && isset($themes[$base])) {
          $static[$theme][$base] = $themes[$base]->info['name'];
        }
      }
    }

    // Add our current subtheme ($key) to that array.
    if (isset($themes[$theme])) {
      $static[$theme][$theme] = $themes[$theme]->info['name'];
    }
  }

  if (isset($static[$theme])) {
    return $static[$theme];
  }
}

/**
 * Implements hook_theme().
 */
function aether_theme() {
  return array(
    'grid_block' => array(
      'variables' => array('content' => NULL, 'id' => NULL),
    ),
  );
}

/**
 *  Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function aether_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }

  return $output;
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 *
 * @return
 *   A string containing the breadcrumb output.
 */
function aether_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  $output = '';

  // Determine if we are to display the breadcrumb.
  $show_breadcrumb = theme_get_setting('aether_breadcrumb');
  if ($show_breadcrumb == 'yes' || $show_breadcrumb == 'admin' && arg(0) == 'admin') {

    // Optionally get rid of the homepage link.
    $show_breadcrumb_home = theme_get_setting('aether_breadcrumb_home');
    if (!$show_breadcrumb_home) {
      array_shift($breadcrumb);
    }

    // Return the breadcrumb with separators.
    if (!empty($breadcrumb)) {
      $breadcrumb_separator = theme_get_setting('aether_breadcrumb_separator');
      $trailing_separator = $title = '';
      if (theme_get_setting('aether_breadcrumb_title')) {
        $item = menu_get_item();
        if (!empty($item['tab_parent'])) {
          // If we are on a non-default tab, use the tab's title.
          $breadcrumb[] = check_plain($item['title']);
        }
        else {
          $breadcrumb[] = drupal_get_title();
        }
      }
      elseif (theme_get_setting('aether_breadcrumb_trailing')) {
        $trailing_separator = $breadcrumb_separator;
      }

      // Provide a navigational heading to give context for breadcrumb links to
      // screen-reader users.
      if (empty($variables['title'])) {
        $variables['title'] = t('You are here');
      }
      // Unless overridden by a preprocess function, make the heading invisible.
      if (!isset($variables['title_attributes_array']['class'])) {
        $variables['title_attributes_array']['class'][] = 'element-invisible';
      }

      // Build the breadcrumb trail.
      $output = '<nav class="breadcrumb" role="navigation">';
      $output .= '<h2' . drupal_attributes($variables['title_attributes_array']) . '>' . $variables['title'] . '</h2>';
      $output .= '<ul><li>' . implode($breadcrumb_separator . '</li><li>', $breadcrumb) . $trailing_separator . '</li></ul>';
      $output .= '</nav>';
    }
  }

  return $output;
}


/**
 * Add unique class (mlid) to all menu items.
 */
function aether_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  $element['#attributes']['class'][] = 'menu-' . $element['#original_link']['mlid'];

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Make Drupal core generated images responsive i.e. flexible in width.
 */
function aether_image($variables) {
  $attributes = $variables['attributes'];
  $attributes['src'] = file_create_url($variables['path']);

  // Remove width and height attributes.
  foreach (array('alt', 'title') as $key) {
    if (isset($variables[$key])) {
      $attributes[$key] = $variables[$key];
    }
  }
  return '<img' . drupal_attributes($attributes) . ' />';
}

/**
 * Returns a list of blocks.
 * Uses Drupal block interface,
 * Appends any blocks assigned by the Context module.
 */
function aether_block_list($region) {
  $drupal_list = array();
  if (module_exists('block')) {
    $drupal_list = block_list($region);
  }
  if (module_exists('context') && $context = context_get_plugin('reaction', 'block')) {
    $context_list = $context->block_list($region);
    $drupal_list = array_merge($context_list, $drupal_list);
  }
  return $drupal_list;
}
