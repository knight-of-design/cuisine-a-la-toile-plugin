<?php
if ( !function_exists('cuisine_plugin_shortcode__cuisine_creations' ) and !shortcode_exists('cuisine-creations')) {
    function cuisine_plugin_shortcode__cuisine_creations($options, $content = null){
        // Copy shortcode options to local variables
        $default_options =  array(
            'numposts' => 3,
            'mealcourse' => '',
            'chefusername' => ''
        );

        $shortcode_options = shortcode_atts($default_options, $options);

        $creations_options = array(
            'content' => $content,
            'query' => array(
                'posts_per_page' => $shortcode_options['numposts']
            )
        );
        // Render shortcode
        return cuisine_template_html('shortcodes/cuisine-creations',$creations_options);

    }

    add_shortcode('cuisine-creations','cuisine_plugin_shortcode__cuisine_creations');
}
?>
