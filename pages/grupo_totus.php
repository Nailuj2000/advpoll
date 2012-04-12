<?php
/**
* /var/www/elgg/mod/polls/pages/all.php
 *
 * Copyright 2012 DRY Team
 *              - aruberuto
 *              - joker
 *              - ******
 *              y otros
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 */
$title = elgg_echo('votaciones:titulo');
$container_guid = get_input('guid');
// Obtiene una lista de polls ordenada por fecha
$content = elgg_list_entities_from_metadata(array(
	'type' => 'object',
	'subtype' => 'poll',
	'limit' => 10,
	'full_view' => false,
	'container_guid' =>  $container_guid,
	
	));


// Registra un botón "añadir nueva" si no se especifican parámetros añade
// ese por defecto
elgg_register_title_button('votaciones', 'nueva');
$filtros = elgg_view('votaciones/filtros_grupos', array(
	'filter_context' => 'totus',
	'context' => 'votaciones'
	));

// llama a la vista 'content' del core registrada en el archivo
// views/default/pages/layout/content.php
$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => $filtros,
	'filter_context' => 'totus',
	'sidebar' => ''
));
// Renderiza la página con el título y el cuerpo
echo elgg_view_page($title, $body);
