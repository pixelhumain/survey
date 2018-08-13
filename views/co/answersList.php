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
	<div class="col-md-12 col-sm-12 col-xs-12 no-padding" id="goBackToHome">
		<a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/admin/id/<?php echo $_GET['id']; ?>" class="col-md-12 col-sm-12 col-xs-12 padding-20 text-center bg-orange" id="btn-home" style="font-size:20px;"><i class="fa fa-home"></i> Retour au panel d'admin</a>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12 text-center">
		<h1><?php echo $form["title"] ?> <a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/index/id/<?php echo $form["id"] ?>"><i class="fa fa-arrow-circle-right"></i></a> </h1>
		<div id="" class="" style="width:80%;  display: -webkit-inline-box;">
	    	<input type="text" class="form-control" id="input-search-table" 
					placeholder="search by name or by #tag, ex: 'commun' or '#commun'">
		    <button class="btn btn-default hidden-xs menu-btn-start-search-admin btn-directory-type">
		        <i class="fa fa-search"></i>
		    </button>
	    </div>
    </div>
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20 text-center"></div>
	<div class="panel-body">
		<div>
			<!-- <a href="<?php //echo '#element.invite.type.'.Form::COLLECTION.'.id.'.(string)$form['_id'] ; ?>" class="btn btn-primary btn-xs pull-right margin-10 lbhp">Invite Admins & Participants</a> -->
			<table class="table table-striped table-bordered table-hover directoryTable" id="panelAdmin">
				<thead>
					<tr>
						<th>Nom du projet</th>
						<th>Organisation</th>
						<th>Utilisateur</th>
						<th>Etape</th>
						<th>Voir la réponse</th>
						<th>Eligibilité</th>
						<th>Priorisation</th>
						<th>Risques</th>
					</tr>
				</thead>
				<tbody class="directoryLines">
				</tbody>
			</table>
			
		</div>
	</div>
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20"></div>
</div>
<?php 
	echo $this->renderPartial( "survey.views.co.modalSelectCategorie",array());
?> 
<script type="text/javascript">

	var form =<?php echo json_encode($form); ?>;
	var data =<?php echo json_encode($results); ?>;
		console.log("data", data);
	var searchAdmin={
		parentSurvey : form.id,
		text:null,
		page:"",
		//type:initType[0]
	};
	var rolesListCustom = <?php echo json_encode(@$roles); ?>;

	jQuery(document).ready(function() {
		bindLBHLinks();
		bindAnwserList();
		if(typeof data != "undefined"){
			initViewTable(data);
		}

		if(rolesListCustom.length > 0)
			rolesList = rolesListCustom ;

		

		$("#input-search-table").keyup(function(e){
			//if(e.keyCode == 13){
			searchAdmin.page=0;
			searchAdmin.text = $(this).val();
			if(searchAdmin.text=="")
				searchAdmin.text=null;
			startAdminSearch(true);
			// Init of search for count
			if(searchAdmin.text===true)
				searchAdmin.text=null;
			//}
	    });

	   $("#validEligible").on("click",function(e){
			var params = {
				childId : $("#childId").val(),
				childType : $("#childType").val(),
				childName : $("#childName").val(),
				userName : $("#userName").val(),
				userId : $("#userId").val(),
				form : $("#form").val(),
				formId : $("#formId").val(),
				eligible : $("#eligible").val(),
				roles : $("#selectCategorie").val()
			};

			if($("#parentId").val() != "" && $("#parentType").val() != ""){
				params["parentId"] = $("#parentId").val();
				params["parentType"] =$("#parentType").val();
				params["parentName"] = $("#parentName").val();
			}

			eligibleFct(params);
		});
	});


	function startAdminSearch(initPage){
		//$("#second-search-bar").val(search);
	    $('#panelAdmin .directoryLines').html("Recherche en cours. Merci de patienter quelques instants...");
	    var data = {
	    	ifForm : form._id.$id,
	    	text : $("#input-search-table").val(),
	    }

	    $.ajax({ 
	        type: "POST",
	        url: baseUrl+'/'+activeModuleId+"/co/searchadminform/",
	        //url: baseUrl+"/"+moduleId+"/admin/directory/tpl/json",
	        data: searchAdmin,
	        dataType: "json",
	        success:function(data) { 
		          initViewTable(data);
		          bindAnwserList();
		          // if(typeof data.results.count !="undefined")
		          // 	refreshCountBadge(data.results.count);
		          // console.log(data.results);
		          // if(initPage)
		          // 	initPageTable(data.results.count[searchAdmin.type]);
	        },
	        error:function(xhr, status, error){
	            $("#searchResults").html("erreur");
	        },
	        statusCode : {
	                404 : function(){
	                    $("#searchResults").html("not found");
	            }
	        }
	    });
	}

	function initViewTable(data){
		console.log("initViewTable", data);
		$('#panelAdmin .directoryLines').html("");
		console.log("valueInit",data);
		$.each(data, function(key, value){

			entry=buildDirectoryLine(key, value);
			console.log("entry", entry);
			$("#panelAdmin .directoryLines").append(entry);
		});
		bindAnwserList();
	}

	function buildDirectoryLine(key, value){
		console.log("buildDirectoryLine", key, value);
		var step = 0;
		var stepTotal = 0;
		$.each(value.scenario, function(k, v){
			stepTotal++;
			if(v == true)
				step++;
		});

		str = '<tr>';
			str += '<td>'+( (typeof value.name != "undefined") ? value.name : "Pas encore renseigner" ) +'</td>';
			str += '<td>'+( (typeof value.parentName != "undefined") ? value.parentName : "Pas encore renseigner" ) +'</td>';
			str += '<td>'+( (typeof value.userName != "undefined") ? value.userName : "Pas encore renseigner" )+'</td>';
			str += '<td>';
				var classText = (step == stepTotal) ? 'text-success' : 'text-red';

				str += "<span class='"+ classText +"'>"+ step +' / '+ stepTotal + "</span>";
			str += '</td>';
			str += '<td>';
				//if(step == stepTotal){
					str += '<center><a href="'+baseUrl+'/survey/co/answer/id/'+form.id+'/user/'+value.userId+'" target="_blanck">Lire</a></center>';
				//}
			str += '</td>';
			str += '<td id="active'+value.id+value.type+'">';
			if(typeof value.type != "undefined" && "projects" == value.type){
				//console.log("here", value.id, form.links.projectExtern[value.id]);
				if( typeof form.links == "undefined" || 
					typeof form.links.projectExtern == "undefined" || 
					typeof form.links.projectExtern[value.id] == "undefined") {
					str += 'Pas encore traité';

				}else {
					str += 'Eligible' ;
				}
			}

			str += '</td>';
		str += '</tr>';
		return str;
	}

	function bindAnwserList(){
		$(".activeBtn").on("click",function(e){
			$('#modalCatgeorieAnswers').modal("show");
			console.log("ffefe", $(this).data("id"));
			$("#childId").val($(this).data("id"));
			$("#childType").val($(this).data("type"));
			$("#childName").val($(this).data("name"));
			$("#userName").val($(this).data("username"));
			$("#userId").val($(this).data("userid"));
			$("#form").val(form._id.$id);
			$("#formId").val(form.id);
			$("#eligible").val(true);
			$("#parentId").val( $(this).data("parentid"));
			$("#parentType").val( $(this).data("parenttype"));
			$("#parentName").val($(this).data("parentname"));
		});
	}


</script> 

