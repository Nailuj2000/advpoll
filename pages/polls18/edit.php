<?php
$vars = '';
$title = elgg_echo('polls18:edit');
$content = elgg_view_form('polls18/save', array(), $vars);

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
