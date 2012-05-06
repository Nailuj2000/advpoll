<?php
/**
 * mod/votaciones/views/default/votaciones/resultados.php
 * 
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

// once elgg_view stops throwing all sorts of junk into $vars, we can use extract()
elgg_load_library('votaciones:model');
elgg_load_js('kinetic');
$guid = elgg_extract('guid', $vars, '');
$votacion = get_entity($guid);
$opciones = polls_get_choice_array($votacion);
$num_votos = 0;
$abcd = 65;
$auditoria = $votacion->auditoria;
$mostrar_resultados = $votacion->mostrar_resultados;
foreach ($opciones as $opcion) {
	$abecedario[] = chr($abcd);
	$abcd++;
}
	

$opciones_condorcet = pasar_opciones_a_condorcet($opciones);

$condorcet = elgg_get_annotations(array(
	'type' => 'object',
	'subtype' => 'poll',
	'guid' => $guid,
	'annotation_name' => 'vote_condorcet',
	'limit' => 0,
	));


	$i = 0;
echo "<br>";

if ($auditoria == 'yes' && ($mostrar_resultados == 'yes' or !votacion_en_fecha($votacion))) {
		
	echo "<div class='auditoria-extendible'>";	
	
	foreach ($condorcet as $papeleta){
		$papeleta_matriz = pasar_cadena_a_matriz($papeleta->value);
		$papelota = pasar_anotacion_a_lista_ordenada($papeleta);
		$usuario_guid = $papeleta->owner_guid;
		$usuario = get_entity($usuario_guid);
		$nombre = $usuario->name;
		echo "<h3  class='separador-punteado'>" . elgg_echo('votaciones:condorcet:opciones:elegidas:usuario') . $nombre . "</h3>";
		echo "<br>";
		echo "<ol class='papeleta-ol'>";
		
		foreach ($papelota as $opcion) {
			echo "<li>$opcion</li>";
			
		}
		
		echo "</ol>";
		echo "<h4>" . elgg_echo('votaciones:condorcet:opciones:elegidas:papeleta') .  $nombre . "</h4>";
		echo elgg_view('votaciones/papeleta', array('matriz' => $papeleta_matriz, 'opciones' => $abecedario));
		$matriz[] = $papeleta_matriz;
		if ($i === 0) {
			$matriz_aux = $papeleta_matriz;
		} else {
			$matriz_aux = suma_matrices($matriz_aux, $papeleta_matriz);
		}
		$i++;
		
	}
	echo '</div>';
}

$i2 = 0;
foreach ($condorcet as $papeleta2){
	$papeleta_matriz2 = pasar_cadena_a_matriz($papeleta2->value);
	$papelota2 = pasar_anotacion_a_lista_ordenada($papeleta2);
	$matriz2[] = $papeleta_matriz2;
	if ($i2 === 0) {
		$matriz_aux2 = $papeleta_matriz2;
	} else {
		$matriz_aux2 = suma_matrices($matriz_aux2, $papeleta_matriz2);
	}
	$i2++;
}



echo '<br>';
echo "<h2>" . elgg_echo('votaciones:condorcet:resultado:final') . "</h2>";

echo elgg_view('votaciones/papeleta', array('matriz' => $matriz_aux2, 'opciones' => $abecedario));
print_r(resultados_condorcet_suma_puntos($matriz_aux2));
$abc = 65;
echo "<br><h3>" . elgg_echo('votaciones:condorcet:leyenda') . "</h3><br>";
echo '<ul><br>';
	foreach ($opciones_condorcet as $opcion){	
		echo "<li><b>" . elgg_echo('votaciones:condorcet:leyenda:opcion') . chr($abc) . ': </b>' . "$opcion</li><br>";
		$abc++;
	}
	
echo '</ul>';
		


?>	Prueba grafo condorcet
		
	<script type="text/javascript">
		var votaciones = [
			["A", 0, 20, 26, 30, 22, 15, 20],
			["B", 25, 0, 16, 33, 18, 12, 20],
			["C", 19, 29, 0, 17, 24, 32, 20],
			["D", 15, 12, 28, 0, 14, 43, 20],
			["E", 23, 27, 21, 31, 0, 23, 20],
			["F", 23, 43, 12, 10, 5, 0, 20],
			["G", 23, 43, 12, 10, 5, 15, 0],
			];
	
		
	</script>



<div id="container"></div>
<script>
	function writeMessage(messageLayer, message) {
        var context = messageLayer.getContext();
        messageLayer.clear();
        context.font = "18pt Calibri";
        context.fillStyle = "black";
        context.fillText(message, 10, 25);
      }
	function grafo_condorcet (id, votaciones) {
	    window.onload = function() {
	        var stage = new Kinetic.Stage({
				container: "container",
				width: 578,
				height: 578
	        });
			var layer = new Kinetic.Layer();  
			var messageLayer = new Kinetic.Layer();
	    
		    // Código de referencia: http://webofilia.com/js/demo/RegularPolygon.js
			var ancho = stage.getWidth();
			var alto = stage.getHeight();
			var nodos = [];
			var radionodo = 20;
			
			var dame_vertices_poligono = function (inicial_x, inicial_y, num_vertices, longitud_arista) {
				var punto = {x: inicial_x, y: inicial_y},
				poligono = [],
				w = 2 * Math.PI / num_vertices;
				
				poligono.push(punto);
			
				for (var i=1; i < num_vertices; i++){
					var x = parseInt(Math.cos(w * (i-1)) * longitud_arista + poligono[i-1].x);
					var y = parseInt(Math.sin(w * (i-1)) * longitud_arista + poligono[i-1].y);
					punto = {x: x, y: y};
					poligono.push(punto);
				}
				
				return poligono;
			}
			
			var dame_posicion_nodos = function (num_nodos) {
				var resultados = dame_vertices_poligono (0, 0, num_nodos, ancho/(num_nodos/2)),
				menor_x = 0,
				mayor_x = 0,
				menor_y = 0,
				mayor_y = 0,
				inicial_x = 0,
				inicial_y = 0;
				
				radionodo = ancho/(num_nodos*2.5);
				
				//Escogemos el menor
				for (var i=1; i < num_nodos; i++){
					if (resultados[i].x < menor_x) menor_x = -resultados[i].x;
					if (resultados[i].x > mayor_x) mayor_x = resultados[i].x;
					if (resultados[i].y < menor_y) menor_y = -resultados[i].y;
					if (resultados[i].y > mayor_y) mayor_y = resultados[i].y;
				}
				
				inicial_x = (menor_x+ancho-mayor_x)/2;
				inicial_y = (menor_y+ancho-mayor_y)/2;
		
				resultados = dame_vertices_poligono (inicial_x, inicial_y, num_nodos, ancho/(num_nodos/2));
				
				nodos = resultados;
				return resultados;
			}
		
			var dibuja_nodo = function (centro, etiqueta) {
				var radio = radionodo;
				
				var nodo = new Kinetic.Circle ({
					x: centro.x,
					y: centro.y,
					radius: radionodo,
					stroke: "grey",
					strokeWidth: 4,
				});
				
				var etiq = new Kinetic.Text({
					x: centro.x,
					y: centro.y,
					text: etiqueta,
					fontSize: parseInt(radio),
					fontFamily: "Arial",
					textFill: "grey",
					align: "center",
					verticalAlign: "middle"
				});
				
				
				
				nodo.on('mouseover', function(){
					
					this.setStrokeWidth(6);
					this.setStroke("black");
					etiq.setTextFill("black");
					layer.draw();
				});
				
				nodo.on("mouseout", function(){
					this.setStrokeWidth(4);
					nodo.setStroke("grey");
					etiq.setTextFill("grey");
					layer.draw();
				});
				
				layer.add(etiq);
				layer.add(nodo);
				stage.add(layer);
							
			}
		
		
			var dibuja_flecha = function (origen, destino, etiqueta) {
		
				var angulo = Math.atan2(destino.y-origen.y,destino.x-origen.x),
				tam_cabeza = 15,
				origen_x = origen.x + radionodo*Math.cos(angulo),
				origen_y = origen.y + radionodo*Math.sin(angulo),
				destino_x = destino.x - radionodo*Math.cos(angulo),
				destino_y = destino.y - radionodo*Math.sin(angulo);
				
				var flecha = new Kinetic.Line({
					points: [{
						x: origen_x,
						y: origen_y,
					}, {
						x: destino_x,
						y: destino_y,
					}],
					
					stroke: "grey",
					strokeWidth: 2,
					lineCap: 'round',
					lineJoin: 'round'
				});
				
				var cabeza = new Kinetic.Polygon({
					points: [{
						x: destino_x-tam_cabeza*Math.cos(angulo-Math.PI/6),
						y: destino_y-tam_cabeza*Math.sin(angulo-Math.PI/6),
					}, {
						x: destino_x,
						y: destino_y,
					}, {
						x: destino_x-tam_cabeza*Math.cos(angulo+Math.PI/6),
						y: destino_y-tam_cabeza*Math.sin(angulo+Math.PI/6),
					}, {
						x: destino_x-tam_cabeza*Math.cos(angulo-Math.PI/6),
						y: destino_y-tam_cabeza*Math.sin(angulo-Math.PI/6),
					}],
					stroke: "grey",
					fill: "grey",
					strokeWidth: 2,
					lineCap: 'round',
					lineJoin: 'round'
				});
				
				layer.add(flecha);
				layer.add(cabeza);
				stage.add(layer);
			}
			
	
			var num_nodos = votaciones.length;
			var vertices = dame_posicion_nodos (num_nodos);
			
			for (var i=0; i<num_nodos; i++) {
				dibuja_nodo (vertices[i], votaciones[i][0]);
				for (var j=1; j<=num_nodos; j++) {
					var valor = votaciones[i][j];
					if ((valor != 0) && (valor > votaciones[j-1][i+1])) {
						dibuja_flecha(vertices[i], vertices[j-1], valor);
					}
				}
			}
		}
	}
	
	var canvas = grafo_condorcet ('grafo', votaciones);



	/*
        var points = [{
          x: 73,
          y: 160
        }, {
          x: 340,
          y: 23
        }, {
          x: 500,
          y: 109
        }];

        var line = new Kinetic.Line({
          points: points,
          stroke: "black",
          strokeWidth: 15,
          lineCap: 'round',
          lineJoin: 'round'
        });
    */
    /*
		line.on('mouseover', function(){
			this.setStrokeWidth(20);
			layer.draw();
		});
		line.on('mouseout', function(){
			this.setStrokeWidth(15);
			layer.draw();
		});
	*/
	/*
		var dame_vertices_poligono = function (inicial_x, inicial_y, num_vertices, longitud_arista) {
			var punto = {x: inicial_x, y: inicial_y},
			poligono = [],
			w = 2 * Math.PI / num_vertices;
			
			poligono.push(punto);
		
			for (var i=1; i < num_vertices; i++){
				var x = parseInt(Math.cos(w * (i-1)) * longitud_arista + poligono[i-1].x);
				var y = parseInt(Math.sin(w * (i-1)) * longitud_arista + poligono[i-1].y);
				punto = {x: x, y: y};
				poligono.push(punto);
			}
			
			return poligono;
		}
		var puntos = dame_vertices_poligono(0, 0, 6, 100);
		var poligono = new Kinetic.Polygon ({
			x: stage.getWidth() / 2,
	        y: stage.getHeight() / 2,
	        points: puntos,      
	        fill: "red",
	        stroke: "black",
	        strokeWidth: 2,
	        	        
		}); 
		*/
		/*
		var poligono = new Kinetic.RegularPolygon({
			x: stage.getWidth() / 2,
	        y: stage.getHeight() / 2,
	        sides: 6,
	        radius: 250,
	        fill: "red",
	        stroke: "black",
	        strokeWidth: 2,
	        getPoints: function() {
				return this.points;
			},
	        
		});
		*/
		/*    
        poligono.on('mouseover', function(){
			line.setStrokeWidth(20);
			layer.draw();
		});
		poligono.on('mouseout', function(){
			line.setStrokeWidth(15);
			layer.draw();
		});
			
				

        // add the shape to the layer
        layer.add(line);
    
        layer.add(poligono);
        
        // add the layer to the stage
        stage.add(layer);
      };
      */


    
</script>

























































