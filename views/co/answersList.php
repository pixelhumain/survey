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
	.clickOpen{
		cursor: pointer;
	}
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
						<th class="col-xs-1">Porteur</th>
						<th class="">Personne référente</th>
						<th class="">Avancement dossier</th>
						<th class="">Commentaire</th>
						<th class="col-xs-1">Étiquetage</th>
						<th>Avis COPIL</th>
						<th >PDF</th>
						<th >Budget</th>
					</tr>
				</thead>
				<tbody class="directoryLines">
					<?php
						$nb = 0;
						foreach ($results as $k => $v) {
							$nb++;

							$lblEligible = "";
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
						<tr data-id="<?php echo $v['_id'] ?>" class="<?php echo $classEligible." "; if(@$v["categories"])foreach (@$v["categories"] as $key => $value) {
									echo $key." ";
								}
								 ?> line">
							<td class="clickOpen"><a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ; ?>/survey/co/logs/id/<?php echo $form['id'] ?>/user/<?php echo @$k  ?>" ><?php echo @$nb ?></a></td>
							<td class=" clickOpen"  id='<?php echo $k."project";?>'><?php echo @$v[Project::CONTROLLER]["name"] ?></td>
							<td class=" clickOpen"  id='<?php echo $k."desc";?>'><?php echo @$v[Project::CONTROLLER]["shortDescription"] ?></td>
							<td class=" clickOpen"  id='<?php echo $k."orga";?>'><?php echo @$v[Organization::CONTROLLER]["name"] ?></td>
							<td class=" clickOpen"  id='<?php echo $k."user";?>'><?php echo @$v['name'] ?></td>
							<td class=" clickOpen" >
								<?php
									$c = 0 ;
									if(@$v['answers']){
										foreach ($v['answers'] as $key => $value) {
											if($value == true)
												$c++;
										}
									}
									$classText = ($c == count(@$v['answers'])) ? 'text-success' : 'text-red';
									echo "<span id='".$k."etape' class='".$classText."'>".$c." / ".count(@$form['scenario'])."</span>"; 
								?>
							</td>
							<td ><a href="javascript:;" class="btn btn-primary"><i class='fa fa-comments'></i></a></td>
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
								// if(!empty($v["risks"])){
								// 	$list= "";
								// 	$globrcol = "success";
								// 	foreach ($v["risks"] as $kr => $vr) {
								// 		$rcol = Form::$riskWeight[$vr["probability"].$vr["gravity"]]["c"];

								// 		if( $globrcol == "success" && $rcol == "orange" )
								// 			$globrcol = "warning";
								// 		else if ( ($globrcol == "success" && $rcol == "red") || 
								// 				  ($globrcol == "orange" && $rcol == "red") )
								// 			$globrcol = "danger";
										
								// 		$list .= "<li class='padding-5' style='background-color:".$rcol."'>".$vr["desc"]."(".$vr["weight"].")</li>";
								// 	}
									
								// 	echo "<a id='".$k."risk' class='btn btn-xs btn-".$globrcol."' href='javascript:;' onclick='$(\"#riskList".$k."\").toggle();'>".count(@$v["risks"])." risque(s)</a>";
								// 	echo "<ul id='riskList".$k."' style='list-style:none; width:100%;display:none;'>";
								// 		echo $list; 
								// 	echo "</ul>";
								// } 
							$col = "green";
							$count = 4;
							$icon = "star-o"
							?>

							<a href="javascript:;" class="prioritize btn btn-default"> 
							<?php 
							for ($i=0; $i < $count+1; $i++) { ?>
							<i class="fa fa-<?php echo $icon ?>"  style="color:<?php echo $col ?>"></i>
							<?php } ?>
							</a>
								
							</td>
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

<div class="form-prioritize" style="display:none;">
  <form class="inputProritary" role="form">

	<a href="javascript:;" data-value="selected" class="prioritize  btn btn-success">SELECTIONNÉ</a><br/><br/>
	
	<a href="javascript:;" data-value="prioritary" class="prioritize btn" style="background-color: #d8e54b">PRIORITAIRE</a> mais à compléter, Manque d'informations, BP incomplet<br/><br/>
	
	<a href="javascript:;" data-value="reserve" class="prioritize btn btn-warning">RESERVE FORTE </a>   Risques potentiels, dossier très incomplet<br/><br/>

	<a href="javascript:;" data-value="abandon"  class="prioritize btn btn-danger">ABANDONNÉ</a> Risques avérés, bloquage reglementaire, incompatible CTE...<br/><br/>
	<br/><br/>
	
  </form>
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
	$(".clickOpen").off().on('click',function(){
		window.location.href = "<?php echo Yii::app()->getRequest()->getBaseUrl(true)."/survey/co/answer/id/" ; ?>"+$(this).parent().data('id') ;
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

	$('.prioritize').click(function() { 

			var modal = bootbox.dialog({
		        message: $(".form-prioritize").html(),
		        title: "Qualifiez ce dossier",
		        buttons: [
		          {
		            label: "Enregistrer",
		            className: "btn btn-primary pull-left",
		            callback: function() {
		            	if ($('.inputprobGrav #probability').last().val() && $('.inputprobGrav #gravity').last().val()) 
		            	{
				            riskObj.selectedRisks[ riskId ].probability = $('.inputprobGrav #probability').last().val();
				            riskObj.selectedRisks[ riskId ].gravity = $('.inputprobGrav #gravity').last().val();
				            riskObj.selectedRisks[ riskId ].weight = riskObj.riskWeight[$('.inputprobGrav #probability').last().val()+""+$('.inputprobGrav #gravity').last().val()].w;
				            //riskObj.selectedRisks[ riskId ].comment = $('.inputprobGrav #comment').last().val();
				            modal.modal("hide");
				            console.log("riskObj.selectedRisks",riskObj.selectedRisks);
							$("#noriskTtile").hide();
							$("#riskList").show();
							var line = "<tr id='srisk"+riskId+"'>"+
							"<td>"+userConnected.name+"</td>"+
							"<td>"+riskObj.selectedRisks[ riskId ].type+"</td>"+
							"<td>"+riskObj.selectedRisks[ riskId ].desc+"</td>"+
							"<td>"+riskObj.selectedRisks[ riskId ].actions.join("<br/>")+"</td>"+
							//"<td>"+riskObj.selectedRisks[ riskId ].comment+"</td>"+
							"<td><a class='btn btn-danger userActionBtn' data-riskid='"+riskId+"' data-answerid='"+adminAnswers._id.$id+"' href='javascript:;'><i class='fa fa-comment'></i> "+trad.answer+"</a></td>"+
							"<td>"+riskObj.selectedRisks[ riskId ].probability+"</td>"+
							"<td>"+riskObj.selectedRisks[ riskId ].gravity+"</td>"+
							"<td style='color:black;background-color:"+riskObj.riskWeight[riskObj.selectedRisks[ riskId ].probability+""+riskObj.selectedRisks[ riskId ].gravity].c+"'>"+riskObj.selectedRisks[ riskId ].weight+"</td></tr>";
							$("#riskList").append( line );
							delete riskObj.selectedRisks[ riskId ]["_id"];
							riskObj.selectedRisks[ riskId ].addUserId = userId;
							riskObj.selectedRisks[ riskId ].addUserName = userConnected.name;
							

							data={
				    			formId : form.id,
				    			answerId : adminAnswers["_id"]["$id"],
				    			session : formSession,
				    			answerSection : "risks."+riskId ,
				    			answers : riskObj.selectedRisks[ riskId ],
				    			answerUser : adminAnswers.user ,
				    			date : true
				    		};
				    		console.log("saving",data);
				          	$.ajax({ 
				          		type: "POST",
						        url: baseUrl+"/survey/co/update",
						        data: data
						    }).done(function (data) { 
						    	toastr.success('Risque ajouté avec succès');
						    	$(".add"+riskId).html("");
						    	$('.userActionBtn').off().click(function() {
									commentRisk($(this).data("answerid"), $(this).data("riskid"));
								});
						    });

						} else {
							bootbox.alert({ message: "Vous devez renseigner les poids du risque." });
						}
		              return false;
		            }
		          },
		          {
		            label: "Annuler",
		            className: "btn btn-default pull-left",
		            callback: function() {
		              console.log("just do something on close");
		            }
		          }
		        ],
		        show: false,
		        onEscape: function() {
		          modal.modal("hide");
		        }
		    });
		    modal.modal("show");
		
	})

});

function countLine(){
	var nbLine = $("#panelAdmin tr.line").filter(function() {
			    return $(this).css('display') !== 'none';
			}).length ;
	$("#nbLine").html(nbLine);
}




</script> 

