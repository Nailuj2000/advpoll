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

elgg_load_library('votaciones:model');
$guid = elgg_extract('guid', $vars, '');
$votacion = get_entity($guid);
$opciones = polls_get_choice_array($votacion);
$owner_guid = elgg_get_logged_in_user_guid();

//print_r($votacion);
//print_r($opciones);

$options = array(
		'relationship' => 'poll_choice',
		'relationship_guid' => $votacion->guid,
		'inverse_relationship' => TRUE,
		'order_by_metadata' => array('name'=>'display_order','direction'=>'ASC'));
	
$choices = elgg_get_entities_from_relationship($options);


?>

<div>
	<h3><?php echo elgg_echo('votaciones:votar:opcion'); ?></h3><br />
	<div class="opciones-condorcet"><ul id="ordenable">
		<?php
		
		foreach ($opciones as $opcion => $guid){
			
			echo '<li class="ui-objeto-ordenable"><p class="parrafo-opciones">'. $opcion . '</p>';
			echo elgg_view('input/hidden', array ('name' => "opciones[]", 'value' => $opcion));
			echo '</li>';
}

echo '</ul></div>';
	
?>

</div>
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
	$(function() {
		$( "#ordenable" ).sortable();
		$( "#ordenable" ).disableSelection();
	});
	</script>



