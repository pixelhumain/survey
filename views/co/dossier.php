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
 ?>

<?php foreach ($form["scenario"] as $k => $v) {
	if(@$answers[$k]){  ?>
		
		<div class=" titleBlock col-xs-12 text-center" style="cursor:pointer;background-color: <?php echo $form["custom"]["color"] ?>"  onclick="$('#<?php echo $v["form"]["id"]; ?>').toggle();">
			<h1> 
			<?php echo $v["form"]["title"]; ?><i class="fa pull-right <?php echo @$v["form"]["icon"]; ?>"></i>
			</h1>
			<span class="text-dark"><?php echo date('d/m/Y h:i', $answers[$k]["created"]) ?></span>
		</div>

		<div class='col-xs-12' id='<?php echo $v["form"]["id"]; ?>'>

		<?php 
			foreach ( $answers[$k]["answers"] as $key => $value) 
			{

			$editBtn = "";
			if(@$v["form"]["scenario"][$key]["saveElement"]) 
				$editBtn = "<a href='javascript:'  data-form='".$k."' data-step='".$key."' data-type='".$value["type"]."' data-id='".$value["id"]."' class='editStep btn btn-default'><i class='fa fa-pencil'></i></a>";
			else 
			//if(!@$v["form"]["scenario"][$key]["saveElement"]) 
				$editBtn = ( (string)$user["_id"] == Yii::app()->session["userId"] ) ? "<a href='javascript:'  data-form='".$k."' data-step='".$key."' class='editStep btn btn-default'><i class='fa fa-pencil'></i></a>" : "";

			echo "<div class='col-xs-12'>".
					"<h2> [ step ] ".@$v["form"]["scenario"][$key]["title"]." ".$editBtn."</h2>";
			echo '<table class="table table-striped table-bordered table-hover  directoryTable" id="panelAdmin">'.
				'<thead>'.
					'<tr>'.
						'<th>'.Yii::t("common","Question").'</th>'.
						'<th>'.Yii::t("common","Answer").'</th>'.
					'</tr>'.
				'</thead>'.
				'<tbody class="directoryLines">';
			if( @$v["form"]["scenario"][$key]["json"] )
			{
				$formQ = @$v["form"]["scenario"][$key]["json"]["jsonSchema"]["properties"];
				foreach ($value as $q => $a) 
				{
					if(is_string($a)){
						echo '<tr>';
							echo "<td>".@$formQ[ $q ]["placeholder"]."</td>";
							$markdown = (strpos(@$formQ[ $q ]["class"], 'markdown') !== false) ? 'markdown' : "";
							echo "<td class='".$markdown."'>".$a."</td>";
						echo '</tr>';
					}else if(@$a["type"] && $a["type"]==Document::COLLECTION){
						$document=Document::getById($a["id"]);
						$path=Yii::app()->getRequest()->getBaseUrl(true)."/upload/communecter/".$document["folder"]."/".$document["name"];
						echo '<tr>';
							echo "<td>".@$formQ[ $q ]["placeholder"]."</td>";
							echo "<td>";
								echo "<a href='".$path."' target='_blank'><i class='fa fa-file-pdf-o text-red'></i> ".$document["name"]."</a>";
							echo "</td>";
						echo '</tr>';
					}
				}
			//todo search dynamically if key exists
			} 
			else if(@$v["form"]["scenario"]["survey"]["json"][$key])
			{
				$formQ = $v["form"]["scenario"]["survey"]["json"][$key]["jsonSchema"]["properties"];
				foreach ($value as $q => $a) {
					if(is_string($a)){
						echo '<tr>';
							echo "<td>".$formQ[ $q ]["placeholder"]."</td>";
							echo "<td>".$a."</td>";
						echo '</tr>';
					}else if(@$a["type"] && $a["type"]==Document::COLLECTION){
						echo '<tr>';
							echo "<td>".@$formQ[ $q ]["placeholder"]."</td>";
							echo "<td>".$a["type"]."</td>";
						echo '</tr>';
					}
				}
			} 
			else if (@$v["form"]["scenario"][$key]["saveElement"]) 
			{
				$el = Element::getByTypeAndId( $value["type"] , $value["id"] );

				echo '<tr>';
					echo "<td> ".Yii::t("common","Name")."</td>";
					echo "<td> <a target='_blank' class='btn btn-default' href='".Yii::app()->createUrl("#@".$el["slug"]).".view.detail'>".$el["name"]."</a></td>";
				echo '</tr>';

				if(@$el["type"]){
					echo '<tr>';
						echo "<td>".Yii::t("common","Type")."</td>";
						echo "<td>".$el["type"]."</td>";
					echo '</tr>';
				}

				if(@$el["description"]){
					echo '<tr>';
						echo "<td>".Yii::t("common", "Description")."</td>";
						echo "<td>".$el["description"]."</td>";
					echo '</tr>';
				}

				if(@$el["tags"]){
					echo '<tr>';
						echo "<td>".Yii::t("common","Tags")."</td>";
						echo "<td>";
						$it=0;
						foreach($el["tags"] as $tags){
							if($it>0)
								echo ", ";
							echo "<span class='text-red'>#".$tags."</span>";
							$it++;
						}
						echo "</td>";
					echo '</tr>';
				}

				if(@$el["shortDescription"]){
					echo '<tr>';
						echo "<td>".Yii::t("common","Short description")."</td>";
						echo "<td>".$el["shortDescription"]."</td>";
					echo '</tr>';
				}

				if(@$el["email"]){
					echo '<tr>';
						echo "<td>".Yii::t("common","Email")."</td>";
						echo "<td>".$el["email"]."</td>";
					echo '</tr>';
				}
				
				if(@$el["profilImageUrl"]){
					echo '<tr>';
						echo "<td>".Yii::t("common","Profil image")." </td>";
						echo "<td><img src='".Yii::app()->createUrl($el["profilImageUrl"])."' class='img-responsive'/></td>";
					echo '</tr>';
				}

				if(@$el["url"]){
					echo '<tr>';
						echo "<td>".Yii::t("common","Website URL")."</td>";
						echo "<td><a href='".$el["url"]."'>".$el["url"]."</a></td>";
					echo '</tr>';
				}

			}
			echo "</tbody></table></div>";
		}
	} else { ?>
	<div class="bg-red col-xs-12 text-center text-large text-white margin-bottom-20"><h1> <?php echo $v["form"]["title"]; ?></h1>
	<?php 
		echo "<h3 style='' class=''> <i class='fa fa-2x fa-exclamation-triangle'></i> ".Yii::t("surveys","This step {num} hasn't been filed yet",array('{num}'=>$k))."</h3>".
			"<a href='".Yii::app()->createUrl('survey/co/index/id/'.$k)."' class='btn btn-success margin-bottom-10'>".Yii::t("surveys","Go back to this form")."</a>";

	}
	echo "</div>";
}
?>

<script type="text/javascript">

$(document).ready(function() { 
	
	$('#doc').html( dataHelper.markdownToHtml( $('#doc').html() ) );
	
	$.each($('.markdown'),function(i,el) { 
		$(this).html( dataHelper.markdownToHtml( $(this).html() ) );	
	});

	$('.editStep').click(function() { 

		if( $(this).data("type") )
		{
			//alert($(this).data("type")+" : "+$(this).data("id"));
			updateForm = {
				form : $(this).data("form"),
				step : $(this).data("step"),
				type : $(this).data("type"),
				id : $(this).data("id"),
				path : modules.co2.url + form.scenario[ $(this).data("form") ].form.scenario[$(this).data("step")].path	
			};

			var subType = "";
			if( $(this).data("type") == "project" ){
				subType = "project2";
				modules.project2 = {
			        form : modules.co2.url+form.scenario[$(this).data("form")].form.scenario[$(this).data("step")].path
			    };
			} else if( $(this).data("type") == "organization" ){
				subType = "organization2";
				modules.organization2 = {
			        form : modules.co2.url+form.scenario[$(this).data("form")].form.scenario[$(this).data("step")].path
			    };
			}

			dyFObj.editElement( $(this).data("type"), $(this).data("id"), subType );
		}
		else 
		{
			//alert($(this).data("form")+" : "+$(this).data("step"));
			updateForm = {
				form : $(this).data("form"),
				step : $(this).data("step")	
			};

			var editForm = form.scenario[$(this).data("form")].form.scenario[$(this).data("step")].json;
			editForm.jsonSchema.onLoads = {
				onload : function(){
					dyFInputs.setHeader("bg-dark");
					$('.form-group div').removeClass("text-white");
					dataHelper.activateMarkdown(".form-control.markdown");
				}
			};
			
			editForm.jsonSchema.save = function(){
				
				data={
	    			formId : updateForm.form,
	    			answerSection : "answers."+updateForm.step ,
	    			answers : getAnswers(form.scenario[updateForm.form].form.scenario[updateForm.step].json , true),
	    			answerUser : adminAnswers.user 
	    		};
	    		
	    		console.log("save",data);
	    		
	    		$.ajax({ type: "POST",
			        url: baseUrl+"/survey/co/update",
			        data: data,
					type: "POST",
			    }).done(function (data) {
			    	if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length == 0 ){
				    	window.location.reload();
				    	updateForm = null;
				    } 
			    });
			};


			var editData = answers[$(this).data("form")]['answers'][$(this).data("step")];
			dyFObj.editStep( editForm , editData);	
		}
	});
});

</script>
<?php } ?>