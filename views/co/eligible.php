<?php if( $canAdmin && array_search('eligible', $steps) <= array_search($adminAnswers["step"], $steps)  ){ ?>
<h1 class="text-center"> <i class="fa fa-<?php echo (@$adminAnswers["eligible"]) ? "thumbs-o-up text-green": "thumbs-o-down text-red"; ?>"></i> ÉLIGILIBITÉ <small>par TCOPIL</small> </h1>

<div id="eligible"  class="col-xs-12">
	<div class="col-xs-12  padding-20" style="border:1px solid #ccc;">
		<?php
		$project = @$answers["cte2"]["answers"][Project::CONTROLLER];
		if(@$answers["cte2"]["answers"][Project::CONTROLLER] && @$answers["cte1"]["answers"] 
			&& @$answers["cte3"]["answers"]){
			if(!empty($adminAnswers["eligible"])){
				if( @$adminAnswers["eligible"] === true)
					echo "<center><h3 class='text-green'>Ce dossier est éligible</h3></center>";
				else
					echo "<center><h3 class='text-red'>Ce dossier n'est pas éligible</h3><center>";
			}else{
				//var_dump($adminAnswers); echo "<br/><br/><br/>"; echo json_encode($answers); exit;
				echo $this->renderPartial( "survey.views.co.modalSelectCategorie",array());
				?>
				<center>
				<?php
				echo '<div id="active'.$project["id"].$project["type"].'">';

					if($canSuperAdmin == true){
						echo '<a href="javascript:;" data-id="'.(String)$adminAnswers["_id"].'" class="btn btn-success activeBtn col-sm-offset-1 col-sm-4 col-xs-12">Eligible</a>';

						echo '<a href="javascript:;" data-id="'.(String)$adminAnswers["_id"].'" class="btn btn-danger notEligibleBtn col-sm-offset-2 col-sm-4 col-xs-12">Non Eligible</a>';
					}else{
						echo "<span class='text-red' ><h4>En attente d'une réponse</h4></span>";
					}
					
				echo '</div>';

				?>
				</center>
				<?php 
			}
		} else {

			echo "<center><h3 class='text-red'>Ce dossier n'est pas complet.</h3></center>";
		}
		?>
	</div>
</div>
<?php } ?>