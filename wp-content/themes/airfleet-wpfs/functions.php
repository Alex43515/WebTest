<?php
require_once __DIR__ . '/inc/setup.php';
require_once __DIR__ . '/inc/assets.php';
require_once __DIR__ . '/inc/blocks/register-blocks.php';
add_action('wp_enqueue_scripts', function () {
  $path = get_stylesheet_directory() . '/dist/styles.css';
  wp_enqueue_style(
    'airfleet-main',
    get_stylesheet_directory_uri() . '/dist/styles.css',
    [],
    file_exists($path) ? filemtime($path) : null
  );
});