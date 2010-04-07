<?php
/**
 * Elgg feed sources
 */

global $CONFIG;

// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
require_once(dirname(__FILE__).'/lib/feeds_api.php');

// Get the current page's owner
$page_owner = page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
	$page_owner = $_SESSION['user'];
	set_page_owner($page_owner->getGUID());
}
$filter = get_input('filter','feeds');
$offset = get_input('offset',0);
elgg_push_breadcrumb(elgg_echo('feeds:all'), $CONFIG->wwwroot."mod/feeds/all.php");
elgg_push_breadcrumb(sprintf(elgg_echo("feeds:sources"),$page_owner->name));

//set feeds header
$area1 .= elgg_view('navigation/breadcrumbs');
$area1 .= elgg_view_title(elgg_echo('feeds:sources'));

$area3 = elgg_view('feeds/nav',array('filter' => "feeds",'offset'=>$offset));

$feeds = elgg_get_entities(array('types' => 'object', 'subtypes' => 'feeds_feed_url', 'owner_guids' => $page_owner->getGUID()));
$title = elgg_echo('feeds:sources');

$body = elgg_view('feeds/sources',array('feeds'=>$feeds,'source'=>'feed_admin','filter'=>'feed_admin'));

page_draw($title,elgg_view_layout('one_column_with_sidebar',$area1.$body, $area3));