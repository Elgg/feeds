<?php

$username = get_input('username');

$fullselect = ''; $condensedselect = '';
switch($vars['filter']) {
	case '':		$condensedselect = 'class="selected"';
					break;
	case 'full':	$fullselect = 'class="selected"';
					break;
	case 'titles':	$titlesselect = 'class="selected"';
					break;
	case 'feeds':	$feedsselect = 'class="selected"';
					break;
}

?>
<div class='submenu group'>
	<ul>
		<!-- <li <?php echo $titlesselect; ?> ><a href="<?php echo $vars['url']; ?>pg/feeds/<?php echo $username; ?>?filter=titles&<?php echo $vars['offset']; ?>"><?php echo elgg_echo('feeds:condensed'); ?></a></li>
		<li <?php echo $fullselect; ?> ><a href="<?php echo $vars['url']; ?>pg/feeds/<?php echo $username; ?>?filter=full&<?php echo $vars['offset']; ?>"><?php echo elgg_echo('feeds:full'); ?></a></li> -->
		<?php
			if($username){
		?>
				<li <?php echo $feedsselect; ?> ><a href="<?php echo $vars['url']; ?>pg/feeds/<?php echo $username; ?>/sources/?item_offset=<?php echo $vars['offset']; ?>"><?php echo elgg_echo('feeds:sources'); ?></a></li>
		<?php
			}else{
		?>
				<li <?php echo $feedsselect; ?> ><a href="<?php echo $vars['url']; ?>mod/feeds/feed_sources.php?item_offset=<?php echo $vars['offset']; ?>"><?php echo elgg_echo('feeds:sources'); ?></a></li>
		<?php
			}
		?>
	</ul>
</div><br />
