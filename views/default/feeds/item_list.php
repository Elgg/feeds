<?php
$feed = $vars['feed'];
$userid = $feed->owner_guid;
$user = get_entity($userid);
$icon = elgg_view(
		"profile/icon", array(
								'entity' => $user,
								'size' => 'small',
							  )
	);
	
if($feed->canEdit()){
	$info = '<div id="feeds_feed_buttons_'.$userid.'" class="feeds_visible">';
	$info .= "<div class='delete_button'>" . elgg_view("output/confirmlink",array(
																		'href' => $vars['url'] . "action/feeds/delete?feed=" . $feed->getGUID(),
																		'text' => elgg_echo('delete'),
																		'confirm' => elgg_echo('deleteconfirm')
																	)) . "</div>";
	$info .= '</div>';
}
$user_link = '<a href="'.$user->getUrl().'">'.$user->name.'</a>';
$info .= $user_link.'<br /><a href="'.$feed->url.'">'.$feed->url.'</a>';
$info .= '<div id="feeds_form_container_'.$userid.'" class="feeds_invisible">';
$form = elgg_view('input/text',array('internalname'=>'feed_url','value'=>$feed->url));
$form .= elgg_view('input/hidden',array('internalname'=>'userid','value'=>$userid));
$form .= elgg_view('input/hidden',array('internalname'=>'form_source','value'=>$vars['source']));
$form .= elgg_view('input/hidden',array('internalname'=>'filter','value'=>$vars['filter']));
$form .= elgg_view('input/submit',array('value'=>elgg_echo('feeds:change')));
$cancel_js = 'onclick="javascript:feeds_hide_form('.$userid.');return false;"';
$form .= ' '.elgg_view('input/button',array('value'=>elgg_echo('feeds:cancel'),'js'=>$cancel_js));
$form .= elgg_view('input/securitytoken');
$info .= elgg_view('input/form',array('action'=>$vars['url'].'action/feeds/manage_feed','body'=>$form));
$info .= '</div>';
echo elgg_view_listing($icon,$info);