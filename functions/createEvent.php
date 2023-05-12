<?php

function createEvent($event)
{
    $post_arr = array(
        'post_title'   => $event['title'],
        'post_type'    => 'events',
        'post_content' => $event['description'],
        'post_status'  => 'publish',
        'meta_input'   => array(
            'hipsy_events_location' => $event['location'],
            'hipsy_events_date' => $event['date'],
            'hipsy_events_date_end' => $event['date_until'],
            'hipsy_events_link' => $event['url_hipsy'],
            'hipsy_events_image' => $event['picture'],
        ),
    );
    if(get_post($event['id'])) {
        $post_arr['ID'] = $event['id'];
        wp_update_post($post_arr);
        return;
    }
    $post_arr['import_id'] = $event['id'];

    $post = wp_insert_post($post_arr);
}
