<?php
/**
 * /var/www/elgg/mod/polls/start.php
 * Poll(ita)s plugin for elgg-1.8
 * Página
 * Formulario: creación y votación.
 * 
 */

elgg_register_event_handler('init', 'system', 'polls18_init');

function polls18_init() {
	// Rename this function based on the name of your plugin and update the
	// elgg_register_event_handler() call accordingly
	// Renombra esta función basada en el nombre de tu plugin y actualiza
	// elgg_register_event handler() llamada acordinglui

	// Register a script to handle (usually) a POST request (an action)
	$base_dir = elgg_get_plugins_path() . 'polls18/actions/polls18';
	elgg_register_action('polls18/save', "$base_dir/save.php");

	// Extend the main CSS file
	elgg_extend_view('css/elgg', 'polls18/css');

	// Add a menu item to the main site menu
	$item = new ElggMenuItem('polls18', elgg_echo('polls18:menu'), 'polls18/all');
	#menu
	elgg_register_menu_item('site', $item);
	#manejador de páginas
	elgg_register_page_handler('polls18', 'polls18_page_handler');
}

function polls18_page_handler($page)
{
	global $CONFIG;
	
	switch ($page[0]){
		case "all":
			include $CONFIG->pluginspath . 'polls18/pages/polls18/all.php';
			break;
		case "edit":
			include $CONFIG->pluginspath . 'polls18/pages/polls18/edit.php';
			break;
		case "view":
			set_input('guid', $page[1]);
			include $CONFIG->pluginspath . 'polls18/pages/polls18/view.php';
			break;
		case "friends":
			include $CONFIG->pluginspath . 'polls18/pages/polls18/friends.php';
			break;
		case "owner":
			include $CONFIG->pluginspath . 'polls18/pages/polls18/owner.php';
			break;
		
		}
		return true;
	}
