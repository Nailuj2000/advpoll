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
elgg_load_library('advpoll:model');
$guid = get_input('guid');
$poll = elgg_extract('entity', $vars, null);

$title = $poll->title;
$desc = $poll->description;
$access_id = $poll->access_id;
$tags = $poll->tags;
$container_guid = $poll->container_guid;

$path = $poll->path;

$auditoria = $poll->auditoria;
$group = get_entity($container_guid);
$start_date = $poll->start_date;
$end_date = $poll->end_date;
$mostrar_resultados = $poll->mostrar_resultados;
$can_change_vote = $poll->can_change_vote;

/**
$group = get_entity($container_guid);
$title = elgg_extract('title', $vars, '');
$desc = elgg_extract('description', $vars, '');
$access_id = elgg_extract('access_id', $vars, ACCESS_DEFAULT);
$tags = elgg_extract('tags', $vars, '');
$container_guid = elgg_extract('container_guid', $vars, elgg_get_page_owner_guid());
$guid = elgg_extract('guid', $vars, null);
$poll = elgg_extract('entity', $vars, null);
$path = elgg_extract('path', $vars, '');
$poll_closed = elgg_extract('poll_closed', $vars, 'no');
$auditoria = elgg_extract('auditoria', $vars, 'no');
*/
if ($poll){
	$opciones = polls_get_choice_array($poll);
} else {
	$opciones = array();
}

	
$num_opciones = count($opciones);
?>

<div>
	<label><?php echo elgg_echo('advpoll:pregunta'); ?></label><br />
	<label><?php echo elgg_view('output/text', array('value' => $title)); ?></label><br />
	<?php echo elgg_echo('advpoll:warning:edit:titulo'); ?>
</div>

<div>
	<label><?php echo elgg_echo('advpoll:discusion:previa'); ?></label><br />
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


<?php 
/**
 * <div id="opciones"><?php echo elgg_view('input/button', array('id' => 'nueva_opcion', 'value' => elgg_echo('advpoll:nueva:opcion')));?>
 * <label><?php echo elgg_echo('advpoll:opciones'); ?></label><br />
 * <?php 
 */
 ?>
<div>
	<label><?php echo elgg_echo('advpoll:opciones'); ?></label><br />
</div>

<div><ul class='choices_ul'>
	<?php
	$i = 0;
	foreach ($opciones as $opcion_guid) {
		$opcion = get_entity($opcion_guid);
		$value = $opcion->text; ?>
		<li><?php echo elgg_view('output/text', array('value' => $value)); ?></li>
		<?php
		$i = $i+1;
	}
	?>
</ul></div>

<div> 
	<?php echo elgg_echo('advpoll:warning:edit'); ?>
</div>
<div>
	<label><?php echo elgg_echo('access'); ?></label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_id', 'value' => $access_id)); ?>
</div>

<div>
	<label><?php echo elgg_echo('advpoll:acceso:vote'); ?></label><br />
	<?php echo elgg_view('input/access', array('name' => 'access_vote_id', 'value' => $access_id)); ?>
</div>

<div>
	<label><?php echo elgg_echo('advpoll:start_date'); ?>
	<?php echo elgg_view('input/date', array(
		'name' => 'start_date',
		'value' => $start_date,
		'timestamp' => true,
		'class' => 'continuos-date',
		)); ?>
	<?php echo elgg_echo('advpoll:end_date'); ?>
	<?php echo elgg_view('input/date', array(
		'name' => 'end_date',
		'value' => $end_date,
		'timestamp' => true,
		'class' => 'continuos-date',
		)); ?>
		</label><br>
	<?php echo elgg_echo('advpoll:help:date'); ?>
</div>

<?php /**
<div>
	<label><?php echo elgg_echo('advpoll:cerrada'); ?></label><br />
	<?php echo elgg_view('input/radio', array(
		'name' => 'poll_closed',
		 'options' => array(
			elgg_echo('option:no') => 'no' ,
			elgg_echo('option:yes') => 'yes',
			),
		'value' => $poll_closed,
		)); ?>
</div>
*/?>

<div>
	<label><?php echo elgg_echo('advpoll:auditoria'); ?></label><br />
	<label><?php echo elgg_echo("option:$auditoria"); ?></label><br />
	<?php echo elgg_echo('advpoll:warning:edit:auditoria'); ?><br />
	
</div>
<div>
	<label><?php echo elgg_echo('advpoll:mostrar:resultados:durante'); ?></label><br />
	<label><?php echo elgg_echo("option:$mostrar_resultados"); ?></label><br />
	<?php echo elgg_echo('advpoll:warning:edit:mostrar:resultados'); ?><br />
	
</div>
<div>
	<label><?php echo elgg_echo('advpoll:can:change:vote'); ?></label><br />
	<?php echo elgg_view('input/radio', array(
		'name' => 'can_change_vote',
		 'options' => array(
			elgg_echo('option:no') => 'no' ,
			elgg_echo('option:yes') => 'yes',
			),
		'value' => $can_change_vote,
	));

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





