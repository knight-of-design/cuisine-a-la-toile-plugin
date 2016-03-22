<?php
/*
Plugin Name: Cuisine a la Toile Plugin
Plugin URI:  https://github.com/knight-of-design/cuisine-a-la-toile-plugin
Description: TODO:SHORT DESCRIPTION GOES HERE
Version:     1.0
Author:      TODO:AUTHORS HERE
Author URI:  https://knight-of-design.github.io
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: cuisine-a-la-toile
Domain Path: /languages

References for Plugin Development:
TODO: ADD ANY REFERENCES TO CODE HERE
https://developer.wordpress.org/plugins/the-basics/best-practices/
https://codex.wordpress.org/Writing_a_Plugin
https://developer.wordpress.org/plugins/the-basics/header-requirements/
https://codex.wordpress.org/I18n_for_WordPress_Developers
https://developer.wordpress.org/plugins/internationalization/how-to-internationalize-your-plugin/
*/

// TODO: COMMENT CODE
// For security reasons, prevent PHP code from being executed as standalone file per the recommendation WordPress Codex
defined( 'ABSPATH' ) or die( 'Plugin protected from unauthorized access' );

// Allow for flexible plugin folder naming
$PLUGIN_DIR = plugin_dir_url(__FILE__);

// Initialize the plugin
if ( !function_exists('cuisine_plugin_init' ) ) {
    function cuisine_plugin_init(){
        //TODO: INITIALIZATION LOGIC HERE
    }

    cuisine_plugin_init();
}

// Initialize Subscriber Gallery
if ( !function_exists('cuisine_subscriber_gallery_init' ) ) {
    function cuisine_subscriber_gallery_init(){
        register_post_type('cuisine_subscriber_gallery', array(
            'labels' => array(
                'name' => __( 'Subscriber Gallery', 'cuisine-a-la-toile' ),
                'singular_name' => __( 'Subscriber Gallery', 'cuisine-a-la-toile')
            ),
            'hierarchical'        => false,
            'public' => true,
            'has_archive' => true,
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
            'menu_position'       => 3,
            'publicly_queryable' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'rewrite' => array('slug' => 'subscriber_gallery'),
        ));
    }

    add_action('init', 'cuisine_subscriber_gallery_init');
}

// Enqueue Assets such as CSS
if ( !function_exists('sweet_plugin_enqueue_assets' ) ) {
    function cuisine_plugin_enqueue_assets(){
        global $PLUGIN_DIR;
        wp_enqueue_style( 'cuisine-plugin', $PLUGIN_DIR.'css/style.css' );
    }

    add_action( 'wp_enqueue_scripts', 'cuisine_plugin_enqueue_assets' );
}

if ( !function_exists('cuisine_plugin_shortcode__cuisine_box' ) and !shortcode_exists('cuisine-box')) {
    function cuisine_plugin_shortcode__cuisine_box($options, $content = null){
        // Copy shortcode options to local variables
        extract( shortcode_atts( array(
            'text' => 'default',
            'custom' => 'inherit'
        ), $options) );

        // Render shortcode
        return '<style type="text/css">div.cuisine-box {color:'.$custom.';}</style><div class="cuisine-box text-'.$text.'">'.do_shortcode($content).'</div>';
    }

    add_shortcode('cuisine-box','cuisine_plugin_shortcode__cuisine_box');
}


if ( !function_exists('cuisine_plugin_shortcode__cuisine_icon' ) and !shortcode_exists('cuisine-icon')) {
    function cuisine_plugin_shortcode__cuisine_icon($options){
        // Copy shortcode options to local variables
        extract( shortcode_atts( array(
            'icon' => '',
        ), $options) );

        // Render shortcode
        return '<i class="cuisine-icon fa fa-'.$icon.'"></i>';
    }

    add_shortcode('cuisine-icon','cuisine_plugin_shortcode__cuisine_icon');
}
?>