<?php

elgg_load_library('advpoll:model');
$guid = get_input('guid');
$votacion = get_entity($guid);
$votacion_tipo = $votacion->poll_tipo;
$container = get_entity($votacion->container_guid);

if ($votacion->canEdit()) {
	if ($votacion_tipo == 'condorcet') {
		if ($votacion->delete()) {
			system_message(elgg_echo('advpoll:delete:success'));	
		}
		forward(REFERER);
	} else {
		$choices = polls_get_choice_array($votacion);
		foreach ($choices as $vote_guid) {
			$vote = get_entity($vote_guid);
			if ($vote->delete()) {
				system_message(elgg_echo('advpoll:opcion:delete:success'));	
			} else {
				register_error(elgg_echo('advpoll:opcion:delete:notsuccess'));
			}
		}
		if ($votacion->delete())  {
			system_message(elgg_echo('advpoll:delete:success'));	
		}
		forward(REFERER);
	}
} else {
	register_error(elgg_echo('advpoll:delete:notsuccess'));
	forward(REFERER);
}

