<?php if( $canAdmin || (string)$user["_id"] == Yii::app()->session["userId"] ){ 

$cssAnsScriptFilesModule = array(
	'/assets/js/comments.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->theme->baseUrl);

$cssAnsScriptFilesModule = array(
	'/plugins/underscore-master/underscore.js',
	'/plugins/jquery-mentions-input-master/jquery.mentionsInput.js',
	'/plugins/jquery-mentions-input-master/jquery.mentionsInput.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getRequest()->getBaseUrl(true))
?>

<?php if(!@$_GET["step"]) { ?>
	<h1 class="text-center"> <i class="fa fa-folder-open-o"></i> DOSSIER </h1>
	<?php
	if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )){ ?>
		<a class="btn btn-default btn-xs" href="javascript:" id="modifLink">Changer le porteur de projet</a>
	<?php		
	}
}
?>




<?php 
	/* ---------------------------------------------
	ETAT DU DOSSIER
	---------------------------------------------- */
 ?>

<?php if(!@$_GET["step"]) { ?>
<div class='col-xs-12'>
	<h2 class="padding-20"  onclick="$('#state').toggle();" style="background-color:lightgrey;cursor:pointer;">ÉTAT DU DOSSIER <i class="fa pull-right  fa-heartbeat"></i></h2>
	<table id="state" class="table table-striped table-bordered table-hover  directoryTable" id="panelAdmin">
		
		<tbody class="directoryLines">
			<tr>
				<td>État du dossier</td>
				<td>
					<?php
					$i = 1 ;
					foreach ($adminForm["scenarioAdmin"] as $ks => $vs) {
						$c = (@$adminAnswers["step"] && $ks == $adminAnswers["step"]) ? "text-red bold" : ( ($i == 1) ? "text-red bold" : "") ;
						echo '<span class="'.$c.'"><i class="'.@$vs["icon"].'"></i> '.str_replace("<br/>", "", @$vs["title"]).'</span> <br/> ';
						$i++;
					} ?>
					
				</td>
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
<?php } ?>


<?php 
	/* ---------------------------------------------
	RISQUE BLOQUANT
	---------------------------------------------- */
	/*
 ?>

<?php 
if(@$adminAnswers["risks"] )
{
	$list= "";
	$globrcol = "success";
	foreach (@$adminAnswers["risks"] as $kr => $vr) {
		$rcol = Form::$riskWeight[$vr["probability"].$vr["gravity"]]["c"];
		// if( $rcol == "red") {
			$userAction = (@$vr["userAction"]) ? $vr["userAction"] : "<a class='btn btn-danger userActionBtn' data-riskid='".$kr."' data-answerid='".(string)$adminAnswers["_id"]."' href='javascript:;'><i class='fa fa-comment'></i> Répondre</a>";
			$list .= "<tr><td>".$vr["desc"]."</td><td>".@$vr["comment"]."</td><td style='background-color:".$rcol."'>".$vr["weight"]."</td><td id='userAction".$kr."'>".$userAction."</td></tr>";
		// }
	}
	if($list != "")
	{
		echo "<div class='col-xs-12'><h2 class='text-red'>Risques à justifier</h2>";
		echo '<table class="table table-striped table-bordered table-hover  directoryTable">'.
				'<thead>'.
					'<tr>'.
						'<th>Risque</th>'.
						'<th>Commentaire</th>'.
						'<th>Poids</th>'.
						'<th>Solution ou Justification</th>'.
					'</tr>'.
				'</thead>'.
				'<tbody class="directoryLines">'.
				$list.
				'</tbody></table></div>';
	}
} */ ?>


<?php 
	/* ---------------------------------------------
	SECTION REPONSE PAR 
	---------------------------------------------- */
 ?>

<?php if(!@$_GET["step"]) { ?>
<div class='col-xs-12' onclick="$('#by').toggle();">
	<h2 class="padding-20" style="background-color:lightgrey;cursor:pointer;"> Réponse par <i class="fa pull-right fa-user"></i></h2>
	<table id="by"  class="table table-striped table-bordered table-hover  directoryTable" id="panelAdmin">
		
		<tbody class="directoryLines">

			<tr>
				<td>Nom</td>
				<td><b><a href="<?php echo Yii::app()->createUrl( "#@".@$user["slug"]) ?>" target="_blank"><?php echo $user["name"]; ?></a></b></td>
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
<?php } ?>


<?php 
	/* ---------------------------------------------
	ETAPE DU SCENARIO
	---------------------------------------------- */

	// echo $this->renderPartial( "answerScenario" , array("form"=>$form,
	// 													"answers" => $answers,
	// 													"user" => $user,
	// 													'scenario' => "scenario") ); 

 ?>

<?php 
//used when we want to show only a sub section of a survey 
if(@$_GET["step"]) 
{
	foreach ($form["scenario"] as $k => $v) 
	{
		if( $k != $path[1] )
			unset( $form[ "scenario" ][$k] );
		else 
		{
			foreach ($v["form"][ "scenario" ] as $ki => $vi) 
			{
				if( $ki != $path[2] )
					unset( $form[ "scenario" ][$k]["form"][ "scenario" ][$ki] );	
			}
		}
	}
}  

//fills empty sections of answers
foreach ($form["scenario"] as $k => $v) {

 	//echo count(array_keys( $v["form"] ));
	if(	!@$answers[$k]["answers"] || count( array_keys($answers[$k]["answers"])) != count(array_keys( $v["form"]["scenario"] )) )
	{
		foreach ( $v["form"]["scenario"] as $step => $f ) 
		{
			if( !@$answers[$k]["answers"][$step] )
			{
				$answers["answers"] = array();
				$answers["answers"][$step] = array();
				if( @$f["json"]['jsonSchema']["properties"] )
				{
					foreach ( $f["json"]['jsonSchema']["properties"] as $key => $value ) 
					{
						if (@$value["properties"]){
							$answers[$k]["answers"][$step][$key] = []; 
							$tmp = array();
							foreach ($value["properties"] as $ki => $vi) {
								$tmp[$ki] = "";
							}
							//$answers[$k]["answers"][$step][$key][] = $tmp;
						}
						else 
							$answers[$k]["answers"][$step][$key] = "";
					}
				}
				$answers[$k]["created"] = time();
			} 

		}
		$v["form"]["title"] = $v["title"];
		$v["form"]["description"] = $v["description"];
		$v["form"]["icon"] = $v["icon"];
	}

	if(@$answers[$k]){  ?>
		
		<?php if(!@$_GET["step"]) { ?>
		<div class=" titleBlock col-xs-12 text-center" style="cursor:pointer;background-color: <?php echo $form["custom"]["color"] ?>"  onclick="$('#<?php echo $v["form"]["id"]; ?>').toggle();">
			<h1> 
			<?php echo $v["form"]["title"]; ?><i class="fa pull-right <?php echo @$v["form"]["icon"]; ?>"></i>
			</h1>
			<span class="text-dark"><?php echo date('d/m/Y h:i', $answers[$k]["created"]) ?></span>
		</div>
		<?php } ?>
		<div class='col-xs-12' id='<?php echo $v["form"]["id"]; ?>'>
		<?php 
		foreach ( $answers[$k]["answers"] as $key => $value) {
			$editBtn = "";
			
			if( (string)$user["_id"] == Yii::app()->session["userId"] /*&& !Form::isFinish($form["session"][$_GET['session']]["endDate"] ) */  ) {
				if(@$v["form"]["scenario"][$key]["saveElement"]) 
					$editBtn = "<a href='javascript:'  data-form='".$k."' data-step='".$key."' data-type='".$value["type"]."' data-id='".$value["id"]."' class='editStep btn btn-default'><i class='fa fa-pencil'></i></a>";
				else if(!@$v["form"]["scenario"][$key]["arrayForm"])
					$editBtn = "<a href='javascript:'  data-form='".$k."' data-step='".$key."' class='editStep btn btn-default'><i class='fa fa-pencil'></i></a>";
			}
			echo "<div class='col-xs-12'>";
			if(!@$_GET["step"] || $key == $path[2]) 
				echo "<h2 id='".$key."'> [ étape ] ".@$v["form"]["scenario"][$key]["title"]." ".$editBtn."</h2>";

			$head =  (!@$_GET["step"] || $key == $path[2]) ? '<thead><tr>'.
						'<th>'.Yii::t("common","Question").'</th>'.
						'<th>Réponse</th>'.
					'</tr></thead>' : "" ;

			if(@@$v["form"]["scenario"][$key]["arrayForm"]  ){
				$ki = (@$v["form"]["scenario"][$key]["key"]) ? $v["form"]["scenario"][$key]["key"] : array_keys($v["form"]["scenario"][$key]["json"]["jsonSchema"]["properties"])[0];
				$head =  '<thead><tr>'.
						'<th>Ajouter une ligne</th>'.
						"<th><a href='javascript:;' data-form='".$k."' data-step='".$key."' data-q='".$ki."' class='addAF btn btn-primary'><i class='fa fa-plus'></i> Ajouter</a></th>".
					'</tr></thead>';
				if( count($value[$ki]) > 0 )
					$head = "";
			}

			echo '<table class="table table-striped table-bordered table-hover  directoryTable">'.
				$head.
				'<tbody class="directoryLines">';
			if( @$v["form"]["scenario"][$key]["json"] )
			{
				$formQ = @$v["form"]["scenario"][$key]["json"]["jsonSchema"]["properties"];
				foreach ($value as $q => $a) 
				{
					if( @$formQ[$q]["inputType"] == "arrayForm" || @$v["form"]["scenario"][$key]["key"] == $q ){
						
						//Tout les titre du tableau de réponses 
						echo '<tr>';
							if(@$v["form"]["scenario"][$key]["properties"])
								$props = $v["form"]["scenario"][$key]["properties"];
							else 
								$props = $formQ[$q]["properties"];

							foreach ( $props as $ik => $iv) {
								echo "<th>".( ( is_string($iv) ) ? $iv : $iv["placeholder"] )."</th>";
							}

							echo "<th><a href='javascript:;' data-form='".$k."' data-step='".$key."' data-q='".$q."' class='addAF btn btn-primary'><i class='fa fa-plus'></i> Ajouter</a></th>";
						echo '</tr>';

						//Toutes les réponses du tableau
						foreach ($a as $sq => $sa) {
							echo '<tr>';
								
								foreach ($props as $ik => $iv) {
									//chaque propriété a sa réponse 
									$ans = @$sa[$ik];
									if($iv["inputType"] == "select" && @$iv["options"][ @$sa[$ik] ])
										$ans = $iv["options"][ @$sa[$ik] ];
									echo "<td>".$ans."</td>";
								}
								echo "<td>".
									"<a href='javascript:;' data-form='".$k."' data-step='".$key."' data-q='".$q."' data-pos='".$sq."' class='editAF btn btn-default'><i class='fa fa-pencil'></i></a> ".
									"<a href='javascript:;' data-form='".$k."' data-step='".$key."' data-q='".$q."' data-pos='".$sq."' class='deleteAF btn btn-danger'><i class='fa fa-times'></i></a>".
								"</td>";
							echo '</tr>';
						}
					}
					else if(is_string($a)){
						echo '<tr>';
							echo "<td>".@$formQ[ $q ]["placeholder"]."</td>";
							$markdown = (strpos(@$formQ[ $q ]["class"], 'markdown') !== false) ? 'markdown' : "";
							echo "<td class='".$markdown."'>".$a."</td>";
						echo '</tr>';
					}else if(@$a["type"] && $a["type"]==Document::COLLECTION){

					
						$document=Document::getById($a["id"]);
						if(!empty($document)){ 
							$document["docId"]=$a["id"];
							$answers[$k]["answers"][$key]["files"]=array($document);
							$path=Yii::app()->getRequest()->getBaseUrl(true)."/upload/communecter/".$document["folder"]."/".$document["name"];
							echo '<tr>';
								echo "<td>".@$formQ[ $q ]["placeholder"]."</td>";
								echo "<td>";
									echo "<a href='".$path."' target='_blank'><i class='fa fa-file-pdf-o text-red'></i> ".$document["name"]."</a>";
								echo "</td>";
							echo '</tr>';
						}
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

		echo "<h3 style='' class=''> <i class='fa fa-2x fa-exclamation-triangle'></i> ".Yii::t("surveys","This step {num} hasn't been filed yet",array('{num}'=>$k))."</h3>";
		if( (string)$user["_id"] == Yii::app()->session["userId"] /*&& !Form::isFinish($form["session"][$session]["endDate"] ) */ ) {
				echo "<a href='".Yii::app()->createUrl('survey/co/index/id/'.$k.'/session/'.$session.'/answer/'.(string)$_GET['id'])."' class='btn btn-success margin-bottom-10'>".Yii::t("surveys","Go back to this form")."</a>";
		}
	}
	echo "</div>";
}

echo $this->renderPartial( "survey.views.co.modalSwitchLink",array());
?>



<script type="text/javascript">
var answers  = <?php echo json_encode($answers); ?>;
var ctxDynForms = null;
var scenarioKey = "scenario";
var answerCollection = "answers";
var answerId = "<?php echo $_GET['id']; ?>";
var answerSection = "";

$(document).ready(function() { 
	
	ctxDynForms = {
		ficheAction : {}
	}
	$('#doc').html( dataHelper.markdownToHtml( $('#doc').html() ) );
	
	$.each($('.markdown'),function(i,el) { 
		$(this).html( dataHelper.markdownToHtml( $(this).html() ) );	
	});
	$('.editStep').off().click(function() { 
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
					answerId : adminAnswers["_id"]["$id"],
	    			formId : updateForm.form,
	    			session : formSession,
	    			answerSection : "answers."+updateForm.form+".answers."+updateForm.step ,
	    			answers : getAnswers(form.scenario[updateForm.form].form.scenario[updateForm.step].json , true),
	    			answerUser : adminAnswers.user 
	    		};
	    		
	    		console.log("save",data);
	    		
	    		$.ajax({ type: "POST",
			        url: baseUrl+"/survey/co/update",
			        data: data,
					type: "POST",
			    }).done(function (data) {
			    	/*listObject=$('.fine-uploader-manual-trigger').fineUploader('getUploads');
			    	goToUpload=false;
			    	if(listObject.length > 0){
			    		$.each(listObject, function(e,v){
			    			if(v.status == "submitted")
			    				goToUpload=true;
			    		});
			    	}*/
					if(typeof updateForm.goToUpload == "undefined" ){
						window.location.reload();
				    	updateForm = null;
				    } 
			    });
			};

			var editData = answers[$(this).data("form")]['answers'][$(this).data("step")];
			dyFObj.editStep( editForm , editData);	
		}
	});

	$('.userActionBtn').off().click(function() {
		commentRisk($(this).data("answerid"), $(this).data("riskid"));
	});

	
	$('#modifLink').off().click(function() {
		$('#modalSwitchLink').modal("show");
	});

	$('.deleteAF').off().click(function() { 
		answerSection = "answers."+$(this).data("form")+".answers."+$(this).data("step")+"."+$(this).data("q");
		arrayForm.del($(this).data("form"),$(this).data("step"),$(this).data("q"),$(this).data("pos"));
	});

	$('.addAF').off().click(function() { 

		answerSection = "answers."+$(this).data("form")+".answers."+$(this).data("step")+"."+$(this).data("q");
		//alert(answerSection);
		arrayForm.add($(this).data("form"),$(this).data("step"),$(this).data("q"));
	});

	$('.editAF').off().click(function() { 
		answerSection = "answers."+$(this).data("form")+".answers."+$(this).data("step")+"."+$(this).data("q");
		arrayForm.edit($(this).data("form"),$(this).data("step"),$(this).data("q"),$(this).data("pos"));
	});
});
function commentRisk(answerId, riskId){
	var modal = bootbox.dialog({
	        message: '<div class="content-risk-comment-tree"></div>',
	        title: "Fil de commentaire du risque",
	        buttons: [
	        
	          {
	            label: "Annuler",
	            className: "btn btn-default pull-left",
	            callback: function() {
	              console.log("just do something on close");
	            }
	          }
	        ],
	        onEscape: function() {
	          modal.modal("hide");
	        }
	    });
		modal.on("shown.bs.modal", function() {
		  $.unblockUI();
		  	getAjax(".content-risk-comment-tree",baseUrl+"/"+moduleId+"/comment/index/type/answers/id/"+answerId+"/path/risks."+riskId,
			function(){  //$(".commentCount").html( $(".nbComments").html() ); 
			},"html");

		  //bindEventTextAreaNews('#textarea-edit-news'+idNews, idNews, updateNews[idNews]);
		});
	   // modal.modal("show");
	//}
}


</script>


<?php } ?>