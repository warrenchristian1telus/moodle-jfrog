<?php

// Every file should have GPL and copyright in the header - we skip it in tutorials but you should not skip it for real.

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

// We will add callbacks here as we add features to our theme.
function theme_bcgov_get_extra_scss($theme) {
    // Load the settings from the parent.
    $theme = theme_config::load('boost');
    // Call the parent themes get_extra_scss function.
    return theme_boost_get_extra_scss($theme);
}

function theme_photo_get_main_scss_content($theme) {
  global $CFG;

  $scss = '';
  $filename = !empty($theme->settings->preset) ? $theme->settings->preset : null;
  $fs = get_file_storage();
  $context = context_system::instance();

  if ($filename == 'default.scss') {
    // We still load the default preset files directly from the boost theme. No sense in duplicating them.
    $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');

  } else if ($filename == 'plain.scss') {
    // We still load the default preset files directly from the boost theme. No sense in duplicating them.
    $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/plain.scss');

  } else if ($filename && ($presetfile = $fs->get_file($context->id, 'theme_bcgov', 'preset', 0, '/', $filename))) {
    // This preset file was fetched from the file area for theme_photo and not theme_boost (see the line above).
    $scss .= $presetfile->get_content();

  } else {
    // Safety fallback - maybe new installs etc.
    $scss .= file_get_contents($CFG->dirroot . '/theme/boost/scss/preset/default.scss');
  }

  return $scss;
}
