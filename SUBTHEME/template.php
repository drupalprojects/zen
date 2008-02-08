<?php
// $Id$

/**
 * @file
 *
 * The Zen theme allows its sub-themes to have their own template.php files. The
 * only restriction with these files is that they cannot redefine any of the
 * functions that are already defined in Zen's main template files:
 * template.php, template-menus.php, and template-subtheme.php.
 *
 * Also remember that the "main" theme is still Zen, so your theme override
 * functions should be named as such:
 *  theme_block()      becomes  zen_block()
 *  theme_feed_icon()  becomes  zen_feed_icon()  as well
 *
 * For a sub-theme to define its own regions, use the function name
 *   SUBTHEME_regions()
 * where SUBTHEME is the name of your sub-theme. For example, the zen_classic
 * theme would define a zen_classic_regions() function.
 *
 * For a sub-theme to add its own variables, use these functions
 *   SUBTHEME_preprocess_page(&$vars)
 *   SUBTHEME_preprocess_node(&$vars)
 *   SUBTHEME_preprocess_comment(&$vars)
 */


/*
 * Initialize theme settings
 */
include_once 'theme-settings-init.php';


/*
 * Sub-themes with their own page.tpl.php files are seen by PHPTemplate as their
 * own theme (seperate from Zen). So we need to re-connect those sub-themes
 * with the main Zen theme.
 */
include_once './'. drupal_get_path('theme', 'zen') .'/template.php';


/*
 * Add the stylesheets you will need for this sub-theme.
 *
 * To add stylesheets that are in the main Zen folder, use path_to_theme().
 * To add stylesheets thar are in your sub-theme's folder, use path_to_subtheme().
 */

// Add any stylesheets you would like from the main Zen theme.
drupal_add_css(path_to_theme() .'/html-elements.css', 'theme', 'all');
drupal_add_css(path_to_theme() .'/tabs.css', 'theme', 'all');

// Then add styles for this sub-theme.
drupal_add_css(path_to_subtheme() .'/layout.css', 'theme', 'all');
drupal_add_css(path_to_subtheme() .'/SUBTHEME.css', 'theme', 'all');

// Avoid IE5 bug that always loads @import print stylesheets
zen_add_print_css(path_to_subtheme() .'/print.css');


/**
 * Declare the available regions implemented by this theme.
 *
 * @return
 *   An array of regions.
 */
/* -- Delete this line if you want to use this function
function SUBTHEME_regions() {
  return array(
    'left' => t('left sidebar'),
    'right' => t('right sidebar'),
    'navbar' => t('navigation bar'),
    'content_top' => t('content top'),
    'content_bottom' => t('content bottom'),
    'header' => t('header'),
    'footer' => t('footer'),
    'closure_region' => t('closure'),
  );
}
// */


/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */
/* -- Delete this line if you want to use this function
function zen_breadcrumb($breadcrumb) {
  return '<div class="breadcrumb">'. implode(' › ', $breadcrumb) .' ›</div>';
}
// */


/**
 * Override or insert PHPTemplate variables into the page templates.
 *
 * @param $vars
 *   A sequential array of variables to pass to the theme template.
 */
/* -- Delete this line if you want to use this function
function SUBTHEME_preprocess_page(&$vars) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert PHPTemplate variables into the node templates.
 *
 * @param $vars
 *   A sequential array of variables to pass to the theme template.
 */
/* -- Delete this line if you want to use this function
function SUBTHEME_preprocess_node(&$vars) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert PHPTemplate variables into the comment templates.
 *
 * @param $vars
 *   A sequential array of variables to pass to the theme template.
 */
/* -- Delete this line if you want to use this function
function SUBTHEME_preprocess_comment(&$vars) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert PHPTemplate variables into the block templates.
 *
 * @param $vars
 *   A sequential array of variables to pass to the theme template.
 */
/* -- Delete this line if you want to use this function
function SUBTHEME_preprocess_block(&$vars) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */


/**
 * Override the Drupal search form using the search-theme-form.tpl.php file.
 */
/* -- Delete this line if you want to use this function
function phptemplate_search_theme_form($form) {
  return _phptemplate_callback('search_theme_form', array('form' => $form), array('search-theme-form'));
}
// */

/**
 * Generate the HTML representing a given menu item ID.
 *
 * An implementation of theme_menu_item_link()
 *
 * @param $item
 *   array The menu item to render.
 * @param $link_item
 *   array The menu item which should be used to find the correct path.
 * @return
 *   string The rendered menu item.
 */
/* -- Delete this line if you want to use this function
function zen_menu_item_link($item, $link_item) {
  // If an item is a LOCAL TASK, render it as a tab
  $tab = ($item['type'] & MENU_IS_LOCAL_TASK) ? TRUE : FALSE;
  return l(
    $tab ? '<span class="tab">'. check_plain($item['title']) .'</span>' : $item['title'],
    $link_item['path'],
    !empty($item['description']) ? array('title' => $item['description']) : array(),
    !empty($item['query']) ? $item['query'] : NULL,
    !empty($link_item['fragment']) ? $link_item['fragment'] : NULL,
    FALSE,
    $tab
  );
}
// */

/**
 * Duplicate of theme_menu_local_tasks() but adds clear-block to tabs.
 */
/* -- Delete this line if you want to use this function
function zen_menu_local_tasks() {
  $output = '';

  if ($primary = menu_primary_local_tasks()) {
    $output .= '<ul class="tabs primary clear-block">'. $primary .'</ul>';
  }
  if ($secondary = menu_secondary_local_tasks()) {
    $output .= '<ul class="tabs secondary clear-block">'. $secondary .'</ul>';
  }

  return $output;
}
// */
