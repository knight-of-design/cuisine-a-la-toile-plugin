<?php
/**
 * Advanced usage of http://codex.wordpress.org/The_Loop
 */

if (!isset($options)){
    $options = array();
}

$args = $options['query'];

if (!isset($args)){
    //DEFAULT OPTIONS
    $args =  array(
        'posts_per_page' => 3,
        'paged' => 1,
        'order' => 'DESC'
    );
}


$gallery_query = new WP_Query($args);

if ( $gallery_query->have_posts() ) :
    // Start the Loop
    while ($gallery_query->have_posts() ) : $gallery_query->the_post();

        ?>
        <article id="post-<?=the_ID()?>" <?php post_class(); ?>>

            <?php
            if ( has_post_thumbnail() ){ ?>
                <div class="preview">
                    <a href="<?php echo esc_url( get_permalink() );?>">
                        <?php the_post_thumbnail(array(400,400));
                        the_title( '<h1 class="entry-title">', '</h1>' );

                        ?>
                    </a>

                </div>
            <?php }

            ?>

        </article><!-- #post-## -->
        <?php


    endwhile;

else :

    ?>
    <div>No User Gallery Submissions</div>
    <?

endif;
// Enable nested loop functionality
wp_reset_postdata();
?>