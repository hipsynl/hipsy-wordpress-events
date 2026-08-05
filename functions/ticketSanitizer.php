<?php

/**
 * Filter and sanitize ticket data from the Hipsy API for safe storage and display.
 *
 * Excludes invisible tickets and strips secret URLs / tokens from the payload.
 *
 * @param array|null $tickets Raw tickets array from API or stored postmeta.
 * @return array Sanitized tickets safe for storage and public display.
 */
function hipsy_events_sanitize_tickets($tickets)
{
    if (!is_array($tickets)) {
        return array();
    }

    $safe_keys = array('id', 'type', 'name', 'description', 'price', 'status');
    $sanitized = array();

    foreach ($tickets as $ticket) {
        if (!is_array($ticket)) {
            continue;
        }

        $status = isset($ticket['status']) ? $ticket['status'] : '';
        if ($status === 'invisible') {
            continue;
        }

        $safe_ticket = array();
        foreach ($safe_keys as $key) {
            if (array_key_exists($key, $ticket)) {
                $safe_ticket[$key] = $ticket[$key];
            }
        }

        $sanitized[] = $safe_ticket;
    }

    return $sanitized;
}
