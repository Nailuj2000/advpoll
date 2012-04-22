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

elgg_load_library('votaciones:model');
$guid = get_input('guid');
$poll = get_entity($guid);
$poll_cerrada = $poll->poll_cerrada;
$poll_tipo = $poll->poll_tipo;



// Esto de abajo sirve para que aparezca en el menu lateral las opciones
// de grupo y de usuario al que pertenece la votación
$container_guid = $poll->container_guid;
$container = get_entity($container_guid);

elgg_set_page_owner_guid($container->getGUID());

$title = $poll->title;

$content = elgg_view_entity($poll, array('full_view' => true));

if ($poll_tipo == 'condorcet') {
	if ($poll_cerrada == 'no') {
		$content .= elgg_view_form('condorcet_votar' , array() , array(
			'guid' => $guid,
			));
	}
	$content .= elgg_view('votaciones/condorcet_resultados', array(
	'guid' => $guid
	));
} else {
	if ($poll_cerrada == 'no') {
		$content .= elgg_view_form('votar' , array() , array(
			'guid' => $guid,
			));
	}
	$content .= elgg_view('votaciones/resultados', array(
	'votacion' => $poll
	));
}

$content .= elgg_view_comments($poll);
$body = elgg_view_layout('content', array(
	'title' => $title,
	'content' => $content,
	'filter' => '',
	));
	
echo elgg_view_page($title, $body);
	


 
