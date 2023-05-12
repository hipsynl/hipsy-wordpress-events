<?php

function submit_hipsy_events_options()
{
    if (! current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['hipsy_events_api_key'])) {
        $api_key = sanitize_text_field($_POST['hipsy_events_api_key']);
        update_option('hipsy_events_api_key', $api_key);
    }


    if (isset($_POST['hipsy_events_organisation_slug'])) {
        $org_slug = sanitize_text_field($_POST['hipsy_events_organisation_slug']);

        // Validate the slug format
        if (! preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $org_slug)) {
            add_settings_error('hipsy_events_organisation_slug', 'hipsy_events_organisation_slug_error', __('Invalid organisation slug. Please use only lowercase alphanumeric characters and hyphens (-).', 'hipsy-events'));
            return;
        }

        update_option('hipsy_events_organisation_slug', $org_slug);
    }

    if(isset($_POST['custom_button'])
        && $_POST['hipsy_events_organisation_slug']
        && $_POST['hipsy_events_api_key']
    ) {
        $events = get_hipsy_events($_POST["hipsy_events_api_key"], $_POST['hipsy_events_organisation_slug']);
        foreach ($events as $event) {
            createEvent($event);
        }
        return;
    }
}
