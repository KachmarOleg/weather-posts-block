<?php
/**
 * Plugin Name: Weather and Posts
 * Description: Gutenberg block that displays selected posts and weather snippet.
 * Version: 1.0.0
 * Author: Oleh Kachmar
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register Gutenberg block
function weather_posts_block_register() {

    wp_register_script(
        'weather-posts-block-editor',
        plugins_url( 'block.js', __FILE__ ),
        array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
        filemtime( plugin_dir_path( __FILE__ ) . 'block.js' )
    );

    wp_register_style(
        'weather-posts-block-style',
        plugins_url( 'styles/block.css', __FILE__ ),
        array(),
        filemtime( plugin_dir_path( __FILE__ ) . 'styles/block.css' )
    );

    register_block_type(
        'custom/weather-posts-block',
        array(
            'editor_script'   => 'weather-posts-block-editor',
            'style'           => 'weather-posts-block-style',
            'render_callback' => 'weather_posts_block_render',
        )
    );
}

add_action( 'init', 'weather_posts_block_register' );

// Render block
function weather_posts_block_render( $attributes, $content ) {

    ob_start();
    ?>

    <div class="weather-posts-block">
        <div class="container">
            <h2>Hello world</h2>
        </div>
    </div>

    <?php
    return ob_get_clean();
}