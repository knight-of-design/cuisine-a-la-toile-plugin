<?php
/**
 * Plugin Name: Cuisine a la Toile Plugin
 * Plugin URI:  https://github.com/knight-of-design/cuisine-a-la-toile-plugin
 * Description: This plugin is a package that contains a shortcode, widget and custom post type
 * The shortcode creates a timer that will allow users to start a timer via javascript
 * Version:     1.0
 * Author:      James Knight, Christina Morden, and Nicole Di Carlo
 * Author URI:  https://knight-of-design.github.io
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: cuisine-a-la-toile
 * Domain Path: /languages
 *
 * References for Plugin Development:
 * https://developer.wordpress.org/plugins/the-basics/best-practices/
 * https://codex.wordpress.org/Writing_a_Plugin
 * https://developer.wordpress.org/plugins/the-basics/header-requirements/
 * https://codex.wordpress.org/I18n_for_WordPress_Developers
 * https://developer.wordpress.org/plugins/internationalization/how-to-internationalize-your-plugin/
 * https://kovshenin.com/2013/get_template_part-within-shortcodes/
 * http://programmers.stackexchange.com/questions/151661/is-it-bad-practice-to-use-tag-in-php
 */

// For security reasons, prevent PHP code from being executed as standalone file per the recommendation WordPress Codex
defined('ABSPATH') or die('Plugin protected from unauthorized access');

// Allow for flexible plugin folder naming
$PLUGIN_DIR = plugin_dir_url(__FILE__);

// Initializes the plugin
if (!function_exists('cuisine_plugin_init')) {
    function cuisine_plugin_init()
    {
      
    }

    cuisine_plugin_init();
}

function cuisine_template_html($template, $options = array())
{
    global $PLUGIN_DIR;
    // Inspired by https://kovshenin.com/2013/get_template_part-within-shortcodes/
    ob_start();
    extract($options);
    include('inc/templates/' . $template . '.php');
    return ob_get_clean();
}

// Enqueue Assets such as CSS
if (!function_exists('sweet_plugin_enqueue_assets')) {
    function cuisine_plugin_enqueue_assets()
    {

        global $PLUGIN_DIR;

        // Enqueue Plugin CSS
        wp_enqueue_style('cuisine-plugin', $PLUGIN_DIR . 'css/style.css');

        // Enqueue Plugin JS
        wp_enqueue_script('cuisine-plugin',$PLUGIN_DIR.'js/script.js',array('jquery'), '1.0', true );

        // Enqueue Google Fonts
        wp_enqueue_style('wpb-google-fonts', 'https://fonts.googleapis.com/css?family=Parisienne|Tangerine|Cookie', false);

        // Enqueue FlipClock.js
        wp_enqueue_style( 'flipclock', $PLUGIN_DIR . 'lib/flipclock/flipclock.css');
        wp_enqueue_script('flipclock', $PLUGIN_DIR . 'lib/flipclock/flipclock.min.js', array('jquery'), '1.1a', true );

    }

    add_action('wp_enqueue_scripts', 'cuisine_plugin_enqueue_assets');
}

/**
 * Include Custom Post Type
 */
include('inc/post-types/cuisine-creations.php');


/**
 * Include Shortcodes
 */
include('inc/shortcodes/cuisine-creations.php');
include('inc/shortcodes/cuisine-timer.php');

/**
 * Include Widgets
 */
include('inc/widgets/cuisine-creations.php');


?>
