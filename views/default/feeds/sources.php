<?php
$feeds = $vars['feeds'];
$starter_feed = $vars['starter_feed'];
$count = $vars['count'];
$offset = $vars['offset'];
$limit = $vars['limit'];

$pagination = elgg_view('navigation/pagination',array('limit'=>$limit,'offset'=>$offset,'count'=>$count));

echo elgg_view('feeds/js',$vars);

if ($starter_feed && ($count > 1)) {
	echo '<div class="flagged_item">'.elgg_view('feeds/item_admin',array('feed'=>$starter_feed,'source'=>$vars['source'],'filter'=>$vars['filter'])).'</div>';
	echo '<h3>'.elgg_echo('feeds:admin_all_feeds:title').'</h3>';
}

echo $pagination;

if ($feeds) {
	foreach($feeds as $feed) {
		echo elgg_view('feeds/item_list',array('feed'=>$feed,'source'=>$vars['source'],'filter'=>$vars['filter']));
	}
} else {
	echo elgg_echo('feeds:admin:nofeeds');
}

echo $pagination;

?>