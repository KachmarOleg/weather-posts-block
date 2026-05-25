<?php
function weather_posts_block_render( $attributes ): string
{
    ob_start();
    ?>

    <div class="weather-posts-block">
        <!-- Featured Posts -->
        <?php include plugin_dir_path( __FILE__ ) . '../templates/featured-posts.php'; ?>

        <!-- Weather Snippet -->
        <?php include plugin_dir_path( __FILE__ ) . '../templates/weather-snippet.php'; ?>
    </div>

    <?php
    return ob_get_clean();
}