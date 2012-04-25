<?php

$title = elgg_echo('votaciones:titulo');
$page_owner = elgg_get_logged_in_user_entity();
//get all polls order by date
$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'poll',
	'limit' => 10,
	'full_view' => false,
	'container_guid' => $page_owner->guid,
	));



elgg_register_title_button('votaciones', 'nueva');
$filtros = elgg_view('votaciones/filtros', array(
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
