<?php

$matriz = elgg_extract('matriz', $vars, array());
echo '<div>';
echo '<br>';
echo "<table class='condorcet-papeleta-table'>";
$i = 0;
$j = 0;
foreach ($matriz as $fila) {
	echo "<tr class='condorcet-tr'>";
	
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

echo "</table>";
echo '</div>';
