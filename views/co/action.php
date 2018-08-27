<h1 class="text-center"><?php echo $answers["name"] ?></h1>

<div class='col-xs-12'>
	<h2 class="padding-20" style="background-color:lightgrey;"> Details de l'action<i class="fa pull-right fa-address-card-o"></i></h2>
	<table id="by"  class="table table-striped table-bordered table-hover  directoryTable" id="panelAdmin">
		
		<tbody>

			<tr>
				<td>Nom de la Fiche Action</td>
				<td><b><?php echo $answers["name"]; ?></b></td>
			</tr>

			<tr>
				<td>Déposé par </td>
				<td><?php echo @$user["name"]; ?></td>
			</tr>

			<tr>
				<td>Email </td>
				<td><?php echo @$user["email"]; ?></td>
			</tr>

			<tr>
				<td>Date de début </td>
				<td><?php echo date("d/m/Y h:i",strtotime(@$answers["startDate"])); ?></td>
			</tr>

			<tr>
				<td>Date de fin </td>
				<td><?php echo date("d/m/Y h:i",strtotime(@$answers["endDate"])); ?></td>
			</tr>

			<tr>
				<td>Description </td>
				<td><?php echo @$answers["descritption"]; ?></td>
			</tr>
			<tr>
				<td></td>
				<td><a class="btn btn-primary" href="javascript:;" onclick="dyFObj.editElement( 'actions', '<?php echo $answers["_id"] ?>' );">Editer</a></td>
			</tr>
		</tbody>
	</table>

</div>

<?php 

$params = array( "answers" => $answers, 
							 'answerCollection' => "actions",
							 'answerId' => (string)$answers["_id"] ,
							 'form' => $form ,
							 "user" => $user,
							 'scenario' => "scenarioFicheAction" );
			//todo apply cte customisation ???
			
 			echo $this->render( "answerScenario" , $params);

 ?>