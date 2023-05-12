<?php

// Create a content type called Hipsy Events
function create_posttype()
{
    register_post_type(
        'events',
        array(
            'labels' => array(
                'name' => __('Hipsy Events'),
                'all_items' => __('All Events'),
                'singular_name' => __('Event'),
                'add_new' => __('Add Event'),
                'add_new_item' => __('Add Event'),
                'edit_item' => __('Edit Event'),
                'view_item' => __('View Event')
            ),
            'supports' => array(
                'title','editor','thumbnail','custom-fields','page-attributes'
            ),
            'menu_position' => 20,
            'public' => true,
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-calendar-alt',
            'has_archive' => false,
        )
    );
}
add_action('init', 'create_posttype');
