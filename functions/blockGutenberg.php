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
        'render_callback' => 'render_events_block',
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
            $date_str2 = get_post_meta(get_the_ID(), 'hipsy_events_date_end', true);
            $date_end = new DateTime($date_str2);
            $formatted_time_end = $date_end->format('H:i');

            // Format: Wo. 11 feb. 2026 19:30 - 21:30
            $formatted_date_string = date_i18n('D. j M. Y H:i', $date->getTimestamp()) . ' - ' . $formatted_time_end;

            $thumbnail = get_the_post_thumbnail(get_the_ID(), 'medium', array('class' => 'event-image w-full h-full object-cover'));
            $description = wp_trim_words(get_the_content(), 25, '...');

            $output .= loop_item($url, $thumbnail, $formatted_date_string, $title, $description);
        }
    }
    wp_reset_postdata();
    $output .= loop_wrapper_end();

    // Check if there are more post to load
    $total_posts = $events_query->found_posts;
    $posts_displayed = $events_query->post_count;

    if ($total_posts > $posts_displayed) {
        $load_more_limit = intval($attributes['numberOfPosts']);
        $output .= '<div class="hipsy-load-more-container" style="text-align: center; margin-top: 20px;">
            <button class="hipsy-load-more button" data-offset="' . esc_attr($posts_displayed) . '" data-limit="' . esc_attr($load_more_limit) . '">Load more</button>
        </div>';
    }

    return $output;
}
