<?php
/**
 * mod/votaciones/views/default/forms/votar.php
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


$guid = elgg_extract('guid', $vars, '');
$votacion = get_entity($guid);
$opciones = polls_get_choice_array($votacion);
$owner_guid = elgg_get_logged_in_user_guid();

//print_r($opciones);


?>

<div>
	<?php if (usuario_ha_votado($owner_guid, $guid)) { ?>
		<br><h2 class='pulsa-que-se-expande'><?php echo elgg_echo('votaciones:pulsar:cambio'); ?></h2>
		<div class='parrafo-extendible'>
	<?php } ?>
	<br>
	<h3><?php echo elgg_echo('votaciones:votar:opcion'); ?></h3><br />
	<?php echo elgg_view('input/radio', array(
		'name' => 'response', 
		'options' => $opciones,
	));

?>


<?php

echo elgg_view('input/hidden', array(
	'name' => 'guid',
	'value' => $guid
	));

echo elgg_view('input/hidden', array(
	'name' => 'owner_guid',
	'value' => $owner_guid,
	));
	
echo elgg_view('input/submit', array('value' => elgg_echo("votar")));


?>



	<script>
	$(".pulsa-que-se-expande").click(function () {
		if ($(".parrafo-extendible").is(":hidden")) {
			$(".parrafo-extendible").slideDown("slow");
		} else {
			$(".parrafo-extendible").hide();
	}
});
	</script>


