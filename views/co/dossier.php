<?php if( $canAdmin || (string)$user["_id"] == Yii::app()->session["userId"] ){ ?>
			
<h1 class="text-center"> <i class="fa fa-folder-open-o"></i> DOSSIER </h1>
<?php 
	/* ---------------------------------------------
	SECTION REPONSE PAR 
	---------------------------------------------- */
 ?>

<div class='col-xs-12' onclick="$('#by').toggle();">
	<h2 class="padding-20" style="background-color:lightgrey;cursor:pointer;"> Réponse par <i class="fa pull-right fa-user"></i></h2>
	<table id="by"  class="table table-striped table-bordered table-hover  directoryTable" id="panelAdmin">
		
		<tbody class="directoryLines">

			<tr>
				<td>Nom</td>
				<td><b><a href="<?php echo Yii::app()->createUrl( "#@".$user["slug"]) ?>" target="_blank"><?php echo $user["name"]; ?></a></b></td>
			</tr>

			<tr>
				<td>Email</td>
				<td><?php echo @$user["email"]; ?></td>
			</tr>
			
			<?php if( $form["id"] == "cte" ){ ?>
				<?php if( @$answers["cte1"]["answers"]["organization"]  ){ ?>
					<tr>
						<td>Organisation</td>
						<td><b><a href="<?php echo Yii::app()->createUrl( "#page.type.organizations.id.".$answers["cte1"]["answers"]["organization"]["id"]); ?>" target="_blank"><?php echo $answers["cte1"]["answers"]["organization"]["name"]; ?></a></b></td>
					</tr>
				<?php }

				if( @$answers["cte2"]["answers"]["project"]  ){ ?>
					<tr>
						<td>Projet</td>
						<td><b><a href="<?php echo Yii::app()->createUrl( "#page.type.projects.id.".$answers["cte2"]["answers"]["project"]["id"]); ?>" target="_blank"><?php echo $answers["cte2"]["answers"]["project"]["name"]; ?></a></b></td>
					</tr>
			<?php } } ?>
		</tbody>
	</table>
</div>


<?php 
	/* ---------------------------------------------
	ETAT DU DOSSIER
	---------------------------------------------- */
 ?>


<div class='col-xs-12'>
	<h2 class="padding-20"  onclick="$('#state').toggle();" style="background-color:lightgrey;cursor:pointer;">ÉTAT DU DOSSIER <i class="fa pull-right  fa-heartbeat"></i></h2>
	<table id="state" class="table table-striped table-bordered table-hover  directoryTable" id="panelAdmin">
		
		<tbody class="directoryLines">
			<tr>
				<td>État du dossier</td>
				<td>Dépot > <b class="text-red">Éligibilité</b> <span style="color:grey"> > Priorisation > Instruction > Selection > Gestion et Suivi</span></td>
			</tr>
			<tr>
				<td>Numéro de dossier</td>
				<td><?php echo (string)@$adminAnswers["_id"] ?></td>
			</tr>
			<tr>
				<td>Organisation CTE</td>
				<td><a class="btn btn-default btn-xs" target="_blank" href="<?php echo Yii::app()->createUrl( "#@cteTco"); ?>">Lien</a></td>
			</tr>

		</tbody>
	</table>					
</div>



<?php 
	/* ---------------------------------------------
	ETAPE DU SCENARIO
	---------------------------------------------- */

	echo $this->renderPartial( "answerScenario" , array("form"=>$form,
														"answers" => $answers,
														"user" => $user) ); 
 ?>


<?php } ?>