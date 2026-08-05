# API ticket visibility

This document describes how the Hipsy Events WordPress plugin handles ticket visibility, and optional API hardening recommendations for the Hipsy backend.

## What the plugin relies on

The plugin syncs events from the [List Events](https://docs.hipsy.nl/api-reference/list-events) endpoint:

```
GET https://api.hipsy.nl/v1/organisation/{organisation-slug}/events
```

Each event includes a `tickets` array. Each ticket object may contain a `status` field with one of these values:

| Status | Plugin behaviour |
| --- | --- |
| `sale` | Shown on the single-event page |
| `sold` | Shown on the single-event page |
| `not_available` | Shown on the single-event page |
| `invisible` | **Excluded** from storage and display |

Tickets with `status: invisible` are meant for secret-link sales only. The plugin must never show them on the public WordPress site or persist secret ticket URLs in postmeta.

## No API schema change required

The existing List Events response already includes `status`. The plugin fix (v1.2.1+) filters on this field client-side. No breaking change to the API contract is needed as long as:

- `status` remains present on ticket objects
- `invisible` continues to mean “hidden from public listings”

## Optional API hardening (recommended, not blocking)

While the plugin now strips invisible tickets and URL/token fields before storing data, the Hipsy API can further reduce exposure for any consumer (not only WordPress):

1. **Omit invisible tickets** from the organisation events payload used for public website syncs, or provide a query parameter (e.g. `exclude_invisible=1`) that defaults to excluding them.

2. **Never include secret ticket URLs** (links containing `?ticket=` tokens) in the standard events list response. Secret links should only be available through authenticated organiser endpoints or the Hipsy dashboard.

These changes are defence-in-depth. The WordPress plugin does not depend on them, but they limit blast radius if another integration stores the raw API response.

## WordPress-side behaviour (v1.2.1+)

- **Sync:** `createEvent.php` runs tickets through `hipsy_events_sanitize_tickets()` before writing `hipsy_ticket_info` postmeta.
- **Render:** `singleEventRenderer.php` applies the same filter so legacy meta is safe before the next sync.
- **REST API:** The public `metadata` field on `/wp-json/wp/v2/events` exposes only `hipsy_events_date` and `hipsy_events_date_end`. Ticket data and other postmeta are not exposed.

## Verification

After deploying plugin v1.2.1+:

1. Sync an event with an invisible ticket — it must not appear on the single-event page.
2. `GET /wp-json/wp/v2/events` (unauthenticated) must not return `hipsy_ticket_info` in `metadata`.
3. The Gutenberg events list block must still show event dates correctly.
