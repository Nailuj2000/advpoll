<?php
/**
* /var/www/elgg/mod/polls/pages/all.php
*/
$title = elgg_echo('polls18:title');

// Obtiene una lista de polls ordenada por fecha
$content = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'polls',
	'limit' => 10
	));


// Registra un botón "añadir nueva" si no se especifican parámetros añade
// ese por defecto
elgg_register_title_button();

// llama a la vista 'content' del core registrada en el archivo
// views/default/pages/layout/content.php
$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter_context' => 'all',
	'sidebar' => ''
));
// Renderiza la página con el título y el cuerpo
echo elgg_view_page($title, $body);
