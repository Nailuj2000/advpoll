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
 
/*
checks for votes on the poll
@param ElggEntity $poll
@param guid
@return true/false
*/
function polls_check_for_previous_vote($poll, $user_guid)
{	
	$votes = get_annotations($poll->guid,"object","poll","vote","",$user_guid,1);
	if ($votes) {
		return true;
	} else {
		return false;
	}
}

function polls_get_choices($poll) {
	$options = array(
		'relationship' => 'poll_choice',
		'relationship_guid' => $poll->guid,
		'inverse_relationship' => TRUE,
		'order_by_metadata' => array('name'=>'display_order','direction'=>'ASC')
	);
	return elgg_get_entities_from_relationship($options);
}

function polls_get_choice_array($poll) {
	$choices = polls_get_choices($poll);
	$responses = array();
	if ($choices) {
		$i = 1;
		foreach($choices as $choice) {
			
			$label = $choice->text;
			$responses[$label] = $choice->guid;
			$i = $i+1;
		}
	}	
	return $responses;
}

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

function polls_delete_choices($poll) {
	$choices = polls_get_choices($poll);
	if ($choices) {
		foreach($choices as $choice) {
			$choice->delete();
		}
	}
}

function polls_replace_choices($poll,$new_choices) {
	polls_delete_choices($poll);
	polls_add_choices($poll, $new_choices);
}

function polls_activated_for_group($group) {
	$group_polls = get_plugin_setting('group_polls', 'polls');
	if ($group && ($group_polls != 'no')) {
		if ( ($group->polls_enable == 'yes') 
			|| ((!$group->polls_enable && ((!$group_polls) || ($group_polls == 'yes_default'))))) {
			return true;
		}
	}
	return false;		
}

function polls_can_add_to_group($group,$user=null) {
	$polls_group_access = get_plugin_setting('group_access', 'polls');
	if (!$polls_group_access || $polls_group_access == 'admins') {
		return $group->canEdit();
	} else {
		if (!$user) {
			$user = get_loggedin_user();
		}
		return $group->canEdit() || $group->isMember($user);
	}
}

function remove_anotation_by_entity_guid_user_guid($annotation, $entity_guid, $user_guid){
	$entity = get_entity($entity_guid);
	$all_annotations = $entity->getAnnotations($annotation);
	foreach ($all_annotations as $annotation_entity){
		if ($annotation_entity->owner_guid == $user_guid 
			&&
			$annotation_entity->entity_guid == $entity_guid){
				$annotation_id = $annotation_entity->id;
				elgg_delete_annotation_by_id($annotation_id);
				$return = TRUE;
				
			} 
		}
		return $return;
	}

function votaciones_preparar_vars($votaciones) {

	// input names => default
	$container_guid = get_input('container_guid');
	$values = array(
		'title' => '',
		'description' => '',
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => $container_guid,
		'guid' => '',
		'entity' => $votaciones,
		'path' => 'http://',
		'poll_cerrada' => 'no',
		'auditoria' => 'no',
		'poll_tipo' => 'normal',
		'access_votar_id' => ACCESS_DEFAULT,
	);

	if ($votaciones) {
		foreach (array_keys($values) as $field) {
			if (isset($votaciones->$field)) {
				$values[$field] = $votaciones->$field;
			}
		}
		
	}
	if (elgg_is_sticky_form('votaciones')) {
		$sticky_values = elgg_get_sticky_values('votaciones');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('votaciones');

/**
	if (elgg_is_sticky_form('votaciones')) {
		$sticky_values = elgg_get_sticky_values('votaciones');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('votaciones');
*/
	return $values;
}

function usuario_ha_votado($user_guid, $votacion_guid) {
	$votacion = get_entity($votacion_guid);
	$opciones = polls_get_choice_array($votacion);
	$return = false;
	foreach ($opciones as $vote_guid){
		$entity = get_entity($vote_guid);
		$all_annotations = $entity->getAnnotations('vote');
		
		foreach ($all_annotations as $ann){
			
			if ($ann->owner_guid == $user_guid 
				&&
				$ann->entity_guid == $vote_guid){
				
					$return = true or $return;
				} else {
					$return = $return or false;
				}
			}
		}
			return $return;
	}






// Funciones especificas para método de Condorcet
function pasar_opciones_a_condorcet ($opciones) {
	foreach ($opciones as $key => $id) {
		$opciones_matriz[] = $key;
	}
	return $opciones_matriz;
}

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
	$opciones_condorcet = pasar_opciones_a_condorcet($opciones);
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

function usuario_ha_votado_condorcet ($user_guid, $anotaciones) {
	foreach ($anotaciones as $anotacion){
		$return = false;
		if ($anotacion->owner_guid == $user_guid){
				$return = true or $return;
			} else {
				$return = $return or false;
			}
		}
		return $return;
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
	
		










?>
