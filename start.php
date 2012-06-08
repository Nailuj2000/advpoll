<?php
/**
 * mod/advpoll/start.php
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

elgg_register_event_handler('init', 'system', 'advpoll_init');

/*
 * Init polls plugin
 */
function advpoll_init() {
	// Register actions
	$action_path = elgg_get_plugins_path() . 'advpoll/actions/advpoll';
	elgg_register_action('advpoll/guardar_votacion', "$action_path/guardar_votacion.php");
	elgg_register_action('advpoll/votar', "$action_path/votar.php");
	elgg_register_action('advpoll/condorcet_votar', "$action_path/votar.php");
	elgg_register_action('advpoll/editar', "$action_path/editar.php");
	elgg_register_action('advpoll/delete', "$action_path/delete.php");
	
	// Es recomendable usar como nombre el mismo que el de la vista de la accion
	// como primer termino, antes registrándola de este modo
	// elgg_register_action('advpoll/guardar', "$base_dir/guardar_votacion.php");
	// no tiraba

	// Extend the main CSS file
	elgg_extend_view('css/elgg', 'advpoll/css');
	
	// Register entity type for search
	// Registrar tipo de entidad para las busquedas
	elgg_register_entity_type('object', 'poll');

	// Add a menu item to the main site menu
	$item = new ElggMenuItem('votaciones', elgg_echo('advpoll:menu'), 'advpoll/totus');
	// Register menu
	elgg_register_menu_item('site', $item);
	// Register page handlers
	elgg_register_page_handler('advpoll', 'advpoll_page_handler');
	// Register URL addresses handler
	elgg_register_entity_url_handler('object', 'poll', 'advpoll_url_handler');
	// Register external libraries
	elgg_register_library('advpoll:model', elgg_get_plugins_path() . 'advpoll/lib/modelo.php');
	// Groups module
	add_group_tool_option('votaciones', elgg_echo('advpoll:grupos:habilitarvotaciones'), true);
	elgg_extend_view('groups/tool_latest', 'advpoll/group_module');
	// Javascript libraries for graphics
	$url = elgg_get_site_url() . "mod/advpoll/lib/js/highcharts.js";
	$url2 = elgg_get_site_url() . "mod/advpoll/lib/js/kinetic-v3.9.4.min.js";
	
	elgg_register_js('highcharts', $url, 'footer', 20000);
	elgg_register_js('kinetic', $url2, 'head', 30000);
	elgg_register_js('grafo-schulze', elgg_get_site_url() . "mod/advpoll/lib/js/grafo-schulze.js", 'head', 40000);
	
	// Register plugin hooks handlers
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'advpoll_owner_block_menu');
	
}

/**
 * Dispatches polls pages.
 * URLs take the form of
 *  TODO: add this when names are fixed
 *
 * @param array $page
 * @return bool
 */
function advpoll_page_handler($page)
{
	$base_dir = elgg_get_plugins_path() . 'advpoll/pages/';
	
	elgg_push_breadcrumb(elgg_echo('votaciones'), 'addpoll/totus');
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

/**
 * Format and return the URL for polls.
 *
 * @param ElggObject $entity poll object
 * @return string URL of blog.
 */
function advpoll_url_handler($entity) {
	$title = elgg_get_friendly_title($entity->title);
	return "advpoll/vistazo/$entity->guid/$title";
}

/**
 * Add a menu item to an ownerblock
 */
function advpoll_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "advpoll/trujaman/{$params['entity']->username}";
		$item = new ElggMenuItem('votaciones', elgg_echo('votaciones'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->bookmarks_enable != 'no') {
			$url = "advpoll/group/{$params['entity']->guid}/totus";
			$item = new ElggMenuItem('votaciones', elgg_echo('advpoll:grupo'), $url);
			$return[] = $item;
		}
	}

	return $return;
}
