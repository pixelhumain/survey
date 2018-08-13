<?php $cssJS = array(
    
    '/plugins/jquery.dynForm.js',
    
    '/plugins/jQuery-Knob/js/jquery.knob.js',
    '/plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js',
    '/plugins/jquery.dynSurvey/jquery.dynSurvey.js',

	'/plugins/jquery-validation/dist/jquery.validate.min.js',
    '/plugins/select2/select2.min.js' , 
    '/plugins/moment/min/moment.min.js' ,
    '/plugins/moment/min/moment-with-locales.min.js',

    // '/plugins/bootbox/bootbox.min.js' , 
    // '/plugins/blockUI/jquery.blockUI.js' , 
    
    '/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js' , 
    '/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css',
    '/plugins/jquery-cookieDirective/jquery.cookiesdirective.js' , 
    '/plugins/ladda-bootstrap/dist/spin.min.js' , 
    '/plugins/ladda-bootstrap/dist/ladda.min.js' , 
    '/plugins/ladda-bootstrap/dist/ladda.min.css',
    '/plugins/ladda-bootstrap/dist/ladda-themeless.min.css',
    '/plugins/animate.css/animate.min.css',
);

HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->request->baseUrl);
$cssJS = array(
    '/js/dataHelpers.js',
    '/js/sig/geoloc.js',
    '/js/sig/findAddressGeoPos.js',
    '/js/default/loginRegister.js'
);
HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->getModule( Yii::app()->params["module"]["parent"] )->getAssetsUrl() );
$cssJS = array(
'/assets/css/default/dynForm.css',

);
HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->theme->baseUrl);
?>

<?php
//assets from ph base repo
$cssAnsScriptFilesTheme = array(
	// SHOWDOWN
	'/plugins/showdown/showdown.min.js',
	//MARKDOWN
	'/plugins/to-markdown/to-markdown.js',
	'/plugins/select2/select2.min.js' ,
	'/plugins/select2/select2.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);

//gettting asstes from parent module repo
$cssAnsScriptFilesModule = array( 
	'/js/dataHelpers.js',
	//'/css/md.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getModule( Yii::app()->params["module"]["parent"] )->getAssetsUrl() );

$cssAnsScriptFilesModule = array( 
	'/js/eligible.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getModule( "survey" )->getAssetsUrl() );

if( $this->layout != "//layouts/empty"){
	$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
	$this->renderPartial($layoutPath.'header',array("page"=>"ressource","layoutPath"=>$layoutPath));
}
?>

<div class="panel panel-dark col-lg-offset-1 col-lg-10 col-xs-12 no-padding margin-top-50">
	<div class="col-xs-12 ">
		
		<div class="col-sm-6 text-center">
			<h1>
			<?php if( Form::canAdmin($form["id"]) ){ ?>
			<a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/answers/id/<?php echo $form["id"]; ?>"><?php echo $form["title"]; ?></a> 
			<?php 
			} else {
				echo $form["title"];
			} ?>
			</h1>
		</div>
		<div class="col-sm-6">
			<?php if(@$form["custom"]['logo']){ ?>
			<img class="img-responsive pull-right margin-20" style="height:150px" src='<?php echo Yii::app()->getModule("survey")->assetsUrl.$form["custom"]['logo']; ?>'>
			<?php }?>
		</div>
    </div>

	<div class="pageTable col-xs-12  text-center"></div>
		<div class="panel-body">
			<div>	
			<style type="text/css">
				.titleBlock{
					border-bottom: 1px solid #666;
				}
			</style>
				<div class="titleBlock col-xs-12 text-center" style="background-color: <?php echo $form["custom"]["color"] ?>" onclick="$('#person').toggle();">
					<h1> Réponse par</h1>
				</div>
				<div class='col-xs-12' id='person'>
					<table class="table table-striped table-bordered table-hover  directoryTable" id="panelAdmin">
						<thead>
							<tr>
								<th><?php echo Yii::t("common","Question") ?></th>
								<th><?php echo Yii::t("common","Answer") ?></th>
							</tr>
						</thead>
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

		foreach ($form["scenario"] as $k => $v) {
			if(@$answers[$k]){  ?>
				<div class=" titleBlock col-xs-12 text-center" style="background-color: <?php echo $form["custom"]["color"] ?>"  onclick="$('#<?php echo $v["form"]["id"]; ?>').toggle();">
					<h1> 
					<?php echo $v["form"]["title"]; ?>
						
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
						$editBtn = "<a href='javascript:'  data-form='".$k."' data-step='".$key."' class='editStep btn btn-default'><i class='fa fa-pencil'></i></a>";

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
					if(@$v["form"]["scenario"][$key]["json"])
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
	</div>
	</div>
</div>

<?php if( Form::canAdmin($form["id"]) ){ ?>
<div class="container" >
	<div class="col-lg-offset-1 col-lg-10 col-xs-12 padding-20 margin-top-50 margin-bottom-50 " style="border:1px solid red;">
		
		<h1 class="text-red text-center">ADMIN SECTION <i class="fa fa-lock"></i></h1>
		<div class="text-center margin-bottom-20">Visible seulement par les admins du TCO</div>

		<div class="col-xs-12 " style="border:1px solid #ccc;">
			

			<?php
			
			if(@$answers["cte2"]["answers"][Project::CONTROLLER]){
				$project = $answers["cte2"]["answers"][Project::CONTROLLER];
				if(!empty($eligible)){
					if( $eligible["eligible"] === true)
						echo "<center><h3>Ce dossier est éligible</h3></center>";
					else
						echo "<center><h3>Ce dossier n'est pas éligible</h3><center>";
				}else{
					echo $this->renderPartial( "survey.views.co.modalSelectCategorie",array());
					?>
					<center><h3>Eligibilité</h3>
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
					<br/><br/>Cette action aura pour impacte de connceté l'organisation au CTE, et ajouterais le projet à la liste des projets du CTE
					<br/>un mail automatique sera envoyé au projet avec <a href="javascript:;" onclick="$('#mailEligible').toggle();">le texte suivant</a>
					<div id="mailEligible" class="hide">
						<textarea id="mailEligibleTxt">fq fdq fq</textarea>
						<textarea id="mailNonEligibleTxt"> qdsf ds fqsdf qsd</textarea>
					</div>
					<?php
				} 
			}
			?>
		</div>

		<div class="col-xs-12 hidden">
			<h3>Instruction</h3>
			à produire par le TCO la matrice d'instruction : <br/>
			<ul>
				<li>Cohérence : Analyse technique / resultat attendu par le CTE</li>
				<li>
					Avis expert Technique / Tete de réseau<br>
					<ul>
						<li>Evaluation du risque</li>
					</ul>
				</li>
				<li>Pertinence / respect Calendrier</li>
				<li>
				Cohérence Financiere (par les financeurs) :<br>
					<ul>	
						<li>Alignement avec les mesures</li>
						<li>Analyse financiere</li>
					</ul>
					</li>
			</ul>
		</div>

		<div class="col-xs-12 hidden">
			<h3>Selection</h3>
		</div>

		<div class="col-xs-12 hidden">
			<h3>Evaluation et Suivi</h3>
			<ul>
				<li>Auto évaluation</li>
				<li>Demande de milestone</li>
				<li>Solication intermédiaire</li>
			</ul>
		</div>

	</div>
</div>
<?php } ?>


<?php 
if(@$form["custom"]['footer']){
	echo $this->renderPartial( $form["custom"]["footer"],array("form"=>$form,"answers"=>$answers));
}
?>

<script type="text/javascript">
var form = <?php echo json_encode($form); ?>;
var answers  = <?php echo json_encode($answers); ?>;
var eligible  = <?php echo json_encode($eligible); ?>;
var rolesListCustom = <?php echo json_encode(@$roles); ?>;
var updateForm = null;

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
	    			answerSection : updateForm.step ,
	    			answers : getAnswers()
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
	
	bindAnwserList();
});

function getAnswers()
{
	//alert("get Answers");
	var editAnswers = {};
	var editForm = form.scenario[updateForm.form].form.scenario[updateForm.step].json;
	$.each( editForm.jsonSchema.properties,function(field,fieldObj) { 
        mylog.log($(this).data("step")+"."+field, $("#"+field).val() );
        if( fieldObj.inputType ){
            if(fieldObj.inputType=="uploader"){
         		if( $('#'+fieldObj.domElement).fineUploader('getUploads').length > 0 ){
					$('#'+fieldObj.domElement).fineUploader('uploadStoredFiles');
					editAnswers[field] = "";
            	}
            }else{
            	editAnswers[field] = $("#"+field).val();
            }
        }
    });
    return editAnswers;
    console.log("editAnswers",editAnswers);
}
</script>
