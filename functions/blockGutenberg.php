<?php
function register_events_block()
{
    wp_register_script(
        'events-block-script',
        plugins_url('../blocks/events-block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-components', 'wp-editor')
    );

    register_block_type('plugin/events-block', array(
        'editor_script' => 'events-block-script',
    ));
}
add_action('init', 'register_events_block');

function enqueue_block_assets()
{
    wp_enqueue_script(
        'events-block-script',
        plugins_url('../blocks/events-block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-components', 'wp-editor', 'wp-api-fetch')
    );
}
add_action('enqueue_block_editor_assets', 'enqueue_block_assets');

function render_events_block($attributes)
{
    // print_r($attributes);
    $args = array(
        'post_type' => 'events',
        'posts_per_page' => intval($attributes['numberOfPosts']),
        'meta_key' => 'hipsy_events_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
    );

    $events_query = new WP_Query($args);

    $value = get_option('hipsy_events_dark_mode');
    $dark_mode = $value === "1" ? 'dark' : '';
    $output = loop_wrapper_start($dark_mode);

    if ($events_query->have_posts()) {
        while ($events_query->have_posts()) {
            $events_query->the_post();
            $link = get_post_meta(get_the_ID(), 'hipsy_events_link', true);
            $title = get_the_title();
            $url = get_permalink();
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
        }
    }
    wp_reset_postdata();
    $output .= loop_wrapper_end();

    $output .= '<p class="has-text-align-center">Events synced with Hipsy</p>';

    return $output;
}
register_block_type('plugin/events-block', array(
    'render_callback' => 'render_events_block',
));
