<?php

/**
 * Render single event content
 * Shared by both Classic Template (templates/single-events.php) and Block Template (via dynamic block)
 *
 * @param int|null $post_id
 * @return string HTML content
 */
function hipsy_events_render_single_event($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    if (!$post_id) {
        return '';
    }

    // Verify that the post actually exists in WordPress before proceeding
    // This prevents errors when trying to access post meta for non-existent posts
    $content_post = get_post($post_id);
    if (!$content_post) {
        return '';
    }

    // Prepare data
    $value = get_option('hipsy_events_dark_mode');
    $dark_mode = $value === "1" ? 'dark' : '';

    // Date
    $date_str = get_post_meta($post_id, 'hipsy_events_date', true);
    if (!$date_str) {
        return ''; // Or handle empty date gracefully
    }
    
    try {
        $date = new DateTime($date_str);
        $formatted_date = $date->format('F j');
        $formatted_time = $date->format('H:i');
    } catch (Exception $e) {
        $formatted_date = '';
        $formatted_time = '';
    }

    $date_str2 = get_post_meta($post_id, 'hipsy_events_date_end', true);
    try {
        $date_end = new DateTime($date_str2);
        $formatted_time_end = $date_end->format('H:i');
    } catch (Exception $e) {
        $formatted_time_end = '';
    }

    $url = get_post_meta($post_id, 'hipsy_events_link', true);
    
    $tickets = maybe_unserialize(get_post_meta($post_id, 'hipsy_ticket_info', true));
    if (!is_array($tickets)) {
        $tickets = array();
    }

    $location = get_post_meta($post_id, 'hipsy_events_location', true);
    $title = get_the_title($post_id);
    $home_url = home_url();
    $events_url = $home_url . '/events';
    
    // Thumbnail
    $thumbnail = get_the_post_thumbnail($post_id, 'large', array('class' => 'event-image'));

    // Content
    $content = $content_post->post_content;
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);


    // Start Output Buffering
    ob_start();
    ?>
    <div class="wp-block-group single-event-wrapper <?php echo esc_attr($dark_mode); ?>">
        <div class="event-single-header">
            <div class="event-info">
                <a class="go-back" href="<?php echo esc_url($events_url); ?>">← back to all events</a>
                <h1 class="event-title"><?php echo esc_html($title); ?></h1>
                <p class="event-date"><?php echo "{$formatted_date} at {$formatted_time} - {$formatted_time_end}" ?></p>
                <div class="event-location">Location: <?php echo esc_html($location); ?></div>
                <a target="_blank" class="event-button event-button-mobile" href="<?php echo esc_url($url); ?>">Get tickets</a>

            </div>
            <?php echo $thumbnail; ?>
        </div>
        <div class="event-single-main">
            <div class="event-content-wrapper">
                <?php echo $content; ?>
                <a style="margin-top:20px; display:block;" href="<?php echo esc_url($events_url); ?>">← back to all events</a>
            </div>
            <div class="ticket-content-wrapper event-content-wrapper">
                <div class="ticket-content">
                    <h4>Book your tickets</h4>
                    <div class="ticket-list">
                        <?php
                        foreach ($tickets as $ticket) {
                            $price_val = isset($ticket['price']) ? $ticket['price'] : 0;
                            $name = isset($ticket['name']) ? $ticket['name'] : '';
                            $description = isset($ticket['description']) ? $ticket['description'] : '';
                            
                            $price = '€ ' . number_format((float)$price_val, 2, ',', '.');
                            $servicecosts = $price_val > 0 ? 'incl. service costs' : '';
                            
                            // Inline ticket HTML generation to avoid function dependency if possible, or define helper inside.
                            // The original code defined a helper function 'ticket' inside the template.
                            ?>
                            <div class="ticket">
                                <div class="ticket-info">
                                    <div class="ticket-name"><?php echo esc_html($name); ?></div>
                                    <div class="ticket-description"><?php echo esc_html($description); ?></div>
                                </div>
                                <div class="ticket-price-wrapper">
                                    <div class="ticket-price"><?php echo esc_html($price); ?></div>
                                    <div class="ticket-description"><?php echo esc_html($servicecosts); ?></div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <a target="_blank" class="event-button" href="<?php echo esc_url($url); ?>">Get tickets</a>
                    
                    <div class="hipsy-logo">
                        <span>Synced with&nbsp;</span>
                        <?php if ($dark_mode === 'dark') { ?>
                            <img src="<?php echo plugins_url('hipsy-events/img/hipsy_white.png'); ?>" alt="Hipsy logo">
                        <?php } else { ?>
                            <img src="<?php echo plugins_url('hipsy-events/img/hipsy_small.png'); ?>" alt="Hipsy logo">
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

