<?php
/**
 * mod/advpoll/views/default/advpoll/results.php
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
elgg_load_library('advpoll:model');
elgg_load_js('highcharts');
$poll = elgg_extract('poll', $vars, array());
$guid = $poll->guid;
$candidates = polls_get_choice_array($poll);
$n_votes = 0;
$n_candidates = count($candidates);
$height = 500 + 36 * $n_candidates;
$audit = $poll->audit;
$show_results =$poll->show_results;
$can_change_vote = $poll->can_change_vote;

$graphic_title = elgg_echo('advpoll:results:graphic:title');
$graphic_subtitle = $poll->title;
if ($audit == 'yes' && ($show_results == 'yes' or !is_poll_on_date($poll))) {
	?>
	<br>
	<br>
	<div class='audit-extendible'>
		<table class='audit-normal-table'>
			<thead class='audit-normal-thead'>
				<tr class='audit-normal-tr'>
					<th class='audit-normal-th'> <?php echo elgg_echo('advpoll:normal:audit:user'); ?> </th>
					<th class='audit-normal-th'> <?php echo elgg_echo('advpoll:normal:audit:nick'); ?> </th>
					<th class='audit-normal-th'> <?php echo elgg_echo('advpoll:normal:audit:name'); ?> </th>
					<th class='audit-normal-th'> <?php echo elgg_echo('advpoll:normal:audit:date'); ?> </th>
					<th class='audit-normal-th'> <?php echo elgg_echo('advpoll:normal:audit:candidate'); ?> </th>
					
				</tr>
			</thead>
			<tbody>
				
		<?php
		
		foreach ($candidates as $candidate) {
			$entity = get_entity($candidate);
			$annotations = $entity->getAnnotations('vote');
			$candidate_name = $entity->text;
			//print_r($nombre_op);
			foreach ($annotations as $annotation){
				$name = $annotation->name;
				$time = $annotation->time_created;
				$date = date('d-m-Y, h:i:s', $time);
				$user_guid = $annotation->owner_guid;
				$user = get_entity($user_guid);
				$user_name = $user->name;
				$user_nick = $user->username;
				$user_icon = elgg_view_entity_icon($user, 'tiny');
				
				?>
				<tr class='audit-normal-tr'>
					<td class='audit-normal-td'><?php echo $user_icon; ?></td>
					<td class='audit-normal-td'><?php echo $user_nick; ?></td>
					<td class='audit-normal-td'><?php echo $user_name; ?></td>
					<td class='audit-normal-td'><?php echo $date; ?></td>
					<td class='audit-normal-td'><?php echo $candidate_name; ?></td>
				</tr>
				<?php
			}
			//print_r($annotations);
		}
		?>
		
		</tbody>
		</table>
	</div>
	
<?php
}
?>		
	
	
<div id='results-sectors'></div>

<script type="text/javascript">

function roundNumber(num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}

$(function () {
	var title = "<?php echo $graphic_title; ?>";
	var h = "<?php echo $height; ?>";
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'results-sectors',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                height: h,                
            },
            title: {
                text: title,
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
                   <?php foreach ($candidates as $candidate){
								$answer = get_entity($candidate);
								$candidate_name = $answer->text;
								$candidate_n_votes = $answer->countAnnotations('vote');
								$n_votes = $n_votes + $candidate_n_votes;
								?> [' <?php echo $candidate_name; ?> ', <?php echo $candidate_n_votes; ?> ],
					<?php } ?>
                ]
            }],
            legend: {
				labelFormatter: function() {
					return '<p>' + this.name + '</p><br>Votos: '+ this.y +' / '+'<?php echo $n_votes; ?> ';
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

