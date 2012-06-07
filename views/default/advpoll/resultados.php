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
elgg_load_js('highcharts');
$votacion = elgg_extract('votacion', $vars, array());
$guid = $votacion->guid;
$opciones = polls_get_choice_array($votacion);
$num_votos = 0;
$num_opciones = count($opciones);
$altura = 500 + 36 * $num_opciones;
$auditoria = $votacion->auditoria;
$mostrar_resultados =$votacion->mostrar_resultados;

$titulo_tarta = elgg_echo('votaciones:resultados:tarta:titulo');
$subtitulo_tarta = $votacion->title;
if ($auditoria == 'yes' && ($mostrar_resultados == 'yes' or !votacion_en_fecha($votacion))) {
	?>
	<br>
	<br>
	<div class='auditoria-extendible'>
		<table class='auditoria-normal-table'>
			<thead class='auditoria-normal-thead'>
				<tr class='auditoria-normal-tr'>
					<th class='auditoria-normal-th'> <?php echo elgg_echo('votaciones:normal:auditoria:usuaria'); ?> </th>
					<th class='auditoria-normal-th'> <?php echo elgg_echo('votaciones:normal:auditoria:nick'); ?> </th>
					<th class='auditoria-normal-th'> <?php echo elgg_echo('votaciones:normal:auditoria:nombre'); ?> </th>
					<th class='auditoria-normal-th'> <?php echo elgg_echo('votaciones:normal:auditoria:fecha'); ?> </th>
					<th class='auditoria-normal-th'> <?php echo elgg_echo('votaciones:normal:auditoria:opcion'); ?> </th>
					
				</tr>
			</thead>
			<tbody>
				
		<?php
		
		foreach ($opciones as $op) {
			$entidad = get_entity($op);
			$anotaciones = $entidad->getAnnotations('vote');
			$nombre_op = $entidad->text;
			//print_r($nombre_op);
			foreach ($anotaciones as $anotacion){
				$nombre = $anotacion->name;
				$time = $anotacion->time_created;
				$fecha = date('d-m-Y, h:i:s', $time);
				$usuario_guid = $anotacion->owner_guid;
				$usuario = get_entity($usuario_guid);
				$usuario_nombre = $usuario->name;
				$usuario_nick = $usuario->username;
				$usuario_icono = elgg_view_entity_icon($usuario, 'tiny');
				
				?>
				<tr class='auditoria-normal-tr'>
					<td class='auditoria-normal-td'><?php echo $usuario_icono; ?></td>
					<td class='auditoria-normal-td'><?php echo $usuario_nick; ?></td>
					<td class='auditoria-normal-td'><?php echo $usuario_nombre; ?></td>
					<td class='auditoria-normal-td'><?php echo $fecha; ?></td>
					<td class='auditoria-normal-td'><?php echo $nombre_op; ?></td>
				</tr>
				<?php
			}
			//print_r($anotaciones);
		}
		?>
		
		</tbody>
		</table>
	</div>
	
<?php
}
?>		
	
	
<div id='tarta-resultados'></div>

<script type="text/javascript">

function roundNumber(num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}

$(function () {
    var chart;
	var titulo = "<?php echo $titulo_tarta; ?>";
	var subtitulo = "<?php echo $subtitulo_tarta; ?>";
	var valores = "<?php echo $valores; ?>";
	var altura = "<?php echo $altura; ?>";
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'tarta-resultados',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                height: altura,                
            },
            title: {
                text: titulo,
                align: "left",
                style: {
					color: '#0054A7',
					fontSize: '18px',
					fontFamily: 'helvetica',
					fontWeight: 'bold',
				},
            },

            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.name +'</b> Num. Votos: '+ this.y ;
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return 'Votos: '+ this.y + '<br>Porcentaje: '+ roundNumber(this.percentage, 2) +' %';
                        }
                    },
                    showInLegend: true,
                    size: 300,
                    
                }
            },
            
            series: [{
                type: 'pie',
                name: 'Browser share',
                data: [
                   <?php foreach ($opciones as $opcion){
								$respuesta = get_entity($opcion);
								$nombre_opcion = $respuesta->text;
								$opcion_num_votos = $respuesta->countAnnotations('vote');
								$num_votos = $num_votos + $opcion_num_votos;
								?> [' <?php echo $nombre_opcion; ?> ', <?php echo $opcion_num_votos; ?> ],
					<?php } ?>
                ]
            }],
            legend: {
				labelFormatter: function() {
					return '<p>' + this.name + '</p><br>Votos: '+ this.y +' / '+'<?php echo $num_votos; ?> ';
					},
				width: 720,
				itemStyle: {
					cursor: 'pointer',
					color: '#3E576F',
					
				},
				itemWidth: 710,
				verticalAlign: 'top',
				y: 50,
				
			},
            credits: {
				enabled: false
			}
        });
    });    
});

</script>







