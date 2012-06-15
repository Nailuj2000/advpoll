<?php

$title = elgg_echo('advpoll:title');
$page_owner = elgg_get_logged_in_user_entity();

elgg_push_breadcrumb($page_owner->name, "advpoll/friends/" . $page_owner->name);
elgg_push_breadcrumb(elgg_echo('friends'));
//get all polls order by date
$content = list_user_friends_objects($page_owner->guid, 'advpoll', 5, false);

elgg_register_title_button('advpoll', 'new');
$filters = elgg_view('advpoll/filters', array(
	'filter_context' => 'friends',
	'context' => 'advpoll'
	));

// llama a la vista 'content' del core registrada en el archivo
// views/default/pages/layout/content.php
$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => $filters,
	'filter_context' => 'friends',
	'sidebar' => ''
));


echo elgg_view_page($title, $body);
