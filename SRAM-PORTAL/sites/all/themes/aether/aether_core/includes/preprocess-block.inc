<?php
/**
 * @file
 * Block related functions
 */

/**
 * Implements hook_preprocess_block().
 */
function aether_preprocess_block(&$variables, $hook) {
  // Use a template with no wrapper for the page's main content.
  if ($variables['block_html_id'] == 'block-system-main') {
    $variables['theme_hook_suggestions'][] = 'block__no_wrapper';
  }

  // Classes describing the position of the block within the region.
  if ($variables['block_id'] == 1) {
    $variables['classes_array'][] = 'first';
  }
  // The last_in_region property is set in aether_page_alter().
  if (isset($variables['block']->last_in_region)) {
    $variables['classes_array'][] = 'last';
  }
  $variables['title_attributes_array']['class'][] = 'block-title';

  // Add a striping class.
  $variables['classes_array'][] = 'block-' . $variables['zebra'];
  // Add Aria Roles via attributes.
  switch ($variables['block']->module) {
    case 'system':
      switch ($variables['block']->delta) {
        case 'help':
        case 'powered-by':
          $variables['attributes_array']['role'] = 'complementary';
          break;

        default:
          // Any other "system" block is a menu block.
          $variables['attributes_array']['role'] = 'navigation';
          break;

      }
      break;

    case 'menu':
    case 'menu_block':
    case 'blog':
    case 'book':
    case 'comment':
    case 'forum':
    case 'shortcut':
    case 'statistics':
      $variables['attributes_array']['role'] = 'navigation';
      break;

    case 'search':
      $variables['attributes_array']['role'] = 'search';
      break;

    case 'help':
    case 'aggregator':
    case 'locale':
    case 'poll':
    case 'profile':
      $variables['attributes_array']['role'] = 'complementary';
      break;

    case 'node':
      switch ($variables['block']->delta) {
        case 'syndicate':
          $variables['attributes_array']['role'] = 'complementary';
          break;

        case 'recent':
          $variables['attributes_array']['role'] = 'navigation';
          break;

      }
      break;

    case 'user':
      switch ($variables['block']->delta) {
        case 'login':
          $variables['attributes_array']['role'] = 'form';
          break;

        case 'new':
        case 'online':
          $variables['attributes_array']['role'] = 'complementary';
          break;

      }
      break;

  }
}
