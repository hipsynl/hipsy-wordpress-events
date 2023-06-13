<?php
/*
Plugin Name: Hipsy Events
Description: Fetches and displays a list of events from the Hipsy API.
Version: 1.0
Author: How About Yes
*/



include("templates/loopItem.php");
include("functions/styles.php");
include("functions/displayEventsShortcode.php");
include("functions/deleteOldEvents.php");
include("functions/createEvent.php");
include("functions/getHipsyEvents.php");
include("functions/displaySettings.php");
include("functions/initSettings.php");
include("functions/submitSettings.php");
include("functions/customPostType.php");
include("functions/submenuItem.php");
include("functions/customFields.php");
include("functions/customTemplates.php");
include("functions/adminColumns.php");

function register_events_block()
{
    wp_register_script(
        'events-block-script',
        plugins_url('blocks/events-block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-components', 'wp-editor')
    );

    register_block_type('plugin/events-block', array(
        'editor_script' => 'events-block-script',
    ));
}
add_action('init', 'register_events_block');

function enqueue_block_assets()
{
    wp_enqueue_script(
        'events-block-script',
        plugins_url('blocks/events-block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-components', 'wp-editor', 'wp-api-fetch')
    );
}
add_action('enqueue_block_editor_assets', 'enqueue_block_assets');

function render_events_block($attributes)
{
    // print_r($attributes);
    $args = array(
        'post_type' => 'events',
        'posts_per_page' => intval($attributes['numberOfPosts']),
        'meta_key' => 'hipsy_events_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
    );

    $events_query = new WP_Query($args);

    $value = get_option('hipsy_events_dark_mode');
    $dark_mode = $value === "1" ? 'dark' : '';
    $output = loop_wrapper_start($dark_mode);

    if ($events_query->have_posts()) {
        while ($events_query->have_posts()) {
            $events_query->the_post();
            $link = get_post_meta(get_the_ID(), 'hipsy_events_link', true);
            $title = get_the_title();
            $url = get_permalink();
            $location = get_post_meta(get_the_ID(), 'hipsy_events_location', true);
            // Date
            $date_str = get_post_meta(get_the_ID(), 'hipsy_events_date', true);
            $date = new DateTime($date_str);
            $formatted_date = $date->format('F j');
            $formatted_time = $date->format('H:i');
            $date_str2 = get_post_meta(get_the_ID(), 'hipsy_events_date_end', true);
            $date_end = new DateTime($date_str2);
            $formatted_time_end = $date_end->format('H:i');

            $thumbnail = get_the_post_thumbnail(get_the_ID(), 'medium', array('class' => 'event-image'));

            $output .= loop_item($url, $thumbnail, $formatted_date, $formatted_time, $formatted_time_end, $title, $location);
        }
    }
    wp_reset_postdata();
    $output .= loop_wrapper_end();

    return $output;
}
register_block_type('plugin/events-block', array(
    'render_callback' => 'render_events_block',
));


add_filter(
    'rest_events_collection_params',
    function ($params) {
        $params['orderby']['enum'][] = 'hipsy_events_date';
        return $params;
    },
    10,
    1
);

// Manipulate query
add_filter(
    'rest_events_query',
    function ($args, $request) {
        $order_by = $request->get_param('orderby');
        if (isset($order_by) && 'hipsy_events_date' === $order_by) {
            $args['meta_key'] = $order_by;
            $args['orderby']  = 'meta_value'; // user 'meta_value_num' for numerical fields
            $args['order']    = 'ASC'; // ASC or DESC
        }
        return $args;
    },
    10,
    2
);

// function filter_rest_events_query($query_vars, $request)
// {
//     $orderby = $request->get_param('orderby');
//     if (isset($orderby) && $orderby === 'hipsy_events_date') {
//         $query_vars['orderby'] = 'meta_value';
//         $query_vars['meta_key'] = 'hipsy_events_date';
//     }
//     return $query_vars;
// }

// // Hook the filter function to the appropriate filter for your custom post type
// add_filter('rest_events_query', 'filter_rest_events_query', 10, 2);
// function register_custom_rest_params($params)
// {
//     $params['orderby']['enum'][] = 'hipsy_events_date';
//     return $params;
// }
// add_filter('rest_query_vars', 'register_custom_rest_params');

// function modify_events_rest_query($args, $request)
// {
//     print_r($request);
//     // $orderby = $request->get_param('orderby');

//     // if ($orderby === 'hipsy_events_date') {
//     //     $args['orderby'] = 'meta_value';
//     //     $args['meta_key'] = 'hipsy_events_date';
//     //     $args['order'] = 'ASC'; // Change as needed: ASC for ascending, DESC for descending
//     // }

//     return $args;
// }
// add_filter('rest_events_collection_params', 'modify_events_rest_query', 10, 2);
