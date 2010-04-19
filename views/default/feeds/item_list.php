<?php
$feed = $vars['feed'];
$userid = $feed->owner_guid;
$user = get_entity($userid);
$icon = elgg_view(
		"profile/icon", array(
								'entity' => $user,
								'size' => 'tiny',
							  )
	);
	
if($feed->canEdit()){
	$info = '<div id="feeds_feed_buttons_'.$userid.'" class="entity_metadata">';
	$edit_panel_id = "#feeds_form_container_".$userid;
	$info .= "<span class='entity_edit'><a class='link' onclick=\"elgg_slide_toggle(this,'.entity_listing','$edit_panel_id'); $(this).closest('.entity_listing').find('.input_text').focus();\">" . elgg_echo('edit') . '</a></span>';
	$info .= "<span class='delete_button'>" . elgg_view("output/confirmlink",array(
																		'href' => $vars['url'] . "action/feeds/delete?feed=" . $feed->getGUID(),
																		'text' => elgg_echo('delete'),
																		'confirm' => elgg_echo('deleteconfirm')
																	)) . "</span>";
	$info .= '</div>';
}

$user_link = '<p class="entity_subtext"><a href="'.$user->getUrl().'">'.$user->name.'</a></p>';
$info .= '<p class="entity_title"><a href="'.$feed->url.'">'.$feed->url.'</a></p>'.$user_link;

if($feed->canEdit()){
	$info .= '<div id="feeds_form_container_'.$userid.'" class="edit_feed hidden margin_top">';
	$form = elgg_view('input/text',array('internalname'=>'feed_url','value'=>$feed->url));
	$form .= elgg_view('input/hidden',array('internalname'=>'userid','value'=>$userid));
	$form .= elgg_view('input/hidden',array('internalname'=>'form_source','value'=>$vars['source']));
	$form .= elgg_view('input/hidden',array('internalname'=>'filter','value'=>$vars['filter']));
	$form .= elgg_view('input/submit',array('value'=>elgg_echo('feeds:change')));
	$cancel_js = 'onclick="javascript:feeds_hide_form('.$userid.');return false;"';
	$form .= ' '.elgg_view('input/button',array('value'=>elgg_echo('feeds:cancel'),'js'=>$cancel_js, 'class' => 'action_button disabled'));
	$form .= elgg_view('input/securitytoken');
	$info .= elgg_view('input/form',array('action'=>$vars['url'].'action/feeds/manage_feed','body'=>$form));
	$info .= '</div>';
}
echo elgg_view_listing($icon,$info);