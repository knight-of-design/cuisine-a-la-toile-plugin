<?php
if (!function_exists('cuisine_plugin_shortcode__cuisine_creations') and !shortcode_exists('cuisine-creations')) {
    function cuisine_plugin_shortcode__cuisine_creations($options, $content = null)
    {
        // Copy shortcode options to local variables
        $default_options = array(
            'numposts' => 1,
            'order' => 'DESC',
            'mealcourse' => '',
            'chefusername' => ''
        );

        $shortcode_options = shortcode_atts($default_options, $options);

        $meta_query = null;
        if ($shortcode_options['chefusername']) {
            $meta_query = array(
                'relation' => 'AND',
                array(
                    'key' => 'Chef Username',
                    'value' => array($shortcode_options['chefusername']),
                    'compare' => 'IN',
                )
            );
        }

        $tax_query = null;
        if ($shortcode_options['mealcourse']) {
            $tax_query = array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'cuisine_creation_meal_course',
                    'field' => 'slug',
                    'terms' => $shortcode_options['mealcourse']
                )
            );
        }
        $creations_options = array(
            'content' => $content,
            'query' => array(
                'posts_per_page' => $shortcode_options['numposts'],
                'order' => $shortcode_options['order'],
                'tax_query' => $tax_query,
                'meta_query' => $meta_query
            )
        );
        // Render shortcode
        return cuisine_template_html('shortcodes/cuisine-creations', $creations_options);

    }

    add_shortcode('cuisine-creations', 'cuisine_plugin_shortcode__cuisine_creations');
}
?>
