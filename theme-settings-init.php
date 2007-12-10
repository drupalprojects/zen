<?php
// $Id$

if (is_null(theme_get_setting('zen_wireframes'))) {
  global $theme_key;
  // Save default theme settings
  $defaults = array(
    'zen_breadcrumb' => 'yes',
    'zen_breadcrumb_separator' => ' › ',
    'zen_breadcrumb_home' => 1,
    'zen_breadcrumb_trailing' => 1,
    'zen_layout' => 'slurpy-liquid',
    'zen_wireframes' => 0,
  );
  variable_set(
    str_replace('/', '_', 'theme_'. $theme_key .'_settings'),
    array_merge($defaults, theme_get_settings($theme_key))
  );
  // Force refresh of Drupal internals
  theme_get_setting('', TRUE);
}
