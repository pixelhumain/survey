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


	$canAdmin = Form::canAdmin($form["id"]);
	$showStyle = ( $canAdmin ) ? "display:none; " : "";
?>

<div class="panel panel-dark col-lg-offset-1 col-lg-10 col-xs-12 no-padding ">
	<div class="col-xs-12 text-center">
		
			<h2>
				<?php if( $canAdmin ){ ?>
				<a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/answers/id/<?php echo $form["id"]; ?>"> 
				<?php 
				} ?>
					<?php /*if(@$form["custom"]['logo']){ ?>
					<img class="img-responsive margin-20" style="vertical-align: middle; height:150px" src='<?php echo Yii::app()->getModule("survey")->assetsUrl.$form["custom"]['logo']; ?>'  >
					<?php } */ 
					
					echo @$answers["cte2"]["answers"]["project"]["name"]."<br/><small> par ".@$answers["cte1"]["answers"]["organization"]["name"]."</small>";//$form["title"]; 
					
				if( $canAdmin ){ ?>
				</a>
				<?php } ?> 
			</h2>
		
    </div>

	<div class="pageTable col-xs-12  text-center"></div>

		<div class="panel-body">
			<div>	
			<style type="text/css">
				.titleBlock{
					border-bottom: 1px solid #666;
				}

				.stepNumber i{margin-top: 8px}
			</style>
				
		
		<div id="wizard" class="swMain">
			<ul id="wizardLinks">
				<?php 
				$ct = 0;
				$currentStep = (@$adminAnswers["step"]) ? $adminAnswers["step"] : "" ;
				if($adminForm["scenarioAdmin"]){
				foreach ( @$adminForm["scenarioAdmin"] as $k => $v) { 
					$aClass = ( $currentStep != "") ? $currentStep : "";
					if( $aClass != "" && $currentStep != $k )
						$aClass == "class='done'";
					else if( $aClass != "" && $currentStep == $k )
						$aClass == "class='selected'";
					?>
					<li><a onclick="nextState($(this).attr('href'),$(this).attr('class'));" href="#<?php echo $k ?>" <?php echo $aClass ?> ><div class="stepNumber"><i class="fa  fa-<?php echo $v["icon"] ?>"></i></div><span class="stepDesc"> <?php echo $v["title"] ?> </span></a></li>	
				<?php } }?>
			</ul>
			<?php  ?>
			<div class="progress progress-xs transparent-black no-radius active">
				<div aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar partition-green step-bar">
					<span class="sr-only"> 0% Complete (success)</span>
				</div>
			</div>
		
			<div class="errorHandler alert alert-danger no-display">
				<i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
			</div>

			


<div id='dossier' class='section0'>
				
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
					if( $answers["cte2"]["answers"]["project"]  ){ ?>
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
					$editBtn = ( $user == Yii::app()->session["userId"] ) ? "<a href='javascript:'  data-form='".$k."' data-step='".$key."' class='editStep btn btn-default'><i class='fa fa-pencil'></i></a>" : "";

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
</div>



<?php 
	/* ---------------------------------------------
	SECTION ELIGIBILITé
	---------------------------------------------- */
 ?>


<div id='eligible' class='section1 hide'>

<?php if( $canAdmin ){ 

	//if(@$adminAnswers["eligible"]){
		?>	
		<h1 class="text-center"> <i class="fa fa-<?php echo (@$adminAnswers["eligible"]) ? "thumbs-o-up text-green": "thumbs-o-down text-red"; ?>"></i> ÉLIGILIBITÉ <small>par TCOPIL</small> </h1>
		
		<div id="eligible"  class="col-xs-12">
			<div class="col-xs-12  padding-20" style="border:1px solid #ccc;">
				<?php
				$project = $answers["cte2"]["answers"][Project::CONTROLLER];
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
				} ?>
			</div>
		</div>
	<?php //} 
	}?>

</div>


<?php 
	/* ---------------------------------------------
	SECTION PRIORISATION
	---------------------------------------------- */ 
?>


<div id='priorisation' class='section2 hide'>

<?php 
$prioKey = $adminForm['key'];
if( $canAdmin ){ 

	if(@$adminAnswers["categories"]){
		$prioKey = $adminForm['key'];
		?>	
		<h1 class="text-center"> <i class="fa fa-flag-checkered"></i> <?php echo mb_strtoupper($prioKey) ?> <small>par TCOPIL</small> </h1>
		<script type="text/javascript">
			function EliTabs(el){
				$('.eliSec').css('display','none').removeClass("");
				$('#'+el).toggle();
				$('.catElLI').removeClass("active");
				$('#'+el+"Btn").addClass("active");
			}
		</script>
		<style type="text/css">
			.nav li a{font-size:17px;}
			.nav li.active {border-right : 3px solid red;border-left : 3px solid red}
			.nav li.active a{font-weight: bolder;}
		</style>
		<div id="categories" class="col-xs-12">
			<ul class="nav nav-tabs">
			  <li id="eligibleDescBtn" class="catElLI active"><a href="javascript:;" onclick="EliTabs('eligibleDesc')">Descriptif</a></li>
				  <?php

				  // ---------------------------------------
				  // ALL THE TABS FOR PRIORISATION 
				  // ---------------------------------------
				  
					$prioTypes = array();
					foreach ($adminForm['scenario'] as $ki => $vi) {
					 	$prioTypes[] = $ki;
					} 
				  foreach ($adminAnswers["categories"] as $ka => $va ) { ?>
				  <li id="<?php echo $ka?>Btn" class="catElLI bold"><a href="javascript:;" onclick="EliTabs('<?php echo $ka ?>')"><?php 
				  	$ic = ( !@$adminAnswers["answers"][$prioKey][ $va["name"]]["total"] && Form::canAdminRoles($form["id"], $va["name"], $form) ) ? " <i class='text-red fa fa-cog'></i>" : "";
					echo mb_strtoupper($va["name"]).$ic; ?></a></li>
				  <?php } ?>
				  <li class="pull-right"> <a href=""><i class="text-red margin-top-10 fa fa-pencil"></i></a></li>
			</ul>




			<?php 
			// ---------------------------------------
			// GOLBZAL RESULT TABLE
			// ---------------------------------------
			 ?>
			<div id="eligibleDesc" class="eliSec col-xs-12 padding-20">
				<h1>Descriptif de la <?php echo mb_strtoupper($prioKey) ?></h1>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				<br>
				<div class="padding-10"  style="border:1px solid red">
					<h3 class="text-center">Matrice de <?php echo mb_strtoupper($prioKey) ?></h3>
					<table border="1" class="text-red text-center bold" style="margin:0px auto;">
						<tr>
							<?php foreach ($adminAnswers["categories"] as $ka => $va ) {
								
								?>
							<th class="padding-10"><a href="javascript:;" onclick="EliTabs('<?php echo $ka ?>')"><?php echo mb_strtoupper($va["name"]) ?></a></th>
							<?php } ?>
							<th class="padding-10">Note globale</th>
							<th class="padding-10">Classification</th>
						</tr>
						<tr>
							<?php foreach ($adminAnswers["categories"] as $ka => $va ) {?>
							<td><a href="javascript:;" onclick="changeCategoryWeight('<?php echo $ka ?>','<?php echo @$va["pourcentage"] ?>')"><?php echo @$va["pourcentage"]."%" ?></a></td>
							<?php } ?>
							<td>100%</td>
							<td>Note</td>
						</tr>
						<tr>
							<?php 
							$tot = 0;
							$ctot = 0;
							if(@$adminAnswers["answers"][$prioKey]){ 
								foreach ( @$adminAnswers["answers"][$prioKey] as $ka => $va ) {?>
									<td class="<?php echo $ka ?>_Total">
									<?php if(@$va['total']){
												echo $va['total'];
												$ctot++;
											} 
												else 
												echo "-"; ?>
									</td>
									<?php 
									$w = 1 + ((int)$adminAnswers["categories"][$ka] / 100);
									$tot += (floor( (float)@$va['total']*100 / $w))/100;
								} 
							}?>
							<td ><?php if($ctot == count($adminAnswers["categories"]) ) echo $tot; ?></td>
							<td></td>
						</tr>
					</table>
				</div>
			</div>

			<?php foreach ($adminAnswers["categories"] as $key => $vey ) {?>
					<div id="<?php echo $key ?>" style="display:none" class="eliSec col-xs-12 padding-20">
						<div class="col-xs-12 text-center " >
							<h2 class="text-center"><?php echo mb_strtoupper($prioKey) ?> <?php echo $key ?></h2>

							<?php 
								$showHide = (@$adminAnswers["answers"][$prioKey][$key]) ? "" : "hide";
							// ---------------------------------------
							// GLOBAL RESULT TABLE FOR EACH CATEGORY
							// ---------------------------------------
							 ?>
							<div class="margin-bottom-20 padding-10 <?php echo $showHide ?> <?php echo $key?>_Priorisation"  style="border:1px solid red">
								<h3 class="text-center text-red" >Matrice de <?php echo mb_strtoupper($prioKey) ?>  <?php echo $key ?></h3>
								<table border="1" class="text-center text-red" style="margin:0px auto;">
									<tr>
										<?php 
										foreach ($prioTypes as $prioType ) 
										{  ?>
										<th class="padding-10"><a href="javascript:;" onclick="showTableOrForm('<?php echo $key ?>','<?php echo $prioType ?>')"><?php echo mb_strtoupper($prioType) ?></a></th>
										<?php } ?>
										<th>Note globale</th>
										<th>Classification</th>
									</tr>
									<tr>
										<?php 
										foreach ($prioTypes as $prioType ) 
										{  ?>
										<td><?php echo floor( (100/count($prioTypes)) ) ?>%</td>
										<?php } ?>
										<td class="text-red" >100%</td>
										<td class="text-red">Note</td>
									</tr>
									<tr>
										<?php 
										$countRes = 0;
										$countTotal = 0;
										foreach ($prioTypes as $prioType ) 
										{  ?>
										<td class="<?php echo $key?>_Total <?php echo $key?>_<?php echo $prioType ?>TotalNum">
											<?php if( @$adminAnswers["answers"][$prioKey][ $key ][ $prioType ]["total"] ) {
												echo $adminAnswers["answers"][$prioKey][ $key ][ $prioType ]["total"]; 
												$countRes++;
												$countTotal += (float)$adminAnswers["answers"][$prioKey][ $key ][ $prioType ]["total"];
											} ?>
										</td>
										<?php } ?>
										<td  class="text-red <?php echo $key?>_totalTotal">
											<?php if($countRes == count($prioTypes) )
												echo floor( ( $countTotal / count($prioTypes) )*100 )/100; ?>
										</td>
										<td></td>
									</tr>
								</table>
							</div>
							
							
							<?php 
							//------------------------------------
							// POUR CHAQUE TAB (categorie) il ya autant de critère 
							// et de formulaire de priorisation 
							//------------------------------------
							foreach ($prioTypes as $prioType ) 
							{ 
								$score = "";
								$titleResult = "à noter";
								$btnColor = "btn-danger";
								$hideTable = "";
								if(@$adminAnswers["answers"][$prioKey][$key][ $prioType ]["total"]){
									$score = "[NOTE : ".$adminAnswers["answers"][$prioKey][$key][ $prioType ]["total"]."]";
									$titleResult = "résultat ".$prioType;
									$btnColor = "btn-default" ;
									$hideTable = "display:none;";
								}
							?>

							<div class="padding-10 <?php echo $key?>_DataTables" id="<?php echo $key?>_<?php echo $prioType ?>Table"  style="<?php echo $hideTable ?> border:1px solid #666">

								<?php if( Form::canAdminRoles($form["id"], $vey["name"], $form) )  { ?>
								<a href="javascript:;" data-section="<?php echo $prioKey?>" data-category="<?php echo $key?>" data-step="<?php echo $prioType ?>" data-form="<?php echo substr( $adminForm["parentSurvey"], 0, -5 )?>" class="adminStep btn <?php echo $btnColor; ?>"><?php echo $adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ]["title"] ?></a>
							<?php } ?>
								<h3 class="text-center <?php echo $key?>_<?php echo $prioType ?>ResultHead <?php echo $key?>_prioTitle <?php echo $showHide ?>"><span class="<?php echo $key?>_<?php echo $prioType ?>ResultHeadLabel"><?php echo $titleResult ?></span> <span class="text-red <?php echo $key?>_<?php echo $prioType ?>Total"><?php echo $score ?></span></h3>


								<table border="1" class="text-center  <?php echo $key?>_<?php echo $prioType ?>Result" style="margin:0px auto;">

									<tr class="<?php echo $key?>_<?php echo $prioType ?>ResultTitle">
										<?php 
										if(@$adminAnswers["answers"][$prioKey][ $key ][ $prioType ]){
										foreach (@$adminAnswers["answers"][$prioKey][ $key ][ $prioType ] as $k => $v ) {

											if(!in_array( @$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["inputType"],array("text", "textarea") )  && $k != "total")
												echo '<td class="padding-10">'.@$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["placeholder"]."</td>"; 
											
										}} ?>
									</tr>
								

									<tr class="<?php echo $key?>_<?php echo $prioType ?>ResultWeight">
										<?php 
										if(@$adminAnswers["answers"][$prioKey][ $key ][ $prioType ]){
										foreach (@$adminAnswers["answers"][$prioKey][ $key ][ $prioType ] as $k => $v ) {
											?>
											<?php 
												if (!in_array( @$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["inputType"],array("text", "textarea") )  && $k != "total")
													echo (@$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["weight"]) ? '<td>'.@$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["weight"]."% </td>" : "";
													 ?>
										<?php }} ?>
									</tr>
								

									<tr class="<?php echo $key?>_<?php echo $prioType ?>ResultAnswer">
										<?php 
										if(@$adminAnswers["answers"][$prioKey][ $key ][ $prioType ]){
										foreach (@$adminAnswers["answers"][$prioKey][ $key ][ $prioType ] as $k => $v ) {?>
											<?php 
												if(! in_array( @$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["inputType"],array("text", "textarea") ) && $k != "total" )
													echo '<td>'.$v.'</td>' ?>
										<?php }} ?>
									</tr>

									<tr class="<?php echo $key?>_<?php echo $prioType ?>LabelAnswer">
										<?php 
										if(@$adminAnswers["answers"][$prioKey][ $key ][ $prioType ]){
										foreach (@$adminAnswers["answers"][$prioKey][ $key ][ $prioType ] as $k => $v ) {?>
											<?php 
												if(! in_array( @$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["inputType"],array("text", "textarea") ) && $k != "total")
													echo '<td class="padding-10">'.$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["options"][$v].'</td>' ?>
										<?php }} ?>
									</tr>
								

								</table>
								<div class="col-xs-12 <?php echo $key?>_<?php echo $prioType ?>Comment"><?php echo (@$adminAnswers["answers"][$prioKey][ $key ][ $prioType ]["prioDesc"]) ? "Commentaire : <br/>".@$adminAnswers["answers"][$prioKey][ $key ][ $prioType ]["prioDesc"]:""; ?></div>
								<div style="clear:both"></div>
							</div>
							<hr>
							<?php } ?>
							

							
						</div>

					</div>
			<?php } ?>
		</div>
	<?php }
} ?>

</div>

<?php 
	/* ---------------------------------------------
	SECTION GESTION DES RISQUES
	---------------------------------------------- */
 ?>

<div id='risk' class='section3 hide'>
	
	<?php if( $canAdmin ){ ?>
		<div id="eligibleDesc" class="eliSec col-xs-12 padding-20">
				<h1>Quelles sont risques éventuelles ?</h1>
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				<br>
				<div class="padding-10"  style="border:1px solid red">
					<h3 class="text-center">Matrice de <?php echo mb_strtoupper($prioKey) ?></h3>
					<table border="1" class="text-red text-center bold" style="margin:0px auto;">
						<tr>
							<?php foreach ($adminAnswers["categories"] as $ka => $va ) {
								
								?>
							<th class="padding-10"><a href="javascript:;" onclick="EliTabs('<?php echo $ka ?>')"><?php echo mb_strtoupper($va["name"]) ?></a></th>
							<?php } ?>
							<th class="padding-10">Note globale</th>
							<th class="padding-10">Classification</th>
						</tr>
						<tr>
							<?php foreach ($adminAnswers["categories"] as $ka => $va ) {?>
							<td><a href="javascript:;" onclick="changeCategoryWeight('<?php echo $ka ?>','<?php echo @$va["pourcentage"] ?>')"><?php echo @$va["pourcentage"]."%" ?></a></td>
							<?php } ?>
							<td>100%</td>
							<td>Note</td>
						</tr>
						<tr>
							<?php 
							$tot = 0;
							$ctot = 0;
							if(@$adminAnswers["answers"][$prioKey]){ 
								foreach ( @$adminAnswers["answers"][$prioKey] as $ka => $va ) {?>
									<td class="<?php echo $ka ?>_Total">
									<?php if(@$va['total']){
												echo $va['total'];
												$ctot++;
											} 
												else 
												echo "-"; ?>
									</td>
									<?php 
									$w = 1 + ((int)$adminAnswers["categories"][$ka] / 100);
									$tot += (floor( (float)@$va['total']*100 / $w))/100;
								} 
							}?>
							<td ><?php if($ctot == count($adminAnswers["categories"]) ) echo $tot; ?></td>
							<td></td>
						</tr>
					</table>
				</div>
			</div>

	<?php } ?>
</div>



</div>
</div>
</div>
</div>



<?php 
if(@$form["custom"]['footer']){
	echo $this->renderPartial( $form["custom"]["footer"],array("form"=>$form,"answers"=>$answers));
}
?>

<script type="text/javascript">
var form = <?php echo json_encode($form); ?>;
var adminForm = <?php echo json_encode($adminForm); ?>;
var answers  = <?php echo json_encode($answers); ?>;
var eligible  = <?php echo json_encode($adminAnswers); ?>;
var rolesListCustom = <?php echo json_encode(@$roles); ?>;
var canAdmin = <?php echo $canAdmin; ?>;
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
	    			answers : getAnswers(form.scenario[updateForm.form].form.scenario[updateForm.step].json)
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

	$('.adminStep').click(function() {

		updateForm = {
			form : $(this).data("form")	,
			category : $(this).data("section")+"."+$(this).data("category")	,
			cat : $(this).data("category"),
			step : $(this).data("step")	
		};

		var editForm = adminForm.scenario[$(this).data("step")].json;
		console.log("editForm",editForm);

		editForm.jsonSchema.onLoads = {
			onload : function(){
				dyFInputs.setHeader("bg-dark");
				$('.form-group div').removeClass("text-white");
				dataHelper.activateMarkdown(".form-control.markdown");
			}
		};
		
		editForm.jsonSchema.save = function()
		{
			
			data={
    			formId : updateForm.form,
    			answerSection : "answers."+updateForm.category+"."+updateForm.step ,
    			answerKey : "<?php echo $prioKey ?>" ,
    			answerStep : updateForm.cat ,
    			answers : getAnswers(adminForm.scenario[ updateForm.step ].json),
    			answerUser : eligible.user ,
    		};
    		
    		console.log("save",data);
    		
    		$.ajax({ type: "POST",
		        url: baseUrl+"/survey/co/update",
		        data: data,
				type: "POST",
		    }).done(function (data) { 
		    	if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length == 0 ){
			    	//window.location.reload();
			    	dyFObj.closeForm();
			    	toastr.success('successfully saved !');
			    	if(data.total != null){
			    		$("#"+updateForm.cat+"Btn i").hide();

			    	}
			    	updateForm = null;
			    } 
		    });
		};

		dyFObj.editStep( editForm );	

	})
	
	bindAnwserList();

	initWizard();
});

function initWizard () { 
	$("#wizard").smartWizard({
	    selected: 0,
	    keyNavigation: true,
	    //enableAllSteps : true,
	    //onLeaveStep: function(){ console.log("leaveAStepCallback");},
	    onShowStep: function(obj, context)
	    {
	    	console.log("test onShowStep",dySObj.navBtnAction,context.toStep,context.fromStep,Math.abs( context.toStep - context.fromStep));
	    	if( !dySObj.navBtnAction ){
	        	$(".section0"+dySObj.activeSection).addClass("hide");
	        	dySObj.activeSection =  context.toStep -1 ;
				console.log("top wisard direct link",dySObj.activeSection);
				$(".section"+dySObj.activeSection).removeClass("hide");	

			}
			dySObj.animateBar(context.toStep);
	    },
	});

	if(canAdmin){
		var ix = 0;
		$.each(adminForm.scenarioAdmin, function(k,v) { 
			ix++;
			if( eligible.step && k == eligible.step ){
				$("#wizard").smartWizard("goToStep",ix);
				return false;
			}else{
				$("#wizard").smartWizard("enableStep",ix);
			}
		});
	}
//dySObj.animateBar();
}

function getAnswers(dynJson)
{
	//alert("get Answers");
	var editAnswers = {};
	var total = 0;
	if( $("."+updateForm.cat+"_"+updateForm.step+"Result") )
	{
		$("."+updateForm.cat+"_"+updateForm.step+"ResultHeadLabel").html('Résultats '+updateForm.step);	
		$("."+updateForm.cat+"_"+updateForm.step+"ResultTitle").html("");
		$("."+updateForm.cat+"_"+updateForm.step+"ResultWeight").html("");
		$("."+updateForm.cat+"_"+updateForm.step+"ResultAnswer").html('');
	}
	$.each( dynJson.jsonSchema.properties , function(field,fieldObj) { 
        console.log($(this).data("step")+"."+field, $("#"+field).val() );
        if( fieldObj.inputType ){
            if(fieldObj.inputType=="uploader"){
         		if( $('#'+fieldObj.domElement).fineUploader('getUploads').length > 0 ){
					$('#'+fieldObj.domElement).fineUploader('uploadStoredFiles');
					editAnswers[field] = "";
            	}
            }else{
            	editAnswers[field] = $("#"+field).val();
            	if( $("."+updateForm.cat+"_"+updateForm.step+"Result"))
            	{
            		if(!isNaN( parseInt($("#"+field).val()) ) ){
	            		$("."+updateForm.cat+"_"+updateForm.step+"ResultTitle").append( "<td class='padding-10'>"+field+"</td>" );
	            		$("."+updateForm.cat+"_"+updateForm.step+"ResultWeight").append( "<td>"+((fieldObj.weight) ? fieldObj.weight+"%" : "")+"</td>" );
	            		$("."+updateForm.cat+"_"+updateForm.step+"ResultAnswer").append( "<td>"+$("#"+field).val()+"</td>" );
	            		  	if(fieldObj.weight){
			  	          		var w = 1 + (parseInt(fieldObj.weight) / 100);
			  	          		console.log("w",w,"cal", parseFloat( parseInt( $("#"+field).val() ) / w ).toFixed(2) );
			  	          		total += parseFloat( parseFloat( parseInt( $( "#"+field ).val() ) / w ).toFixed(2) );
			  	          	}
			  	          	else 
			  	          		total += parseInt($("#"+field).val());
		  	        } else {
		  	        	//the field is a comment or a string 
						$("."+updateForm.cat+"_"+updateForm.step+"Comment").html("").append( "<h3>"+field+"</h3>"+dataHelper.markdownToHtml( $("#"+field ).val() ) );
		  	        }
	            }
            }
        }
    });
    
    $("."+updateForm.cat+"_"+updateForm.step+"Total").html( "[ Note : "+( parseFloat(total).toFixed(2) )+" ]" );
    $("."+updateForm.cat+"_"+updateForm.step+"TotalNum").html( parseFloat(total).toFixed(2) );
    $("."+updateForm.cat+"_"+updateForm.step+"ResultTitle").append( "<td class='bold'>Note</td>" );
	$("."+updateForm.cat+"_"+updateForm.step+"ResultWeight").append( "<td>100%</td>" );	
	$("."+updateForm.cat+"_"+updateForm.step+"ResultAnswer").append( "<td>"+( parseFloat(total).toFixed(2) )+"</td>" );

    editAnswers.total = total;

    
    $("."+updateForm.cat+"_Priorisation").removeClass('hide');	
    
    calcPrio( updateForm.cat );
	
	console.log("editAnswers",editAnswers);
    return editAnswers;
}

function calcPrio (key) 
{
	var t = 0;
	$("."+key+"_Total").each( function(i,v){ 
		console.log(i,v);
		t += parseFloat( $(v).html() );
	} );
	t = parseFloat( t / $("."+key+"_Total").length ).toFixed(2) ;
	//alert(t);
	$( "."+key+"_totalTotal" ).html( t );
	return false;
}

function showTableOrForm(key,type){
	$("."+key+"_DataTables").hide();
	$("#"+key+"_"+type+"Table").show();
}

function nextState(step,c) { 
	if( canAdmin && c =="disabled"){
		bootbox.dialog({
	      message: "Ce dossier passera à l'étape : "+step ,
	      title: "Cette action est irréversible, est vous sûr ?",
	      buttons: {
	        annuler: {
	          label: "Annuler",
	          className: "btn-default",
	          callback: function() {
	            console.log("Annuler");
	          }
	        },
	        danger: {
	          label: "Confirmer",
	          className: "btn-primary",
	          callback: function() {
	          	data={
	    			formId : form.id,
	    			answerSection : "step" ,
	    			answers : step.substring(1)
	    		};
	          	$.ajax({ 
	          		type: "POST",
			        url: baseUrl+"/survey/co/update",
			        data: data
			    }).done(function (data) { 
			    	window.location.reload();
			    });
	          }
	        },
	      }
	    });
	}
	return false;
 }

 function changeCategoryWeight(key,v) { 
 	if( canAdmin ){
 		bootbox.prompt(	{
	        title: "Dans ce projet que représente la catégorie "+key+" ?", 
	        value : v, 
	        callback : function(result){ 
	        	$.ajax({ 
	        		type: "POST",
			        url: baseUrl+"/survey/co/update",
			        data: {
		    			formId        : form.id,
		    			answerSection : "categories."+key ,
		    			answers       : result
		    		}
			    }).done( function (data) { 
			    	console.log("data",data);
			    	alert();
			    	//window.location.reload();
			    });
	        }
	    });
	}
}

</script>

<?php 

/*

bug 
- page title + descriptif issue de la page TCO
- extraire les templates des etapes 
- ajouter HomePage 
	Territoire Tropical Bioclimatique
		Eco-Construction tropicale 
		Ville jardin désirable et support de biodiversité 
	Territoire smart et décarbonné* 
		Production renouvelable 
		Maîtrise de l’énergie 
		Eco-mobilités 
	Territoire collaboratif écologique et solidaire* 
		Economie Sociale et solidaire 
		Economie circulaire et circuits courts
- PROJET SOUTENU par 
	- citoyen 
	- organisateur 
	- financeur 
	- donne un contexte au projet localement 
- changer de role 
- btn mes parametres
- Gestion du risque 
	- selection d'un risque dans un catalogue 
	- ajouter un risque au catalogue
	- risk management 
- Calendrier cte2.2
- Syhthese par thematique avec la listes de plusieurs projets
- ajouter point et info de contacts
- ajouter les etapes remplis dans answerLists

- edit formualire 
- demande de complément d'info
- drive du dossier 
- chat du dossier 
- geoloc du projet et de la liste des projets


inscrit > paiement > Custom 
mutualisation d'un community manager


devis le port Site Web 
reproduire et améliorer 
	qui parle du port : mention pour tout 
	flux rss du quotidien le port dans le live 

nouveau projet
	liste d'action opérationnel AO
	devisable > validation et accepttion par les différents acteurs
	chaque AO et divisé en liste d'actions fonctionnelles AF
	3 niveau de recette 
		travailleur : j'ai terminé une AO 
		client : 
			je valide l'AO 
			je n evalide pas encore l'AO 
				commentaire et liste AF
					recevable ou non 

communauté 
	supprimer une invitation 


gestion des sessions
	nouvelle session 
	changer les dte start end 



Key Partnerships
Key Activities
Key Resources
Value Propositions
Customer Relationships
Channels
Customer Segments
Cost Structure
Revenue Streams



*/

 ?>

 





