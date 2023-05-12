<?php get_header(); ?>
<section style="max-width:700px; padding: 50px 15px;">
        <?php

if (have_posts()) {
    while (have_posts()) {
        the_post(); ?>
        <a style="margin-top:10px; display:block;" href="<?php echo home_url(); ?>/events">← back to all events</a>
        <h2 style="margin-top:10px;"><?php the_title(); ?></h2>
        <div><?php the_content(); ?></div>
        <a style="margin-top:20px; display:block;" href="<?php echo home_url(); ?>/events">← back to all events</a>

	<?php } // end while
} // end if

?>
    </section>
<?php get_footer(); ?>