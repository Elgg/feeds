<?php
$userid = $vars['userid'];

$throttle = get_plugin_setting('throttle', 'feeds');
if (!$throttle || ($throttle > $vars['feed_count'])) {
	$button = elgg_echo('feeds:add');
	$body .= '<h3>'.elgg_echo('feeds:addfeed:title').'</h3>';
}

$form  = elgg_view('input/hidden',array('internalname'=>'userid','value'=>$userid));
$form .= elgg_view('input/text',array('internalname'=>'feed_url','value'=>''));
$form .= elgg_view('input/submit',array('value'=>$button));
$form .= elgg_view('input/securitytoken');
$body .= elgg_view('input/form',array('action'=>$vars['url'].'action/feeds/manage_feed','body'=>$form));

echo $body;