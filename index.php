<?php
/**
 * Plugin Name: Weather and Posts
 * Description: Gutenberg block that displays selected posts and weather snippet.
 * Version: 1.0.0
 * Author: Oleh Kachmar
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/includes/render.php';

function weather_posts_block_register(): void
{
    wp_enqueue_style(
            'weather-posts-block-fonts',
            'https://fonts.googleapis.com/css2?family=Archivo:wght@100;200;300;400;500;600;700;800;900&display=swap',
            [],
            null
    );

    register_block_type(__DIR__, [
            'render_callback' => 'weather_posts_block_render',
    ]);
}

add_action('init', 'weather_posts_block_register');