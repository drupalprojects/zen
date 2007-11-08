<?php
// $Id$

/**
 * Implementation of THEMEHOOK_settings() function.
 *
 * @param $saved_settings
 *   array An array of saved settings for this theme.
 * @return
 *   array A form array.
 */
function zen_settings($saved_settings) {

  // Add javascript to show/hide optional settings
  drupal_add_js(path_to_theme().'/theme-settings.js', 'theme');

  // The default values for the theme variables
  $defaults = array(
    'zen_breadcrumb' => 'yes',
    'zen_breadcrumb_home' => 1,
    'zen_breadcrumb_separator' => ' › ',
  );

  // Merge the saved variables and their default values
  $settings = array_merge($defaults, $saved_settings);

  /*
   * Create the form using Form API
   */
  $form['breadcrumb'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Breadcrumb settings'),
  );
  $form['breadcrumb']['zen_breadcrumb'] = array(
    '#type'          => 'select',
    '#title'         => t('Display breadcrumb'),
    '#default_value' => $settings['zen_breadcrumb'],
    '#options'       => array(
                          'yes'   => 'Yes',
                          'admin' => 'Only in admin section',
                          'no'    => 'No',
                        ),
  );
  $form['breadcrumb']['zen_breadcrumb_home'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Show home page link in breadcrumb'),
    '#default_value' => $settings['zen_breadcrumb_home'],
    '#prefix'        => '<div id="div-zen-breadcrumb">', // jquery hook to show/hide optional widgets
  );
  $form['breadcrumb']['zen_breadcrumb_separator'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Breadcrumb separator'),
    '#description'   => 'Text only. Don’t forget to include spaces.',
    '#default_value' => $settings['zen_breadcrumb_separator'],
    '#size'          => 5,
    '#maxlength'     => 10,
    '#suffix'        => '</div>', // #div-zen-breadcrumb
  );

  // Return the form
  return $form;
}
