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

$desc = get_input('description');
$path = get_input('path');
$tags = get_input('tags');
$access_id = get_input('access_id');
$guid = intval(get_input('guid'));

$poll_cerrada = get_input('poll_cerrada');
$auditoria = get_input('auditoria');

$votacion = get_entity($guid);

	
//escribimos en base de datos	
$votacion->description = $desc;
$votacion->path = $path;
$votacion->access_id = $access_id;
$votacion->tags = $tags;
$votacion->guid = $guid;

$votacion->poll_cerrada = $poll_cerrada;
$votacion->auditoria = $auditoria;

$guid2 = $votacion->save();

if ($guid2){
	system_message(elgg_echo('votacion:guardada'));
	forward($votacion->getURL());
}
else {
	register_error(elgg_echo('votacion:error:guardar'));
	forward(REFERER); // REFERER is a global variable that defines the previous page
}






