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

			<?php if( $form["id"] == "cte" ){ ?>
			<h4>
			Person : <?php echo $user["name"]; ?> <br/>
			Organisation : 	<?php echo $answers["cte1"]["answers"]["organization"]["name"]; ?><br/>
			Projet : <?php echo $answers["cte2"]["answers"]["project"]["name"]; ?>
			</h4>
			<?php }?>
		</div>
		<div class="col-sm-6">
		<?php if(@$form["custom"]['urlLogo']){ ?>
		<img class="img-responsive pull-right margin-20"   src='<?php echo Yii::app()->getModule("survey")->assetsUrl.$form["custom"]['urlLogo']; ?>'>
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
								<th>Question</th>
								<th>Answer</th>
							</tr>
						</thead>
						<tbody class="directoryLines">
							<tr>
								<td>Nom</td>
								<td><?php echo $user["name"]; ?></td>
							</tr>
							<tr>
								<td>Email</td>
								<td><?php echo $user["email"]; ?></td>
							</tr>
							<tr>
								<td>Fiche</td>
								<td><?php echo Yii::app()->createUrl("#page.type.citoyens.id.".$user["username"]) ?></td>
							</tr>
						</tbody>
					</table>
				</div>
	<?php 

		foreach ($form["scenario"] as $k => $v) {
			if(@$answers[$k]){  ?>
				<div class=" titleBlock col-xs-12 text-center" style="background-color: <?php echo $form["custom"]["color"] ?>"  onclick="$('#<?php echo $v["form"]["id"]; ?>').toggle();">
					<h1> <?php echo $v["form"]["title"]; ?></h1>
				</div>
				<div class='col-xs-12' id='<?php echo $v["form"]["id"]; ?>'>

				<?php 
					foreach ( $answers[$k]["answers"] as $key => $value) 
					{
					echo "<div class='col-xs-12'>".
							"<h2> [ step ] ".@$v["form"]["scenario"][$key]["title"]."</h2>";
					echo '<table class="table table-striped table-bordered table-hover  directoryTable" id="panelAdmin">'.
						'<thead>'.
							'<tr>'.
								'<th>Question</th>'.
								'<th>Answer</th>'.
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
									echo "<td>".$a."</td>";
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
							echo "<td> name </td>";
							echo "<td> ".$el["name"]."</td>";
						echo '</tr>';

						if(@$el["type"]){
							echo '<tr>';
								echo "<td> Type </td>";
								echo "<td>".$el["type"]."</td>";
							echo '</tr>';
						}

						if(@$el["description"]){
							echo '<tr>';
								echo "<td> Description </td>";
								echo "<td>".$el["description"]."</td>";
							echo '</tr>';
						}

						if(@$el["tags"]){
							echo '<tr>';
								echo "<td> Tags </td>";
								echo "<td>";
								$it=0;
								foreach($el["tags"] as $tags){
									if($it>0)
										echo ", ";
									echo $tags;
								}
								echo "</td>";
							echo '</tr>';
						}

						if(@$el["shortDescription"]){
							echo '<tr>';
								echo "<td> Short Description </td>";
								echo "<td>".$el["shortDescription"]."</td>";
							echo '</tr>';
						}

						if(@$el["email"]){
							echo '<tr>';
								echo "<td> Email </td>";
								echo "<td>".$el["email"]."</td>";
							echo '</tr>';
						}
						
						if(@$el["profilImageUrl"]){
							echo '<tr>';
								echo "<td> profilImageUrl </td>";
								echo "<td><img src='".Yii::app()->createUrl($el["profilImageUrl"])."' class='img-responsive'/></td>";
							echo '</tr>';
						}

						if(@$el["url"]){
							echo '<tr>';
								echo "<td> URL </td>";
								echo "<td><a href='".$el["url"]."'>Site</a></td>";
							echo '</tr>';
						}

						echo '<tr>';
							echo "<td> link </td>";
							echo "<td> <a target='_blank' class='btn btn-default' href='".Yii::app()->createUrl("#page.type.".$value["type"].".id.".$value["id"])."'>".$value["type"]."</a></td>";
						echo '</tr>';
					}
					echo "</tbody></table></div>";
				}
			} else { ?>
			<div class="bg-red col-xs-12 text-center text-large"><h1> <?php echo $v["form"]["title"]; ?></h1></div>
			<?php 
				echo "<h3 style='color:red' class='text-center'> This step ".$k." hasn't been filed yet.</h3>";
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
			} ?>
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

$(document).ready(function() { 
	
	$('#doc').html( dataHelper.markdownToHtml( $('#doc').html() ) );
	
	bindAnwserList();
});


</script>
