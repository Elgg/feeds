<?php
/**
 * Elgg feeds: delete action
 */

// Make sure we're logged in (send us to the front page if not)
if (!isloggedin()) forward();

// Get input data
	$guid = (int) get_input('feed');
		
// Make sure we actually have permission to edit
$feed = get_entity($guid);
if ($feed->getSubtype() == "feeds_feed_url" && $feed->canEdit()) {
	
	// Get owning user
	$owner = get_entity($feed->getOwner());
	// Delete it!
	$rowsaffected = $feed->delete();
	if ($rowsaffected > 0) {
		// Success message
		system_message(elgg_echo("feeds:deleted"));
	} else {
		register_error(elgg_echo("feeds:notdeleted"));
	}
}
// Forward
forward($_SERVER['HTTP_REFERER']);