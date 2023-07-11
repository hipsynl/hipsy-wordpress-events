<?php

// Create "Events" page
function hipsy_events_track_activation_status($plugin)
{
    $main_plugin_file = 'hipsy-events/hipsy-events.php'; // Update with the correct relative path to the main plugin file

    if ($plugin === plugin_basename($main_plugin_file)) {
        update_option('hipsy_events_plugin_activated', true);
    }
}
add_action('activated_plugin', 'hipsy_events_track_activation_status');

// Check and create "Events" page on plugin reactivation
function hipsy_events_reactivation_check()
{
    // if (get_option('hipsy_events_plugin_activated')) {
    $existing_page = get_page_by_path('events');

    if ($existing_page === null) {
        // Page doesn't exist, create it
        $events_page = array(
            'post_title'   => 'Events',
            'post_name'    => 'events',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '<!-- wp:plugin/events-block {"numberOfPosts":"99","eventList":[]} /-->'
        );

        wp_insert_post($events_page);
    }

    // Reset the activation status
    update_option('hipsy_events_plugin_activated', false);
    // }
}
add_action('admin_init', 'hipsy_events_reactivation_check');

// Enable Single Event template
function load_hipsy_event_template($template)
{
    global $post;
    if ('events' === $post->post_type && locate_template(array('single-events.php')) !== $template) {
        return plugin_dir_path(__FILE__) . '../templates/single-events.php';
    }
    return $template;
}

add_filter('single_template', 'load_hipsy_event_template');
