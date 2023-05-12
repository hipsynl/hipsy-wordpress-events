<?php

function hipsy_events_enqueue_styles()
{
    wp_enqueue_style('hipsy-events-style', plugins_url('../style.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'hipsy_events_enqueue_styles');
