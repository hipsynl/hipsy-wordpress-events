<?php
defined('ABSPATH') || exit;

/**
 * Classic Theme Template for Single Events
 * 
 * This template is used by classic themes. Block themes will typically use
 * the block-templates/single-events.html file instead, unless this file
 * is specifically loaded by the theme or a plugin override.
 */

get_header();

?>

<main id="site-content" class="site-main hipsy-event-container">
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            
            // Use the shared renderer to output the event content
            echo hipsy_events_render_single_event(get_the_ID());
        }
    }
    ?>
</main>

<?php
get_footer();
