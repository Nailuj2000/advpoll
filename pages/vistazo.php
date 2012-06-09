<?php

/*
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

elgg_load_library('advpoll:model');
$guid = get_input('guid');
$poll = get_entity($guid);
$poll_cerrada = $poll->poll_cerrada;
$poll_tipo = $poll->poll_tipo;
$usuaria_guid = elgg_get_logged_in_user_guid();
$auditoria = $poll->auditoria;
$fecha_fin = $poll->end_date;
$fecha_inicio = $poll->start_date;
$mostrar_resultados = $poll->mostrar_resultados;
$can_change_vote = $poll->can_change_vote;

$acceso_lectura = $poll->access_id;
$acceso_votar = $poll->access_votar_id;
$acceso_col = get_access_array($usuaria_guid);

if (!in_array($acceso_lectura, $acceso_col)) {
	forward(REFERER);
} else {	
	// Esto de abajo sirve para que aparezca en el menu lateral las opciones
	// de grupo y de usuario al que pertenece la votación
	$container_guid = $poll->container_guid;
	$container = get_entity($container_guid);
	
	if (elgg_instanceof($container, 'group')) {
		elgg_push_breadcrumb($container->name, "votaciones/group/$container->guid/");
	} else {
		elgg_push_breadcrumb($container->name, "votaciones/trujaman/$container->username");
	}
	elgg_push_breadcrumb($poll->title);
	
	elgg_set_page_owner_guid($container->getGUID());
	elgg_register_title_button('advpoll', 'nueva');
	$title = $poll->title;
	
	$content = elgg_view_entity($poll, array('full_view' => true));
	if (user_has_voted($usuaria_guid, $guid) &&
			is_poll_on_date($poll) && in_array($acceso_votar, $acceso_col) &&
			$can_change_vote == 'yes') {
		$content .= elgg_view('input/button', array(
			'class' => 'pulsa-que-se-expande',
			'value' => elgg_echo('advpoll:condorcet:pulsar:cambio'),
		));
		
	}
	
	if ($auditoria == 'yes' && ($mostrar_resultados == 'yes' or !is_poll_on_date($poll))) {
		$content .= elgg_view('input/button', array('class' => 'resultados-expandibles', 'value' => elgg_echo('advpoll:condorcet:auditoria:mostrar'))); 
	}
	
	if ($poll_tipo == 'condorcet') {
		if (is_poll_on_date($poll) && in_array($acceso_votar, $acceso_col)) {
			$content .= elgg_view_form('advpoll/condorcet_votar' , array() , array(
				'guid' => $guid,
				));
		}	
		if ($mostrar_resultados == 'yes' or !is_poll_on_date($poll)) {
			$content .= elgg_view('advpoll/condorcet_resultados', array(
				'guid' => $guid
			));
		}
	} else { // normal
		if (is_poll_on_date($poll) && in_array($acceso_votar, $acceso_col)) {
			$content .= elgg_view_form('advpoll/votar' , array() , array(
				'guid' => $guid,
				));
		
		}
		if ($mostrar_resultados == 'yes' or !is_poll_on_date($poll)) {
			$content .= elgg_view('advpoll/resultados', array(
			'votacion' => $poll
			));
		}
	}
	
	$content .= elgg_view_comments($poll);
	$body = elgg_view_layout('content', array(
		'title' => $title,
		'content' => $content,
		'filter' => '',
		));
		
	echo elgg_view_page('', $body);
}
	
?>
<script>
$(".resultados-expandibles").click(function () {
if ($(".auditoria-extendible").is(":hidden")) {
$(".auditoria-extendible").slideDown("slow");
} else {
$(".auditoria-extendible").hide();
}
});

$(".pulsa-que-se-expande").click(function () {
		if ($(".parrafo-extendible").is(":hidden")) {
			$(".parrafo-extendible").slideDown("slow");
		} else {
			$(".parrafo-extendible").hide();
	}
});
	$(function() {
		$( "#ordenable" ).sortable();
		$( "#ordenable" ).disableSelection();
	});
	</script>


 
