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
$guid = get_input('guid');
$votacion = get_entity($guid);
$opciones_iniciales = polls_get_choice_array($votacion);
$opciones = get_input(opciones);
$opciones = pasar_opciones_a_condorcet($opciones);
$opciones_iniciales = pasar_opciones_a_condorcet($opciones_iniciales);
$owner_guid = get_input('owner_guid');
$access_id = ACCESS_PUBLIC;


$papeleta = matriz_papeleta($opciones_iniciales, $opciones);

if ($votacion->annotate('vote_condorcet', "$papeleta", $access_id, $owner_guid)){
		//system_message(elgg_echo('votacion:vote:success'));
	}


echo $papeleta;
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
