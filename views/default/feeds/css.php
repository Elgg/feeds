<?php
/**
 * Elgg Feeds CSS
 */
?>

.feed_content img {
	max-height:250px;
	max-width:300px;
	float:right;
	margin:10px 0 10px 20px;
}
.feed_item_full {
	border-bottom:1px solid #dedede;
	padding-bottom:6px;
	margin-bottom:10px;
}
.feed_item_full .entity_subtext {
	margin-top:5px;
}
.edit_feed .submit_button {
	margin-right:10px;
}
.feed_title h2 {
	border-bottom:none;
}
.feed_group .feed_date {
	background-color:#888888;
	color:white;
	font-size:1.2em;
	margin:0 0 15px;
	padding:2px 10px;
	display: table;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
}

/* youtube rss uses it's own table structure */
.feed_content table img { 
	float:left;
	margin:5px 0 10px 0;
}
.feed_content table td {
	min-width:140px;
	width:auto;
	padding-right:10px;
}
.feed_content table td:first-child {
	min-width:120px;
	width:auto;
}
.feed_content table td div {
	display:table;
}