<?php
function hipsy_load_more_scripts()
{
    wp_enqueue_script('hipsy_load_more', plugins_url('../assets/js/load-more.js', __FILE__), array('jquery'), '1.0', true);
    wp_localize_script('hipsy_load_more', 'hipsy_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('hipsy_load_more_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'hipsy_load_more_scripts');

function hipsy_load_more_events()
{
    check_ajax_referer('hipsy_load_more_nonce', 'nonce');

    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $posts_per_page = isset($_POST['limit']) ? intval($_POST['limit']) : 10;

    $args = array(
        'post_type' => 'events',
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
        'meta_key' => 'hipsy_events_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
    );

    $events_query = new WP_Query($args);

    if ($events_query->have_posts()):
        while ($events_query->have_posts()):
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

            echo loop_item($url, $thumbnail, $formatted_date_string, $title, $description);
        endwhile;
    endif;

    wp_die();
}
add_action('wp_ajax_hipsy_load_more', 'hipsy_load_more_events');
add_action('wp_ajax_nopriv_hipsy_load_more', 'hipsy_load_more_events');
