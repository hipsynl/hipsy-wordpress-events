<?php

add_action('init', 'trash_old_events');
function trash_old_events()
{
    $args = array(
        'post_type' => 'events',
        'posts_per_page' => -1,
        'meta_key' => 'hipsy_events_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'hipsy_events_date',
                'value' => date("Y-m-d H:i:s"),
                'compare' => '<'
            )
        ),
    );
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $post_id = get_the_ID();
            wp_trash_post($post_id);
        }
        wp_reset_postdata();
    }
}
