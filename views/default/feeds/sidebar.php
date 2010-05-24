<?php
$count = $vars['count'];
$context = $vars['context'];

echo "<h3>Feeds stats</h3>";

if($context == 'all')
	echo "So far, " . $count . " feeds have been added to the site feed reader.";
else
	echo $count . " feed(s) added.";