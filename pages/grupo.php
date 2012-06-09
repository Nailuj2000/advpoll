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

elgg_load_library('advpoll:model');
$title = elgg_echo('advpoll:grupo:titulo');
$container_guid = get_input('guid');
$container = get_entity($container_guid);
$group_context = get_input('group_context');

elgg_register_title_button('advpoll', 'nueva');
elgg_push_breadcrumb($container->name, "votaciones/group/" . $container->guid);
elgg_push_breadcrumb(elgg_echo('advpoll:' . $group_context));

$votaciones = elgg_get_entities(array(
	'type' => 'object',
	'subtype' => 'poll',
	'limit' => 0,
	'container_guid' => $container_guid,
	));

$filtradas = advpoll_get_polls_from_state($votaciones, $group_context);

$content = elgg_view_entity_list(
	$filtradas,
	$vars = array(), 
	$offset = 0, 
	$limit = 5, 
	$full_view = false, 
	$list_type_toggle = true, 
	$pagination = true
	); 	

$filtros = elgg_view('votaciones/filtros_grupos', array(
	'filter_context' => "$group_context",
	'context' => 'advpoll'
	));

$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => $filtros,
	'filter_context' => "$group_context",
	'sidebar' => ''
));
// Renderiza la página con el título y el cuerpo
echo elgg_view_page($title, $body);
