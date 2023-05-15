<?php get_header(); ?>
<div class="events-overview-page">
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post(); ?>
            <h2><?php the_title(); ?></h2>
            <div><?php the_content(); ?></div>
            <p class="text-slate-300">These are all our events</p>
            <!-- <p style="padding-bottom:50px; padding-top:50px;">Events automatically synced with Hipsy.<br>Also an event organiser? <a href="https://hipsy.nl">Download the free plugin here</a></p> -->
    <?php }
    }
    ?>
</div>
<?php get_footer(); ?>