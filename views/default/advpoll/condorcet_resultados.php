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
elgg_load_library('advpoll:model');
elgg_load_js('kinetic');
elgg_load_js('grafo-schulze');
$guid = elgg_extract('guid', $vars, '');
$votacion = get_entity($guid);
$opciones = polls_get_choice_array($votacion);
$num_votos = 0;
$abcd = 65;
$auditoria = $votacion->auditoria;
$mostrar_resultados = $votacion->mostrar_resultados;
$can_change_vote = $votacion->can_change_vote;
foreach ($opciones as $opcion) {
	$abecedario[] = chr($abcd);
	$abcd++;
}
	

$opciones_condorcet = array_keys($opciones);

$condorcet = elgg_get_annotations(array(
	'type' => 'object',
	'subtype' => 'poll',
	'guid' => $guid,
	'annotation_name' => 'vote_condorcet',
	'limit' => 0,
	));


	$i = 0;
echo "<br>";

if ($auditoria == 'yes' && ($mostrar_resultados == 'yes' or !votacion_en_fecha($votacion))) {
		
	echo "<div class='auditoria-extendible'>";	
	
	foreach ($condorcet as $papeleta){
		$papeleta_matriz = pasar_cadena_a_matriz($papeleta->value);
		$papelota = pasar_anotacion_a_lista_ordenada($papeleta);
		$usuario_guid = $papeleta->owner_guid;
		$usuario = get_entity($usuario_guid);
		$nombre = $usuario->name;
		echo "<h3  class='separador-punteado'>" . elgg_echo('advpoll:condorcet:opciones:elegidas:usuario') . $nombre . "</h3>";
		echo "<br>";
		echo "<ol class='papeleta-ol'>";
		
		foreach ($papelota as $opcion) {
			echo "<li>$opcion</li>";
			
		}
		
		echo "</ol>";
		echo "<h4>" . elgg_echo('advpoll:condorcet:opciones:elegidas:papeleta') .  $nombre . "</h4>";
		echo elgg_view('advpoll/condorcet_matrix', array('matriz' => $papeleta_matriz, 'opciones' => $abecedario));
		$matriz[] = $papeleta_matriz;
		if ($i === 0) {
			$matriz_aux = $papeleta_matriz;
		} else {
			$matriz_aux = suma_matrices($matriz_aux, $papeleta_matriz);
		}
		$i++;
		
	}
	echo '</div>';
}

$i2 = 0;
foreach ($condorcet as $papeleta2){
	$papeleta_matriz2 = pasar_cadena_a_matriz($papeleta2->value);
	$papelota2 = pasar_anotacion_a_lista_ordenada($papeleta2);
	$matriz2[] = $papeleta_matriz2;
	if ($i2 === 0) {
		$matriz_aux2 = $papeleta_matriz2;
	} else {
		$matriz_aux2 = suma_matrices($matriz_aux2, $papeleta_matriz2);
	}
	$i2++;
}



echo '<br>';
echo "<h2>" . elgg_echo('advpoll:condorcet:resultado:final') . "</h2>";

echo elgg_view('advpoll/condorcet_matrix', array('matriz' => $matriz_aux2, 'opciones' => $abecedario));
print_r(resultados_condorcet_suma_puntos($matriz_aux2));
$abc = 65;
echo "<br><h3>" . elgg_echo('advpoll:condorcet:leyenda') . "</h3><br>";
echo '<ul><br>';
	foreach ($opciones_condorcet as $opcion){	
		echo "<li><b>" . elgg_echo('advpoll:condorcet:leyenda:opcion') . chr($abc) . ': </b>' . "$opcion</li><br>";
		$abc++;
	}
	
echo '</ul>';
$abc = 65;		


?>	Prueba grafo condorcet
		
	<script type="text/javascript">
		var votaciones = [ <?php foreach ($matriz_aux2 as $linea){
			echo "[" . '"' . chr($abc) . '", ';
			foreach ($linea as $punt) {
				echo $punt . ', ';
			}
			echo '], ';
			$abc++;
		}
		?>
		];
		
	</script>



<div id="container"></div>
<script>
	
	var canvas = grafo_condorcet ('grafo', votaciones);

</script>

























































