<?php
/**
 * Elgg feeds plugin index page
 */
global $CONFIG;

// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
require_once(dirname(__FILE__).'/lib/feeds_api.php');

set_context('feeds');

// Get the current page's owner
$page_owner = page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
	$page_owner = $_SESSION['user'];
	set_page_owner($page_owner->getGUID());
}

//set feeds header
if(page_owner() == get_loggedin_userid()) {
	$area1 = elgg_view('page_elements/content_header', array(
		'context' => 'friends',
		'type' => 'feeds',
		'all_link' => "{$CONFIG->site->url}pg/feeds/all",
	));
} else {
	elgg_push_breadcrumb(elgg_echo('feeds:all'), "{$CONFIG->wwwroot}pg/feeds/all");
	elgg_push_breadcrumb(sprintf(elgg_echo("feeds:user"), $page_owner->name));
	
	$area1 .= elgg_view('navigation/breadcrumbs');
	$area1 .= elgg_view('page_elements/content_header_member', array('type' => 'feeds'));
}

$filter = get_input('filter','full');
$callback = get_input('callback');
$limit = (int) get_input('limit',get_plugin_setting('limit','feeds'));
if (!$limit) {
	$limit = 20;
}

$offset = get_input('offset',0);

$title = elgg_echo('feeds:friends:title');

$nav = elgg_view('feeds/nav',array('filter' => $filter,'offset'=>$offset));
$feed_count = feeds_get_friend_feed_urls($page_owner->getGUID(), TRUE);
$feed = feeds_get_feed($page_owner->getGUID(), TRUE);

if (empty($callback) && isloggedin()) {
	$userid = get_loggedin_userid();
	$area2 = elgg_view('feeds/nav',array('filter' => $filter,'offset'=>$offset));
	$area2 .= elgg_view('feeds/sidebar', array('count' => $feed_count));
} else {
	$area2 = '';
}

if ($feed instanceof SimplePie) {
	$body = elgg_view('feeds/feed', array(
		'feed' => $feed,
		'filter' => $filter,
		'limit' => $limit,
		'offset' => $offset,
	));
	
	$pagination = elgg_view('navigation/pagination', array(
		'limit' => $limit,
		'offset' => $offset,
		'count' => $feed->get_item_quantity(),
	));
	
	if (empty($callback)) {
		page_draw($title, elgg_view_layout('one_column_with_sidebar', $area1 . $body . $pagination, $area2));
	} else {
		echo $nav . $body . $pagination;
	}
} else {
	$body = elgg_view('feeds/feed',array('feed'=>$feed,'filter'=>$filter,'limit'=>$limit,'offset'=>$offset));
	$body = $body;
	if (empty($callback)) {
		page_draw($title,elgg_view_layout('one_column_with_sidebar',$area1 . $body, $area2));
	} else {
		echo $body;
	}
}
