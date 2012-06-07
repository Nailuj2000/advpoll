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
elgg_push_breadcrumb(elgg_echo('advpoll:ayuda'));

// Esto de abajo sirve para que aparezca en el menu lateral las opciones
// de grupo y de usuario al que pertenece la votación


$title = elgg_echo('advpoll:condorcet:ayuda:titulo');

$content = elgg_echo('advpoll:condorcet:ayuda:papeletas:seguramente');

$content .= elgg_view('advpoll/papeleta', array(
	'matriz' => array(
		array(0, 0, 1, 1),
		array(1, 0, 1, 1),
		array(0, 0, 0, 1),
		array(0, 0, 0, 0),
	),
	'opciones' => array(
		'A',
		'B', 
		'C', 
		'D',
	)));
$content .= '<br>';	
$content .= elgg_echo('advpoll:condorcet:ayuda:papeletas:notemas') . '<br>';

$content .= '<h3>' . elgg_echo('advpoll:condorcet:ayuda:papeletas:explicacion:titulo') . '</h3><br>';

$content .= elgg_echo('advpoll:condorcet:ayuda:papeletas:supongamos') . '<br>';

$content .= 
	"<br><table class='condorcet-papeleta-table'>
		<thead class='condorcet-thead'>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'></th>
				<th class='condorcet-th'>Opción A</th>
				<th class='condorcet-th'>Opción B</th>
				<th class='condorcet-th'>Opción C</th>
				<th class='condorcet-th'>Opción D</th>
			</tr>
		</thead>
		<tbody>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción A</th>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción B</th>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción C</th>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción D</th>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
			</tr>
		</tbody>
	</table>
<br>";

$content .= elgg_echo('advpoll:condorcet:ayuda:papeletas:paso2') . '<br>';

$content .= 
	"<br><table class='condorcet-papeleta-table'>
		<thead class='condorcet-thead'>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'></th>
				<th class='condorcet-th'>Opción A</th>
				<th class='condorcet-th'>Opción B</th>
				<th class='condorcet-th'>Opción C</th>
				<th class='condorcet-th'>Opción D</th>
			</tr>
		</thead>
		<tbody>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción A</th>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción B</th>
					<td class='condorcet-td'>1</td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción C</th>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción D</th>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
			</tr>
		</tbody>
	</table>
<br>";

$content .= elgg_echo('advpoll:condorcet:ayuda:papeletas:paso3') . '<br>';

$content .= 
	"<br><table class='condorcet-papeleta-table'>
		<thead class='condorcet-thead'>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'></th>
				<th class='condorcet-th'>Opción A</th>
				<th class='condorcet-th'>Opción B</th>
				<th class='condorcet-th'>Opción C</th>
				<th class='condorcet-th'>Opción D</th>
			</tr>
		</thead>
		<tbody>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción A</th>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción B</th>
					<td class='condorcet-td'>1</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción C</th>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'></td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción D</th>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'>0</td>
			</tr>
		</tbody>
	</table>
<br>";

$content .= elgg_echo('advpoll:condorcet:ayuda:papeletas:opciona') . '<br>';

$content .= 
	"<br><table class='condorcet-papeleta-table'>
		<thead class='condorcet-thead'>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'></th>
				<th class='condorcet-th'>Opción A</th>
				<th class='condorcet-th'>Opción B</th>
				<th class='condorcet-th'>Opción C</th>
				<th class='condorcet-th'>Opción D</th>
			</tr>
		</thead>
		<tbody>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción A</th>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>1</td>
					<td class='condorcet-td'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción B</th>
					<td class='condorcet-td'>1</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción C</th>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'></td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción D</th>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'>0</td>
			</tr>
		</tbody>
	</table>
<br>";

$content .= elgg_echo('advpoll:condorcet:ayuda:papeletas:opcionb') . '<br>';

$content .= 
	"<br><table class='condorcet-papeleta-table'>
		<thead class='condorcet-thead'>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'></th>
				<th class='condorcet-th'>Opción A</th>
				<th class='condorcet-th'>Opción B</th>
				<th class='condorcet-th'>Opción C</th>
				<th class='condorcet-th'>Opción D</th>
			</tr>
		</thead>
		<tbody>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción A</th>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>1</td>
					<td class='condorcet-td'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción B</th>
					<td class='condorcet-td'>1</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>1</td>
					<td class='condorcet-td'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción C</th>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'></td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción D</th>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'>0</td>
			</tr>
		</tbody>
	</table>
<br>";

$content .= elgg_echo('advpoll:condorcet:ayuda:papeletas:opcionc') . '<br>';

$content .= 
	"<br><table class='condorcet-papeleta-table'>
		<thead class='condorcet-thead'>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'></th>
				<th class='condorcet-th'>Opción A</th>
				<th class='condorcet-th'>Opción B</th>
				<th class='condorcet-th'>Opción C</th>
				<th class='condorcet-th'>Opción D</th>
			</tr>
		</thead>
		<tbody>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción A</th>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>1</td>
					<td class='condorcet-td'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción B</th>
					<td class='condorcet-td'>1</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>1</td>
					<td class='condorcet-td'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción C</th>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción D</th>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'></td>
					<td class='condorcet-td'>0</td>
			</tr>
		</tbody>
	</table>
<br>";


$content .= elgg_echo('advpoll:condorcet:ayuda:papeletas:opciond') . '<br>';

$content .= 
	"<br><table class='condorcet-papeleta-table'>
		<thead class='condorcet-thead'>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'></th>
				<th class='condorcet-th'>Opción A</th>
				<th class='condorcet-th'>Opción B</th>
				<th class='condorcet-th'>Opción C</th>
				<th class='condorcet-th'>Opción D</th>
			</tr>
		</thead>
		<tbody>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción A</th>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>1</td>
					<td class='condorcet-td'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción B</th>
					<td class='condorcet-td'>1</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>1</td>
					<td class='condorcet-td'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción C</th>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>Opción D</th>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td'>0</td>
			</tr>
		</tbody>
	</table>
<br>";

$content .= elgg_echo('advpoll:condorcet:ayuda:papeletas:paso4') . '<br>';

$content .= elgg_view('advpoll/papeleta', array(
	'matriz' => array(
		array(0, 0, 1, 1),
		array(1, 0, 1, 1),
		array(0, 0, 0, 1),
		array(0, 0, 0, 0),
	),
	'opciones' => array(
		'A',
		'B', 
		'C', 
		'D',
	)));
$content .= '<br>';	

$content .= '<h3>' . elgg_echo('advpoll:condorcet:ayuda:suma:explicacion:titulo') . '</h3><br>';

$content .= elgg_echo('advpoll:condorcet:ayuda:suma:explicacion:maspapeletas');

$content .= "
		<table class='ayuda-cuatro-columnas'>
		<tr class='ayuda-cuatro-columnas'>
		<td class='ayuda-cuatro-columnas'>A B C D</td>
		<td class='ayuda-cuatro-columnas'>C D A B</td>
		<td class='ayuda-cuatro-columnas'>C A B D</td>
		<td class='ayuda-cuatro-columnas'>A B D C</td>
		</tr>
		<tr class='ayuda-cuatro-columnas'>
		<td class='ayuda-cuatro-columnas'><table>
		<thead class='condorcet-thead'>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'></th>
				<th class='condorcet-th'>A</th>
				<th class='condorcet-th'>B</th>
				<th class='condorcet-th'>C</th>
				<th class='condorcet-th'>D</th>
			</tr>
		</thead>
		<tbody>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>A</th>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td verde'>1</td>
					<td class='condorcet-td verde'>1</td>
					<td class='condorcet-td verde'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>B</th>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td verde'>1</td>
					<td class='condorcet-td verde'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>C</th>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td verde'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>D</th>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td'>0</td>
			</tr>
		</tbody>
	</table></td>
	
	
	
		<td class='ayuda-cuatro-columnas'><table>
		<thead class='condorcet-thead'>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'></th>
				<th class='condorcet-th'>A</th>
				<th class='condorcet-th'>B</th>
				<th class='condorcet-th'>C</th>
				<th class='condorcet-th'>D</th>
			</tr>
		</thead>
		<tbody>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>A</th>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td verde'>1</td>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td rojo'>0</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>B</th>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td rojo'>0</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>C</th>
					<td class='condorcet-td verde'>1</td>
					<td class='condorcet-td verde'>1</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td verde'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>D</th>
					<td class='condorcet-td verde'>1</td>
					<td class='condorcet-td verde'>1</td>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td'>0</td>
			</tr>
		</tbody>
	</table></td>
	
	
	
		<td class='ayuda-cuatro-columnas'><table>
		<thead class='condorcet-thead'>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'></th>
				<th class='condorcet-th'>A</th>
				<th class='condorcet-th'>B</th>
				<th class='condorcet-th'>C</th>
				<th class='condorcet-th'>D</th>
			</tr>
		</thead>
		<tbody>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>A</th>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td verde'>1</td>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td verde'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>B</th>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td verde'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>C</th>
					<td class='condorcet-td verde'>1</td>
					<td class='condorcet-td verde'>1</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td verde'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>D</th>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td'>0</td>
			</tr>
		</tbody>
	</table></td>
	
	
	
		<td class='ayuda-cuatro-columnas'><table>
		<thead class='condorcet-thead'>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'></th>
				<th class='condorcet-th'>A</th>
				<th class='condorcet-th'>B</th>
				<th class='condorcet-th'>C</th>
				<th class='condorcet-th'>D</th>
			</tr>
		</thead>
		<tbody>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>A</th>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td verde'>1</td>
					<td class='condorcet-td verde'>1</td>
					<td class='condorcet-td verde'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>B</th>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td verde'>1</td>
					<td class='condorcet-td verde'>1</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>C</th>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td'>0</td>
					<td class='condorcet-td rojo'>0</td>
			</tr>
			<tr class='condorcet-tr'>
				<th class='condorcet-th'>D</th>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td rojo'>0</td>
					<td class='condorcet-td verde'>1</td>
					<td class='condorcet-td'>0</td>
			</tr>
		</tbody>
	</table></td>
	
	
	
		</tr></table>
		
";



$body = elgg_view_layout('content', array(
	'title' => $title,
	'content' => $content,
	'filter' => '',
	'nav' => '<b>Navigation</b>'
	));
	

	
echo elgg_view_page($title, $body);
	


 
