<?php

$title = elgg_echo('votaciones:titulo');

//get all polls order by date
$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'polls',
	'limit' => 10
	));



elgg_register_title_button();
$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter_context' => 'friends',
	'sidebar' => ''
));

echo elgg_view_page($title, $body);
