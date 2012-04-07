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
	// Es recomendable usar como nombre el mismo que el de la vista de la accion
	// como primer termino, antes registrándola de este modo
	// elgg_register_action('votaciones/guardar', "$base_dir/guardar_votacion.php");
	// no tiraba

	// Extend the main CSS file
	elgg_extend_view('css/elgg', 'votaciones/css');

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
}

function maneja_paginas_votaciones($page)
{
	$base_dir = elgg_get_plugins_path() . 'votaciones/pages/';
	
	switch ($page[0]){
		case "totus":
			include $base_dir . 'totus.php';
			break;
		case "editare":
			include $base_dir . 'editare.php';
			break;
		case "nueva":
			include $base_dir . 'editare.php';
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
		
	}
	
	return true;
}

function votaciones_url($entity) {
	$title = elgg_get_friendly_title($entity->title);
	return "votaciones/vistazo/$entity->guid/$title";
}
