<?php
// $Id$

/**
 * @file
 * File which contains theme overrides for the Zen theme.
 *
 * ABOUT
 *
 * The template.php file is one of the most useful files when creating or
 * modifying Drupal themes. You can add new regions for block content, modify or
 * override Drupal's theme functions, intercept or make additional variables
 * available to your theme, and create custom PHP logic. For more information,
 * please visit the Theme Developer's Guide on Drupal.org:
 * http://drupal.org/theme-guide
 */


/*
 * To make this file easier to read, we split up the code into managable parts.
 * Theme developers are likely to only be interested in functions that are in
 * this main template.php file.
 */

// Initialize theme settings
include_once 'theme-settings-init.php';

// Sub-theme support
include_once 'template-subtheme.php';

// Tabs and menu functions
include_once 'template-menus.php';

/**
 * Declare the available regions implemented by this engine.
 *
 * Regions are areas in your theme where you can place blocks. The default
 * regions used in themes are "left sidebar", "right sidebar", "header", and
 * "footer", although you can create as many regions as you want. Once declared,
 * they are made available to the page.tpl.php file as a variable. For instance,
 * use <?php print $header ?> for the placement of the "header" region in
 * page.tpl.php.
 *
 * By going to the administer > site building > blocks page you can choose
 * which regions various blocks should be placed. New regions you define here
 * will automatically show up in the drop-down list by their human readable name.
 *
 * @return
 *   An array of regions. The first array element will be used as the default
 *   region for themes. Each array element takes the format:
 *   variable_name => t('human readable name')
 */
function zen_regions() {
  // Allow a sub-theme to add/alter variables
  global $theme_key;
  if ($theme_key != 'zen') {
    $function = str_replace('-', '_', $theme_key) .'_regions';
    if (function_exists($function)) {
      return call_user_func($function);
    }
  }

  return array(
       'left' => t('left sidebar'),
       'right' => t('right sidebar'),
       'content_top' => t('content top'),
       'content_bottom' => t('content bottom'),
       'header' => t('header'),
       'footer' => t('footer'),
  );
}


/*
 * OVERRIDING THEME FUNCTIONS
 *
 * The Drupal theme system uses special theme functions to generate HTML output
 * automatically. Often we wish to customize this HTML output. To do this, we
 * have to override the theme function. You have to first find the theme
 * function that generates the output, and then "catch" it and modify it here.
 * The easiest way to do it is to copy the original function in its entirety and
 * paste it here, changing the prefix from theme_ to zen_. For example:
 *
 *   original: theme_breadcrumb()
 *   theme override: zen_breadcrumb()
 *
 * See the following example. In this theme, we want to change all of the
 * breadcrumb separator links from >> to ::
 */


/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */
function phptemplate_breadcrumb($breadcrumb) {
  $show_breadcrumb = theme_get_setting('zen_breadcrumb');
  $show_breadcrumb_home = theme_get_setting('zen_breadcrumb_home');
  $breadcrumb_separator = theme_get_setting('zen_breadcrumb_separator');
  if ($show_breadcrumb == 'yes' || $show_breadcrumb == 'admin' && arg(0) == 'admin') {
    if (!$show_breadcrumb_home) {
      // Get rid of homepage link
      array_shift($breadcrumb);
    }
    if (!empty($breadcrumb)) {
      return '<div class="breadcrumb">'. implode($breadcrumb_separator, $breadcrumb) ."$breadcrumb_separator</div>";
    }
  }
  return '';
}


/*
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 * The most powerful function available to themers is _phptemplate_variables().
 * It allows you to pass newly created variables to different template (tpl.php)
 * files in your theme. Or even unset ones you don't want to use.
 *
 * It works by switching on the hook, or name of the theme function, such as:
 *   - page
 *   - node
 *   - comment
 *   - block
 *
 * By switching on this hook you can send different variables to page.tpl.php
 * file, node.tpl.php (and any other derivative node template file, like
 * node-forum.tpl.php), comment.tpl.php, and block.tpl.php.
 */


/**
 * Intercept template variables
 *
 * @param $hook
 *   The name of the theme function being executed
 * @param $vars
 *   A sequential array of variables passed to the theme function.
 */
function _phptemplate_variables($hook, $vars = array()) {
  // Get the currently logged in user
  global $user;

  // Set a new $is_admin variable. This is determined by looking at the
  // currently logged in user and seeing if they are in the role 'admin'. The
  // 'admin' role will need to have been created manually for this to work this
  // variable is available to all templates.
  $vars['is_admin'] = in_array('admin', $user->roles);

  switch ($hook) {
    case 'page':
      global $theme, $theme_key;

      // If we're in the main theme
      if ($theme == $theme_key) {
        // These next lines add additional CSS files and redefine
        // the $css and $styles variables available to your page template
        // We had previously used @import declarations in the css files,
        // but these are incompatible with the CSS caching in Drupal 5
        drupal_add_css($vars['directory'] .'/layout.css', 'theme', 'all');
        drupal_add_css($vars['directory'] .'/tabs.css', 'theme', 'all');
        $vars['css'] = drupal_add_css($vars['directory'] .'/print.css', 'theme', 'print');
        $vars['styles'] = drupal_get_css();
      }

      // Send a new variable, $logged_in, to page.tpl.php to tell us if the
      // current user is logged in or out. An anonymous user has a user id of 0.
      $vars['logged_in'] = ($user->uid > 0) ? TRUE : FALSE;

      // Classes for body element. Allows advanced theming based on context
      // (home page, node of certain type, etc.)
      $body_classes = array();
      $body_classes[] = ($vars['is_front']) ? 'front' : 'not-front';
      $body_classes[] = ($vars['logged_in']) ? 'logged-in' : 'not-logged-in';
      if ($vars['node']->type) {
        // If on an individual node page, put the node type in the body classes
        $body_classes[] = 'node-type-'. zen_id_safe($vars['node']->type);
      }
      if ($vars['sidebar_left'] && $vars['sidebar_right']) {
        $body_classes[] = 'two-sidebars';
      }
      elseif ($vars['sidebar_left']) {
        $body_classes[] = 'one-sidebar sidebar-left';
      }
      elseif ($vars['sidebar_right']) {
        $body_classes[] = 'one-sidebar sidebar-right';
      }
      else {
        $body_classes[] = 'no-sidebars';
      }
      $vars['body_classes'] = implode(' ', $body_classes); // implode with spaces

      break;

    case 'node':
      if ($vars['submitted']) {
        // We redefine the format for submitted.
        $vars['submitted'] =
          t('Posted <abbr class="created" title="!microdate">@date</abbr> by !username',
            array(
              '!username' => theme('username', $vars['node']),
              '@date' => format_date($vars['node']->created,'custom', "F jS, Y"),
              '!microdate' => format_date($vars['node']->created,'custom', "Y-m-d\TH:i:sO"),
            )
          );
      }

      // In this section you can also edit the following variables:
      // $vars['links']

      // Special classes for nodes
      $node_classes = array('node');
      if ($vars['sticky']) {
        $node_classes[] = 'sticky';
      }
      if (!$vars['node']->status) {
        $node_classes[] = 'node-unpublished';
      }
      if ($vars['node']->uid && $vars['node']->uid == $user->uid) {
        // Node is authored by current user
        $node_classes[] = 'node-mine';
      }
      // Class for node type: "node-type-page", "node-type-story", "node-type-my-custom-type", etc.
      $node_classes[] = 'node-type-'. zen_id_safe($vars['node']->type);
      $vars['node_classes'] = implode(' ', $node_classes); // implode with spaces

      break;

    case 'comment':
      // We load the node object that the current comment is attached to
      $node = node_load($vars['comment']->nid);
      // If the author of this comment is equal to the author of the node, we
      // set a variable so we can theme this comment uniquely.
      $vars['author_comment'] = $vars['comment']->uid == $node->uid ? TRUE : FALSE;

      $comment_classes = array('comment');

      // Odd/even handling
      static $comment_odd = TRUE;
      $comment_classes[] = $comment_odd ? 'odd' : 'even';
      $comment_odd = !$comment_odd;

      if ($vars['comment']->status == COMMENT_NOT_PUBLISHED) {
        $comment_classes[] = 'comment-unpublished';
      }
      if ($vars['author_comment']) {
        // Comment is by the node author
        $comment_classes[] = 'comment-by-author';
      }
      if ($vars['comment']->uid == 0) {
        // Comment is by an anonymous user
        $comment_classes[] = 'comment-by-anon';
      }
      if ($user->uid && $vars['comment']->uid == $user->uid) {
        // Comment was posted by current user
        $comment_classes[] = 'comment-mine';
      }
      $vars['comment_classes'] = implode(' ', $comment_classes);

      // If comment subjects are disabled, don't display 'em
      if (variable_get('comment_subject_field', 1) == 0) {
        $vars['title'] = '';
      }

      break;
  }

  // Allow a sub-theme to add/alter variables
  if (function_exists('zen_variables')) {
    $vars = zen_variables($hook, $vars);
  }

  return $vars;
}

/**
 * Converts a string to a suitable html ID attribute.
 *
 * - Preceeds initial numeric with 'n' character.
 * - Replaces space and underscore with dash.
 * - Converts entire string to lowercase.
 * - Works for classes too!
 *
 * @param string $string
 *   The string
 * @return
 *   The converted string
 */
function zen_id_safe($string) {
  if (is_numeric($string{0})) {
    // If the first character is numeric, add 'n' in front
    $string = 'n'. $string;
  }
  return strtolower(preg_replace('/[^a-zA-Z0-9-]+/', '-', $string));
}
