<?php get_header(); ?>

<?php
if (have_posts()) {
    while (have_posts()) {
        the_post();
        $date_string = get_post_meta(get_the_ID(), 'hipsy_events_date', true);
        $date = new DateTime($date_string);
        $formatted_date = $date->format('F j \a\t H:i');


?>
        <div class="event-single-header">
            <section style="padding: 50px 50px; background-color:#f5f5f5;width:100%;">
                <a style="margin-top:10px; display:block;" href="<?php echo home_url(); ?>/events">← back to all events</a>

                <h3 style="margin-top:10px;margin-bottom:0px;"><?php echo $formatted_date; ?></h3>
                <h2 style="margin:0px;"><?php the_title(); ?></h2>
                <div>Location: <?php echo get_post_meta(get_the_ID(), 'hipsy_events_location', true); ?></div>
                <a target="_blank" class="hipsy-button" href="<?php echo get_post_meta(get_the_ID(), 'hipsy_events_link', true); ?>">Tickets</a>
            </section>
            <?php the_post_thumbnail('large', array('style' => 'width:100%;object-fit: cover;')); ?>
        </div>
        <section style="max-width:700px; padding: 50px 15px;">
            <div><?php the_content(); ?></div>
            <a style="margin-top:20px; display:block;" href="<?php echo home_url(); ?>/events">← back to all events</a>
        </section>

<?php } // end while
} // end if

?>
<?php get_footer(); ?>