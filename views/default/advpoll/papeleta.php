<?php

$matriz = elgg_extract('matriz', $vars, array());
$opciones = elgg_extract('opciones', $vars, array());


echo '<div>';
echo '<br>';
echo "<table class='condorcet-papeleta-table'>";
echo "<thead class='condorcet-thead'><tr class='condorcet-tr'>";
echo "<th class='condorcet-th'>";
$texto .= elgg_echo('votaciones:condorcet:info');
$texto .= elgg_view_icon('info');

$direccion = elgg_get_site_url() . "votaciones/ayuda/condorcet";
echo elgg_view('output/url',array(
	'text' => $texto ,
	'href' => $direccion,
	)) . "</th>";
foreach ($opciones as $opcion) {
	echo "<th class='condorcet-th'>" . elgg_echo('votaciones:condorcet:leyenda:opcion') . "$opcion</th>";
}
echo "</tr></thead><tbody>";
$i = 0;
$j = 0;
foreach ($matriz as $fila) {
	echo "<tr class='condorcet-tr'>";
	echo "<th class='condorcet-th'>" . elgg_echo('votaciones:condorcet:leyenda:opcion') . "$opciones[$i]</th>";
	
	foreach($fila as $elemento){
		if ($matriz[$i][$j] === $matriz[$j][$i]) {
			echo "<td class='condorcet-td'>" . $elemento . '</td>';
		} else {
			if ($matriz[$i][$j] < $matriz[$j][$i]) {
				echo "<td class='condorcet-td  rojo'>" . $elemento . '</td>';
			} else {
				if ($matriz[$i][$j] > $matriz[$j][$i]) {
					echo "<td class='condorcet-td  verde'>" . $elemento . '</td>';
				}
			}
		}
	$j++;
	}
	$j = 0;
	$i++;
	echo '</tr>';
}

echo "</tbody></table>";
echo '</div>';



