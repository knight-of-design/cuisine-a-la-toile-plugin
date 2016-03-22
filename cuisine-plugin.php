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
            'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
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

/**
 * WIDGETS
 * TODO: REMOVE ANY CODE-DIVA REFERENCES FROM THIS WIDGET EXAMPLE
 * TODO: Replace 'codediva' with 'cusine-a-la-toile'
 * TODO: MAKE THIS WIDGET OUR OWN (eg replace description etc.)
 */

// Subscriber Gallery Widget
class CDYearlyArchivesWidget extends WP_Widget {

    // Initialize the Widget
    public function __construct() {
        $widget_ops = array(
            'classname' => 'widget_archive',
            'description' => __( 'A yearly archive of your site&#8217;s posts.', 'codediva')
        );
        // Adds a class to the widget and provides a description on the Widget page to describe what the widget does.
        parent::__construct('yearly_archives', __('Cuisine Widget', 'cuisine-a-la-toile'), $widget_ops);
    }


    // Determines what will appear on the site
    public function widget( $args, $instance ) {
        $c = ! empty( $instance['count'] ) ? '1' : '0';
        //sets a variable for whether or not the 'Count' option is checked
        $d = ! empty( $instance['dropdown'] ) ? '1' : '0';
        // sets a variable for whether or not the 'Dropdown' option is checked
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Yearly Archives', 'codediva') : $instance['title'], $instance, $this->id_base);
        // Determines if there's a user-provided title and if not, displays a default title.

        echo $args['before_widget']; // what's set up when you registered the sidebar

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        if ( $d ) {
            //if the dropdown option is checked, gets a list of the archives and displays them by year in a dropdown list.
            $dropdown_id = "{$this->id_base}-dropdown-{$this->number}";
            ?>
            <label class="screen-reader-text" for="<?php echo esc_attr( $dropdown_id ); ?>"><?php echo $title; ?></label>
            <select id="<?php echo esc_attr( $dropdown_id ); ?>" name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'>

                <?php	$dropdown_args = apply_filters( 'widget_archives_dropdown_args', array(
                    'type'            => 'yearly',
                    'format'          => 'option',
                    'show_post_count' => $c // If post count checked, show the post count
                ) );
                ?>
                <option value="<?php echo __( 'Select Year', 'codediva' ); ?>"><?php echo __( 'Select Year', 'codediva' ); ?></option>
                <?php wp_get_archives( $dropdown_args ); ?>
            </select>
            <?php
        } else {
            // If (d) not selected, show this:
            ?>
            <ul>
                <?php
                wp_get_archives( apply_filters( 'widget_archives_args', array(
                    'type'            => 'yearly',
                    'show_post_count' => $c
                ) ) );
                // gets a list of the archives and displays them by year. If the Count option is checked, this gets shown.
                ?>
            </ul>

            <?php
        }

        echo $args['after_widget']; // what's set up when you registered the sidebar
    }

    // Sets up the form for users to set their options/add content in the widget admin page

    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
        $title = strip_tags($instance['title']);
        $count = $instance['count'] ? 'checked="checked"' : '';
        $dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'codediva'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php echo $dropdown; ?> id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>" />
            <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e('Display as dropdown', 'codediva'); ?></label>
            <br/>
            <input class="checkbox" type="checkbox" <?php echo $count; ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" />
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Show post count', 'codediva'); ?></label>
        </p>
    <?php }

    // Sanitizes, saves and submits the user-generated content.

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = $new_instance['count'] ? 1 : 0;
        $instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;

        return $instance;
    }
}

// Tells WordPress that this widget has been created and that it should display in the list of available widgets.

add_action( 'widgets_init', function(){
    register_widget( 'CDYearlyArchivesWidget' );
});

/**
 * SHORTCODES
 */
// TODO: UPDATE SHORTCODES
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