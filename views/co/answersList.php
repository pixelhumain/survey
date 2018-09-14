<?php
$cssAnsScriptFilesModule = array(
    '/plugins/jquery-simplePagination/jquery.simplePagination.js',
	'/plugins/jquery-simplePagination/simplePagination.css',
	'/plugins/select2/select2.min.js' ,
	'/plugins/select2/select2.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getRequest()->getBaseUrl(true));

$cssAnsScriptFilesModule = array( 
	'/js/eligible.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getModule( "survey" )->getAssetsUrl() );


$cssJS = array(
    '/js/dataHelpers.js'
);
HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->getModule( Yii::app()->params["module"]["parent"] )->getAssetsUrl() );

?>

<style type="text/css">
	.round{
		border-radius: 100%;
		width: 250px;
		height: 250px;
		padding-top: 70px;
		border-color: #333;
 	}
</style>
<div class="panel panel-white col-lg-offset-1 col-lg-10 col-xs-12 no-padding">
	
	<div class="col-md-12 col-sm-12 col-xs-12 ">
		<h1 class="text-center">Liste des projets <!-- <a href="<?php //echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/index/id/<?php // echo $form["id"] ?>"><i class="fa fa-arrow-circle-right"></i></a>  --></h1>
		<br/>
		<h5 class="">
			Filtres : 
			<a href="javascript:;" onclick="showType('line')" class="btn btn-xs btn-default">Tous</a>
			<a href="javascript:;" onclick="showType('eligible')" class="btn btn-xs btn-default">Éligible</a> 
			<a href="javascript:;" onclick="showType('noteligible')" class="btn btn-xs btn-default">Non éligible</a> 
			<a href="javascript:;" onclick="showType('todoeligible')" class="btn btn-xs btn-default">Étudier l'éligibilité</a>
		</h5>
		<h5 class="">	
			Thématiques : 
			<?php 
			$lblRole = array();
			foreach ($form["custom"]["roles"] as $key) {
				$lblRole[InflectorHelper::slugify($key)] = $key;
				?>
				<a href="javascript:;" onclick="showType('<?php echo InflectorHelper::slugify($key)?>')" class="btn btn-xs btn-default"><?php echo $key; ?></a>
			<?php } ?>
		</h5>	

		<div style="width:80%;  display: -webkit-inline-box;">
	    	<input type="text" class="form-control" id="search" placeholder="Rechercher une information dans le tableau">
	    </div>
    </div>
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20 text-center"></div>
	<div class="panel-body">
		<div>
			<!-- <a href="<?php //echo '#element.invite.type.'.Form::COLLECTION.'.id.'.(string)$form['_id'] ; ?>" class="btn btn-primary btn-xs pull-right margin-10 lbhp">Invite Admins & Participants</a> -->
			<span><b>Il y a <span id="nbLine"><?php echo count(@$results); ?></span> réponses</b></span> 
			<a href="<?php echo Yii::app()->createUrl('survey/co/roles/id/'.$_GET["id"].'/session/1'); ?>" class="pull-right btn btn-xs btn-primary margin-10">Fiche Action</a>
			<br/>

			<table class="table table-striped table-bordered table-hover directoryTable" id="panelAdmin">
				<thead>
					<tr>
						<th>#</th>
						<th>Nom du projet</th>
						<th>Organisation</th>
						<th>Référent</th>
						<th>Etape</th>
						<th>Voir la réponse</th>
						<th>Eligibilité</th>
						<th>Thématiques</th>
						<th>Contraintes</th>
						<th>Fiche Action</th>
						<th>PDF</th>
					</tr>
				</thead>
				<tbody class="directoryLines">
					<?php
						$nb = 0;
						foreach ($results as $k => $v) {
							$nb++;

							$lblEligible = "À faire";
							$classEligible = "todoeligible";
							$colorEligible = "black";
							if(isset($userAdminAnswer[$k]["eligible"])){ 
								if($userAdminAnswer[$k]["eligible"]) {
									$lblEligible = "Éligible";
									$classEligible = "eligible";
									$colorEligible = "text-green";
								}
								else  {
									$lblEligible = "Non Éligible"; 
									$classEligible = "noteligible";
									$colorEligible = "text-red";
								}
							} 
								 ?>
						<tr class="<?php echo $classEligible." "; if(@$userAdminAnswer[$k]["categories"])foreach (@$userAdminAnswer[$k]["categories"] as $key => $value) {
									echo $key." ";
								}
								 ?> line">
							<td><a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ; ?>/survey/co/logs/id/<?php echo $form['id'] ?>/user/<?php echo @$k  ?>" ><?php echo @$nb ?></a></td>
							<td><?php echo @$v['name'] ?></td>
							<td><?php echo @$v['parentName'] ?></td>
							<td><?php echo @$v['userName'] ?></td>
							<td>
								<?php
								$c = 0 ;
								foreach ($v['scenario'] as $key => $value) {
									if($value == true)
										$c++;
								}
								$classText = ($c == count(@$v['scenario'])) ? 'text-success' : 'text-red';
								echo "<span class='".$classText."'>".$c." / ".count(@$v['scenario'])."</span>"; ?>
							</td>
							<td><a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ; ?>/survey/co/answer/id/<?php echo $form['id'] ?>/session/<?php echo $_GET['session'] ?>/user/<?php echo @$k  ?>" target="_blanck" class="btn btn-primary">Lire</a></td>
							<td class="<?php echo $colorEligible ?>"><?php echo $lblEligible ?></td>
							<td><?php if(@$userAdminAnswer[$k]["categories"]){
								foreach ($userAdminAnswer[$k]["categories"] as $key => $value) {
									echo $value["name"]."<br/>";
								}
								} ?></td>
							<td><?php 
								
								if(@$userAdminAnswer[$k]["risks"]){
									$list= "";
									$globrcol = "success";
									foreach ($userAdminAnswer[$k]["risks"] as $kr => $vr) {

										$rcol = Form::$riskWeight[$vr["probability"].$vr["gravity"]]["c"];

										if( $globrcol == "success" && $rcol == "orange" )
											$globrcol = "warning";
										else if ( ($globrcol == "success" && $rcol == "red") || 
												  ($globrcol == "orange" && $rcol == "red") )
											$globrcol = "danger";
										
										$list .= "<li class='padding-5' style='background-color:".$rcol."'>".$vr["desc"]."(".$vr["weight"].")</li>";
									}
									
									echo "<a class='btn btn-xs btn-".$globrcol."' href='javascript:;' onclick='$(\"#riskList".$k."\").toggle();'>".count(@$userAdminAnswer[$k]["risks"])." risque(s)</a>";
									echo "<ul id='riskList".$k."' style='list-style:none; width:100%;display:none;'>";
										echo $list; 
									echo "</ul>";
								} ?></td>
							<td><?php echo (@$userAdminAnswer[$k]["step"] == "ficheAction") ? "Selectionné" : ""; ?></td>

							<td><?php echo "<a class='btn btn-xs' href='".Yii::app()->getRequest()->getBaseUrl(true)."/survey/co/pdf/id/".$form['id']."/session/".$_GET['session']."/user/".@$k."' target='_blanck'><i class='fa fa-2x fa-file' ></i></a>"; ?></td>
						</tr>
						<?php
					} ?>
				</tbody>
			</table>
			
		</div>
	</div>
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20"></div>
</div>

<script type="text/javascript">

function showType (type) { 
	$(".line").hide();
	$("."+type).show();
}

jQuery(document).ready(function() {
	
	$("#search").on("keyup", function() {
	    var value = $(this).val().toLowerCase();
	    $("#panelAdmin tr.line").filter( function() {
	    	$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
	    	countLine();
	    });
	});

});

function countLine(){
	var nbLine = $("#panelAdmin tr.line").filter(function() {
			    return $(this).css('display') !== 'none';
			}).length ;
	$("#nbLine").html(nbLine);
}



</script> 

