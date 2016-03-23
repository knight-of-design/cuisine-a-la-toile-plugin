<?php
/**
 * This widget setup and comments were referenced from Lecture 10 CCT460 Building a WordPress Widget
 **/
// Creates the Subscriber Gallery Widget
class SubscriberGalleryWidget extends WP_Widget
{

    // Initializes the Widget
    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'widget_archive',
            'description' => __('A community creations of recent posts on Cuisine a la toile site&#8217;s.', 'cuisine-a-la-toile')
        );
        // Adds a class to the widget
        // Provides a description on the Widget page explaining the widget's purpose
        parent::__construct('community_archives', __('Cuisine Widget', 'cuisine-a-la-toile'), $widget_ops);
    }


    // Determines what will appear on the site
    public function widget($args, $instance)
    {
        $c = !empty($instance['cuisine-widget-order']) ? '1' : '0';
        //sets a variable for the 'cuisine-widget-order' option
        $d = !empty($instance['cuisine-widget-number']) ? '1' : '0';
        // sets a variable for the 'cuisine-widget-number' option
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Community Creations', 'cuisine-a-la-toile') : $instance['title'], $instance, $this->id_base);
        // Determines whether a title is provided by the user. If this is not provided, the default title is displayed

        echo $args['before_widget']; // Appears once the sidebar is registered.

        if ($title) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        // Post Query
        echo cuisine_render_creations();


       ?>
        <button onclick="document.location.href='index.php/creation';">See All Creations</button>
        <?php

            //if the dropdown option is checked, a list of the subcriber creations posts are displayed by year in a dropdown list.
            $number_dropdown_id = "widget-{$this->id_base}-cuisine-number-dropdown-{$this->number}";
            ?>
            <label class="screen-reader-text" for="<?= esc_attr($number_dropdown_id) ?>"><?= $title ?></label>

      <?php

        echo $args['after_widget']; // Appears once the sidebar is registered.
    }

    // Form Set up. Allows users to customize the widget in the widget admin page.
    // Backend Form
    public function form($instance)
    {
        $instance = wp_parse_args((array)$instance, array('title' => '', 'count' => 0, 'dropdown' => ''));
        $title = strip_tags($instance['title']);
        $count = $instance['count'] ? 'checked="checked"' : '';
        $dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
        ?>
        <select id="<?= esc_attr($number_dropdown_id) ?>" name="cuisine-widget-number"
                onchange="document.location.href=this.options[this.selectedIndex].value;">
            <option value="<?= __('Select the number of posts you want to show', 'cuisine-a-la-toile'); //Number of Posts ?>">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <?php echo __('Select the number of posts you want to show', 'cuisine-a-la-toile'); ?></option>
        </select>

        <?php $order_dropdown_id = "widget-{$this->id_base}-cuisine-order-dropdown-{$this->number}"; ?>

        <label class="screen-reader-text" for="<?= esc_attr($order_dropdown_id) ?>"><?= $title ?></label>
        <select id="<?= esc_attr($order_dropdown_id); ?>" name="cuisine-widget-order"
                onchange="document.location.href=this.options[this.selectedIndex].value;">
            <option value="ascending">Ascending</option>
            <option value="descending">Descending</option>
            <?= __('Select whether you want the posts to be displayed in either Ascending or Descending order', 'cuisine-a-la-toile'); ?>


            <?= __('Select whether you want the posts to be displayed in either Ascending or Descending order', 'cuisine-a-la-toile'); //Ascending to Descending ?></option>

        </select>
        <p>
            <label
                for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'cuisine-a-la-toile'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text"
                   value="<?php echo esc_attr($title); ?>"/>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php echo $dropdown; ?>
                   id="<?php echo $this->get_field_id('cuisine-widget-number'); ?>"
                   name="<?php echo $this->get_field_name('cuisine-widget-number'); ?>"/>
            <label
                for="<?php echo $this->get_field_id('cuisine-widget-number'); ?>"><?php _e('Display the number of posts as dropdown', 'cuisine-a-la-toile'); ?></label>
            <br/>
            <input class="checkbox" type="checkbox" <?php echo $count; ?>
                   id="<?php echo $this->get_field_id('cuisine-widget-order'); ?>"
                   name="<?php echo $this->get_field_name('cuisine-widget-order'); ?>"/>
            <label3
                for="<?php echo $this->get_field_id('cuisine-widget-order'); ?>"><?php _e('Display ascending or descending as a dropdown', 'cuisine-a-la-toile'); ?></label>
        </p>
    <?php }

    // Saves and submits the content generated by the user.

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $new_instance = wp_parse_args((array)$new_instance, array('title' => '', 'cuisine-widget-order' => 0, 'cuisine-widget-number' => ''));
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['cuisine-widget-order'] = $new_instance['cuisine-widget-order'] ? 1 : 0;
        $instance['cuisine-widget-number'] = $new_instance['cuisine-widget-number'] ? 1 : 0;
        return $instance;
    }
}

// Informs WordPress that the widget has been created and should be listed along with the rest of the available widgets.
function cuisine_register_community_creations_widget()
{
    register_widget('SubscriberGalleryWidget');
}

add_action('widgets_init', 'cuisine_register_community_creations_widget');
?>
