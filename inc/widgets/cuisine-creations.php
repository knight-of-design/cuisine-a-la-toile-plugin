<?php
/**
 * This widget setup and comments were referenced from Lecture 10 CCT460 Building a WordPress Widget
 **/
// Creates the Subscriber Gallery Widget
class SubscriberGalleryWidget extends WP_Widget {

    // Initializes the Widget
    public function __construct() {
    $widget_ops = array(
    'classname' => 'widget_archive',
    'description' => __( 'A community creations of recent posts on Cuisine a la toile site&#8217;s.', 'cuisine-a-la-toile')
    );
    // Adds a class to the widget
    // Provides a description on the Widget page explaining the widget's purpose
    parent::__construct('community_archives', __('Cuisine Widget', 'cuisine-a-la-toile'), $widget_ops);
    }


    // Determines what will appear on the site
    public function widget( $args, $instance ) {
    $c = ! empty( $instance['count'] ) ? '1' : '0';
    //sets a variable for the 'Count' option
    $d = ! empty( $instance['dropdown'] ) ? '1' : '0';
    // sets a variable for the 'Dropdown' option
    $title = apply_filters('widget_title', empty($instance['title']) ? __('Community Creations', 'cuisine-a-la-toile') : $instance['title'], $instance, $this->id_base);
    // Determines whether a title is provided by the user. If this is not provided, the default title is displayed

    echo $args['before_widget']; // Appears once the sidebar is registered.

    if ( $title ) {
    echo $args['before_title'] . $title . $args['after_title'];
    }

    // Post Query
    echo cuisine_render_creations();

    if ( $d ) {
    //if the dropdown option is checked, a list of the subcriber creations posts are displayed by year in a dropdown list.
    $dropdown_id = "{$this->id_base}-dropdown-{$this->number}";
    ?>
    <label class="screen-reader-text" for="<?php echo esc_attr( $dropdown_id ); ?>"><?php echo $title; ?></label>
//Number of Posts
    <select id="<?php echo esc_attr( $dropdown_id ); ?>" name="cuisine-widget-number-of-posts" onchange='document.location.href=this.options[this.selectedIndex].value;'>
        <option value="<?php echo __( 'Select the number of posts you want to show', 'cuisine-a-la-toile' ); ?>">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <?php echo __( 'Select the number of posts you want to show', 'cuisine-a-la-toile' ); ?></option>
        <?php wp_get_archives( $dropdown_args ); ?>
    </select>
  //Ascending to Descending
    <select id="<?php echo esc_attr( $dropdown_id ); ?>" name="cuisine-widget-ascending-descending" onchange='document.location.href=this.options[this.selectedIndex].value;'>
        <option value="ascending">Ascending</option>
        <option value="descending">Descending</option>
        <?php echo __( 'Select whether you want the posts to be displayed in either Ascending or Descending order', 'cuisine-a-la-toile' ); ?>">

        <?php echo __( 'Select whether you want the posts to be displayed in either Ascending or Descending order', 'cuisine-a-la-toile' ); ?></option>
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
function cuisine_register_community_creations_widget(){
    register_widget( 'SubscriberGalleryWidget' );
}

add_action( 'widgets_init', 'cuisine_register_community_creations_widget');
?>
