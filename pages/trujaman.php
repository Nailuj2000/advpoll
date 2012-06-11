<?php

$title = elgg_echo('advpoll:titulo');
$page_owner = elgg_get_logged_in_user_entity();
elgg_push_breadcrumb($page_owner->name, "advpoll/amigos/" . $page_owner->name);
//get all polls order by date
$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'poll',
	'limit' => 5,
	'full_view' => false,
	'container_guid' => $page_owner->guid,
	));



elgg_register_title_button('advpoll', 'nueva');
$filtros = elgg_view('advpoll/filtros', array(
	'filter_context' => 'amigos',
	'context' => 'advpoll'
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
