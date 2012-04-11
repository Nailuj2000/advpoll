<?php
/**
 * Main content filter
 *
 * Select between user, friends, and all content
 *
 * @uses $vars['filter_context']  Filter context: all, friends, mine
 * @uses $vars['filter_override'] HTML for overriding the default filter (override)
 * @uses $vars['context']         Page context (override)
 */

if (isset($vars['filter_override'])) {
	echo $vars['filter_override'];
	return true;
}

$context = elgg_extract('context', $vars, elgg_get_context());

if (elgg_is_logged_in() && $context) {
	$username = elgg_get_logged_in_user_entity()->username;
	$filter_context = elgg_extract('filter_context', $vars, 'all');

	// generate a list of default tabs
	$tabs = array(
		'activas' => array(
			'text' => elgg_echo('votaciones:filtros:activas'),
			'href' => (isset($vars['activas_link'])) ? $vars['activas_link'] : "$context/activas",
			'selected' => ($filter_context == 'activas'),
			'priority' => 100,
		),
		'totus' => array(
			'text' => elgg_echo('votaciones:filtros:totus'),
			'href' => (isset($vars['totus_link'])) ? $vars['totus_link'] : "$context/totus",
			'selected' => ($filter_context == 'totus'),
			'priority' => 200,
		),
		'trujaman' => array(
			'text' => elgg_echo('votaciones:filtros:trujaman'),
			'href' => (isset($vars['mtrujaman_link'])) ? $vars['trujaman_link'] : "$context/trujaman",
			'selected' => ($filter_context == 'trujaman'),
			'priority' => 600,
		),
		'amigos' => array(
			'text' => elgg_echo('votaciones:filtros:amigos'),
			'href' => (isset($vars['amigos_link'])) ? $vars['amigos_link'] : "$context/amigos",
			'selected' => ($filter_context == 'burning'),
			'priority' => 400,
		),
		'anuladas' => array(
			'text' => elgg_echo('votaciones:filtros:anuladas'),
			'href' => (isset($vars['anuladas_link'])) ? $vars['all_link'] : "$context/anuladas",
			'selected' => ($filter_context == 'all'),
			'priority' => 500,
		),
			);
	
	foreach ($tabs as $name => $tab) {
		$tab['name'] = $name;
		
		elgg_register_menu_item('filter', $tab);
	}

	echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
}
