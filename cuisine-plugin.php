<?php
/*
Plugin Name: Cuisine a la Toile Plugin
Plugin URI:  https://github.com/knight-of-design/cuisine-a-la-toile-plugin
Description: This plugin is a package that contains a shortcode, widget and custom post type
             The shortcode creates a timer that will allow users to start a timer via javascript
Version:     1.0
Author:      James Knight, Christina Morden, and Nicole Di Carlo
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

// Initializes the plugin
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
            'hierarchical' => false,
            'public' => true,
            'has_archive' => true,
            'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
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
    wp_enqueue_style( 'wpb-google-fonts', 'https://fonts.googleapis.com/css?family=Parisienne|Tangerine|Cookie', false );
    }

    add_action( 'wp_enqueue_scripts', 'cuisine_plugin_enqueue_assets' );
}

/**
 * WIDGET
 * This widget setup and comments were referenced from Lecture 10 CCT460 Building a WordPress Widget
 **/

// Creates the Subscriber Gallery Widget
class SubscriberGalleryWidget extends WP_Widget {

    // Initializes the Widget
    public function __construct() {
        $widget_ops = array(
            'classname' => 'widget_archive',
            'description' => __( 'A subscriber gallery of recent posts on Cuisine a la toile site&#8217;s.', 'cuisine-a-la-toile')
        );
        // Adds a class to the widget
        // Provides a description on the Widget page explaining the widget's purpose
        parent::__construct('subscriber_archives', __('Cuisine Widget', 'cuisine-a-la-toile'), $widget_ops);
    }


    // Determines what will appear on the site
    public function widget( $args, $instance ) {
        $c = ! empty( $instance['count'] ) ? '1' : '0';
        //sets a variable for the 'Count' option
        $d = ! empty( $instance['dropdown'] ) ? '1' : '0';
        // sets a variable for the 'Dropdown' option
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Subscriber Gallery Submissions', 'cuisine-a-la-toile') : $instance['title'], $instance, $this->id_base);
        // Determines whether a title is provided by the user. If this is not provided, the default title is displayed

        echo $args['before_widget']; // Appears once the sidebar is registered.

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        // Post Query

        $args = array(
            'posts_per_page' => 3,
            'paged' => 1,
            'order' => 'DESC'
        );
        $gallery_query = new WP_Query($args);

        if ( $gallery_query->have_posts() ) :
            // Start the Loop
            while ($gallery_query->have_posts() ) : $gallery_query->the_post();

                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

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


        if ( $d ) {
            //if the dropdown option is checked, a list of the subcriber gallery posts are displayed by year in a dropdown list.
            $dropdown_id = "{$this->id_base}-dropdown-{$this->number}";
            ?>
            <label class="screen-reader-text" for="<?php echo esc_attr( $dropdown_id ); ?>"><?php echo $title; ?></label>
            <select id="<?php echo esc_attr( $dropdown_id ); ?>" name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'>

                <?php	$dropdown_args = apply_filters( 'widget_archives_dropdown_args', array(
                    'type'            => 'yearly',
                    'format'          => 'option',
                    'show_post_count' => $c // If post count is checked, the post count will be shown.
                ) );
                ?>
                <option value="<?php echo __( 'Select a Year', 'cuisine-a-la-toile' ); ?>"><?php echo __( 'Select a Year', 'cuisine-a-la-toile' ); ?></option>
                <?php wp_get_archives( $dropdown_args ); ?>
            </select>
            <?php
        } else {
            // If this option is not selected then this is shown instead:
            ?>
            <ul>
                <?php
                wp_get_archives( apply_filters( 'widget_archives_args', array(
                    'type'            => 'yearly',
                    'show_post_count' => $c
                ) ) );
                // Gets a list of the posts and displays them by year. If the Count option is checked, this gets shown.
                ?>
            </ul>

            <?php
        }

        echo $args['after_widget']; // Appears once the sidebar is registered.
    }

    // Form Set up. Allows users to customize the widget in the widget admin page.
    // Backend Form

    public function form( $instance ) {
        $instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
        $title = strip_tags($instance['title']);
        $count = $instance['count'] ? 'checked="checked"' : '';
        $dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'cuisine-a-la-toile'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php echo $dropdown; ?> id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>" />
            <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e('Display as dropdown', 'cuisine-a-la-toile'); ?></label>
            <br/>
            <input class="checkbox" type="checkbox" <?php echo $count; ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" />
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Show post count', 'cuisine-a-la-toile'); ?></label>
        </p>
    <?php }

// Saves and submits the content generated by the user.

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '', 'count' => 0, 'dropdown' => '') );
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = $new_instance['count'] ? 1 : 0;
        $instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;
        return $instance;
    }
}

// Informs WordPress that the widget has been created and should be listed along with the rest of the available widgets.

add_action( 'widgets_init', function(){
    register_widget( 'SubscriberGalleryWidget' );
});

/**
 * SHORTCODES
 */
// TODO: UPDATE SHORTCODES
if ( !function_exists('cuisine_plugin_shortcode__cuisine_timer' ) and !shortcode_exists('cuisine-timer')) {
    function cuisine_plugin_shortcode__cuisine_box($options){
        // Copy shortcode options to local variables
        extract( shortcode_atts( array(
            'time' => 30,
            'sound' => 'oohlala',
            'color' => 'blue',
            'font' => 'parisienne'
        ), $options) );

        // Render shortcode
        return '<div class="cuisine-timer text-'.$color.' font-'.$font.'">'.$time.'</div>';
    }

    add_shortcode('cuisine-timer','cuisine_plugin_shortcode__cuisine_timer');
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
