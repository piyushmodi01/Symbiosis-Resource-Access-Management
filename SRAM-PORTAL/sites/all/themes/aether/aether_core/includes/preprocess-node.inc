<?php
/**
 * @file
 * node preprocess
 */

/**
 * Implements hook_preprocess_node().
 */
function aether_preprocess_node(&$variables) {
  // Add a striping class.
  $variables['classes_array'][] = 'node-' . $variables['zebra'];
  // Add $unpublished variable.
  $variables['unpublished'] = (!$variables['status']) ? TRUE : FALSE;

  // Add pubdate to submitted variable.
  $variables['pubdate'] = '<time pubdate="pubdate" datetime="' . format_date($variables['node']->created, 'custom', 'Y-m-d\TH:i:s\Z') . '">' . $variables['date'] . '</time>';
  if ($variables['display_submitted']) {
    $variables['submitted'] = t('Submitted by !username on !datetime', array('!username' => $variables['name'], '!datetime' => $variables['pubdate']));
  }
}
