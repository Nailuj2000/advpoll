<?php
/**
 * Edit / add a poll
 *
 * @package Polls18
 *
 * Copyright 2012 DRY Team
 *              - aruberuto
 *              - joker
 *              - mari
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


$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$path = elgg_extract('path', $vars, '');
$tags = elgg_extract('tags', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$container_guid = elgg_extract('container_guid', $vars);
$guid = elgg_extract('guid', $vars, null);
$opciones = elgg_extract('opciones', $vars, array());
$num_opciones = elgg_extract('numero_opciones', $vars, 0);
?>

<div>
	<label><?php echo elgg_echo('title'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'title', 'value' => $title)); ?>
</div>

<div>
	<label><?php echo elgg_echo('votaciones:discusion:previa'); ?></label><br />
	<?php echo elgg_view('input/text', array('name' => 'path', 'value' => $path)); 
	//TODO Modificarlo para enviar una lista de las páginas de discusión de
	// la votacion en el grupo?>
</div>
<div>
	<label><?php echo elgg_echo('description'); ?></label>
	<?php echo elgg_view('input/longtext', array('name' => 'description', 'value' => $desc)); ?>
</div>
<div>
	<label><?php echo elgg_echo('tags'); ?></label>
	<?php echo elgg_view('input/tags', array('name' => 'tags', 'value' => $tags)); ?>
</div>
<?php

$categories = elgg_view('input/categories', $vars);
if ($categories) {
	echo $categories;
}

?>
<div>
	<label><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>
<div id="opciones"><?php echo elgg_view('input/button', array('id' => 'nueva_opcion', 'value' => elgg_echo('votaciones:nueva:opcion')));?>
<label><?php echo elgg_echo('votaciones:opciones'); ?></label><br />
<?php 



$num_opciones = count($opciones);
for ($i=0; $i<$num_opciones; $i++) {
?>
<div>
	<?php echo elgg_view('input/text', array('name' => 'opcion'.$i, 'class' => 'opcion', 'value' => $opcion)); ?>
</div>
<?php
}
?>
</div>


<div class="elgg-foot">
<?php

//echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));
echo elgg_view('input/hidden', array('name' => 'num_opciones', 'id' => 'num_opciones', 'value' => $num_opciones));

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => elgg_echo("save")));

?>
</div>

<script type="text/javascript">
	$('#nueva_opcion').click(function() {
		var num_opciones = $('.opcion').length;
		$('#opciones').append ('<div><br /><input type="text" name="opcion'+num_opciones+'" id="opcion'+num_opciones+'" class="elgg-input-text opcion" /></div>');
	});
	$('.elgg-form-guardar-votacion').submit(function() {
		$('#num_opciones').val($('.opcion').length);
	});
</script>




