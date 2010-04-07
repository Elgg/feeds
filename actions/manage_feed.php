<?php
require_once(dirname(dirname(__FILE__)).'/lib/feeds_api.php');

$userid = get_input('userid',0);
$offset = get_input('offset',0);
$user = get_entity($userid);

if ($userid) {
	$result = feeds_set_feed_url(get_input('feed_url',''),$userid);
}

if ($result == 'fail') {
	register_error(elgg_echo('feeds:feed_save_error'));
} else if ($result == 'dup') {
	register_error(elgg_echo('feeds:feed_dup_error'));
} else if ($result == 'success') {
	system_message(elgg_echo('feeds:feed_response'));
}

// Forward
$url = $vars['url'];
forward($url . "pg/feeds/" . $user->username);