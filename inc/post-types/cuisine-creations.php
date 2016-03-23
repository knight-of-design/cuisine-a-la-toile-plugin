<?php
//Register Custom Taxonomy
if ( !function_exists('cuisine_register_creations_taxonomy' ) ) {
function cuisine_register_creations_taxonomy(){
register_taxonomy(
		'cuisine_creation_meal_course',
		'cuisine_creation',
		array(
			'labels' => array(
					'name' =>	__( 'Meal Courses', 'cuisine-a-la-toile'),
          'singular_name' => __( 'Meal Course', 'cuisine-a-la-toile'),
					'all_items' => __( 'All Meal Courses' , 'cuisine-a-la-toile'),
					'edit_item'  => __( 'Edit Meal Course', 'cuisine-a-la-toile' ),
					'view_item' => __( 'View Meal Course' , 'cuisine-a-la-toile'),
					'update_item'  => __( 'Update Meal Course', 'cuisine-a-la-toile' ),
					'add_new_item'  => __( 'Add New Meal Course', 'cuisine-a-la-toile' ),
					'new_item_name'  => __( 'New Meal Course Name', 'cuisine-a-la-toile' ),
					'search_items' =>  __( 'Search Meal Courses', 'cuisine-a-la-toile' ),
					'not_found' => __( 'No Meal Courses found.', 'cuisine-a-la-toile' )

				),
			'rewrite' => array( 'slug' => 'creation-course'),
			'public' => true,
			'show_ui' => true,
			'hierarchical' => true,
		));
  }

  add_action('init', 'cuisine_register_creations_taxonomy', 0);
}

// Register Community Creations Custom Post Type
if ( !function_exists('cuisine_register_creations' ) ) {
    function cuisine_register_creations(){
        register_post_type('cuisine_creation', array(
            'label' => __('Creations','cuisine-a-la-toile') ,
            'labels' => array(
                'name' => __( 'Creations', 'cuisine-a-la-toile' ),
                'singular_name' => __( 'Creation', 'cuisine-a-la-toile')
            ),
            'taxonomies' => array('cuisine_creation_meal_course'),
            'hierarchical' => true,
            'public' => true,
            'menu_position' => 9,
            'has_archive' => true,
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
            'publicly_queryable' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'rewrite' => array('slug' => 'creation'),
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
