
<h1 class="text-center"> <i class="fa fa-<?php echo (@$adminAnswers["eligible"]) ? "thumbs-o-up text-green": "thumbs-o-down text-red"; ?>"></i> ÉLIGILIBITÉ <small>par TCOPIL</small> </h1>

<div id="eligible"  class="col-xs-12">
	<div class="col-xs-12  padding-20" style="border:1px solid #ccc;">
		<?php
		$project = @$answers["cte2"]["answers"][Project::CONTROLLER];

		if(@$answers["cte2"]["answers"][Project::CONTROLLER]){
			if(!empty($adminAnswers["eligible"])){
				if( @$adminAnswers["eligible"] === true)
					echo "<center><h3 class='text-green'>Ce dossier est éligible</h3></center>";
				else
					echo "<center><h3 class='text-red'>Ce dossier n'est pas éligible</h3><center>";
			}else{
				echo $this->renderPartial( "survey.views.co.modalSelectCategorie",array());
				?>
				<center><h2>Eligibilité</h2>
				<?php
				echo '<div id="active'.$project["id"].$project["type"].'">';
					echo '<a href="javascript:;"  data-id="'.$project["id"].'" data-type="'.$project["type"].'" data-name="'.$project["name"].'" data-userid="'.$answers["cte2"]["user"].'" data-username="'.$answers["cte2"]["name"].'" ';
						if(!empty($project["parentId"]) && !empty($project["parentType"])){
							echo 'data-parentId="'.$project["parentId"].'" data-parenttype="'.$answers["cte2"]["parentType"].'" data-parentname="'.$answers["cte2"]["parentName"].'" ';
						}
					echo 'class="btn btn-success activeBtn col-sm-offset-1 col-sm-4 col-xs-12">Eligible</a>';

					echo '<a href="javascript:;"  data-id="'.$project["id"].'" data-type="'.$project["type"].'" data-name="'.$project["name"].'" data-userid="'.$answers["cte2"]["user"].'" data-username="'.$answers["cte2"]["name"].'" ';
						if(!empty($project["parentId"]) && !empty($project["parentType"])){
							echo 'data-parentId="'.$project["parentId"].'" data-parenttype="'.$answers["cte2"]["parentType"].'" data-parentname="'.$answers["cte2"]["parentName"].'" ';
						}
					echo 'class="btn btn-danger notEligibleBtn col-sm-offset-2 col-sm-4 col-xs-12">Non Eligible</a>';
				echo '</div>';

				?>
				</center>
				<?php 
			}
		}
			?>
	</div>
</div>