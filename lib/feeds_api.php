<?php

require_once(dirname(__FILE__).'/simplepie.inc');

/**
 * Returns a SimplePie object containing the appropriate RSS feeds.
 *
 * Assigns the user's registered feeds. If the $friends flag is enabled,
 * the user's friends' feeds are assigned instead.
 *
 * @param int $user
 * @param bool $friends
 * @return SimplePie
 */
function feeds_get_feed($user, $friends=FALSE) {
	global $CONFIG;
	
	$feed_urls = ($friends === FALSE) ? feeds_get_feed_urls($user) : feeds_get_friend_feed_urls($user);
	if (is_array($feed_urls) && !empty($feed_urls)) {
		// retrieve registered URLs from feeds
		$urls = array();
		foreach($feed_urls as $feed_url) {
			$urls[] = $feed_url->url;
		}
		
		$feed = new SimplePie();
		$feed->set_feed_url(array_unique($urls));
		
		$cache_duration = get_plugin_setting('cache_duration','feeds');
		if (isset($cache_duration)) {
			$feed->set_cache_duration($cache_duration);
		} else {
			$feed->set_cache_duration(600);
		}
		
		if (!file_exists("{$CONFIG->dataroot}simplepie_cache")) {
			@mkdir("{$CONFIG->dataroot}simplepie_cache");
		}
		
		$feed->set_cache_location("{$CONFIG->dataroot}simplepie_cache");
		if ($feed->init()) {
			return $feed;
		}
	}
	
	return false;
}

/**
 * Returns an array of RSS feeds registered by the user.
 *
 * If the $count flag is enabled, returns the count of feeds instead.
 *
 * @param int $user_id
 * @param bool $count
 * @param array ElggObject | int
 */
function feeds_get_feed_urls($user_id, $count=FALSE) {
	return elgg_get_entities(array(
		'types' => 'object',
		'subtypes' => 'feeds_feed_url',
		'owner_guids' => (int) $user_id,
		'limit' => 0,
		'count' => $count,
	));
}

/**
 * Returns an array of RSS feeds registered by the user's friends.
 *
 * If the $count flag is enabled, returns the count of feeds instead.
 *
 * @param int $user_id
 * @param bool $count
 * @return array ElggObject | int
 */
function feeds_get_friend_feed_urls($user_id, $count=FALSE) {
	// obtain a list of friends' GUIDs
	$owner_guids = array();
	foreach (get_user_friends($user_id, ELGG_ENTITIES_ANY_VALUE, 0) as $friend) {
		$owner_guids[] = $friend->getGUID();
	}
	
	return elgg_get_entities(array(
		'types' => 'object',
		'subtypes' => 'feeds_feed_url',
		'owner_guids' => $owner_guids,
		'limit' => 0,
		'count' => $count,
	));
}

function feeds_get_feed_url($user_id) {
	if ($user_id) {
		$entities = elgg_get_entities(array('types' => 'object', 'subtypes' => 'feeds_feed_url', 'owner_guids' => $user_id));
		if ($entities) {
			return $entities[0]->url;
		}
	}
}

function feeds_get_feed_urls_from_url($feed_url,$user_id) {
	return get_entities_from_metadata('url',$feed_url,'object','feeds_feed_url',$user_id);
}

function feeds_set_feed_url($url,$user_id) {
	global $CONFIG;
	$__elgg_ts = time();
	$__elgg_token = generate_action_token(time());
	// prevent duplicate feeds for that user
	$feeds = feeds_get_feed_urls_from_url($url,$user_id);
	if ($feeds && count($feeds) > 1) {
		return 'dup';
	}else if ($feeds && count($feeds) == 1) {
		if ($feeds[0]->owner_guid == $user_id) {
			// nothing to do, so return success
			return 'success';
		} else {
			return 'dup';
		}
	}	
	$feed_url = new ElggObject();
	$feed_url->subtype = 'feeds_feed_url';
	$feed_url->owner_guid = $user_id;
	$feed_url->access_id = $CONFIG->default_access; //replace with the users default access level
	$feed_url->url = $url;

	if ($feed_url->save()) {
		//put in a river view
		return 'success';
	} else {
		return 'fail';
	}
}

function feeds_group_feeds_by_date($feeds) {
	$result = array();
	if ($feeds) {
		$count = count($feeds);
		$i = 0;
		while ($i < $count) {
			$current_group = array();
			$current_date = $feeds[$i]->get_date('l, jS \of F');
			while($i < $count) {
				$this_date = $feeds[$i]->get_date('l, jS \of F');
				if ($this_date == $current_date) {
					$current_group[] = $feeds[$i];
					$i += 1;
				} else {
					break;				
				}
			}
			$result[$current_date] = $current_group;				
		}
	}
	return $result;
}