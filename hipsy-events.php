<?php
/*
Plugin Name: Hipsy Events
Description: Fetches and displays a list of events from the Hipsy API.
Version: 1.0
Author: How About Yes
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
include("functions/customTemplates.php");
include("functions/adminColumns.php");
include("functions/restApiSorting.php");
include("functions/blockGutenberg.php");
include("functions/cronJob.php");

