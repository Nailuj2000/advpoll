<?php

elgg_load_library('advpoll:model');
$guid = get_input('guid');

$poll = get_entity($guid);
$poll_type = $poll->poll_type;
$container = get_entity($poll->container_guid);

if ($poll->canEdit()) {
	if ($poll_type == 'normal') {
		$choices = $poll->getCandidatesArray();
		foreach ($choices as $vote_guid) {
			$vote = get_entity($vote_guid);
			if ($vote->delete()) {
				system_message(elgg_echo('advpoll:candidate:delete:success'));	
			} else {
				register_error(elgg_echo('advpoll:candidate:delete:fail'));
			}
		}
	}
	if ($poll->delete()) {
		system_message(elgg_echo('advpoll:delete:success'));
		if (elgg_instanceof($container, 'group')) {
			forward("advpoll/group/$container->guid/all");
		} else {
			forward("advpoll/owner/$container->username");
		}
	}
} else {
	register_error(elgg_echo('advpoll:delete:notsuccess'));
}
forward(REFERER);
