<?php

$title = elgg_echo('votaciones:titulo');

//get all polls order by date

//$content = get_entity(171);
	
$content = elgg_list_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'poll',
	'metadata_name' => 'poll_cerrada',
	'metadata_value' => 'no',
	'limit' => 10,
	));
	


elgg_register_title_button('votaciones', 'nueva');
$filtros = elgg_view('votaciones/filtros', array(
	'filter_context' => 'activas',
	'context' => 'votaciones'
	));

// llama a la vista 'content' del core registrada en el archivo
// views/default/pages/layout/content.php
$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => $filtros,
	'filter_context' => 'activas',
	'sidebar' => ''
));


echo elgg_view_page($title, $body);
