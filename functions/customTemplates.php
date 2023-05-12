<?php

// Create "Events" page
function hipsy_events_activation()
{
    $events_page = array(
        'post_title' => 'Events',
        'post_name' => 'events',
        'post_status' => 'publish',
        'post_type' => 'page',
        'post_content' => '[hipsy_events]'
    );
    $events_page_id = wp_insert_post($events_page);

    // Set "Events" page as the page for the shortcode
    update_option('hipsy_events_page_id', $events_page_id);
}
register_activation_hook(__FILE__, 'hipsy_events_activation');

// Enable Events overview template
function hipsy_events_page_template($template)
{
    // Get the "Events" page ID from the options table
    $events_page_id = get_option('hipsy_events_page_id');

    // If this is the "Events" page, load the custom template
    if (is_page($events_page_id)) {
        $template = plugin_dir_path(__FILE__) . '../templates/events.php';
    }

    return $template;
}
add_filter('page_template', 'hipsy_events_page_template');

// Enable Single Event template
function load_hipsy_event_template($template)
{
    global $post;
    if ('events' === $post->post_type && locate_template(array( 'single-events.php' )) !== $template) {
        return plugin_dir_path(__FILE__) . '../templates/single-events.php';
    }
    return $template;
}

add_filter('single_template', 'load_hipsy_event_template');
