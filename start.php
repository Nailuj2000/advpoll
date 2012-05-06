<?php
/**
 * mod/votaciones/start.php
 * Poll(ita)s plugin for elgg-1.8
 * Página
 * Formulario: creación y votación.
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

elgg_register_event_handler('init', 'system', 'votaciones_init');

function votaciones_init() {

	$base_dir = elgg_get_plugins_path() . 'votaciones/actions';
	elgg_register_action('guardar_votacion', "$base_dir/guardar_votacion.php");
	elgg_register_action('votar', "$base_dir/votar.php");
	elgg_register_action('condorcet_votar', "$base_dir/condorcet_votar.php");
	elgg_register_action('editar', "$base_dir/editar.php");
	elgg_register_action('votaciones/delete', "$base_dir/delete.php");
	
	// Es recomendable usar como nombre el mismo que el de la vista de la accion
	// como primer termino, antes registrándola de este modo
	// elgg_register_action('votaciones/guardar', "$base_dir/guardar_votacion.php");
	// no tiraba

	// Extend the main CSS file
	elgg_extend_view('css/elgg', 'votaciones/css');
	
	// Register entity type for search
	// Registrar tipo de entidad para las busquedas
	elgg_register_entity_type('object', 'poll');

	// Add a menu item to the main site menu
	$item = new ElggMenuItem('votaciones', elgg_echo('votaciones:menu'), 'votaciones/totus');
	#menu
	elgg_register_menu_item('site', $item);
	#manejador de páginas
	elgg_register_page_handler('votaciones', 'maneja_paginas_votaciones');
	#manejador de direccion url
	elgg_register_entity_url_handler('object', 'poll', 'votaciones_url');
	//registra librerias externas
	elgg_register_library('votaciones:model', elgg_get_plugins_path() . 'votaciones/lib/modelo.php');
	// Módulo para grupos
	add_group_tool_option('votaciones', elgg_echo('votaciones:grupos:habilitarvotaciones'), true);
	elgg_extend_view('groups/tool_latest', 'votaciones/group_module');
	//libreria para las tartas
	$url = elgg_get_site_url() . "mod/votaciones/lib/js/highcharts.js";
	$url2 = elgg_get_site_url() . "mod/votaciones/lib/js/kinetic-v3.9.4.min.js";
	elgg_register_js('highcharts', $url, 'footer', 20000);
	elgg_register_js('kinetic', $url2, 'head', 30000);
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'votaciones_trujaman_menu_block');
	
}

function maneja_paginas_votaciones($page)
{
	$base_dir = elgg_get_plugins_path() . 'votaciones/pages/';
	
	elgg_push_breadcrumb(elgg_echo('votaciones'), 'votaciones/totus');
	switch ($page[0]){
		case "totus":
			include $base_dir . 'totus.php';
			break;
		case "edit":
			set_input('guid', $page[1]);
			include $base_dir . 'editare.php';
			break;
		case "nueva":
			set_input('container_guid', $page[1]);
			include $base_dir . 'creare.php';
			break;
		case "vistazo":
			set_input('guid', $page[1]);
			include $base_dir . 'vistazo.php';
			break;
		case "amigos":
			include $base_dir . 'amigos.php';
			break;
		case "trujaman":
			include $base_dir . 'trujaman.php';
			break;
		case "en_curso":
			set_input('contexto', $page[0]);
			include $base_dir . 'listas.php';
			break;
		case "finalizadas":
			set_input('contexto', $page[0]);
			include $base_dir . 'listas.php';
			break;
		case "no_iniciadas":
			set_input('contexto', $page[0]);
			include $base_dir . 'listas.php';
			break;
		case "ayuda":
			switch ($page[1]) {
				case "condorcet":
					include $base_dir . 'condorcet_ayuda.php';
					break;
			}
			break;			
		case "group":
			set_input('guid', $page[1]);
			set_input('group_context', $page[2]);
			//if ($page[2] == 'totus') {
				include $base_dir . 'grupo.php';
			//}
			//if ($page[2] == 'cerradas'){
			//	include $base_dir . 'grupo_cerradas.php';
			//} else {
			//	include $base_dir . 'grupo_activas.php';
			//}
			break;
				
	}
	
	return true;
}

function votaciones_url($entity) {
	$title = elgg_get_friendly_title($entity->title);
	return "votaciones/vistazo/$entity->guid/$title";
}



function votaciones_trujaman_menu_block($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "votaciones/trujaman/{$params['entity']->username}";
		$item = new ElggMenuItem('votaciones', elgg_echo('votaciones'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->bookmarks_enable != 'no') {
			$url = "votaciones/group/{$params['entity']->guid}/totus";
			$item = new ElggMenuItem('votaciones', elgg_echo('votaciones:grupo'), $url);
			$return[] = $item;
		}
	}

	return $return;
}
