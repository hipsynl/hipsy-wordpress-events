<?php
$frequency = 'twicedaily';

add_filter( 'cron_schedules', 'add_every_three_minutes' );
function add_every_three_minutes( $schedules ) {
    $schedules['every_three_minutes'] = array(
        'interval'  => 180,
        'display'   => __( 'Every 3 Minutes', 'hipsy-events' )
    );
    return $schedules;
}

if (!wp_next_scheduled('refresh_hipsy_events')) {
    wp_schedule_event( time(), $frequency, 'refresh_hipsy_events' );
}
add_action ( 'refresh_hipsy_events', 'refresh_hipsy_events_func' );
function refresh_hipsy_events_func() {
    $api_key = get_option('hipsy_events_api_key');
    $org_slug = get_option('hipsy_events_organisation_slug');
    $events = get_hipsy_events($api_key, $org_slug);
    if(isset($events["message"])) {
        return;
    }
    foreach ($events as $event) {
        createEvent($event);
    }
}