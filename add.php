<?php
/**
 * Elgg feeds add page
 */
global $CONFIG;
// Load Elgg engine
require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
gatekeeper();
		
// Get the current page's owner
$page_owner = page_owner_entity();
if ($page_owner === false || is_null($page_owner)) {
	$page_owner = $_SESSION['user'];
	set_page_owner($_SESSION['guid']);
}
if ($page_owner instanceof ElggGroup)
	$container = $page_owner->guid;
	
//set up breadcrumbs
elgg_push_breadcrumb(elgg_echo('feeds:all'), $CONFIG->wwwroot."mod/feeds/all.php");
elgg_push_breadcrumb(elgg_echo("feeds:add"));

$area1 = elgg_view('navigation/breadcrumbs');
$area1 .= elgg_view('page_elements/content_header', array('context' => "action", 'type' => 'feeds'));
		
//instructions
$area1 .= elgg_view('feeds/whatarefeeds');

// Get the form
$area1 .= elgg_view("feeds/forms/add", array('container_guid' => $container, 'userid' => $page_owner->getGUID()));

// Display page
page_draw(elgg_echo('feeds:add'),elgg_view_layout("one_column_with_sidebar", $area1));