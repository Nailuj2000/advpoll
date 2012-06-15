<?php

elgg_load_library('advpoll:model');
elgg_push_breadcrumb(elgg_echo('advpoll:activas'));

$context = get_input('context');
$title = elgg_echo('advpoll:title');

$polls = elgg_get_entities(array(
	'type' => 'object',
	'subtype' => 'advpoll',
	'limit' => 0,
	));

$filtradas = advpoll_get_polls_from_state($polls, $context);
$content = elgg_view_entity_list(
	$filtradas,
	$vars = array(), 
	$offset = 0, 
	$limit = 5, 
	$full_view = false, 
	$list_type_toggle = true, 
	$pagination = true
	); 	

elgg_register_title_button('advpoll', 'new');

$filters = elgg_view('advpoll/filters', array(
	'filter_context' => $context,
	'context' => 'advpoll'
	));

// llama a la vista 'content' del core registrada en el archivo
// views/default/pages/layout/content.php
$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => $filters,
	'filter_context' => $context,
	'sidebar' => ''
));


echo elgg_view_page($title, $body);
