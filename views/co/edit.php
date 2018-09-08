<?php 
foreach ($form["scenario"] as $key => $value) {
	echo "<h1>".$key."</h1>";
	foreach ($value['json']['jsonSchema']['properties'] as $k => $v ) {
		echo "<h2>".$k."</h2>";
	}
/*
	foreach ($value['json']['jsonSchema']['scenario'] as $k => $v ) {
		echo "<h2>".$k."</h2>";
	}*/
} ?>