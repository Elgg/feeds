<?php
$feed = $vars['feed'];
$filter = $vars['filter'];
$limit = $vars['limit'];
$offset = $vars['offset'];
$date_format = get_plugin_setting('date_format','feeds');
if ($date_format) {
	$date_format = 'l jS \of F'; //'F jS, Y';
}

//echo elgg_view('feeds/js');

?>
<div id="feed_feeds">
<?php 
if ($feed && ($feed_items = $feed->get_items($offset,$limit))) {
	if ($filter == 'titles') {
		$grouped_items = feeds_group_feeds_by_date(array_unique($feed_items));
		foreach ($grouped_items as $group_date => $group) {
?>
			<div class="feed_group">
			<div class="feed_date"><?php echo $group_date; ?></div>
<?php
			foreach ($group as $item) {
?>
				<div class="feed_item_condensed">
					<div class="feed_title"><h2><?php echo '<a href="'.$item->get_permalink().'">'.$item->get_title().'</a>'; ?></h2></div>
				</div>
<?php 		}
			echo "</div>";
		}
	} else { 
		$grouped_items = feeds_group_feeds_by_date(array_unique($feed_items));
		foreach ($grouped_items as $group_date => $group) {
?>
			<div class="feed_group">
			<div class="feed_date"><?php echo $group_date; ?></div>
			<?php foreach ($group as $item) {?>
			<div class="feed_item_full clearfloat">
				<div class="feed_title"><h2><?php echo '<a href="'.$item->get_permalink().'">'.$item->get_title().'</a>'; ?></h2></div>
				<div class="feed_content"><?php echo $item->get_description(); ?></div>
				<div class="entity_subtext"><?php echo elgg_echo('feeds:via').' '.'<a href="'.$item->get_feed()->get_link().'">'.$item->get_feed()->get_title().'</a>'; ?></div>
			</div>
			<?php }
			?>
			</div>
<?php 
		}
	}
} else {
	echo "<p class='margin_top'>".elgg_echo('feeds:no_feeds')."</p>";
}
?>
</div>