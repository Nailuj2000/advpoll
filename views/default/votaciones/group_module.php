<?php

$grupo = elgg_get_page_owner_entity();

if ($grupo->votaciones_enable == "no") {
	return true;
}

$totus_link = elgg_view('output/url', array(
	'href' => "votaciones/group/$grupo->guid/activas",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtype' => 'poll',
	'container_guid' => $grupo->guid,
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
);



$content = elgg_list_entities($options);

elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('votaciones:ninguna') . '</p>';
}

$nueva_link = elgg_view('output/url', array(
	'href' => "votaciones/nueva/$grupo->guid",
	'text' => elgg_echo('votaciones:nueva'),
	'is_trusted' => true,
));

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('votaciones:grupo'),
	'content' => $content,
	'all_link' => $totus_link,
	'add_link' => $nueva_link,
));
