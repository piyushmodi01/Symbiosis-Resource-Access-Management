<?php
/**
 * @file
 * General alters.
 */

/**
 * Implements hook_html_head_alter().
 */
function aether_html_head_alter(&$head) {
  // Simplify the meta tag for character encoding.
  $head['system_meta_content_type']['#attributes'] = array(
    'charset' => str_replace('text/html; charset=', '', $head['system_meta_content_type']['#attributes']['content']),
  );
}

/**
 * Implements hook_form_BASE_FORM_ID_alter().
 *
 * Prevent user-facing field styling from screwing up node edit forms by
 * renaming the classes on the node edit form's field wrappers.
 */
function aether_form_node_form_alter(&$form, &$form_state, $form_id) {
  // Remove if #1245218 is backported to D7 core.
  foreach (array_keys($form) as $item) {
    if (strpos($item, 'field_') === 0) {
      if (!empty($form[$item]['#attributes']['class'])) {
        foreach ($form[$item]['#attributes']['class'] as &$class) {
          if (strpos($class, 'field-type-') === 0 || strpos($class, 'field-name-') === 0) {
            // Make the class different from that used in theme_field().
            $class = 'form-' . $class;
          }
        }
      }
    }
  }
}

/**
 * Implements hook_page_alter().
 *
 * Force enable empty regions where necessary if they are in the page array.
 *
 * Look for the last block in the region. This is impossible to determine from
 * within a preprocess_block function.
 *
 * @param $page
 *   Nested array of renderable elements that make up the page.
 */
function aether_page_alter(&$page) {

  // Check if the branding region is in the page array and display it if so.
  foreach (system_region_list($GLOBALS['theme'], REGIONS_ALL) as $region => $name) {
    if (in_array($region, array('branding'))) {
      $page['branding'] = array(
        '#region' => 'branding',
        '#weight' => '-10',
        '#theme_wrappers' => array('region'),
      );
    }
    if (in_array($region, array('main_menu'))) {
      $page['main_menu'] = array(
        '#region' => 'main_menu',
        '#weight' => '-10',
        '#theme_wrappers' => array('region'),
      );
    }
  }

  // Look in each visible region for blocks.
  foreach (system_region_list($GLOBALS['theme'], REGIONS_VISIBLE) as $region => $name) {
    if (!empty($page[$region])) {
      // Find the last block in the region.
      $blocks = array_reverse(element_children($page[$region]));
      while ($blocks && !isset($page[$region][$blocks[0]]['#block'])) {
        array_shift($blocks);
      }
      if ($blocks) {
        $page[$region][$blocks[0]]['#block']->last_in_region = TRUE;
      }
    }
  }
}
