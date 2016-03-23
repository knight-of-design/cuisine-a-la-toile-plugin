<?php
if ( !function_exists('cuisine_plugin_shortcode__cuisine_timer' ) and !shortcode_exists('cuisine-timer')) {
    function cuisine_plugin_shortcode__cuisine_timer($options){
        $default_options =  array(
            'time' => '00:00:30',
            'sound' => 'mmm',
            'color' => 'blue',
            'font' => 'parisienne',
            'colorstartbutton' => 'green',
            'colorpausebutton' => 'red',
            'colorrestartbutton' => 'yellow'
        );

        $shortcode_options = shortcode_atts($default_options, $options);

        return cuisine_template_html('shortcodes/cuisine-timer',$shortcode_options);
    }

    add_shortcode('cuisine-timer','cuisine_plugin_shortcode__cuisine_timer');
}
?>