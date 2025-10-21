<?php
add_action('wp_enqueue_scripts', function () {
  $theme = wp_get_theme();

  // Google Fonts per assignment (Roboto & Roboto Condensed)
  wp_enqueue_style(
    'airfleet-fonts',
    'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Roboto+Condensed:wght@400;700&display=swap',
    [],
    null
  );

  // Base CSS + JS
  wp_enqueue_style('airfleet-wpfs', get_template_directory_uri() . '/dist/styles.css', ['airfleet-fonts'], $theme->get('Version'));
  wp_enqueue_script('airfleet-wpfs', get_template_directory_uri() . '/dist/main.js', [], $theme->get('Version'), true);
});
