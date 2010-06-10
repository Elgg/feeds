<?php
$body = '';

$limit = get_plugin_setting('limit', 'feeds');
if (!$limit) {
	$limit = 10;
}

$body .= "<p>".elgg_echo('feeds:settings:limit:title');
$body .= '<br />';
$body .= elgg_view('input/text',array('internalname'=>'params[limit]','value'=>$limit));

$body .= '</p>';

$cache_duration = get_plugin_setting('cache_duration', 'feeds');
if (!$cache_duration) {
	$cache_duration = 600;
}

$body .= "<p>".elgg_echo('feeds:settings:cache_duration:title');
$body .= '<br />';
$body .= elgg_view('input/text',array('internalname'=>'params[cache_duration]','value'=>$cache_duration));

$body .= '</p>';

$throttle = get_plugin_setting('throttle', 'feeds');
if (!$throttle) {
	$throttle = 0;
}

$body .= "<p>".elgg_echo('feeds:settings:throttle:title');
$body .= '<br />';
$body .= elgg_view('input/text',array('internalname'=>'params[throttle]','value'=>$throttle));

$body .= '</p>';

$date_format = get_plugin_setting('date_format', 'feeds');
if (!$date_format) {
	$date_format = 'F jS, Y';
}

$body .= "<p>".elgg_echo('feeds:settings:date_format:title');
$body .= '<br />';
$body .= elgg_view('input/text',array('internalname'=>'params[date_format]','value'=>$date_format));
$body .= '</p>';
echo $body;