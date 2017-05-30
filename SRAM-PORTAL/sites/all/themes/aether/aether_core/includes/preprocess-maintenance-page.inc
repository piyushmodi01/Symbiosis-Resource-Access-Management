<?php
/**
 * @file
 * Implements page functions.
 */

/**
 * Override or insert variables into the maintenance page template.
 *
 * @param $variables
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("maintenance_page" in this case.)
 */
function aether_preprocess_maintenance_page(&$variables, $hook) {
  aether_preprocess_html($variables, $hook);
}
