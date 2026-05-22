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
function weather_posts_block_register(): void
{

    wp_register_script(
        'weather-posts-block-editor',
        plugins_url( 'block.js', __FILE__ ),
        array( 'wp-blocks', 'wp-element', 'wp-block-editor' ),
        filemtime( plugin_dir_path( __FILE__ ) . 'block.js' )
    );

    wp_enqueue_style(
        'weather-posts-block-fonts',
        'https://fonts.googleapis.com/css2?family=Archivo:wght@100;200;300;400;500;600;700;800;900&display=swap',
        [],
        null
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
function weather_posts_block_render( $attributes ): string
{
    $plugin_dir_path = plugin_dir_path( __FILE__ );

    $big_id     = !empty($attributes['bigPostId']) ? (int)$attributes['bigPostId'] : 0;
    $small1_id  = !empty($attributes['smallPost1Id']) ? (int)$attributes['smallPost1Id'] : 0;
    $small2_id  = !empty($attributes['smallPost2Id']) ? (int)$attributes['smallPost2Id'] : 0;

    ob_start();
    ?>

    <div class="weather-posts-block">
        <div class="container-grid">
            <?php $args = [ 'post_id' => $big_id ];
            if ( file_exists( $plugin_dir_path ) ) {
                include $plugin_dir_path . 'templates/post-item.php';
            } ?>

            <div class="small-posts">
                <?php $args = [ 'post_id' => $small1_id ];
                if ( file_exists( $plugin_dir_path ) ) {
                    include $plugin_dir_path . 'templates/post-item.php';
                } ?>

                <?php $args = [ 'post_id' => $small2_id ];
                if ( file_exists( $plugin_dir_path ) ) {
                    include $plugin_dir_path . 'templates/post-item.php';
                } ?>
            </div>
        </div>
    </div>

    <?php
    return ob_get_clean();
}