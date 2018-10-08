
<?php

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';

if(@Yii::app()->session["userId"])
    $this->renderPartial($layoutPath.'.rocketchat'); 


$cssAnsScriptFilesModule = array(
    '/plugins/jquery-simplePagination/jquery.simplePagination.js',
	'/plugins/jquery-simplePagination/simplePagination.css',
	'/plugins/select2/select2.min.js' ,
	'/plugins/select2/select2.css',
	'/plugins/underscore-master/underscore.js',
	'/plugins/jquery-mentions-input-master/jquery.mentionsInput.js',
	'/plugins/jquery-mentions-input-master/jquery.mentionsInput.css',
	'/plugins/jquery.dynForm.js',
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

$cssAnsScriptFilesModule = array(
	'/assets/js/comments.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->theme->baseUrl);

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
			
			<?php 

			$states = array(
					"selected"   => array("color"=>"green","icon"=>"fa-thumbs-up","lbl"=>"SELECTIONNÉ"),
					"prioritary" => array("color"=>"#d8e54b","icon"=>" fa-hand-pointer-o","lbl"=>"PRIORITAIRE"),
					"reserved"   => array("color"=>"orange","icon"=>"fa-question-circle","lbl"=>"RESERVE FORTE"),
					"abandoned"  => array("color"=>"red","icon"=>"fa-times","lbl"=>"ABANDONNÉ")
				); 
			foreach ($states as $s => $sv) { ?>
				<a href="javascript:;" onclick="showType('<?php echo $s ?>')" class="btn btn-xs btn-default"><?php echo $sv["lbl"] ?></a>
			<?php } ?>
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
						<th class="col-xs-1">Tags</th>
						<th>Status</th>
						<th >PDF</th>
						<th >Budget</th>
						<th >Financement</th>
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
						<tr data-id="<?php echo $v['_id'] ?>" class="<?php echo $classEligible." ".@$v["priorisation"]." "; if(@$v["categories"])foreach (@$v["categories"] as $key => $value) {
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
							<td >
								<a href="javascript:;" class="btn btn-primary openAnswersComment" onclick="commentAnswer('<?php echo $v['_id'] ?>')">
									<?php echo PHDB::count(Comment::COLLECTION, array("contextId"=>(string)$v['_id'],"contextType"=>Form::ANSWER_COLLECTION)); ?> <i class='fa fa-commenting'></i>
								</a>
								<a href="javascript:;" class="btn btn-default btn-open-chat" data-name-el="<?php echo @$v[Project::CONTROLLER]["name"] ?>" data-username="<?php echo Yii::app()->session["user"]["username"] ?>" data-slug="<?php echo @$v[Project::CONTROLLER]["name"] ?>" data-type-el="projects"  data-open="<?php echo (@$v[Project::CONTROLLER]["value"]["preferences"]["isOpenEdition"]) ? "true" : "false" ?>"  data-hasRC="<?php echo (@$v[Project::CONTROLLER]["hasRC"]) ? "true" : "false" ?>" data-id="<?php echo (string)@$v[Project::CONTROLLER]["_id"] ?>"> <i class='fa fa-comments-o'></i>
								</a>
							</td>
							<td id='<?php echo $k."etiquetage";?>'>
								<?php 
								if(@$v["categories"]){
									foreach ($v["categories"] as $kC => $vC) {
										echo $vC["name"]."<br/>";
									}
								} 
								?>
							</td>
							<td id='<?php echo $k."tags";?>'>
								<?php 
								if(@$v["tags"]){
									foreach ($v["tags"] as $kC => $vC) {
										echo $vC."<br/>";
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
							$col = "white";
							$icon = "fa-star";
							
							if( @$v["priorisation"] ){
								if(@$states[$v["priorisation"]]){
									$col = $states[$v["priorisation"]]["color"];
									$icon = $states[$v["priorisation"]]["icon"];
								}
							}


							if(Form::canAdminRoles((String) $form["_id"], "TCO", $form )){?>

								<a href="javascript:;" data-id="<?php echo $v['_id'] ?>" id="prio<?php echo $v['_id'] ?>" class="prioritize  btn btn-default" style="background-color:<?php echo $col ?>"> 
									<i class="fa fa-2x <?php echo $icon ?>"></i>
								
								</a>
							<?php
							}else{
								echo '<span class="btn btn-default" style="background-color:'.$col.'" ><i class="fa fa-2x '.$icon.' "></i></span>';
							}
							?>
								
							</td>
							<td><?php echo "<a class='btn btn-xs' href='".Yii::app()->getRequest()->getBaseUrl(true)."/survey/co/pdf/id/".@$k."' target='_blanck'><i class='fa fa-2x fa-file-pdf-o text-red' ></i></a>"; ?></td>

							<td>
								<?php
								if(!empty($v["answers"]["cte3"]["answers"]["previsionnel"]["previsionel"]["id"])){
									$a = $v["answers"]["cte3"]["answers"]["previsionnel"]["previsionel"];
									//var_dump($a );
									try {
										$document=Document::getById($a["id"]);
										if(!empty($document)){ 
											$path=Yii::app()->getRequest()->getBaseUrl(true)."/upload/communecter/".$document["folder"]."/".$document["name"];
											echo "<a href='".$path."' target='_blank'><i class='fa fa-2x fa-file-pdf-o text-red'></i></a>";
										}
									} catch (Exception $e) {
										
									}
									
								} 
								?>
							</td>
							<td><a href="/survey/co/answer/id/<?php echo $v['_id'] ?>/step/dossier.cte3.planFinancement" target="_blank" class=" btn btn-primary"><i class="fa fa-money"></i></a></td>
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

	<a href="javascript:;" data-value="selected" class=" prioBtn btn btn-success">SELECTIONNÉ</a><br/><br/>
	
	<a href="javascript:;" data-value="prioritary" class="prioBtn btn" style="background-color: #d8e54b">PRIORITAIRE</a> mais à compléter, Manque d'informations, BP incomplet<br/><br/>
	
	<a href="javascript:;" data-value="reserved" class="prioBtn btn btn-warning">RESERVE FORTE </a>   Risques potentiels, dossier très incomplet<br/><br/>

	<a href="javascript:;" data-value="abandoned"  class="prioBtn btn btn-danger">ABANDONNÉ</a> Risques avérés, bloquage reglementaire, incompatible CTE...<br/><br/>
	<br/><br/>
	
  </form>
</div>

<script type="text/javascript">

var results  = <?php echo json_encode($results); ?>;
var formId = "<?php echo $form['id']; ?>";
var sessionId = "<?php echo $_GET['session'] ?>";
var avis = null;
var answerId = null;
var prioModal = null;
var states  = <?php echo json_encode($states); ?>;

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
		window.open("<?php echo Yii::app()->getRequest()->getBaseUrl(true)."/survey/co/answer/id/" ; ?>"+$(this).parent().data('id')) ;
	});
	$("#csv").off().on('click',function(){
    	var chaine = "";
    	var csv = '"Num";"Projet";"Desc";"Porteur";"Référent";"Avancement dossier";"Lire";"Etiquetage";"Tags";"Status"' ;

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
        		//csv += '"'+$("#"+key+"eligible").html()+'";';
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
				csv += '"'
        		if(notNull(value2.tags)){
        			var j = 1;
					$.each(value2.tags, function(keyC, valC){
						if(j != 1)
							csv += ", ";
						csv += valC;
						j++;
					});
				}
				csv += '";';

				csv += '"'+( notNull(value2.priorisation ) ? value2.priorisation : "" )+'";';

        		//csv += '"'+$("#"+key+"etiquetage").html()+'";';
        		//csv += '"'+(notNull($("#"+key+"risk").html()) ? $("#"+key+"risk").html(): "")+'";';
        		//csv += '"'+$("#"+key+"action").html()+'";';
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

	$('.prioritize').off().on("click",function() { 
		answerId = $(this).data("id");
		prioModal = bootbox.dialog({
	        message: $(".form-prioritize").html(),
	        title: "Qualifiez ce dossier",
	        show: false,
	        onEscape: function() {
	          prioModal.modal("hide");
	        }
	    });
	    prioModal.modal("show");

	    $(".prioBtn").off().on("click",function() { 
			prioValue = $(this).data("value");
			prioModal.modal("hide");
	        postdata={
				formId : formId,
				answerId : answerId,
				answerSection : "priorisation" ,
				answers : $(this).data("value"),
				answerUser : userId 
			};
			
			console.log("saving",postdata);
			// /alert(answerId);
	      	$.ajax({ 
	      		type: "POST",
		        url: baseUrl+"/survey/co/update",
		        data: postdata
		    }).done(function (data) { 
		    	
		    	toastr.success('Status changé avec succès');
		    	
		    	$('#prio'+answerId).css("background-color",states[postdata.answers].color).html("<i class='fa fa-2x  "+states[postdata.answers].icon+"'></i>");

		    	
		    	postdata.answerSection = "step";
		    	postdata.answers = ( prioValue == "selected") ? "ficheAction" : "eligible"; 

				$.ajax({ 
		      		type: "POST",
			        url: baseUrl+"/survey/co/update",
			        data: postdata
			    }).done(function (data) { 
			    	toastr.success('Step changé avec succès');
			    });
			    
		    });

		    

		});
	});

	$(".btn-open-chat").click( function() { 
    	var nameElo = $(this).data("name-el");
    	var idEl = $(this).data("id");
    	var usernameEl = $(this).data("username");
    	var slugEl = $(this).data("slug");
    	var typeEl = dyFInputs.get($(this).data("type-el")).col;
    	var openEl = $(this).data("open");
    	var hasRCEl = ( $(this).data("hasRC") ) ? true : false;
    	//alert(nameElo +" | "+typeEl +" | "+openEl +" | "+hasRCEl);
    	var ctxData = {
    		name : nameElo,
    		type : typeEl,
    		id : idEl
    	}
    	if(typeEl == "citoyens")
    		ctxData.username = usernameEl;
    	else if(slugEl)
    		ctxData.slug = slugEl;
    	rcObj.loadChat(nameElo ,typeEl ,openEl ,hasRCEl, ctxData );
    });

});
function showFinancial(answerId){
	var modal = bootbox.dialog({
	        message: '<div class="content-financial-tree"></div>',
	        title: "Point fincancier",
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
		  	getAjax(".content-risk-comment-tree",baseUrl+"/survey/co/answer/id/"+answerId+"/step/dossier.cte3.planFinancement",
			function(){  //$(".commentCount").html( $(".nbComments").html() ); 
			},"html");

		  //bindEventTextAreaNews('#textarea-edit-news'+idNews, idNews, updateNews[idNews]);
		});
	    modal.modal("show");
	//}
}
function commentAnswer(answerId){
	var modal = bootbox.dialog({
	        message: '<div class="content-risk-comment-tree"></div>',
	        title: "Fil de commentaire du projet",
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
		  	getAjax(".content-risk-comment-tree",baseUrl+"/"+moduleId+"/comment/index/type/answers/id/"+answerId,
			function(){  //$(".commentCount").html( $(".nbComments").html() ); 
			},"html");

		  //bindEventTextAreaNews('#textarea-edit-news'+idNews, idNews, updateNews[idNews]);
		});
	   // modal.modal("show");
	//}
}
function countLine(){
	var nbLine = $("#panelAdmin tr.line").filter(function() {
			    return $(this).css('display') !== 'none';
			}).length ;
	$("#nbLine").html(nbLine);
}




</script> 

