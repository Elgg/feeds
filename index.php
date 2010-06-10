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

elgg_push_breadcrumb(elgg_echo('feeds:all'), $CONFIG->wwwroot."mod/feeds/all.php");
elgg_push_breadcrumb(sprintf(elgg_echo("feeds:user"),$page_owner->name));

//set feeds header
if(page_owner() == get_loggedin_userid()) {
	$area1 = elgg_view('page_elements/content_header', array(
		'context' => 'mine',
		'type' => 'feeds',
		'all_link' => "{$CONFIG->site->url}pg/feeds/all",
	));
} else {
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
$callback = get_input('callback');

$title = elgg_echo('feeds:myfeed:title');

$nav = elgg_view('feeds/nav',array('filter' => $filter,'offset'=>$offset));
$feed_count = feeds_get_feed_url_count($page_owner->getGUID());
$feed = feeds_get_feed($page_owner->getGUID());

if (empty($callback) && isloggedin()) {
	$userid = get_loggedin_userid();
	$area2 = elgg_view('feeds/nav',array('filter' => $filter,'offset'=>$offset));
	$area2 .= elgg_view('feeds/sidebar', array('count' => $feed_count));
} else {
	$area2 = '';
}
if ($feed) {
	$body = elgg_view('feeds/feed',array('feed'=>$feed,'filter'=>$filter,'limit'=>$limit,'offset'=>$offset));
	$count = $feed->get_item_quantity();
	$pagination = elgg_view('navigation/pagination', array('limit' => $limit, 'offset' => $offset, 'count' => $count));
	$body = $body.$pagination;
	if (empty($callback)) {
		$body = $body;
		page_draw($title,elgg_view_layout('one_column_with_sidebar',$area1 . $body,$area2));
	} else {
		echo $nav.$body;
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
