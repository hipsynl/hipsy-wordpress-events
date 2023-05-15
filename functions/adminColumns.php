<?php
// Add custom sortable column in the event list table
function hipsy_events_add_date_column($columns)
{
    $columns['hipsy_events_date'] = 'Event Date';
    return $columns;
}
add_filter('manage_events_posts_columns', 'hipsy_events_add_date_column');

// Render the content of the custom sortable column
function hipsy_events_render_date_column($column_name, $post_id)
{
    if ($column_name === 'hipsy_events_date') {
        $event_date = get_post_meta($post_id, 'hipsy_events_date', true);
        $date = new DateTime($event_date);
        $formatted_date = $date->format('M jS, Y \a\t H:i');
        echo $formatted_date;
    }
}
add_action('manage_events_posts_custom_column', 'hipsy_events_render_date_column', 10, 2);

// Make the custom date column sortable
function hipsy_events_make_date_column_sortable($columns)
{
    $columns['hipsy_events_date'] = 'hipsy_events_date';
    return $columns;
}
add_filter('manage_edit-events_sortable_columns', 'hipsy_events_make_date_column_sortable');

// Sort the events list based on the custom date column
function hipsy_events_sort_events_by_date($query)
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    // Check if the current query is for the "events" post type
    $post_type = $query->get('post_type');
    if ($post_type !== 'events') {
        return;
    }

    // Set the default sorting to the "hipsy_events_date" column
    if (!$query->get('orderby')) {
        $query->set('meta_key', 'hipsy_events_date');
        $query->set('orderby', 'meta_value');
        $query->set('order', 'ASC');
    }
}
add_action('pre_get_posts', 'hipsy_events_sort_events_by_date');
