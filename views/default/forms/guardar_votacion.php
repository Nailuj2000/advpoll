<?php
/**
 * Edit / add a poll
 *
 * @package Polls18
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



$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$tags = elgg_extract('tags', $vars, '');
$container_guid = elgg_extract('container_guid', $vars, '');
$guid = elgg_extract('guid', $vars, null);
$votacion = elgg_extract('entity', $vars, null);
$path = elgg_extract('path', $vars, '');
$poll_cerrada = elgg_extract('poll_cerrada', $vars, 'no');
$auditoria = elgg_extract('auditoria', $vars, 'no');
$group = get_entity($container_guid);
$poll_tipo = elgg_extract('poll_tipo', $vars, 'normal');
$fecha_inicio = elgg_extract('fecha_inicio', $vars);
$fecha_fin = elgg_extract('fecha_fin', $vars);


?>

<div>
	<label><?php echo elgg_echo('votaciones:pregunta'); ?></label><br />
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

</div>

<div>
	<label><?php echo elgg_echo('votaciones:fecha:inicio'); ?>
	<?php echo elgg_view('input/date', array(
		'name' => 'fecha_inicio',
		'value' => $fecha_inicio,
		'timestamp' => true,
		'class' => 'fecha-continua',
		)); ?>
	<?php echo elgg_echo('votaciones:fecha:fin'); ?>
	<?php echo elgg_view('input/date', array(
		'name' => 'fecha_fin',
		'value' => $fecha_inicio,
		'timestamp' => true,
		'class' => 'fecha-continua',
		)); ?>
		</label>
	<?php echo elgg_echo('votaciones:fecha:ayuda'); ?>
</div>
<?php /**
<div>
	<label><?php echo elgg_echo('votaciones:cerrada'); ?></label><br />
	<?php echo elgg_view('input/radio', array(
		'name' => 'poll_cerrada',
		 'options' => array(
			elgg_echo('option:no') => 'no' ,
			elgg_echo('option:yes') => 'yes',
			),
		'value' => $poll_cerrada,
		)); ?>
</div>
*/ ?>
<div>
	<label><?php echo elgg_echo('votaciones:auditoria'); ?></label><br />
	<?php echo elgg_view('input/radio', array(
		'name' => 'auditoria',
		 'options' => array(
			'no' => 'no' ,
			'yes' => 'yes',
			),
		'value' => $auditoria,
	));

	?>
</div>

<div>
	<label><?php echo elgg_echo('votaciones:tipo'); ?></label><br />
	<?php echo elgg_view('input/radio', array(
		'name' => 'poll_tipo',
		 'options' => array(
			elgg_echo('option:normal') => 'normal' ,
			elgg_echo('option:condorcet') => 'condorcet',
			),
		'value' => $poll_tipo,
		)); ?>
</div>


<div class="elgg-foot">
<?php

echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $container_guid));
echo elgg_view('input/hidden', array('name' => 'num_opciones', 'id' => 'num_opciones', 'value' => $num_opciones));

if ($guid) {
	echo elgg_view('input/hidden', array('name' => 'guid', 'value' => $guid));
}

echo elgg_view('input/submit', array('value' => elgg_echo("save")));

?>
</div>

<script type="text/javascript">
	$('#nueva_opcion').click(function() {
		// si estás aquí dentro es porque has pulsado el botón nueva_opcion
		// metemos en la variable número de opciones,
		// la longitud de opciones que haya o no haya... 0,1,2,3,4
		var num_opciones = $('.opcion').length;
		
		// Añadimos al selector <div id=opciones... un input text
		$('#opciones').append ('<div id="'+num_opciones+'"><br /><input type="text" name="opcion'+num_opciones+'" id="opcion'+num_opciones+'" class="elgg-input-text opcion" /><span class="eliminarcontomate" rel="'+num_opciones+'" ><?php echo elgg_echo('votaciones:opcion:borrame'); ?></span></div>');
		
		// cosa rara para que funcione el live, quizás.
		return false; 
	});
	$('.eliminarcontomate').live('click', function() {
	    // alert('hola caracola');
	    
	    // si estás aquí dentro es porque has pulsado alguna palabra,
	    // "borrame" contenida dentro de un class="eliminarcontomate"
	    // metemos dentro de la variable cual_borro, el contenido de 
	    // rel="0 o 1 o 2 o 3 o 4".....rel="'+num_opciones+'" para luego
	    // borrar todo el div de la opcion <div id="'+num_opciones+'">
	    var cual_borro = $(this).attr('rel');
	    
	    // metemos en la variable chapucilla, el selector(id) que se va a usar
	    var chapucilla = "#"+ cual_borro;
	    
	    // removemos chapucilla.
	    $(chapucilla).remove();
	    return false;
	});

	//$('.eliminarcontomate').click(function() {
		//alert('ha pulsado el boton borrame');
		//var cual_borro = $(this).attr('rel');
		//var x = '#'+ cual_borro
		//alert(x);
		//$(x).fadeOut();
	//});
	$('.elgg-form-guardar-votacion').submit(function() {
		$('#num_opciones').val($('.opcion').length);
	});
</script>

