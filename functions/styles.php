<?php

/**
 * Enqueue plugin styles only on pages that need them
 * - Single event pages
 * - Pages containing the events block
 * - Pages with the events shortcode
 */
function hipsy_events_enqueue_styles()
{
    // Always enqueue on single event pages
    if (is_singular('events')) {
        $src  = plugins_url('../styles/dist/main.css', __FILE__);
        $path = plugin_dir_path(__FILE__) . '../styles/dist/main.css';
        $ver  = file_exists($path) ? (string) filemtime($path) : null;

        wp_enqueue_style('hipsy-events-style', $src, array(), $ver);
        return;
    }

    // Check if current page/post contains the events block
    if (is_singular() && function_exists('has_block')) {
        global $post;
        if ($post && has_block('plugin/events-block', $post)) {
            $src  = plugins_url('../styles/dist/main.css', __FILE__);
            $path = plugin_dir_path(__FILE__) . '../styles/dist/main.css';
            $ver  = file_exists($path) ? (string) filemtime($path) : null;

            wp_enqueue_style('hipsy-events-style', $src, array(), $ver);
            return;
        }
    }

    // Check if current page/post contains the events shortcode
    if (is_singular()) {
        global $post;
        if ($post && has_shortcode($post->post_content, 'hipsy_events')) {
            $src  = plugins_url('../styles/dist/main.css', __FILE__);
            $path = plugin_dir_path(__FILE__) . '../styles/dist/main.css';
            $ver  = file_exists($path) ? (string) filemtime($path) : null;

            wp_enqueue_style('hipsy-events-style', $src, array(), $ver);
        }
    }
}

add_action('wp_enqueue_scripts', 'hipsy_events_enqueue_styles');
