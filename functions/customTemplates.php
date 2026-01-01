<?php

// Create "Events" page
function hipsy_events_track_activation_status($plugin)
{
    $main_plugin_file = 'hipsy-events/hipsy-events.php'; // Update with the correct relative path to the main plugin file

    if ($plugin === plugin_basename($main_plugin_file)) {
        update_option('hipsy_events_plugin_activated', true);
    }
}
add_action('activated_plugin', 'hipsy_events_track_activation_status');

// Check and create "Events" page on plugin reactivation
function hipsy_events_reactivation_check()
{
    // if (get_option('hipsy_events_plugin_activated')) {
    $existing_page = get_page_by_path('events');

    if ($existing_page === null) {
        // Page doesn't exist, create it
        $events_page = array(
            'post_title'   => 'Events',
            'post_name'    => 'events',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '<!-- wp:plugin/events-block {"numberOfPosts":"99","eventList":[]} /-->'
        );

        wp_insert_post($events_page);
    }

    // Reset the activation status
    update_option('hipsy_events_plugin_activated', false);
    // }
}
add_action('admin_init', 'hipsy_events_reactivation_check');


/**
 * 1. Classic Theme Template Routing
 * 
 * If the theme is classic (or simply doesn't provide a specific template),
 * we inject our plugin's PHP template.
 */
function hipsy_events_load_classic_template($template)
{
    global $post;
    
    // Only handle events post type
    if (!$post || 'events' !== $post->post_type) {
        return $template;
    }

    // If theme provides a PHP template (single-events.php), let it win.
    $theme_template = locate_template(array('single-events.php'));
    if ($theme_template) {
        return $theme_template;
    }

    // Check if this is a block theme (FSE).
    // If it is a block theme, we normally want to let it use block templates.
    // However, if the block theme DOES NOT have a 'single-events' block template,
    // WordPress might fall back to 'single.html' or 'index.html'.
    // 
    // We want to force our block template in that case, but that's handled by 
    // the block template filters below.
    // 
    // For the 'single_template' filter:
    // If we return our PHP template here on a block theme, it forces the PHP template rendering 
    // (which we made compatible with get_header/get_footer, but block themes might not have those).
    // 
    // So: If it's a block theme, return $template (letting WP proceed to block template resolution).
    // If it's a classic theme (no block support), use our PHP template.

    if (function_exists('wp_is_block_theme') && wp_is_block_theme()) {
        return $template;
    }

    // Classic fallback: use plugin PHP template
    return plugin_dir_path(__FILE__) . '../templates/single-events.php';
}
add_filter('single_template', 'hipsy_events_load_classic_template');


/**
 * 2. Block Theme Template Registration
 * 
 * Injects the 'single-events' block template into the list of available templates,
 * and provides the content for it from our plugin's HTML file.
 */

// Inject into template hierarchy/list
function hipsy_events_get_block_templates($query_result, $query, $template_type) {
    if ( ! function_exists('wp_is_block_theme') || ! wp_is_block_theme() ) {
        return $query_result;
    }

    $slug = 'single-events';
    $post_type = 'events';

    // Validation: Don't inject if the query is strictly asking for something else
    if (isset($query['slug__in']) && !empty($query['slug__in']) && !in_array($slug, $query['slug__in'])) {
        return $query_result;
    }
    if (isset($query['slug']) && !empty($query['slug']) && $slug !== $query['slug'] && !in_array($slug, (array)$query['slug'])) {
        return $query_result;
    }
    if (isset($query['post_type']) && !empty($query['post_type']) && $post_type !== $query['post_type'] && !in_array($post_type, (array)$query['post_type'])) {
        return $query_result;
    }

    // Check if the theme already has this template
    foreach ($query_result as $template) {
        if ($template->slug === $slug) {
            return $query_result; // Theme wins
        }
    }

    // Create a new template object
    $template = new WP_Block_Template();
    $template->theme = get_stylesheet();
    $template->slug = $slug;
    $template->id = get_stylesheet() . '//' . $slug;
    $template->title = 'Single Event (Hipsy)';
    $template->description = 'Displays a single event.';
    $template->type = 'single';
    $template->post_types = array($post_type);
    $template->origin = 'plugin';
    $template->status = 'publish';
    $template->is_custom = false; 
    
    $content_path = plugin_dir_path(__FILE__) . '../block-templates/single-events.html';
    $template->content = file_exists($content_path) ? file_get_contents($content_path) : '';
    
    // Add to results
    $query_result[] = $template;

    return $query_result;
}
// Hook for WP 5.9+
add_filter('get_block_templates', 'hipsy_events_get_block_templates', 10, 3);


// Inject content when the specific template is requested (e.g. for rendering)
function hipsy_events_get_block_template($block_template, $id, $template_type) {
    if ( ! function_exists('wp_is_block_theme') || ! wp_is_block_theme() ) {
        return $block_template;
    }

    // $id format: theme_slug//template_slug
    $parts = explode('//', $id);
    if (count($parts) < 2) {
        return $block_template;
    }
    
    $slug = $parts[1];

    if ('single-events' !== $slug) {
        return $block_template;
    }

    // If the template object is already fully formed and found (e.g. from theme), return it.
    if ($block_template && !empty($block_template->content)) {
        return $block_template;
    }

    // Build the template object
    $block_template = new WP_Block_Template();
    $block_template->theme = get_stylesheet();
    $block_template->slug = 'single-events';
    $block_template->id = $id;
    $block_template->title = 'Single Event (Hipsy)';
    $block_template->description = 'Displays a single event.';
    $block_template->type = 'single';
    $block_template->post_types = array('events');
    $block_template->origin = 'plugin';
    $block_template->status = 'publish';
    
    $content_path = plugin_dir_path(__FILE__) . '../block-templates/single-events.html';
    $block_template->content = file_exists($content_path) ? file_get_contents($content_path) : '';

    return $block_template;
}
add_filter('get_block_template', 'hipsy_events_get_block_template', 10, 3);
