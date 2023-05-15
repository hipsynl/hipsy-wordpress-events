<?php

// Add custom meta boxes for the "events" post type
function hipsy_events_add_meta_boxes()
{
    add_meta_box(
        'hipsy_events_meta_box',
        'Event Details',
        'hipsy_events_render_meta_box',
        'events',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'hipsy_events_add_meta_boxes');

// Render the custom meta box fields
function hipsy_events_render_meta_box($post)
{
    // Retrieve saved meta values
    $location = get_post_meta($post->ID, 'hipsy_events_location', true);
    $date = get_post_meta($post->ID, 'hipsy_events_date', true);
    $date_end = get_post_meta($post->ID, 'hipsy_events_date_end', true);
    $link = get_post_meta($post->ID, 'hipsy_events_link', true);

    // Output the fields
    echo '<label style="display:inline-block;width:85px;margin-bottom:5px;" for="hipsy_events_location">Location:</label>';
    echo '<input style="max-width:500px;width:100%;margin-bottom:5px;" type="text" id="hipsy_events_location" name="hipsy_events_location" value="' . esc_attr($location) . '"><br>';

    echo '<label style="display:inline-block;width:85px;margin-bottom:5px;" for="hipsy_events_date">Date:</label>';
    echo '<input style="max-width:500px;width:100%;margin-bottom:5px;" type="datetime-local" id="hipsy_events_date" name="hipsy_events_date" value="' . esc_attr($date) . '"><br>';

    echo '<label style="display:inline-block;width:85px;margin-bottom:5px;" for="hipsy_events_date_end">End Date:</label>';
    echo '<input style="max-width:500px;width:100%;margin-bottom:5px;" type="datetime-local" id="hipsy_events_date_end" name="hipsy_events_date_end" value="' . esc_attr($date_end) . '"><br>';

    echo '<label style="display:inline-block;width:85px;margin-bottom:5px;" for="hipsy_events_link">Link:</label>';
    echo '<input style="max-width:500px;width:100%;margin-bottom:5px;" type="text" id="hipsy_events_link" name="hipsy_events_link" value="' . esc_attr($link) . '"><br>';
}

// Save the custom meta box fields
function hipsy_events_save_meta_box($post_id)
{
    if (isset($_POST['hipsy_events_location'])) {
        update_post_meta($post_id, 'hipsy_events_location', sanitize_text_field($_POST['hipsy_events_location']));
    }
    if (isset($_POST['hipsy_events_date'])) {
        update_post_meta($post_id, 'hipsy_events_date', sanitize_text_field($_POST['hipsy_events_date']));
    }
    if (isset($_POST['hipsy_events_date_end'])) {
        update_post_meta($post_id, 'hipsy_events_date_end', sanitize_text_field($_POST['hipsy_events_date_end']));
    }
    if (isset($_POST['hipsy_events_link'])) {
        update_post_meta($post_id, 'hipsy_events_link', sanitize_text_field($_POST['hipsy_events_link']));
    }
}
add_action('save_post_events', 'hipsy_events_save_meta_box');
