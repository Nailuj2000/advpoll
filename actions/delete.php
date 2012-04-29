<?php

elgg_load_library('votaciones:model');
$guid = get_input('guid');
$votacion = get_entity($guid);
$votacion_tipo = $votacion->poll_tipo;
$container = get_entity($votacion->container_guid);

if ($votacion->canEdit()) {
	if ($votacion_tipo == 'condorcet') {
		if ($votacion->delete()) {
			system_message(elgg_echo('votaciones:delete:success'));	
		}
		if (elgg_instanceof($container, 'group')) {
			forward("votaciones/group/$container->guid/activas");
		} else {
			forward("votaciones/activas");
		}
	} else {
		$choices = polls_get_choice_array($votacion);
		foreach ($choices as $vote_guid) {
			$vote = get_entity($vote_guid);
			if ($vote->delete()) {
				system_message(elgg_echo('votaciones:opcion:delete:success'));	
			} else {
				register_error(elgg_echo('votaciones:opcion:delete:notsuccess'));
			}
		}
		if ($votacion->delete())  {
			system_message(elgg_echo('votaciones:delete:success'));	
		}
		if (elgg_instanceof($container, 'group')) {
			forward("votaciones/group/$container->guid/activas");
		} else {
			forward("votaciones/activas");
		}
	}
} else {
	register_error(elgg_echo('votaciones:delete:notsuccess'));
}

