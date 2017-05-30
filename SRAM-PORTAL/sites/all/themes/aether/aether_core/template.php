<?php

/**
 * @file
 * Contains theme override functions and preprocess functions for Aether.
 */

// Auto-rebuild the theme registry during theme development.
if (theme_get_setting('clear_registry')) {
  // Rebuild .info data.
  system_rebuild_theme_data();
  // Rebuild theme registry.
  drupal_theme_rebuild();
}

require_once drupal_get_path('theme', 'aether') . '/includes/grid.inc';
require_once drupal_get_path('theme', 'aether') . '/includes/preprocess-html.inc';
require_once drupal_get_path('theme', 'aether') . '/includes/preprocess-page.inc';
require_once drupal_get_path('theme', 'aether') . '/includes/preprocess-maintenance-page.inc';
require_once drupal_get_path('theme', 'aether') . '/includes/preprocess-node.inc';
require_once drupal_get_path('theme', 'aether') . '/includes/preprocess-comment.inc';
require_once drupal_get_path('theme', 'aether') . '/includes/preprocess-block.inc';
require_once drupal_get_path('theme', 'aether') . '/includes/preprocess-region.inc';
require_once drupal_get_path('theme', 'aether') . '/includes/process.inc';
require_once drupal_get_path('theme', 'aether') . '/includes/theme.inc';
require_once drupal_get_path('theme', 'aether') . '/includes/alter.inc';
