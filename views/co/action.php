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
				<td><?php if(@$answers["startDate"])echo date("d/m/Y h:i",strtotime(@$answers["startDate"])); ?></td>
			</tr>

			<tr>
				<td>Date de fin </td>
				<td><?php if (@$answers["endDate"])echo date("d/m/Y h:i",strtotime(@$answers["endDate"])); ?></td>
			</tr>

			<tr>
				<td>Description </td>
				<td><?php echo @$answers["descritption"]; ?></td>
			</tr>

			<tr>
				<td>Thématique </td>
				<?php 
				foreach ($parentSurvey["custom"]["roles"] as $key) {
					$lblRole[InflectorHelper::slugify($key)] = $key;
				}
				 ?>
				<td><?php echo $lblRole[$answers["role"]]; ?></td>
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
							 'projects' => $projects ,
							 "user" => $user,
							 'scenario' => "scenarioFicheAction" );
			//todo apply cte customisation ???
			
 			echo $this->render( "answerScenario" , $params);

 ?>

 <script type="text/javascript">
 	
var currentRoomId = "";
var form =<?php echo json_encode($form); ?>;
var contextData = { id : form.parentId, type : form.parentType } ;
var role = "<?php echo $answers["role"]; ?>";
var parentIdSurvey = "<?php echo @$answers["parentIdSurvey"]; ?>";
</script>