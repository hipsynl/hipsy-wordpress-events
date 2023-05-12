<?php

function hipsy_events_settings_init()
{
    register_setting('hipsy_events_settings', 'hipsy_events_api_key');
    register_setting('hipsy_events_settings', 'hipsy_events_organisation_slug');

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
