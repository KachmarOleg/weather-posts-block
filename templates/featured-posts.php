<?php
$plugin_dir_path = plugin_dir_path( __FILE__ );

$latest_posts = get_posts([
        'numberposts' => 1,
        'post_status' => 'publish',
        'orderby'     => 'date',
        'order'       => 'DESC',
]);
$big_id = !empty($latest_posts) ? (int)$latest_posts[0]->ID : 0;

$small1_id = !empty($attributes['smallPost1Id']) ? (int)$attributes['smallPost1Id'] : 0;
$small2_id = !empty($attributes['smallPost2Id']) ? (int)$attributes['smallPost2Id'] : 0;

$post_item_template = $plugin_dir_path . '../templates/post-item.php';
?>

<div class="featured-posts">
    <div class="container-grid">
        <?php
        if ( $big_id && file_exists( $post_item_template ) ) {
            $args = [ 'post_id' => $big_id, 'class' => 'big-post' ];
            include $post_item_template;
        } ?>

        <div class="small-posts">
            <?php
            if ( $small1_id && file_exists( $post_item_template ) ) {
                $args = [ 'post_id' => $small1_id, 'class' => 'small-post' ];
                include $post_item_template;
            }

            if ( $small2_id && file_exists( $post_item_template ) ) {
                $args = [ 'post_id' => $small2_id, 'class' => 'small-post' ];
                include $post_item_template;
            } ?>
        </div>
    </div>
</div>