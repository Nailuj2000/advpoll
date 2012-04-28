<?php

$title = elgg_echo('votaciones:titulo');
elgg_push_breadcrumb(elgg_echo('votaciones:cerradas'));

//get all polls order by date

//$content = get_entity(171);
	
$content = elgg_list_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'poll',
	'metadata_name' => 'poll_cerrada',
	'metadata_value' => 'yes',
	'limit' => 10,
	'full_view' => false,
	));
	


elgg_register_title_button('votaciones', 'nueva');

$filtros = elgg_view('votaciones/filtros', array(
	'filter_context' => 'cerradas',
	'context' => 'votaciones'
	));

// llama a la vista 'content' del core registrada en el archivo
// views/default/pages/layout/content.php
$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => $filtros,
	'filter_context' => 'cerradas',
	'sidebar' => ''
));


echo elgg_view_page($title, $body);
