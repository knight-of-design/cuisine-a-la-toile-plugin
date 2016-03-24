<?php
/**
 * Advanced usage of http://codex.wordpress.org/The_Loop
 */

if (!isset($query)){
    $query = array();
}

$tax_query = $query['tax_query'];
$meta_query = $query['meta_query'];

//MERGE DEFAULT OPTIONS
$query =  array(
    'post_type' =>  'cuisine_creation',
    'posts_per_page' => $query['posts_per_page']? $query['posts_per_page'] : 3,
    'paged' => $query['paged'] ? $query['paged'] : 1,
    'order' =>  $query['order'] ? $query['order'] : 'DESC'
);

if (isset($tax_query)){
    $query['tax_query'] = $tax_query;
}
if (isset($meta_query)){
    $query['meta_query'] = $meta_query;
}


$gallery_query = new WP_Query($query);

if ( $gallery_query->have_posts() ) :
    // Start the Loop
    while ($gallery_query->have_posts() ) : $gallery_query->the_post();

        ?>
        <article id="post-<?=the_ID()?>" <?php post_class('cuisine-creation'); ?>>

            <?php
            if ( has_post_thumbnail() ){ ?>
                <div class="preview">
                    <a href="<?= esc_url( get_permalink() );?>">
                        <?php
                        the_post_thumbnail(array(400,400));

                        ?>
                    </a>

                </div>
            <?php }




            ?>

            <a class="creation-link" href="<?php echo esc_url( get_permalink() );?>">
                <?php
                the_title( '<h1 class="entry-title cuisine-hidden">', '</h1>' );

                ?>
                    <span class="recipe-name">
                    <?=get_post_meta(get_the_ID(),'Recipe Name',true) ?>
                        </span>
                by
                <span class="chef-name"> <?=get_post_meta(get_the_ID(),'Chef Name',true) ?></span>
                <span class="chef-username">@<?=get_post_meta(get_the_ID(),'Chef Username',true) ?></span>

            </a>

            <?php
            $recipe_link = get_post_meta(get_the_ID(),'Recipe Link',true);

            if ($recipe_link) {
                ?>
                <a class="recipe-link" href="<?=esc_url($recipe_link)?>">See Recipe</a>
                <?php
            }
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
