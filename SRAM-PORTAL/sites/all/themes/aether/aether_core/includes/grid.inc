<?php
/**
 * @file
 * Grid data created and processed.
 */

/**
 * Generate initial grid info.
 */
function aether_grid_info() {
  global $theme_key;
  $sec_links = theme_get_setting('toggle_secondary_menu');
  $logo = theme_get_setting('toggle_logo');
  $push_prefix = 'push';
  $pull_prefix = 'pull';
  $offset_prefix = 'o';
  $right_prefix = 'right';

  if (!isset($grid)) {
    $grid = array();
    $media_queries = theme_get_setting('media_queries');
  }
  else {
    $media_queries = 1;
  }
  for ($media_count = 1; $media_count <= $media_queries; $media_count++) {
    $gridprefix = theme_get_setting('grid_prefix' . $media_count);
    $grid['user_first_width' . $media_count] = theme_get_setting('user_first_width' . $media_count);
    $grid['user_second_width' . $media_count] = theme_get_setting('user_second_width' . $media_count);
    $grid['header_first_width' . $media_count] = theme_get_setting('header_first_width' . $media_count);
    $grid['header_second_width' . $media_count] = theme_get_setting('header_second_width' . $media_count);
    $grid['header_third_width' . $media_count] = theme_get_setting('header_third_width' . $media_count);
    $grid['preface_first_width' . $media_count] = theme_get_setting('preface_first_width' . $media_count);
    $grid['preface_second_width' . $media_count] = theme_get_setting('preface_second_width' . $media_count);
    $grid['preface_third_width' . $media_count] = theme_get_setting('preface_third_width' . $media_count);
    $grid['nav_link_width' . $media_count] = theme_get_setting('nav_link_width' . $media_count);
    $grid['navigation_first_width' . $media_count] = theme_get_setting('navigation_first_width' . $media_count);
    $grid['navigation_second_width' . $media_count] = theme_get_setting('navigation_second_width' . $media_count);
    $grid['postscript_first_width' . $media_count] = theme_get_setting('postscript_first_width' . $media_count);
    $grid['postscript_second_width' . $media_count] = theme_get_setting('postscript_second_width' . $media_count);
    $grid['postscript_third_width' . $media_count] = theme_get_setting('postscript_third_width' . $media_count);
    $grid['postscript_fourth_width' . $media_count] = theme_get_setting('postscript_fourth_width' . $media_count);
    $grid['footer_first_width' . $media_count] = theme_get_setting('footer_first_width' . $media_count);
    $grid['footer_second_width' . $media_count] = theme_get_setting('footer_second_width' . $media_count);
    $grid['footer_third_width' . $media_count] = theme_get_setting('footer_third_width' . $media_count);
    $grid['footer_fourth_width' . $media_count] = theme_get_setting('footer_fourth_width' . $media_count);
    $grid['name' . $media_count] = drupal_substr(theme_get_setting('theme_grid' . $media_count), 0, 7);
    $grid['type' . $media_count] = drupal_substr(theme_get_setting('theme_grid' . $media_count), 7);
    $grid['fixed' . $media_count] = (drupal_substr(theme_get_setting('theme_grid' . $media_count), 7) != 'fluid') ? TRUE : FALSE;
    $grid['width' . $media_count] = (int) drupal_substr($grid['name' . $media_count], 4, 2);

    // block_list does not return the correct enabled regions on demo page.
    $item = menu_get_item();
    if ($item['path'] == 'admin/structure/block/demo/' . $theme_key) {
      $grid['sidebar_first_width' . $media_count] = theme_get_setting('sidebar_first_width' . $media_count);
      $grid['sidebar_second_width' . $media_count] = theme_get_setting('sidebar_second_width' . $media_count);
    }
    else {
      $grid['sidebar_first_width' . $media_count] = (aether_block_list('sidebar_first')) ? theme_get_setting('sidebar_first_width' . $media_count) : 0;
      $grid['sidebar_second_width' . $media_count] = (aether_block_list('sidebar_second')) ? theme_get_setting('sidebar_second_width' . $media_count) : 0;
    }

    $grid['content_width' . $media_count] = $grid['width' . $media_count] - ($grid['sidebar_first_width' . $media_count] + $grid['sidebar_second_width' . $media_count]);

    $grid['regions'] = array();
    $regions = array_keys(system_region_list($theme_key, REGIONS_VISIBLE));
    $adjusted_regions = theme_get_setting('grid_adjusted_regions');

    $nav_link_width[] = $gridprefix . $grid['nav_link_width' . $media_count];

    // Define vars.
    $user_first_width[] = $gridprefix . $grid['user_first_width' . $media_count];
    $user_second_width[] = $gridprefix . $grid['user_second_width' . $media_count];
    $header_first_width[] = $gridprefix . $grid['header_first_width' . $media_count];
    $header_second_width[] = $gridprefix . $grid['header_second_width' . $media_count];
    $header_third_width[] = $gridprefix . $grid['header_third_width' . $media_count];
    $preface_first_width[] = $gridprefix . $grid['preface_first_width' . $media_count];
    $preface_second_width[] = $gridprefix . $grid['preface_second_width' . $media_count];
    $preface_third_width[] = $gridprefix . $grid['preface_third_width' . $media_count];
    $navigation_first_width[] = $gridprefix . $grid['navigation_first_width' . $media_count];
    $navigation_second_width[] = $gridprefix . $grid['navigation_second_width' . $media_count];
    $content_width[] = '';
    $content_push[] = '';
    $sidebar_first_width[] = '';
    $sidebar_second_width[] = '';
    $sidebar_first_pull[] = '';
    $sidebar_first_push[] = '';
    $sidebar_second_offset[] = '';
    $sidebar_second_pull[] = '';
    // Split sidebars.
    if (theme_get_setting('sidebar_layout' . $media_count) === '1') {
      $content_width[] = $gridprefix . $grid['content_width' . $media_count];
      $sidebar_first_width[] = $gridprefix . $grid['sidebar_first_width' . $media_count];
      $sidebar_second_width[] = $gridprefix . $grid['sidebar_second_width' . $media_count];
      $content_push[] = $gridprefix . $push_prefix . $grid['sidebar_first_width' . $media_count];
      $sidebar_first_pull[] = $gridprefix . $pull_prefix . $grid['content_width' . $media_count];
      $sidebar_second_offset[] = $gridprefix . $offset_prefix . ($grid['sidebar_first_width' . $media_count] + $grid['content_width' . $media_count]);
    }
    // Two sidebars left.
    elseif (theme_get_setting('sidebar_layout' . $media_count) === '2') {
      $content_width[] = $gridprefix . $grid['content_width' . $media_count];
      $sidebar_first_width[] = $gridprefix . $grid['sidebar_first_width' . $media_count];
      $sidebar_second_width[] = $gridprefix . $grid['sidebar_second_width' . $media_count];
      $content_push[] = $gridprefix . $push_prefix . ($grid['sidebar_first_width' . $media_count] + $grid['sidebar_second_width' . $media_count]);
      $sidebar_first_pull[] = $gridprefix . $pull_prefix . $grid['content_width' . $media_count];
      $sidebar_second_offset[] = $gridprefix . $offset_prefix . ($grid['sidebar_first_width' . $media_count] + $grid['content_width' . $media_count]);
      $sidebar_second_pull[] = $gridprefix . $pull_prefix . ($grid['content_width' . $media_count]);
    }
    // Two sidebars right.
    elseif (theme_get_setting('sidebar_layout' . $media_count) === '3') {
      $content_width[] = $gridprefix . $grid['content_width' . $media_count];
      $sidebar_first_width[] = $gridprefix . $grid['sidebar_first_width' . $media_count];
      $sidebar_second_width[] = $gridprefix . $grid['sidebar_second_width' . $media_count];
    }
    // Sidebar1 left, sidebar2 bottom.
    elseif (theme_get_setting('sidebar_layout' . $media_count) === '4') {
      $content_width[] = $gridprefix . ($grid['content_width' . $media_count] + $grid['sidebar_second_width' . $media_count]);
      $sidebar_second_width[] = $gridprefix . $grid['width' . $media_count];
      $sidebar_first_width[] = $gridprefix . $grid['sidebar_first_width' . $media_count];
      $content_push[] = $gridprefix . $push_prefix . $grid['sidebar_first_width' . $media_count];
      $sidebar_first_pull[] = $gridprefix . $pull_prefix . ($grid['content_width' . $media_count] + $grid['sidebar_second_width' . $media_count]);
    }
    // Sidebar1 right, sidebar2 bottom.
    elseif (theme_get_setting('sidebar_layout' . $media_count) === '5') {
      $content_width[] = $gridprefix . ($grid['content_width' . $media_count] + $grid['sidebar_second_width' . $media_count]);
      $sidebar_first_width[] = $gridprefix . $grid['sidebar_first_width' . $media_count];
      $sidebar_second_width[] = $gridprefix . $grid['width' . $media_count];
    }
    // Sidebar1 left, sidebar2 under content.
    elseif (theme_get_setting('sidebar_layout' . $media_count) === '6') {
      $content_width[] = $gridprefix . ($grid['content_width' . $media_count] + $grid['sidebar_second_width' . $media_count]);
      $sidebar_second_width[] = $gridprefix . ($grid['content_width' . $media_count] + $grid['sidebar_second_width' . $media_count]);
      $sidebar_second_width[] = $gridprefix . $right_prefix;
      $sidebar_first_width[] = $gridprefix . $grid['sidebar_first_width' . $media_count];
      $content_push[] = $gridprefix . $push_prefix . $grid['sidebar_first_width' . $media_count];
      $sidebar_first_pull[] = $gridprefix . $pull_prefix . ($grid['content_width' . $media_count] + $grid['sidebar_second_width' . $media_count]);
    }
    // Sidebar1 right, sidebar2 bottom.
    elseif (theme_get_setting('sidebar_layout' . $media_count) === '7') {
      $content_width[] = $gridprefix . ($grid['content_width' . $media_count] + $grid['sidebar_second_width' . $media_count]);
      $sidebar_first_width[] = $gridprefix . $grid['sidebar_first_width' . $media_count];
      $sidebar_first_width[] = $gridprefix . $right_prefix;
      $sidebar_second_width[] = $gridprefix . ($grid['content_width' . $media_count] + $grid['sidebar_second_width' . $media_count]);
    }
    // Sidebar1 and sidebar2 right stacked.
    elseif (theme_get_setting('sidebar_layout' . $media_count) === '8') {
      $content_width[] = $gridprefix . ($grid['content_width' . $media_count] + $grid['sidebar_second_width' . $media_count]);
      $sidebar_first_width[] = $gridprefix . $grid['sidebar_first_width' . $media_count];
      $sidebar_second_width[] = $gridprefix . $grid['sidebar_first_width' . $media_count];
      $sidebar_second_width[] = $gridprefix . $right_prefix;
    }
    // Full width.
    else {
      $content_width[] = $gridprefix . $grid['width' . $media_count];
      $sidebar_first_width[] = $gridprefix . $grid['width' . $media_count];
      $sidebar_second_width[] = $gridprefix . $grid['width' . $media_count];
    }

    $postscript_first_width[] = $gridprefix . $grid['postscript_first_width' . $media_count];
    $postscript_second_width[] = $gridprefix . $grid['postscript_second_width' . $media_count];
    $postscript_third_width[] = $gridprefix . $grid['postscript_third_width' . $media_count];
    $postscript_fourth_width[] = $gridprefix . $grid['postscript_fourth_width' . $media_count];
    $footer_first_width[] = $gridprefix . $grid['footer_first_width' . $media_count];
    $footer_second_width[] = $gridprefix . $grid['footer_second_width' . $media_count];
    $footer_third_width[] = $gridprefix . $grid['footer_third_width' . $media_count];
    $footer_fourth_width[] = $gridprefix . $grid['footer_fourth_width' . $media_count];

    $grid_width[] = $gridprefix . $grid['width' . $media_count];

    foreach ($regions as $region) {
      $region_width = '';
      $region_offset = '';
      $other_width = '';

      switch ($region) {
        case 'main_menu':
          $region_width = $grid_width;
          $other_width = $nav_link_width;
          break;

        case 'user_first':
          $region_width = $user_first_width;
          break;

        case 'user_second':
          $region_width = $user_second_width;
          break;

        case 'header_first':
          $region_width = $header_first_width;
          break;

        case 'header_second':
          $region_width = $header_second_width;
          break;

        case 'header_third':
          $region_width = $header_third_width;
          break;

        case 'preface_first':
          $region_width = $preface_first_width;
          break;

        case 'preface_second':
          $region_width = $preface_second_width;
          break;

        case 'preface_third':
          $region_width = $preface_third_width;
          break;

        case 'navigation_first':
          $region_width = $navigation_first_width;
          break;

        case 'navigation_second':
          $region_width = $navigation_second_width;
          break;

        case 'sidebar_first':
          $region_width = _aether_array_interlace($sidebar_first_width, $sidebar_first_pull, $sidebar_first_push);
          break;

        case 'sidebar_second':
          $region_width = _aether_array_interlace($sidebar_second_width, $sidebar_second_pull);
          $region_offset = $sidebar_second_offset;
          break;

        case 'content':
          $region_width = _aether_array_interlace($content_width, $content_push);
          break;

        case 'postscript_first':
          $region_width = $postscript_first_width;
          break;

        case 'postscript_second':
          $region_width = $postscript_second_width;
          break;

        case 'postscript_third':
          $region_width = $postscript_third_width;
          break;

        case 'postscript_fourth':
          $region_width = $postscript_fourth_width;
          break;

        case 'footer_first':
          $region_width = $footer_first_width;
          break;

        case 'footer_second':
          $region_width = $footer_second_width;
          break;

        case 'footer_third':
          $region_width = $footer_third_width;
          break;

        case 'footer_fourth':
          $region_width = $footer_fourth_width;
          break;

      }

      $grid['regions'][$region] = array(
        'width' => $region_width,
        'offset' => $region_offset,
        'grid_width' => $grid_width,
        'other_width' => $other_width,
        'total' => count(aether_block_list($region)),
        'count' => 0,
      );
    }

  }
  return $grid;
}

/**
 * Interlace two or more arrays together.
 */
function _aether_array_interlace() {
  $args = func_get_args();
  $total = count($args);

  if ($total < 2) {
    return FALSE;
  }

  $i = 0;
  $j = 0;
  $arr = array();

  foreach ($args as $arg) {
    foreach ($arg as $v) {
      $arr[$j] = $v;
      $j += $total;
    }

    $i++;
    $j = $i;
  }

  ksort($arr);
  return array_values($arr);
}
