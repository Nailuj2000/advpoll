<?php

/*
 * Copyright 2012 DRY Team
 *              - aruberuto
 *              - joker
 *              - *****
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

gatekeeper();
 
elgg_load_library('votaciones:model');


$title = elgg_echo('votaciones:editare');

// Esto de abajo sirve para que aparezca en el menu lateral las opciones
// de grupo y de usuario al que pertenece la votación

$guid = (int) get_input('guid');
$votacion = get_entity($guid);
$container_guid = $votacion->container_guid;
$container = get_entity($container_guid);
elgg_set_page_owner_guid($container->getGUID());
$vars = votaciones_preparar_vars($votacion);
$content = elgg_view_form('editar', array(), $vars);
//$content = elgg_view('votaciones/vistazo', array());
$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
