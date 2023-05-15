<?php

// Create a submenu item at the bottom of the Hipsy Events menu
function hipsy_events_add_menu_item()
{
    add_submenu_page(
        'edit.php?post_type=events',
        __('Sync with Hipsy', 'hipsy-events'),
        __('Sync with Hipsy', 'hipsy-events'),
        'manage_options',
        'hipsy_events_settings',
        'hipsy_events_settings_page'
    );
}
add_action('admin_menu', 'hipsy_events_add_menu_item');
