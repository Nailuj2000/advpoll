<?php
/**
 * Polls plugin for elgg-1.8
 * Copyright 2012 Lorea, DRY Team
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
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

$vars = advpoll_init_vars($poll);
$title = elgg_echo('advpoll:editing');
elgg_push_breadcrumb(elgg_echo('advpoll:editing'));

// Esto de abajo sirve para que aparezca en el menu lateral las opciones
// de grupo y de usuario al que pertenece la votación

$container_guid = (int) get_input('container_guid');
$container = get_entity($container_guid);
elgg_set_page_owner_guid($container->getGUID());


$content = elgg_view_form('advpoll/save', array(), $vars);
//$content = elgg_view('advpoll/view', array());
$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);
