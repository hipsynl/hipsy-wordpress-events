<?php get_header();
$value = get_option('hipsy_events_dark_mode');
$dark_mode = $value === "1" ? 'dark' : '';

?>
<div class="single-event-wrapper <?php echo $dark_mode ?>">
    <?php
    function ticket($name, $price, $description)
    {
        return <<<EOT
        <div class="ticket">
            <div class="ticket-info">
                <div class="ticket-name">{$name}</div>
                <div class="ticket-description">{$description}</div>
            </div>
            <div class="ticket-price-wrapper">
                <div class="ticket-price">{$price}</div>
                <div class="ticket-description">includes €0,80 servicecosts</div>
            </div>
        </div>
    EOT;
    }
    ?>

    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();

            // Date
            $date_str = get_post_meta(get_the_ID(), 'hipsy_events_date', true);
            $date = new DateTime($date_str);
            $formatted_date = $date->format('F j');
            $formatted_time = $date->format('H:i');
            $date_str2 = get_post_meta(get_the_ID(), 'hipsy_events_date_end', true);
            $date_end = new DateTime($date_str2);
            $formatted_time_end = $date_end->format('H:i');


            $tickets = unserialize(get_post_meta(get_the_ID(), 'hipsy_ticket_info', true));


    ?>
            <div class="event-single-header">
                <div class="event-info">
                    <a class="go-back" href="<?php echo home_url(); ?>/events">← back to all events</a>

                    <p class="event-date"><?php echo "{$formatted_date} at {$formatted_time} - {$formatted_time_end}" ?></p>
                    <h2 class="event-title"><?php the_title(); ?></h2>
                    <div class="event-location">Location: <?php echo get_post_meta(get_the_ID(), 'hipsy_events_location', true); ?></div>
                </div>
                <?php the_post_thumbnail('large', array('class' => 'event-image')); ?>
            </div>
            <div class="event-single-main">
                <div class="event-content-wrapper">
                    <?php the_content(); ?>
                    <a target="_blank" class="event-button" href="<?php echo get_post_meta(get_the_ID(), 'hipsy_events_link', true); ?>">Get tickets</a>
                    <a style="margin-top:20px; display:block;" href="<?php echo home_url(); ?>/events">← back to all events</a>
                </div>
                <div class="ticket-content-wrapper event-content-wrapper">
                    <div class="ticket-content">
                        <h4>Book your tickets</h4>
                        <div class="ticket-list">
                            <?php
                            foreach ($tickets as $ticket) {
                                $price = '€ ' . number_format($ticket['price'], 2, ',', '.');
                                $output = ticket($ticket['name'], $price, $ticket['description']);
                                echo $output;
                            }
                            ?>
                        </div>
                        <a target="_blank" class="event-button" href="<?php echo get_post_meta(get_the_ID(), 'hipsy_events_link', true); ?>">Get tickets</a>
                        <!-- Surround with a tag linking to hipsy.nl -->

                        <a class="hipsy-logo" href="<?php echo home_url(); ?>/events">
                            <span>Powered by </span>
                            <?php if ($dark_mode === 'dark') { ?>
                                <img src="<?php echo plugins_url('hipsy-events/img/hipsy_white.png'); ?>" alt="Hipsy logo">
                            <?php } else { ?>
                                <img src="<?php echo plugins_url('hipsy-events/img/hipsy_small.png'); ?>" alt="Hipsy logo">
                            <?php } ?>
                        </a>
                    </div>
                </div>
            </div>
    <?php } // end while
    } // end if

    ?>
</div>
<?php get_footer(); ?>