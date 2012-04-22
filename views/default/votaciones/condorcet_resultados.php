<?php
/**
 * mod/votaciones/views/default/votaciones/resultados.php
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
$guid = elgg_extract('guid', $vars, '');
$votacion = get_entity($guid);
$opciones = polls_get_choice_array($votacion);
$num_votos = 0;


$condorcet = elgg_get_annotations(array(
	'type' => 'object',
	'subtype' => 'poll',
	'guid' => $guid,
	'anotation_name' => 'vote_condorcet',
	'limit' => 0,
	));


	$i = 0;
foreach ($condorcet as $papeleta){
	$papeleta_matriz = pasar_cadena_a_matriz($papeleta->value);
	$content .= elgg_view('votaciones/papeleta', array('matriz' => $papeleta_matriz));
	$matriz[] = $papeleta_matriz;
	if ($i === 0) {
		$matriz_aux = $papeleta_matriz;
	} else {
		$matriz_aux = suma_matrices($matriz_aux, $papeleta_matriz);
	}
	$i++;
	
}

$content .= elgg_view('votaciones/papeleta', array('matriz' => $matriz_aux));
echo $content;






