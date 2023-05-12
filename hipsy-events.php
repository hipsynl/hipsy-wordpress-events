<?php
/*
Plugin Name: Hipsy Events
Description: Fetches and displays a list of events from the Hipsy API.
Version: 1.0
Author: How About Yes
*/

// Create the embeddable shortcode
function hipsy_events_shortcode()
{
    $args = array(
        'post_type' => 'events',
        'posts_per_page' => -1,
        'meta_key' => 'hipsy_events_date',
        'orderby' => 'meta_value',
        'order' => 'ASC'
    );
    $output = '<div class="events">';
    $events_query = new WP_Query($args);
    if ($events_query->have_posts()) :
        while ($events_query->have_posts()) :
            $events_query->the_post();
            $link = get_post_meta(get_the_ID(), 'hipsy_events_link', true);
            $title = get_the_title();
            $location = get_post_meta(get_the_ID(), 'hipsy_events_location', true);
            $date_str = get_post_meta(get_the_ID(), 'hipsy_events_date', true);
            $date = new DateTime($date_str);
            $formatted_date = $date->format('F j');
            $formatted_time = $date->format('H:i');
            $date_end = get_post_meta(get_the_ID(), 'hipsy_events_date_end', true);
            $image = get_post_meta(get_the_ID(), 'hipsy_events_image', true);

            $output .= <<<EOT
                <a class="event" target="_blank" rel="noreferrer" href="{$link}">
                    <img class="event-image" src="{$image}" alt="Event image" />
                    <div class="event-info">
                        <div class="event-date">{$formatted_date} at {$formatted_time}</div>
                        <div class="event-title">{$title}</div>
                        <div class="event-location">{$location}</div>
                    </div>
                </a>
            EOT;
        endwhile;
    endif;
    wp_reset_postdata();
    $output .= '</div>';

    return $output;

}
add_shortcode('hipsy_events', 'hipsy_events_shortcode');


function hipsy_events_enqueue_styles()
{
    wp_enqueue_style('hipsy-events-style', plugins_url('style.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'hipsy_events_enqueue_styles');

include("functions/createEvent.php");
include("functions/getHipsyEvents.php");
include("functions/displaySettings.php");
include("functions/initSettings.php");
include("functions/submitSettings.php");
include("functions/customPostType.php");
include("functions/submenuItem.php");
include("functions/customFields.php");
