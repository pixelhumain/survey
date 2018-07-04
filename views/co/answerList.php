<?php


//assets from ph base repo
$cssAnsScriptFilesTheme = array(
	// SHOWDOWN
	'/plugins/showdown/showdown.min.js',
	//MARKDOWN
	'/plugins/to-markdown/to-markdown.js'
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);

//gettting asstes from parent module repo
$cssAnsScriptFilesModule = array( 
	'/js/dataHelpers.js',
	//'/css/md.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getModule( Yii::app()->params["module"]["parent"] )->getAssetsUrl() );

if( $this->layout != "//layouts/empty"){
	$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
	$this->renderPartial($layoutPath.'header',array("page"=>"ressource","layoutPath"=>$layoutPath));
}
?>

<div class="panel panel-dark col-lg-offset-1 col-lg-10 col-xs-12 no-padding margin-top-50">
	<div class="col-xs-12 text-center">
		<h1><a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/answers/id/<?php echo $form["id"]; ?>"><?php echo $form["title"]; ?></a> </h1>
		<h4 style="text-align: center;padding:10px;">Answers by <?php echo $user["name"]; ?> </h4>
    </div>

	<div class="pageTable col-xs-12 padding-20 text-center"></div>
		<div class="panel-body">
			<div>	

		<?php 

		foreach ($form["scenario"] as $k => $v) {
			//var_dump($v);
			//var_dump($answers);
			//break;
			if(@$answers[$k])
			{?>
				<div class="bg-dark col-xs-12 text-center">
					<h1> <?php echo $v["form"]["title"]; ?><a class='btn pull-right btn-default' href="javascript:;" onclick="$('#<?php echo $v["form"]["id"]; ?>').toggle();"><i class="fa  fa-eye"></i></a></h1>
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
								foreach($el["tags"] as $v){
									if($it>0)
										echo ", ";
									echo $v;
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

<?php 
if( Form::canAdmin($form["id"]) )
{ ?>
<div class="container" >
	<div class="col-lg-offset-1 col-lg-10 col-xs-12 padding-20 margin-top-50 margin-bottom-50 " style="border:1px solid red;">
		
		<h1 class="text-red text-center">ADMIN SECTION <i class="fa fa-lock"></i></h1>
		<div class="text-center margin-bottom-20">Visible seulement par les admins du TCO</div>

		<div class="col-xs-12 " style="border:1px solid #ccc;">
			<h3>Eligibilité</h3>
			<a href="" class="btn btn-success">Eligible</a> <a href=""  class="btn btn-danger">Non Eligible</a>
			<br/>Cette action aura pour impacte de connceté l'organisation au CTE, et ajouterais le projet à la liste des projets du CTE
			<br/>un mail automatique sera envoyé au projet avec <a href="javascript:;" onclick="$('#mailEligible').toggle();">le texte suivant</a>
			<div id="mailEligible" class="hide">
				<textarea id="mailEligibleTxt">fq fdq fq</textarea>
				<textarea id="mailNonEligibleTxt"> qdsf ds fqsdf qsd</textarea>
			</div>
		</div>

		<div class="col-xs-12 hidden">
			<h3>Instruction</h3>
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

$(document).ready(function() { 
	$('#doc').html( dataHelper.markdownToHtml( $('#doc').html() ) );		
});


</script>
