<?php get_header(); ?>

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
                <h1 class="event-title"><?php the_title(); ?></h1>
                <div class="event-location">Location: <?php echo get_post_meta(get_the_ID(), 'hipsy_events_location', true); ?></div>
                <a target="_blank" class="md:hidden event-button" href="<?php echo get_post_meta(get_the_ID(), 'hipsy_events_link', true); ?>">Get tickets</a>

            </div>
            <?php the_post_thumbnail('large', array('class' => 'event-image')); ?>
        </div>
        <div class="grid grid-cols-1 lg:!grid-cols-2 md:gap-8 relative">
            <div class="event-content-wrapper md:py-16 pt-8">
                <?php the_content(); ?>
                <a target="_blank" class="event-button" href="<?php echo get_post_meta(get_the_ID(), 'hipsy_events_link', true); ?>">Get tickets</a>
                <a style="margin-top:20px; display:block;" href="<?php echo home_url(); ?>/events">← back to all events</a>
            </div>
            <div class="event-content-wrapper py-16 sticky top-6 self-start">
                <div class="p-5 bg-hipsy_teal rounded-md">
                    <p class="mb-2">Book your tickets</p>
                    <hr class="border-black/10 mb-4">
                    <div class="flex flex-col gap-5 mb-5">
                        <?php
                        foreach ($tickets as $ticket) {
                            $price = '€ ' . number_format($ticket['price'], 2, ',', '.');
                            $output = ticket($ticket['name'], $price, $ticket['description']);
                            echo $output;
                        }
                        ?>
                    </div>
                    <a target="_blank" class="event-button" href="<?php echo get_post_meta(get_the_ID(), 'hipsy_events_link', true); ?>">Get tickets</a>
                </div>
            </div>
        </div>
<?php } // end while
} // end if

?>
<?php get_footer(); ?>