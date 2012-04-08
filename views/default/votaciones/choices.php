<?php
$choices = elgg_extract('choices', $vars, array());


echo "<div><ul class='choices_ul'>";

foreach($choices as $choice){	
	$entidad = get_entity($choice);
	echo "<li>" . $entidad->text . "</li>";
}
echo "</ul></div>";
