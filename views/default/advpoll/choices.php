<?php
$choices = elgg_extract('choices', $vars, array());


echo '<h5>' . elgg_echo('advpoll:candidates') . '</h5>';

echo "<div><ul class='choices_ul'>";

foreach($choices as $choice){	
	$entity = get_entity($choice);
	echo "<li>" . $entity->text . "</li>";
}
echo "</ul></div>";
