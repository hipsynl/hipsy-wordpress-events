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
    $value = get_option('hipsy_events_dark_mode');
    $dark_mode = $value === "1" ? 'dark' : '';

    $output = loop_wrapper_start($dark_mode);
    $events_query = new WP_Query($args);
    if ($events_query->have_posts()) :
        while ($events_query->have_posts()) :
            $events_query->the_post();
            $link_type = get_option('hipsy_events_button_link');
            $link = get_post_meta(get_the_ID(), 'hipsy_events_link', true);
            $title = get_the_title();
            
            if ($link_type === 'shop' && !empty($link)) {
                $url = $link;
            } else {
                $url = get_permalink();
            }
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
        endwhile;
    endif;
    wp_reset_postdata();
    $output .= loop_wrapper_end();

    return $output;
}
add_shortcode('hipsy_events', 'hipsy_events_shortcode');
