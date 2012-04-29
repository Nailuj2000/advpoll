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
		'en_curso' => array(
			'text' => elgg_echo('votaciones:filtros:encurso'),
			'href' => (isset($vars['en_curso_link'])) ? $vars['en_curso_link'] : "$context/en_curso",
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
			'href' => (isset($vars['mtrujaman_link'])) ? $vars['trujaman_link'] : "$context/trujaman/$username",
			'selected' => ($filter_context == 'trujaman'),
			'priority' => 300,
		),
		'amigos' => array(
			'text' => elgg_echo('votaciones:filtros:amigos'),
			'href' => (isset($vars['amigos_link'])) ? $vars['amigos_link'] : "$context/amigos/$username",
			'selected' => ($filter_context == 'burning'),
			'priority' => 400,
		),
		'finalizadas' => array(
			'text' => elgg_echo('votaciones:filtros:finalizadas'),
			'href' => (isset($vars['finalizadas_link'])) ? $vars['finalizadas_link'] : "$context/finalizadas",
			'selected' => ($filter_context == 'finalizadas'),
			'priority' => 500,
		),
		'no_iniciadas' => array(
			'text' => elgg_echo('votaciones:filtros:noiniciadas'),
			'href' => (isset($vars['no_iniciadas_link'])) ? $vars['no_iniciadas_link'] : "$context/no_iniciadas",
			'selected' => ($filter_context == 'no_iniciadas'),
			'priority' => 600,
		),
			);
	
	foreach ($tabs as $name => $tab) {
		$tab['name'] = $name;
		
		elgg_register_menu_item('filter', $tab);
	}

	echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
}
