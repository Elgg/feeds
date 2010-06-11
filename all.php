<?php

/**
 * Elgg feeds plugin all site feeds
 */
global $CONFIG;
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");

require_once(dirname(__FILE__).'/lib/feeds_api.php');

set_context('feeds');

$filter = get_input('filter','full');
$callback = get_input('callback');
$limit = (int) get_input('limit',get_plugin_setting('limit','feeds'));
if (!$limit) {
	$limit = 20;
}
$offset = get_input('offset',0);
$callback = get_input('callback');

$title = elgg_echo('feeds:title');
$nav = elgg_view('feeds/nav',array('filter' => $filter,'offset'=>$offset));
$feed_count = feeds_get_feed_urls(0, TRUE);
$feed = feeds_get_feed();

$tabs = elgg_view('page_elements/content_header', array(
	'context' => 'everyone',
	'type' => 'feeds',
	'all_link' => "{$CONFIG->site->url}pg/feeds/all",
));

if (empty($callback) && isloggedin()) {
	$userid = get_loggedin_userid();
	$area3 = elgg_view('feeds/nav',array('filter' => $filter,'offset'=>$offset));
	$area3 .= elgg_view('feeds/sidebar', array('count' => $feed_count, 'context' => 'all'));
} else {
	$area3 = '';
}
if ($feed) {
	$body = elgg_view('feeds/feed',array('feed'=>$feed,'filter'=>$filter,'limit'=>$limit,'offset'=>$offset));
	$count = $feed->get_item_quantity();
	$pagination = elgg_view('navigation/pagination',array('limit'=>$limit,'offset'=>$offset,'count'=>$count));
	$body = $body.$pagination;
	if (empty($callback)) {
		page_draw($title,elgg_view_layout('one_column_with_sidebar', $tabs.$body,$area3));
	} else {
		echo $body;
	}
} else {
	$body = elgg_view('feeds/feed',array('feed'=>$feed,'filter'=>$filter,'limit'=>$limit,'offset'=>$offset));
	$body = $body;
	if (empty($callback)) {
		page_draw($title,elgg_view_layout('one_column_with_sidebar', $tabs.$body, $area3));
	} else {
		echo $body;
	}
}