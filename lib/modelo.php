<?php
/*
 * Copyright 2012 DRY Team
 *              - aruberuto
 *              - joker
 *              - ****
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


function polls_get_choices($poll) {
	$options = array(
		'relationship' => 'poll_choice',
		'relationship_guid' => $poll->guid,
		'inverse_relationship' => TRUE,
		'order_by_metadata' => array('name'=>'display_order','direction'=>'ASC'),
		'limit' => 0,
	);
	return elgg_get_entities_from_relationship($options);
}

/**
 *  Get an array of all poll choices guids.
 *  
 *  @param $poll  The poll the choices of which we want.
 *  @return an array containing a relation between the choice text and
 *  the choice guid. 
 */
function polls_get_choice_array($poll) {
	$choices = polls_get_choices($poll);
	$responses = array();
	if ($choices) {
		foreach($choices as $choice) {
			$label = $choice->text;
			// force numbers to be strings
			$responses["$label" . ' '] = $choice->guid;
		}
	}	
	return $responses;
}

/**
 * Save a list of choices in a poll. For each choice, an ElggObject is created,
 * and related to the poll as an Elgg relationship.
 * 
 * @param $poll  A poll entity.
 * @param $choices  A collections of strings.
 */
function polls_add_choices($poll,$choices) {
	$i = 0;
	if ($choices) {
		foreach($choices as $choice) {
			$poll_choice = new ElggObject();
			$poll_choice->subtype = "poll_choice";
			$poll_choice->text = $choice;
			$poll_choice->display_order = $i*10;
			$poll_choice->access_id = $poll->access_id;
			$poll_choice->save();
			add_entity_relationship($poll_choice->guid, 'poll_choice', $poll->guid);
			$i += 1;
		}
	}
}

/**
 * Removes all choices associated with a poll.
 * 
 * @param $poll  A poll entity.
 */
function polls_delete_choices($poll) {
	$choices = polls_get_choices($poll);
	if ($choices) {
		foreach($choices as $choice) {
			$choice->delete();
		}
	}
}

/**
 * Replaces the current set of polls choices for a new one.
 * 
 * @param $poll  A poll entity.
 * @param $new_choices  A collection of strings.
 */
function polls_replace_choices($poll,$new_choices) {
	polls_delete_choices($poll);
	polls_add_choices($poll, $new_choices);
}

/**
 * Removes all annotation of a certain type from an entity that belong to a given user.
 * 
 * @param $annotation_name  A string with the name of the annotation's type to remove.
 * @param $entity_guid  The guid of the entity from which remove annotations.
 * @param $user_guid  The guid of the user the annotation from whom we want to remove.
 */
function remove_annotation_by_entity_guid_user_guid($annotation_name, $entity_guid, $user_guid){
	$entity = get_entity($entity_guid);
	$all_annotations = $entity->getAnnotations($annotation_name);
	foreach ($all_annotations as $annotation_entity){
		if ($annotation_entity->owner_guid == $user_guid &&
				$annotation_entity->entity_guid == $entity_guid){
			$annotation_id = $annotation_entity->id;
			elgg_delete_annotation_by_id($annotation_id);
			$return = TRUE;	
		} 
	}
	return $return;
}

/**
 * Initialize a vars array suitable for viewing a poll associated form
 * using elgg_view_form. If $poll is null the variable take default values,
 * if $poll is a poll entity, the resulting array is initialized using this
 * poll values. Also, this function use a sticky form called 'polls' to
 * update the vars array values.
 * 
 * @param $poll  A poll entity or null.
 */
function advpoll_init_vars($poll) {
	$container_guid = get_input('container_guid');
	$values = array(
		'title' => '',
		'description' => '',
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => $container_guid,
		'guid' => '',
		'entity' => $poll,
		'path' => 'http://',
		'poll_cerrada' => 'no',
		'auditoria' => 'no',
		'poll_tipo' => 'normal',
		'access_votar_id' => ACCESS_DEFAULT,
		'mostrar_resultados' => 'no',
		'can_change_vote' => 'yes',
	);

	if ($poll) {
		foreach (array_keys($values) as $key) {
			if (isset($poll->$key)) {
				$values[$key] = $poll->$key;
			}
		}
		
	}
	if (elgg_is_sticky_form('polls')) {
		$sticky_values = elgg_get_sticky_values('polls');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('polls');

	return $values;
}

/**
 * Return if a user has already cast a vote on a poll or not.
 * 
 * @param $user_guid  The user guid for whom we want to check if she has already voted.
 * @param $poll_guid  The poll guid that we want to check.
 * @return true if the user has voted on this poll, or false otherwise.
 */
function user_has_voted($user_guid, $poll_guid) {
	$poll = get_entity($poll_guid);
	$return = false;
	if ($poll->poll_tipo == 'normal') {
		$choices = polls_get_choice_array($poll);
		foreach ($choices as $choice_guid){
			$choice = get_entity($choice_guid);
			$votes = $choice->getAnnotations('vote');
			
			foreach ($votes as $vote) {
				if ($vote->owner_guid == $user_guid) {
					$return = true;
				}
			}
		}
	} else { // condorcet
		$votes = elgg_get_annotations(array(
				'type' => 'object',
				'subtype' => 'poll',
				'guid' => $poll_guid,
				'anotation_name' => 'vote_condorcet',
				'limit' => 0,
		));
		foreach ($votes as $vote){
			if ($vote->owner_guid == $user_guid){
				$return = true;
			}
		}		
	}
	return $return;
}

/*
 *  Specific functions concerning preferencial voting and Condorcet.
 */

function opcion_gana_a_opcion($opcion1, $opcion2, $matriz_ordenada) {
	foreach ($matriz_ordenada as $posicion => $elemento) {
		if ($elemento == $opcion1) {
			$posicion1 = $posicion;
		}
		if ($elemento == $opcion2) {
			$posicion2 = $posicion;
		}
	}
	if ($posicion1 < $posicion2) {
		return true;
	} else {
		return false;
	}
			
}

function linea_de_candidato($candidato, $candidatos_ordenados, $opciones_condorcet) {
	$i = 0;
	foreach ($opciones_condorcet as $op) {
		if (opcion_gana_a_opcion($candidato, $op, $candidatos_ordenados)) {
			$linea[$i] = 1;
		} else {
			$linea[$i] = 0;
		}
		$i++;
	}
	return $linea;
}

function matriz_papeleta($opciones_iniciales, $opciones_ordenadas) {
	foreach ($opciones_iniciales as $opcion) {
		$matriz_papeleta[] = linea_de_candidato($opcion, $opciones_ordenadas, $opciones_iniciales);
	}
	return $matriz_papeleta;
}

function pasar_matriz_a_cadena($matriz) {
	foreach ($matriz as $fila) {
		$cadena_fila[] = implode(" ", $fila);
	}
	$cadena = implode(",", $cadena_fila);
	return $cadena;
}

function pasar_cadena_a_matriz($cadena) {
	$matriz_filas = explode(",", $cadena);
	foreach ($matriz_filas as $fila_cadena) {
		$fila_matriz = explode(" ", $fila_cadena);
		$matriz_final[] = $fila_matriz;
	}
	return $matriz_final;
}

function todas_las_filas_dimension_n($n, $matrix) {
	foreach ($matrix as $fila) {
		$columnas = count($fila);
		if ($columnas !== $n) {
			return false;
			break;
		} else {
			return true;
		}
	}
}
	 
function suma_filas($fila1, $fila2) {
	$i = 0;
	foreach ($fila1 as $elemento) {
		$fila_sumada[] = $elemento + $fila2[$i];
		$i++;
	}
	return $fila_sumada;
}	

function suma_matrices($a, $b) {
	
	/** Las matrices tienen que estar expresadas de la forma
	 * $a = array(
	 * 			array(a11, a12, a13),
	 * 			array(a21, a22, a23),
	 * 			array(a31, a32, a33)
	 * );
	 */
	
	$a_filas = count($a);
	$b_filas = count($b);
	$a_columnas = count($a[0]);
	$b_columnas = count($b[0]);
	if (todas_las_filas_dimension_n($a_columnas, $a) &&
		todas_las_filas_dimension_n($b_columnas, $b) &&
		$a_filas === $b_filas &&
		$a_columnas === $b_columnas) {
			$i= 0;
			foreach ($a as $filas){
				$matriz_sumada[] = suma_filas($a[$i], $b[$i]);
			$i++;
			}
			
			
		} else {
			$matriz_sumada = "No se pueden sumar las matrices";
		}
	return $matriz_sumada;
} 

function suma_puntos_de_fila($fila) {
	$suma = 0;
	foreach ($fila as $puntos) {
		$suma = $suma + $puntos;
	}
	return $suma;
}

function pasar_anotacion_a_lista_ordenada ($anotacion){
	$votacion = get_entity($anotacion->entity_guid);
	$papeleta = pasar_cadena_a_matriz($anotacion->value);
	$opciones = polls_get_choice_array($votacion);
	$opciones_condorcet = array_keys($opciones);
	$i = 0;
	foreach ($papeleta as $fila) {
		$puntuacion = suma_puntos_de_fila($fila);
		$lista[$puntuacion] = $opciones_condorcet[$i];
		$i++;
	}
	krsort($lista);
	foreach ($lista as $opcion) {
		$lista2[] = $opcion;
	}
	return $lista2;
}

function se_repite_nombre_array ($nombre, $array) {
	$return = false;
	foreach ($array as $element) {
		if ($nombre == $element) {
			$return = true;
		} 
	}
	return $return;
}

function algo_repe_en_array ($array) {
	$return = false;
	$copia = $array;
	foreach ($array as $key => $opc) {
		unset($array[$key]);
		if ( se_repite_nombre_array($opc, $array)){
			$return = true;
		}
		$array = $copia;
	}
	return $return;
}

function votacion_en_fecha($votacion) {
	$inicio = $votacion->fecha_inicio;
	$fin = $votacion->fecha_fin;
	$date = time();
	
	if ($fin == 'no') {
		if ($inicio < $date) {
			return true ;
		} else {
			return false ;
		}
	} else {
		if (($inicio < $date) && ($date < $fin)) {
			return true ;
		} else {
			return false ;
		}
	}
}

function elgg_get_votaciones_por_estado($votaciones, $estado) {
	$time = time();
	switch ($estado) {
		case 'en_curso':
			foreach ($votaciones as $votacion) {
				if ($time < $votacion->fecha_fin && $time > $votacion->fecha_inicio) {
					$resultado[] = $votacion;
				}
			}
			break;
		case 'no_iniciadas':
			foreach ($votaciones as $votacion) {
				if ($time < $votacion->fecha_fin && $time < $votacion->fecha_inicio) {
					$resultado[] = $votacion;
				}
			}
			break;
		case 'finalizadas':
			foreach ($votaciones as $votacion) {
				if ($time > $votacion->fecha_fin && $time > $votacion->fecha_inicio) {
					$resultado[] = $votacion;
				}
			}
			break;
		
		case 'totus':
			$resultado = $votaciones;
			break;
		}
	return $resultado;
}

function resultados_condorcet_suma_puntos ($matriz) {
	foreach ($matriz as $fila) {
		$puntuacion = 0;
		foreach ($fila as $puntos) {
			$puntuacion = $puntuacion + $puntos;
		}
		$resultado[] = $puntuacion;
	}
	return $resultado;
}
	
		










?>
