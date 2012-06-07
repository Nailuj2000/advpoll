<?php

$title = elgg_echo('votaciones:titulo');
$page_owner = elgg_get_logged_in_user_entity();

elgg_push_breadcrumb($page_owner->name, "votaciones/amigos/" . $page_owner->name);
elgg_push_breadcrumb(elgg_echo('friends'));
//get all polls order by date
$content = list_user_friends_objects($page_owner->guid, 'poll', 5, false);

elgg_register_title_button('advpoll', 'nueva');
$filtros = elgg_view('advpoll/filtros', array(
	'filter_context' => 'amigos',
	'context' => 'votaciones'
	));

// llama a la vista 'content' del core registrada en el archivo
// views/default/pages/layout/content.php
$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => $filtros,
	'filter_context' => 'amigos',
	'sidebar' => ''
));


echo elgg_view_page($title, $body);
