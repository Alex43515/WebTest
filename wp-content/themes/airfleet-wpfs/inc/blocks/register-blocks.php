<?php
add_action('acf/init', function () {
  if (!function_exists('acf_register_block_type')) return;
  require_once __DIR__ . '/hero-feature/acf-fields.php';
  acf_register_block_type([
    'name' => 'hero-feature',
    'title' => __('Hero Feature', 'airfleet-wpfs'),
    'description' => __('Feature section with text and image, two orientations', 'airfleet-wpfs'),
    'render_template' => __DIR__ . '/hero-feature/render.php',
    'category' => 'layout',
    'icon' => 'layout',
    'keywords' => ['hero','feature','image','text'],
    'supports' => ['align' => ['full','wide','center'], 'jsx' => true],
    'enqueue_assets' => function(){
      wp_enqueue_script('airfleet-hero-feature', get_template_directory_uri() . '/src/js/hero-feature.js', [], wp_get_theme()->get('Version'), true);
      wp_enqueue_style('airfleet-hero-feature', get_template_directory_uri() . '/dist/hero-feature.css', [], wp_get_theme()->get('Version'));
    }
  ]);
});
