<?php
/**
 * mod/advpoll/views/default/advpoll/condorcet_results.php
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
$poll = get_entity($guid);
$candidates = $poll->getCandidatesArray();
$num_votos = 0;
$abcd = 65;
$audit = $poll->audit;
$show_results = $poll->show_results;
$can_change_vote = $poll->can_change_vote;
foreach ($candidates as $candidate) {
	$abecedario[] = chr($abcd);
	$abcd++;
}
	

$candidates_condorcet = array_keys($candidates);

$condorcet = elgg_get_annotations(array(
	'type' => 'object',
	'subtype' => 'advpoll',
	'guid' => $guid,
	'annotation_name' => 'vote_condorcet',
	'limit' => 0,
	));


	$i = 0;
echo "<br>";

if ($audit == 'yes' && ($show_results == 'yes' or !is_poll_on_date($poll))) {
		
	echo "<div class='audit-extendible'>";	
	
	foreach ($condorcet as $papeleta){
		$papeleta_matriz = string_to_ballot_matrix($papeleta->value);
		$papelota = get_ordered_candidates_from_annotation($papeleta);
		$usuario_guid = $papeleta->owner_guid;
		$usuario = get_entity($usuario_guid);
		$nombre = $usuario->name;
		echo "<h3  class='separador-punteado'>" . elgg_echo('advpoll:condorcet:candidates:elegidas:usuario') . $nombre . "</h3>";
		echo "<br>";
		echo "<ol class='papeleta-ol'>";
		
		foreach ($papelota as $candidate) {
			echo "<li>$candidate</li>";
			
		}
		
		echo "</ol>";
		echo "<h4>" . elgg_echo('advpoll:condorcet:candidates:elegidas:papeleta') .  $nombre . "</h4>";
		echo elgg_view('advpoll/condorcet_matrix', array('matriz' => $papeleta_matriz, 'candidates' => $abecedario));
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
	$papeleta_matriz2 = string_to_ballot_matrix($papeleta2->value);
	$papelota2 = get_ordered_candidates_from_annotation($papeleta2);
	$matriz2[] = $papeleta_matriz2;
	if ($i2 === 0) {
		$matriz_aux2 = $papeleta_matriz2;
	} else {
		$matriz_aux2 = suma_matrices($matriz_aux2, $papeleta_matriz2);
	}
	$i2++;
}



echo '<br>';
echo "<h2>" . elgg_echo('advpoll:condorcet:results:final') . "</h2>";

echo elgg_view('advpoll/condorcet_matrix', array('matriz' => $matriz_aux2, 'candidates' => $abecedario));
print_r(condorcet_results_sum_points($matriz_aux2));
$abc = 65;
echo "<br><h3>" . elgg_echo('advpoll:condorcet:leyenda') . "</h3><br>";
echo '<ul><br>';
	foreach ($candidates_condorcet as $candidate){	
		echo "<li><b>" . elgg_echo('advpoll:condorcet:legend:candidate') . chr($abc) . ': </b>' . "$candidate</li><br>";
		$abc++;
	}
	
echo '</ul>';
$abc = 65;		


?>	Prueba grafo condorcet
		
	<script type="text/javascript">
		var polls = [ <?php foreach ($matriz_aux2 as $linea){
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
	
	var canvas = grafo_condorcet ('grafo', polls);

</script>

























































