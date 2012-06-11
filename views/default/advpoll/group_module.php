<?php

$grupo = elgg_get_page_owner_entity();

if ($grupo->polls_enable == "no") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "advpoll/group/$grupo->guid/all",
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
	$content = '<p>' . elgg_echo('advpoll:ninguna') . '</p>';
}

$nueva_link = elgg_view('output/url', array(
	'href' => "advpoll/nueva/$grupo->guid",
	'text' => elgg_echo('advpoll:nueva'),
	'is_trusted' => true,
));

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('advpoll:grupo'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $nueva_link,
));
