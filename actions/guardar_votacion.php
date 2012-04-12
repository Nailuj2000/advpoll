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
$title = get_input('title');
$desc = get_input('description');
$path = get_input('path');
$tags = get_input('tags');
$access_id = get_input('access_id');
$container_guid = get_input('container_guid');
//$guid = get_input('guid');
$choices = get_input('choices');
$num_opciones = intval(get_input('num_opciones'));
$trujaman = intval(get_input('container_guid'));
//$guid = intval(get_input('guid'));

$poll_cerrada = get_input('poll_cerrada');
$auditoria = get_input('auditoria');
$owner_guid = elgg_get_logged_in_user_guid();

elgg_make_sticky_form('page');

$opciones = array();
for ($i=0; $i<$num_opciones; $i++) {
	$opciones[$i] = get_input('opcion'.$i);
}


$votacion = new ElggObject();

$votacion->subtype = "poll";
$votacion->title = $title;
$votacion->description = $desc;
$votacion->path = $path;
$votacion->access_id = $access_id;
$votacion->owner_guid = $owner_guid;
$votacion->container_guid = $trujaman;
$votacion->tags = $tags;
$votacion->poll_cerrada = $poll_cerrada;
$votacion->auditoria = $auditoria;
$guid = $votacion->save();

polls_delete_choices($votacion); 
polls_add_choices($votacion,$opciones);

elgg_clear_sticky_form('votaciones');

if ($guid) { //esta parte creo que esta un poco mal
	system_message(elgg_echo('votacion:guardada'));
	forward($votacion->getURL());
}
else {
	register_error(elgg_echo('votacion:error:guardar'));
	forward(REFERER); // REFERER is a global variable that defines the previous page
}





