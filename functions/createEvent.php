<?php

function createEvent($event)
{
    $timezone = new DateTimeZone(wp_timezone_string());
    $stored_date = new DateTime($event['date']);
    $stored_date->setTimezone($timezone);

    $stored_date_until = new DateTime($event['date_until']);
    $stored_date_until->setTimezone($timezone);

    $formatted_date = $stored_date->format('Y-m-d\TH:i');
    $formatted_date_until = $stored_date_until->format('Y-m-d\TH:i');


    $post_arr = array(
        'post_title'   => $event['title'],
        'post_type'    => 'events',
        'post_content' => $event['description'],
        'post_status'  => 'publish',
        'meta_input'   => array(
            'hipsy_events_location' => $event['location'],
            'hipsy_events_date' => $formatted_date,
            'hipsy_events_date_end' => $formatted_date_until,
            'hipsy_events_link' => $event['url_ticketshop'],
            'hipsy_ticket_info' => serialize($event['tickets'])
        ),
    );
    if (get_post($event['id'])) {
        $post_arr['ID'] = $event['id'];
        wp_update_post($post_arr);
        return;
    }
    $post_arr['import_id'] = $event['id'];

    $post = wp_insert_post($post_arr);
    $image = add_external_image_to_media_library($event['picture']);
    set_post_thumbnail($post, $image);
}

function add_external_image_to_media_library($image_url)
{
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $filename = basename($image_url);
    if (strpos($filename, '.png') !== false) {
        $filetype = 'image/png';
    } elseif (strpos($filename, '.jpg') !== false || strpos($filename, '.jpeg') !== false) {
        $filetype = 'image/jpeg';
    } else {
        return false;
    }
    $new_file_path = $upload_dir['path'] . '/' . $filename;
    if (!file_exists($new_file_path)) {
        file_put_contents($new_file_path, $image_data);
    }
    $attachment = array(
        'post_mime_type' => $filetype,
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment($attachment, $new_file_path);
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $attach_data = wp_generate_attachment_metadata($attach_id, $new_file_path);
    wp_update_attachment_metadata($attach_id, $attach_data);
    return $attach_id;
}
