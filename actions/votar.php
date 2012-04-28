<?php
/**
 * mod/votaciones/actions/votar.php
 * 
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

// once elgg_view stops throwing all sorts of junk into $vars, we can use extract()
elgg_load_library('votaciones:model');
$choice = get_input('response');
$guid = get_input('guid');
$votacion = get_entity($guid);
$respuesta = get_entity($choice);
$owner_guid = get_input('owner_guid');
$access_id = $respuesta->access_id;
$choices = polls_get_choice_array($votacion);


foreach ($choices as $vote_guid){
	if (remove_anotation_by_entity_guid_user_guid('vote', $vote_guid, $owner_guid)){
		system_message(elgg_echo('votaciones:anteriores:borradas:ok'));
	}
}


if ($respuesta->annotate('vote', 1, $access_id, $owner_guid, 'int')){
		system_message(elgg_echo('votaciones:accion:voto:ok'));
	}

//system_message($choices);
