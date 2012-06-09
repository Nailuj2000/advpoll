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
$grupo = get_input('guid');

if (elgg_is_logged_in() && $context) {
	$username = elgg_get_logged_in_user_entity()->username;
	$filter_context = elgg_extract('filter_context', $vars, 'all');

	// generate a list of default tabs
	$tabs = array(
		'current' => array(
			'text' => elgg_echo('advpoll:filtros:current'),
			'href' => (isset($vars['current_link'])) ? $vars['current_link'] : "$context/group/$grupo/current",
			'selected' => ($filter_context == 'activas'),
			'priority' => 100,
		),
		'all' => array(
			'text' => elgg_echo('advpoll:filtros:all'),
			'href' => (isset($vars['all_link'])) ? $vars['all_link'] : "$context/group/$grupo/all",
			'selected' => ($filter_context == 'all'),
			'priority' => 200,
		),
		
		'ended' => array(
			'text' => elgg_echo('advpoll:filtros:ended'),
			'href' => (isset($vars['ended_link'])) ? $vars['ended_link'] : "$context/group/$grupo/ended",
			'selected' => ($filter_context == 'cerradas'),
			'priority' => 500,
		),
		'not_initiated' => array(
			'text' => elgg_echo('advpoll:filtros:not_initiated'),
			'href' => (isset($vars['not_initiated_link'])) ? $vars['not_initiated_link'] : "$context/group/$grupo/not_initiaded",
			'selected' => ($filter_context == 'cerradas'),
			'priority' => 500,
		),
		
			);
	
	foreach ($tabs as $name => $tab) {
		$tab['name'] = $name;
		
		elgg_register_menu_item('filter', $tab);
	}

	echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
}
