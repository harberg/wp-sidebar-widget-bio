<?php
/**
 * Plugin Name: Author Bio Sidebar Widget
 * Plugin URI: https://github.com/harberg/wp-sidebar-widget-bio
 * Description: This plugin is a sidebar widget on the posts that collects extended author bio information.
 * Version: 1.0
 * Author: Nick Harberg
 * License: MIT
 */

// use widget_init Action hook to execute custom funtion
add_action( 'widgets_init', 'hc_register_widgets' );

// register widget
function hc_register_widgets() {
    register_widget( 'hc_widget' );
}

// hc widget class
class hc_widget extends WP_Widget {
    // process our new widget
    function __construct() {
        $widget_options = array(
            'classname'   => 'hc_widget_class',
            'description' => 'Widget that displays an author\'s bio.'
        );
        parent::__construct( 'hc_widget', 'Bio Widget', $widget_options );
    }

    // build the widget
    function form( $instance ) {
        $defaults = array(
            'title' => 'My Bio',
            'name'  => 'WP Author',
            'bio'   => ''
        );
        $instance = wp_parse_args( (array) $instance, $defaults );
        $title    = $instance['title'];
        $name     = $instance['name'];
        $bio      = $instance['bio'];
    ?>
    <p>Title:
        <input class="hc-widget-input" name="<?php echo $this->get_field_name( 'title' ); ?>"
        type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>Name:
        <input class="hc-widget-input" name="<?php echo $this->get_field_name( 'name' ); ?>"
        type="text" value="<?php echo esc_attr( $name ); ?>" />
    </p>
    <p>Bio
        <textarea class="hc-widget-input" name="<?php echo $this->get_field_name( 'bio' ); ?>">
            <?php echo esc_textarea( $bio ); ?>
        </textarea>
    </p>
    <?php
    }

    // Save widget settings
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['name'] = sanitize_text_field( $new_instance['name'] );
        $instance['bio'] = sanitize_text_field( $new_instance['bio'] );

        return $instance;
    }

    // Display the widget
    function widget( $args, $instance ) {
        extract( $args );

        echo $before_widget;

        $title = apply_filters( 'widget_title', $instance['title'] );
        $name = ( empty($instance['name'] ) ) ? '&nbsp' : $instance['name'];
        $bio = ( empty($instance['bio'] ) ) ? '&nbsp' : $instance['bio'];

        if( !empty( $title ) ) {
            echo $before_title . esc_html( $title ) . $after_title;
        };
        echo '<p>Name: ' . esc_html( $name ) . '</p>';
        echo '<p>Bio: ' . esc_html( $bio ) . '</p>';

        echo $after_widget;
    }
}// end class hc_widget




















