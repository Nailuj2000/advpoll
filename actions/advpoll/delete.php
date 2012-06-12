<?php

elgg_load_library('advpoll:model');
$guid = get_input('guid');
$poll = get_entity($guid);
$poll_type = $poll->poll_type;
$container = get_entity($poll->container_guid);

if ($poll->canEdit()) {
	if ($poll_type == 'condorcet') {
		if ($poll->delete()) {
			system_message(elgg_echo('advpoll:delete:success'));	
		}
		forward(REFERER);
	} else {
		$choices = polls_get_choice_array($poll);
		foreach ($choices as $vote_guid) {
			$vote = get_entity($vote_guid);
			if ($vote->delete()) {
				system_message(elgg_echo('advpoll:opcion:delete:success'));	
			} else {
				register_error(elgg_echo('advpoll:opcion:delete:notsuccess'));
			}
		}
		if ($poll->delete())  {
			system_message(elgg_echo('advpoll:delete:success'));	
		}
		forward(REFERER);
	}
} else {
	register_error(elgg_echo('advpoll:delete:notsuccess'));
	forward(REFERER);
}

