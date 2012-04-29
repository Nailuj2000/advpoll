<?php

elgg_push_breadcrumb(elgg_echo('votaciones:activas'));


$title = elgg_echo('votaciones:titulo');

//get all polls order by date

//$content = get_entity(171);
$time = time();
$content = elgg_list_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'poll',
	'metadata_name_value_pairs' => array(
		'name' => 'fecha_fin',
		'value' => $time,
		'operand' => '>',
		'case_sensitive' => TRUE
		),
	
	/**'metadata_name_value_pairs' => array(
		'name' => 'fecha_fin',
		'value' => 'no',
		'operand' => '=',
		'case_sensitive' => TRUE
		),
		*/
	'limit' => 5,
	'full_view' => false,
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
