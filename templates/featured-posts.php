<?php
$plugin_dir_path = plugin_dir_path( __FILE__ );

$big_id = !empty($attributes['bigPostId']) ? (int)$attributes['bigPostId'] : 0;

$latest_post = get_posts([
    'numberposts' => 1,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
]);

$big_id = $latest_post[0]->ID;

$small1_id  = !empty($attributes['smallPost1Id']) ? (int)$attributes['smallPost1Id'] : 0;
$small2_id  = !empty($attributes['smallPost2Id']) ? (int)$attributes['smallPost2Id'] : 0;
?>

<div class="featured-posts">
    <div class="container-grid">
        <?php $args = [ 'post_id' => $big_id, 'class' => 'big-post' ];
        if ( file_exists( $plugin_dir_path ) && !empty($latest_post) ) {
            include $plugin_dir_path . '../templates/post-item.php';
        } ?>

        <div class="small-posts">
            <?php $args = [ 'post_id' => $small1_id, 'class' => 'small-post' ];
            if ( file_exists( $plugin_dir_path ) ) {
                include $plugin_dir_path . '../templates/post-item.php';
            } ?>

            <?php $args = [ 'post_id' => $small2_id, 'class' => 'small-post' ];
            if ( file_exists( $plugin_dir_path ) ) {
                include $plugin_dir_path . '../templates/post-item.php';
            } ?>
        </div>
    </div>
</div>