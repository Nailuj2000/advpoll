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
$op_ini = polls_get_choice_array($votacion);
$opciones = get_input('opciones');
$opciones_iniciales = pasar_opciones_a_condorcet($op_ini);
$owner_guid = get_input('owner_guid');
$access_id = $votacion->acces_id;
$usuaria = elgg_get_logged_in_user_guid();
$access_col = get_access_array($usuaria);
$access_votar_id = $votacion->access_votar_id;




if (!votacion_en_fecha($votacion)) {
	register_error(elgg_echo('votaciones:accion:votacion:cerrada'));
} else {
	if (!in_array($access_votar_id, $access_col)) {
		register_error(elgg_echo('votaciones:accion:error:permisos'));
	} else {
		$papeleta = matriz_papeleta($opciones_iniciales, $opciones);
		$papeleta_cadena = pasar_matriz_a_cadena($papeleta);
		/**
		if (remove_anotation_by_entity_guid_user_guid('vote_condorcet', $guid, $owner_guid)){
				system_message(elgg_echo('votaciones:anteriores:borradas:ok'));
			}
		*/
		
		if ($votacion->annotate('vote_condorcet', "$papeleta_cadena", $access_id, $owner_guid)){
				system_message(elgg_echo('votaciones:accion:voto:ok'));
			}
	}
}
	
	
	
	
	
	
	
	
	
	
	
	
	
		