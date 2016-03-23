<?php
// Register Community Creations Custom Post Type
if ( !function_exists('cuisine_register_creations' ) ) {
    function cuisine_register_creations(){
        register_post_type('cuisine_creations', array(
            'label' => __('Creations','cuisine-a-la-toile') ,
            'labels' => array(
                'name' => __( 'Creations', 'cuisine-a-la-toile' ),
                'singular_name' => __( 'Community Creation', 'cuisine-a-la-toile')
            ),
            'hierarchical' => true,
            'public' => true,
            'menu_position' => 9,
            'has_archive' => true,
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
            'publicly_queryable' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'rewrite' => array('slug' => 'creations'),
        ));
    }

    add_action('init', 'cuisine_register_creations', 0);
}

if ( !function_exists('cuisine_render_creations' ) ) {
    function cuisine_render_creations($options = array())
    {
        return cuisine_template_html('cuisine-creations', $options);
    }
}
?>