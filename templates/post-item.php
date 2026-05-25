<?php
$post_id = ! empty( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$post_class = ! empty( $args['class'] ) ? $args['class'] : '';
$big = get_post( $post_id );

$permalink = get_permalink( $big );
$title = esc_html( $big->post_title );
$excerpt = wp_trim_words( $big->post_excerpt ?: $big->post_content, 30 );

$categories = get_the_category( $big->ID );
$cat_names = ! empty( $categories ) ? wp_list_pluck( $categories, 'name' ) : [];
?>


<article class="post-card post-card--featured<?php echo ' ' . esc_html($post_class); ?>">
    <?php if ( has_post_thumbnail( $big ) ) : ?>
        <div class="post-card__thumbnail">
            <a href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
                <?php echo get_the_post_thumbnail( $big, 'large', [ 'class' => 'post-card__image' ] ); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="post-card__body">
        <?php if ( ! empty( $cat_names ) ) : ?>
            <div class="post-card__categories">
                <?php foreach ( $cat_names as $cat_name ) : ?>
                    <span class="post-card__category"><?php echo esc_html( $cat_name ); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <h3 class="post-card__title">
            <a class="post-card__link" href="<?php echo esc_url( $permalink ); ?>" aria-label="Read more about <?php echo $title; ?>">
                <?php echo $title; ?>
            </a>
        </h3>

        <p class="post-card__excerpt"><?php echo $excerpt; ?></p>
    </div>
</article>