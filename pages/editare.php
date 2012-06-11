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
 
elgg_load_library('advpoll:model');


$title = elgg_echo('advpoll:editare');
elgg_push_breadcrumb(elgg_echo('advpoll:editare'));

// Esto de abajo sirve para que aparezca en el menu lateral las opciones
// de grupo y de usuario al que pertenece la votación

$guid = (int) get_input('guid');
$poll = get_entity($guid);
$container_guid = $poll->container_guid;
$container = get_entity($container_guid);
elgg_set_page_owner_guid($container->getGUID());
$vars = advpoll_init_vars($poll);
$content = elgg_view_form('advpoll/editar', array(), $vars);
$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
