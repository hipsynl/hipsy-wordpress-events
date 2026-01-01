<?php

/**
 * Hipsy Events
 *
 * @package       HIPSY
 * @author        How About Yes
 *
 * @wordpress-plugin
 * Plugin Name:   Hipsy Events
 * Plugin URI:    https://hipsy.nl
 * Description:   Sync Hipsy events from your Hipsy organiser account with your Wordpress website, and let people find your events and sell tickets.
 * Version:       1.2.0
 * Author:        How About Yes
 * Author URI:    https://howaboutyes.com
 * Text Domain:   hipsy-events
 */


include("templates/loopItem.php");
include("functions/styles.php");
include("functions/displayEventsShortcode.php");
include("functions/deleteOldEvents.php");
include("functions/createEvent.php");
include("functions/getHipsyEvents.php");
include("functions/displaySettings.php");
include("functions/initSettings.php");
include("functions/submitSettings.php");
include("functions/customPostType.php");
include("functions/submenuItem.php");
include("functions/customFields.php");
include("functions/singleEventRenderer.php");
include("functions/customTemplates.php");
include("functions/adminColumns.php");
include("functions/restApiSorting.php");
include("functions/blockGutenberg.php");
include("functions/cronJob.php");
include("functions/ajaxLoadMore.php");
