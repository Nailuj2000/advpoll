<?php

elgg_load_library('advpoll:model');
$poll = $vars['entity'];

$auditoria = $poll->auditoria;
$tipo = $poll->poll_tipo;
$titulo = $poll->title;
$desc = $poll->description;
$path = $poll->path;
$acces_id = $poll->access_id;
$owner_guid = $poll->owner_guid;
$container_guid = $poll->container_guid;
$tags = $poll->tags;
$choices = polls_get_choice_array($poll);
$full = elgg_extract('full_view', $vars, FALSE);
$owner =  $poll->getOwnerEntity();
$start_date = $poll->start_date;
$end_date = $poll->end_date;
$time = time();
$mostrar_resultados = $poll->mostrar_resultados;
$can_change_vote = $poll->can_change_vote;
if ($time < $end_date ) {
	$poll_comparada_fin = 'menorfin';
} else {
	if ($time >= $end_date ){
		$poll_comparada_fin = 'mayorfin';
	}
}

if ($time < $start_date) {
	$poll_comparada_ini = 'menorini';
}else {
	if ($time >= $start_date ){
		$poll_comparada_ini = 'mayorini';
	}
}


$entity_icon = elgg_view_entity_icon($poll, 'small');

$metadata = elgg_view_menu('entity', array(
	'entity' => $poll,
	'handler' => 'advpoll',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));


	
	$url = $poll->path;
	$display_text = $url;
	$excerpt = elgg_get_excerpt($poll->description);
	if ($excerpt) {
		$excerpt = " - $excerpt";
	}

	
	$link = elgg_get_site_url() . "profile/" . $owner->name ;
	$subtitle = elgg_echo('advpoll:owner');
	$subtitle .= elgg_view('output/url', array(
		'href' => $link,
		'text' => $owner->name,
	));
	
	
	
	$subtitle .= '<br>' . elgg_view('output/url', array(
		'href' => $poll->path,
		'text' => elgg_echo('advpoll:debate:previo:link'),
	));

	$subtitle .= "<br>" . elgg_echo('advpoll:view:ended:' . $poll_comparada_fin . ':' . $poll_comparada_ini ) . ',';
	if ($poll_comparada_ini == 'menorini') {
	$subtitle .= elgg_echo('advpoll:view:tiempo:desde') . date('d - M - Y', $start_date) . ', ';
} 
	if ($poll_comparada_fin == 'menorfin') {
	$subtitle .= elgg_echo('advpoll:view:tiempo:hasta') .date('d - M - Y', $end_date);
} 
	$subtitle .= elgg_echo('advpoll:view:auditoria') . elgg_echo('option:' . $auditoria) . ',';
	$subtitle .= elgg_echo('advpoll:view:tipo') . elgg_echo('advpoll:tipo:' . $tipo) . ',';
	$subtitle .= elgg_echo('advpoll:view:mostrar:resultados') . elgg_echo('advpoll:mostrar:' . $mostrar_resultados) . '.';
	$subtitle .= elgg_echo('advpoll:view:can:change:vote') . elgg_echo('advpoll:mostrar:' . $can_change_vote) . '.';

	
	$content .= elgg_view('advpoll/choices', array('choices' => $choices));
	$params = array(
		'entity' => $poll,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $content,
	);
	$params = $params + $vars;
	

if ($full) {
	$body = elgg_view('output/longtext', array('value' => $poll->description));
	$entity_icon = elgg_view_entity_icon($poll, 'small');
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', array(
		'entity' => $poll,
		'title' => '',
		'icon' => $entity_icon,
		'summary' => $summary,
		'body' => $body,
	));

} else {
	$body = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($entity_icon, $body);
}

