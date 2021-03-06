<?php
/**
 * Elgg feeds plugin
 */

global $CONFIG;

// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
require_once(dirname(__FILE__).'/lib/feeds_api.php');

$filter = get_input('filter','feeds');
$offset = get_input('offset',0);
elgg_push_breadcrumb(elgg_echo('feeds:all'), $CONFIG->wwwroot."mod/feeds/all.php");
elgg_push_breadcrumb(elgg_echo("feeds:sources"));

$feed_count = feeds_get_feed_urls(0, TRUE);

//set feeds header
$area1 .= elgg_view('navigation/breadcrumbs');

$area1 .= "<div class='clearfloat' id='content_header'><div class='content_header_title'>".elgg_view_title(elgg_echo('feeds:sources'))."</div>";
if (isloggedin()) {
	$area1 .= "<div class='content_header_options'><a class='action_button' href='" . $CONFIG->wwwroot . "pg/feeds/" .$_SESSION['user']->username. "/new/'>".elgg_echo('feeds:addfeed:title')."</a></div>";
}
$area1 .= "</div>";


$area3 = elgg_view('feeds/nav',array('filter' => "feeds",'offset'=>$offset));
$area3 .= elgg_view('feeds/sidebar', array('count' => $feed_count));

$feed_url = trim(get_input('feed_url'));
$feeds = elgg_get_entities(array('types' => 'object', 'subtypes' => 'feeds_feed_url'));
$title = elgg_echo('feeds:sources');

$body = elgg_view('feeds/sources',array('feeds'=>$feeds,'source'=>'feed_admin','filter'=>'feed_admin'));

page_draw($title,elgg_view_layout('one_column_with_sidebar',$area1.$body, $area3));