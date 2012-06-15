<?php

$group = elgg_get_page_owner_entity();

if ($group->polls_enable == "no") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "advpoll/group/$group->guid/all",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtype' => 'advpoll',
	'container_guid' => $group->guid,
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
);



$content = elgg_list_entities($options);

elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('advpoll:ninguna') . '</p>';
}

$new_link = elgg_view('output/url', array(
	'href' => "advpoll/new/$group->guid",
	'text' => elgg_echo('advpoll:new'),
	'is_trusted' => true,
));

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('advpoll:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
