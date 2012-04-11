<?php

$title = elgg_echo('votaciones:titulo');

//get all polls order by date
$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'polls',
	'limit' => 10
	));



elgg_register_title_button();
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
