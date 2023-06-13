<?php

function hipsy_events_settings_init()
{
    register_setting('hipsy_events_settings', 'hipsy_events_api_key');
    register_setting('hipsy_events_settings', 'hipsy_events_organisation_slug');
    register_setting('hipsy_events_settings', 'hipsy_events_button_link');
    register_setting('hipsy_events_settings', 'hipsy_events_dark_mode');

    add_settings_section(
        'hipsy_events_settings_section',
        __('Hipsy Events API Key', 'hipsy-events'),
        'hipsy_events_settings_section_cb',
        'hipsy_events_settings'
    );

    add_settings_field(
        'hipsy_events_api_key_field',
        __('API Key', 'hipsy-events'),
        'hipsy_events_api_key_field_cb',
        'hipsy_events_settings',
        'hipsy_events_settings_section'
    );
    add_settings_field(
        'hipsy_events_organisation_slug_field',
        __('Organisation Slug', 'hipsy-events'),
        'hipsy_events_organisation_slug_field_cb',
        'hipsy_events_settings',
        'hipsy_events_settings_section'
    );
    add_settings_field(
        'hipsy_events_button_link_field',
        __('Type of button link', 'hipsy-events'),
        'hipsy_events_button_link_field_cb',
        'hipsy_events_settings',
        'hipsy_events_settings_section'
    );
    add_settings_field(
        'hipsy_events_dark_mode_field',
        __('Enable dark theme', 'hipsy-events'),
        'hipsy_events_dark_mode_field_cb',
        'hipsy_events_settings',
        'hipsy_events_settings_section'
    );
}
add_action('admin_init', 'hipsy_events_settings_init');

function hipsy_events_settings_section_cb()
{
    echo __('Enter your Hipsy Events API key below:', 'hipsy-events');
}

function hipsy_events_api_key_field_cb()
{
    $value = get_option('hipsy_events_api_key');

    echo '<input type="text" id="hipsy_events_api_key" name="hipsy_events_api_key" value="' . esc_attr($value) . '" />';
}

function hipsy_events_organisation_slug_field_cb()
{
    $value = get_option('hipsy_events_organisation_slug');

    echo '<input type="text" id="hipsy_events_organisation_slug" name="hipsy_events_organisation_slug" value="' . esc_attr($value) . '" />';
}

function hipsy_events_button_link_field_cb()
{
    $value = get_option('hipsy_events_button_link');

    echo '<select name="hipsy_events_button_link" id="hipsy_events_button_link">';
    echo '<option value="event" ' . selected($value, 'event') . '>Event page</option>';
    echo '<option value="ticket" ' . selected($value, 'ticket') . '>Ticketshop</option>';
    echo '<option value="popup" disabled ' . selected($value, 'popup') . '>Popup</option>';
    echo '</select>';
}

function hipsy_events_dark_mode_field_cb()
{
    $value = get_option('hipsy_events_dark_mode');

    echo '<input type="checkbox" id="hipsy_events_dark_mode" name="hipsy_events_dark_mode" value="1" ' . checked(1, $value) . ' />';
}
