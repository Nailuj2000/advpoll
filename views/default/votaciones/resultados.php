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
$votacion = elgg_extract('votacion', $vars, '');
$opciones = polls_get_choice_array($votacion);
$num_votos = 0;

?>
<br />
<div>
	<h3><?php echo elgg_echo('votaciones:resultados'); ?></h3><br />
	<?php
foreach ($opciones as $opcion){
	$respuesta = get_entity($opcion);
	$opcion_num_votos = $respuesta->countAnnotations('vote');
	$num_votos = $num_votos + $opcion_num_votos;
	echo "<div>	<label>";
	echo " $respuesta->text ";
	echo elgg_echo('votaciones:numero:votos:opcion') . " $opcion_num_votos";
	echo "</label></div>";
	
}
echo "<div>	<label>";
	echo elgg_echo('votaciones:numero:votos:total') . " $num_votos";
	echo "</label></div>";


//print_r($opciones);

