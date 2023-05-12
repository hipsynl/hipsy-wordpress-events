<?php

// Create the embeddable shortcode
function hipsy_events_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'limit' => -1
    ), $atts);

    $args = array(
        'post_type' => 'events',
        'posts_per_page' => $atts['limit'],
        'meta_key' => 'hipsy_events_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
    );
    $output = '<div class="events">';
    $events_query = new WP_Query($args);
    if ($events_query->have_posts()) :
        while ($events_query->have_posts()) :
            $events_query->the_post();
            $link = get_post_meta(get_the_ID(), 'hipsy_events_link', true);
            $title = get_the_title();
            $url = get_permalink();
            $location = get_post_meta(get_the_ID(), 'hipsy_events_location', true);
            $date_str = get_post_meta(get_the_ID(), 'hipsy_events_date', true);
            $date = new DateTime($date_str);
            $formatted_date = $date->format('F j');
            $formatted_time = $date->format('H:i');
            $date_end = get_post_meta(get_the_ID(), 'hipsy_events_date_end', true);
            $image = get_post_meta(get_the_ID(), 'hipsy_events_image', true);

            $output .= <<<EOT
                <a class="event" href="{$url}">
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
