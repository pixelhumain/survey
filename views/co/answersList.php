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
</div>
<div class="panel panel-white col-lg-12 col-xs-12 no-padding">
	<div class="panel-body">
		<div>
			<!-- <a href="<?php //echo '#element.invite.type.'.Form::COLLECTION.'.id.'.(string)$form['_id'] ; ?>" class="btn btn-primary btn-xs pull-right margin-10 lbhp">Invite Admins & Participants</a> -->
			

			<span><b>Il y a <span id="nbLine"><?php echo count(@$results); ?></span> réponses</b></span> 
			<span> <a href="javascript:;" id="csv"><i class='fa fa-2x fa-table text-green'></i></a></span>
			<br/><br/>

			<table class="table table-striped table-bordered table-hover directoryTable" id="panelAdmin" style="table-layout: fixed; width:100%; word-wrap:break-word;">
				<thead>
					<tr>
						<th class="">#</th>
						<th class="col-xs-1">Projet</th>
						<th class="col-xs-1">Description</th>
						<th class="col-xs-1">Organisation</th>
						<th class="">Référent</th>
						<th class="">Etape</th>
						<th class="">Lire</th>
						<th class="">Eligibilité</th>
						<th class="col-xs-1">Étiquetage</th>
						<th class="">Contraintes</th>
						<th class="">Fiche Action</th>
						<th >PDF</th>
						<th >Budget</th>
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
							if(isset($v["eligible"])){ 
								if($v["eligible"]) {
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
						<tr class="<?php echo $classEligible." "; if(@$v["categories"])foreach (@$v["categories"] as $key => $value) {
									echo $key." ";
								}
								 ?> line">
							<td><a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ; ?>/survey/co/logs/id/<?php echo $form['id'] ?>/user/<?php echo @$k  ?>" ><?php echo @$nb ?></a></td>
							<td  id='<?php echo $k."project";?>'><?php echo @$v[Project::CONTROLLER]["name"] ?></td>
							<td  id='<?php echo $k."desc";?>'><?php echo @$v[Project::CONTROLLER]["shortDescription"] ?></td>
							<td  id='<?php echo $k."orga";?>'><?php echo @$v[Organization::CONTROLLER]["name"] ?></td>
							<td  id='<?php echo $k."user";?>'><?php echo @$v['name'] ?></td>
							<td >
								<?php
									$c = 0 ;
									foreach ($v['answers'] as $key => $value) {
										if($value == true)
											$c++;
									}
									$classText = ($c == count(@$v['answers'])) ? 'text-success' : 'text-red';
									echo "<span id='".$k."etape' class='".$classText."'>".$c." / ".count(@$form['scenario'])."</span>"; 
								?>
							</td>
							<td ><a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ; ?>/survey/co/answer/id/<?php echo $v['_id'] ?>" target="_blanck" class="btn btn-primary">Lire</a></td>
							<td id='<?php echo $k."eligible";?>' class="<?php echo $colorEligible ?>"><?php echo $lblEligible ?></td>
							<td id='<?php echo $k."etiquetage";?>'>
								<?php 
								if(@$v["categories"]){
									foreach ($v["categories"] as $kC => $vC) {
										echo $vC["name"]."<br/>";
									}
								} 
								?>
							</td>
							<td>
							<?php
								if(!empty($v["risks"])){
									$list= "";
									$globrcol = "success";
									foreach ($v["risks"] as $kr => $vr) {
										$rcol = Form::$riskWeight[$vr["probability"].$vr["gravity"]]["c"];

										if( $globrcol == "success" && $rcol == "orange" )
											$globrcol = "warning";
										else if ( ($globrcol == "success" && $rcol == "red") || 
												  ($globrcol == "orange" && $rcol == "red") )
											$globrcol = "danger";
										
										$list .= "<li class='padding-5' style='background-color:".$rcol."'>".$vr["desc"]."(".$vr["weight"].")</li>";
									}
									
									echo "<a id='".$k."risk' class='btn btn-xs btn-".$globrcol."' href='javascript:;' onclick='$(\"#riskList".$k."\").toggle();'>".count(@$v["risks"])." risque(s)</a>";
									echo "<ul id='riskList".$k."' style='list-style:none; width:100%;display:none;'>";
										echo $list; 
									echo "</ul>";
								} 
							?>
								
							</td>
							<td id='<?php echo $k."action";?>'><?php echo (@$v["step"] == "ficheAction") ? "Selectionné" : ""; ?></td>
							<td><?php echo "<a class='btn btn-xs' href='".Yii::app()->getRequest()->getBaseUrl(true)."/survey/co/pdf/id/".@$k."' target='_blanck'><i class='fa fa-2x fa-file-pdf-o text-red' ></i></a>"; ?></td>

							<td>
								<?php
								//var_dump($userAdminAnswer[$k]["scenario"]["cte3"]);
								if(!empty($v["answers"]["cte3"]["answers"]["previsionnel"]["previsionel"]["id"])){
									$a = $v["answers"]["cte3"]["answers"]["previsionnel"]["previsionel"];
									//var_dump($a );
									$document=Document::getById($a["id"]);
									if(!empty($document)){ 
										$path=Yii::app()->getRequest()->getBaseUrl(true)."/upload/communecter/".$document["folder"]."/".$document["name"];
										echo "<a href='".$path."' target='_blank'><i class='fa fa-2x fa-file-pdf-o text-red'></i></a>";
									}
								} ?>
							</td>
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

var results  = <?php echo json_encode($results); ?>;
var formId = "<?php echo $form['id']; ?>";
var sessionId = "<?php echo $_GET['session'] ?>";

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

	$("#csv").off().on('click',function(){
    	var chaine = "";
    	var csv = '"Num";"Projet";"Desc";"Organisation";"Référent";"Etape";"Lire";"Eligibilité";"Etiquetage";"Contraintes";"Fiche Action"' ;
    	var i = 1 ;
    	if(typeof results != "undefined"){
        	$.each(results, function(key, value2){
        		console.log(value2)
        		csv += "\n";
        		csv += '"'+i+'";';
        		csv += '"'+$("#"+key+"project").html()+'";';
        		csv += '"'+$("#"+key+"desc").html()+'";';
        		csv += '"'+$("#"+key+"orga").html()+'";';
        		csv += '"'+$("#"+key+"user").html()+'";';
        		csv += '"'+$("#"+key+"etape").html()+'";';
        		csv += '"'+ baseUrl + "/survey/co/answer/id/"+key+'";'; 
        		csv += '"'+$("#"+key+"eligible").html()+'";';
        		csv += '"'
        		if(notNull(value2.categories)){
        			var j = 1;
					$.each(value2.categories, function(keyC, valC){
						if(j != 1)
							csv += ", ";
						csv += valC.name;
						j++;
					});
				}
				csv += '";';
        		//csv += '"'+$("#"+key+"etiquetage").html()+'";';
        		csv += '"'+(notNull($("#"+key+"risk").html()) ? $("#"+key+"risk").html(): "")+'";';
        		csv += '"'+$("#"+key+"action").html()+'";';
        		// csv += '"'+(notNull(value2.name) ? value2.name: "")+'";';
        		
        		i++;
        		
			});
  		}
  		
    	$("<a />", {
		    "download": "cte.csv",
		    "href" : "data:application/csv," + encodeURIComponent(csv)
		  }).appendTo("body")
		  .click(function() {
		     $(this).remove()
		  })[0].click() ;
			$("#bodyResult").html(chaine);
    	$.unblockUI();
	});

});

function countLine(){
	var nbLine = $("#panelAdmin tr.line").filter(function() {
			    return $(this).css('display') !== 'none';
			}).length ;
	$("#nbLine").html(nbLine);
}



</script> 

