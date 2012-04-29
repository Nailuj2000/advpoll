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
$abcd = 65;
foreach ($opciones as $opcion) {
	$abecedario[] = chr($abcd);
	$abcd++;
}
	

$opciones_condorcet = pasar_opciones_a_condorcet($opciones);

$condorcet = elgg_get_annotations(array(
	'type' => 'object',
	'subtype' => 'poll',
	'guid' => $guid,
	'anotation_name' => 'vote_condorcet',
	'limit' => 0,
	));


	$i = 0;
echo "<br>";

//echo "<h2 class='resultados-expandibles'>" . elgg_echo('votaciones:condorcet:auditoria:mostrar') . "</h2>";
echo "<div class='auditoria-extendible'>";	

foreach ($condorcet as $papeleta){
	$papeleta_matriz = pasar_cadena_a_matriz($papeleta->value);
	$papelota = pasar_anotacion_a_lista_ordenada($papeleta);
	$usuario_guid = $papeleta->owner_guid;
	$usuario = get_entity($usuario_guid);
	$nombre = $usuario->name;
	echo "<h3  class='separador-punteado'>" . elgg_echo('votaciones:condorcet:opciones:elegidas:usuario') . $nombre . "</h3>";
	echo "<br>";
	echo "<ol class='papeleta-ol'>";
	
	foreach ($papelota as $opcion) {
		echo "<li>$opcion</li>";
		
	}
	
	echo "</ol>";
	echo "<h4>" . elgg_echo('votaciones:condorcet:opciones:elegidas:papeleta') .  $nombre . "</h4>";
	echo elgg_view('votaciones/papeleta', array('matriz' => $papeleta_matriz, 'opciones' => $abecedario));
	$matriz[] = $papeleta_matriz;
	if ($i === 0) {
		$matriz_aux = $papeleta_matriz;
	} else {
		$matriz_aux = suma_matrices($matriz_aux, $papeleta_matriz);
	}
	$i++;
	
}
echo '</div>';
echo '<div><br>';
echo "<h2>" . elgg_echo('votaciones:condorcet:resultado:final') . "</h2>";

echo elgg_view('votaciones/papeleta', array('matriz' => $matriz_aux, 'opciones' => $abecedario));
		
$abc = 65;
echo "<br><h3>" . elgg_echo('votaciones:condorcet:leyenda') . "</h3><br>";
echo '<ul><br>';
	foreach ($opciones_condorcet as $opcion){	
		echo "<li><b>" . elgg_echo('votaciones:condorcet:leyenda:opcion') . chr($abc) . ': </b>' . "$opcion</li><br>";
		$abc++;
	}
	
echo '</ul></div>';
		


?>



