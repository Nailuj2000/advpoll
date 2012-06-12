<?php

/*
 * Copyright 2012 DRY Team
 *              - aruberuto
 *              - joker
 *              - *****
 *              y otros
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 */
elgg_load_library('advpoll:model');
$title = get_input('title');
$desc = get_input('description');
$path = get_input('path');
$tags = string_to_tag_array(get_input('tags'));
$access_id = get_input('access_id');
$container_guid = get_input('container_guid');
//$guid = get_input('guid');
$choices = get_input('choices');
$num_opciones = intval(get_input('num_opciones'));
$owner = intval(get_input('container_guid'));
//$guid = intval(get_input('guid'));

$poll_closed = get_input('poll_closed');
$audit = get_input('audit');
$owner_guid = elgg_get_logged_in_user_guid();
$poll_type = get_input('poll_type');
$start_date = get_input('start_date');
$end_date = get_input('end_date');
$access_vote_id = get_input('access_vote_id');
$show_results = get_input('show_results');
$can_change_vote = get_input('can_change_vote');


if (!$end_date) {
	$end_date = time() + 31536000 ;
}

if (!$start_date) {
	$start_date = time();
}



elgg_make_sticky_form('polls');

$opciones = array();
for ($i=0; $i<$num_opciones; $i++) {
	$opciones[$i] = get_input('opcion'.$i);
	
}

if (!$title) {
	register_error(elgg_echo('advpoll:error:pregunta'));

} else {
	if ($num_opciones < 2) {
		register_error(elgg_echo('advpoll:error:num:opciones'));
	} else { 
		if (array_has_repeated_value($opciones)) {
			register_error(elgg_echo('advpoll:error:opciones:repes'));
		} else {
			if ($start_date > $end_date) {
				register_error(elgg_echo('advpoll:error:wrong_dates'));
			} else {
				
				$poll = new ElggObject();
				$poll->subtype = "poll";
				$poll->title = $title;
				$poll->description = $desc;
				$poll->path = $path;
				$poll->access_id = $access_id;
				$poll->owner_guid = $owner_guid;
				$poll->container_guid = $owner;
				$poll->tags = $tags;
				$poll->poll_closed = $poll_closed;
				$poll->audit = $audit;
				$poll->poll_type = $poll_type;
				$poll->start_date = $start_date;
				$poll->end_date = $end_date;
				$poll->access_vote_id = $access_vote_id;
				$poll->show_results = $show_results;
				$poll->can_change_vote = $can_change_vote;
				$guid = $poll->save();
				
				polls_delete_choices($poll); 
				polls_add_choices($poll,$opciones);
				
				elgg_clear_sticky_form('polls');
				
				if ($guid) { //esta parte creo que esta un poco mal
					system_message(elgg_echo('advpoll:saved'));
					forward($poll->getURL());
				}
				else {
					register_error(elgg_echo('advpoll:error:save'));
					forward(REFERER); // REFERER is a global variable that defines the previous page
				}
			}
		}
	}
}
		
		
		

