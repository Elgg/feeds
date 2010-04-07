<?php
$body = '';

$limit = get_plugin_setting('limit', 'feeds');
if (!$limit) {
	$limit = 10;
}

$body .= elgg_echo('feeds:settings:limit:title');
$body .= '<br />';
$body .= elgg_view('input/text',array('internalname'=>'params[limit]','value'=>$limit));

$body .= '<br />';

$cache_duration = get_plugin_setting('cache_duration', 'feeds');
if (!$cache_duration) {
	$cache_duration = 600;
}

$body .= elgg_echo('feeds:settings:cache_duration:title');
$body .= '<br />';
$body .= elgg_view('input/text',array('internalname'=>'params[cache_duration]','value'=>$cache_duration));

$body .= '<br />';

$throttle = get_plugin_setting('throttle', 'feeds');
if (!$throttle) {
	$throttle = 0;
}

$body .= elgg_echo('feeds:settings:throttle:title');
$body .= '<br />';
$body .= elgg_view('input/text',array('internalname'=>'params[throttle]','value'=>$throttle));

$body .= '<br />';

$date_format = get_plugin_setting('date_format', 'feeds');
if (!$date_format) {
	$date_format = 'F jS, Y';
}

$body .= elgg_echo('feeds:settings:date_format:title');
$body .= '<br />';
$body .= elgg_view('input/text',array('internalname'=>'params[date_format]','value'=>$date_format));

echo $body;