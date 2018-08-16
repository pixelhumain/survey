<div class="container margin-top-50">
	<h1>Logs</h1>
<?php 
if(!is_array($logs))
	echo "<h1 class='text-center'>".$logs."</h1>";
else {
	?>
	<table border="1" id="riskList"  class="table table-striped table-bordered table-hover  directoryTable margin-bottom-20" style="width:100%;">
			<tr>
				
				<th>Qui</th>
				<th>Quoi </th>
				<th>Quand</th>
				<th>Clef </th>
			</tr>
	<?php
	//session DEPOT dossier
	foreach ($answers as $k => $v) {?>
		<tr>
			
			<td><a href="http://127.0.0.1/ph/#page.type.citoyens.id.<?php echo $v["user"] ?>" target="_blank"><?php echo $v["name"]; ?></a></td>
			<td>Formulaire <?php echo $v["formId"]; ?> enregistré</td>
			<td><?php echo date('d/m/Y h:i',$v["created"]) ?></td>
			<td></td>
		</tr>
	<?php } ?>

	<?php
	//session ADMIN
	foreach ($logs as $k => $v) {?>
		<tr>
			
			<td><a href="http://127.0.0.1/ph/#page.type.citoyens.id.<?php echo $v["userId"] ?>" target="_blank"><?php 
			$u=Person::getSimpleUserById($v["userId"]);
			echo $u["name"] ?></a></td>
			<td><?php echo $v["action"] ?></td>
			<td><?php echo date('d/m/Y h:i',$v["created"]->sec) ?></td>
			<td><?php echo $v["params"]["key"] ?></td>
		</tr>
	<?php } ?>
	</table>
	<?php 
} ?>

</div>