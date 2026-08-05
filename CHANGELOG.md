# Changelog

All notable changes to this project are documented here.

The format is based on [Keep a Changelog](https://keepachangelog.com/).

## [1.2.1] - 2026-08-05

### Security

- Invisible tickets no longer appear on the single-event page. Tickets with `status: invisible` are filtered during sync and render.
- REST API no longer exposes all event postmeta. The public `metadata` field on `/wp-json/wp/v2/events` is limited to event dates only, preventing secret ticket URLs from leaking.

### Changed

- Added automated GitHub Releases workflow. Pushing a `v*` tag builds and publishes `hipsy-events.zip`.
