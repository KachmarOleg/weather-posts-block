<?php
/**
 * Plugin Name: Weather Posts Block
 */

if (!defined('ABSPATH')) exit;

require_once __DIR__ . '/includes/render.php';

function weather_posts_block_init() {
    register_block_type(__DIR__);
}
add_action('init', 'weather_posts_block_init');