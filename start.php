<?php
/**
 *  RSS feed reader
 */

/**
 * RSS feeds initialisation
 */

function feeds_init() {
		
	// Load system configuration
	global $CONFIG;
			
	// Load the language files
	register_translations($CONFIG->pluginspath . "feeds/languages/");
			
	// Register a page handler, so we can have nice URLs
	register_page_handler('feeds','feeds_page_handler');
					
	// Set up menu for users
	add_menu(elgg_echo('item:object:feeds'), $CONFIG->wwwroot . "pg/feeds/all/");
		
	//add to the css
	elgg_extend_view('css', 'feeds/css');
	
	// Register profile menu hook
	register_plugin_hook('profile_menu', 'profile', 'feeds_profile_menu');
}
	
/**
 * Page handler; allows the use of fancy URLs
 *
 * @param array $page From the page_handler function
 * @return true|false Depending on success
 */
function feeds_page_handler($page) {
	
	// The first component of a feeds URL is the username
	if (isset($page[0])) {
		if (($page[0] == 'feeds')) {
			@include(dirname(__FILE__) . "/feed_sources.php");
		}elseif (($page[0] == 'all')) {
			@include(dirname(__FILE__) . "/all.php");
		}else {
			set_input('username',$page[0]);
		}
	}

	// The second part dictates what we're doing
	if (isset($page[1])) {
		switch($page[1]) {
			case "friends":
				include(dirname(__FILE__) . "/friends.php");
				return true;
				break;
			case "new":
				include(dirname(__FILE__) . "/add.php");
				return true;
				break;
			case "sources":
				include(dirname(__FILE__) . "/sources.php");
				return true;
				break;
		}
	} else {
		if($page[0] != 'all'){
			include(dirname(__FILE__) . "/index.php");
			return true;
		}
	}

	return false;
	
}

function feeds_profile_menu($hook, $entity_type, $return_value, $params) {
	global $CONFIG;
	
	if (!($params['owner'] instanceof ElggGroup)) {
		$return_value[] = array(
			'text' => elgg_echo('feeds'),
			'href' => "{$CONFIG->url}pg/feeds/{$params['owner']->username}",
		);
	}
	
	return $return_value;
}
	
// Register events
register_elgg_event_handler('init','system','feeds_init');
	
// Register actions
global $CONFIG;
register_action("feeds/manage_feed",false,$CONFIG->pluginspath . "feeds/actions/manage_feed.php");
register_action("feeds/delete",false,$CONFIG->pluginspath . "feeds/actions/delete.php");