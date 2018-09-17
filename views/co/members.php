<?php
$cssAnsScriptFilesModule = array(
    '/plugins/jquery-simplePagination/jquery.simplePagination.js',
	'/plugins/jquery-simplePagination/simplePagination.css'
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getRequest()->getBaseUrl(true));
$cssJS = array(
    '/js/dataHelpers.js',
    //'/js/default/directory.js'
);
HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->getModule( Yii::app()->params["module"]["parent"] )->getAssetsUrl() );

$cssJS = array(
    '/plugins/jquery.dynForm.js',
    '/plugins/select2/select2.min.js' , 
);
HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->request->baseUrl);

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
$me = isset(Yii::app()->session['userId']) ? Person::getById(Yii::app()->session['userId']) : null;
$this->renderPartial( $layoutPath.'modals.'.Yii::app()->params["CO2DomainName"].'.mainMenu', array("me"=>$me) );
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
<?php 
	if(	Form::canAdmin((string)$form["_id"], $form) ){ ?>
<div class="panel panel-white col-lg-offset-1 col-lg-10 col-xs-12 no-padding">
	<div class="col-md-12 col-sm-12 col-xs-12 text-center">
		<h1><?php echo "Liste des membres "?> <!-- <a href="<?php //echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/index/id/<?php //echo $form["id"] ?>"><i class="fa fa-arrow-circle-right"></i></a> --> </h1>
		<br/>
		<div id="" class="" style="width:80%;  display: -webkit-inline-box;">
	    	<input type="text" class="form-control" id="input-search-table" 
					placeholder="Rechercher une information dans le tableau">
	    </div>
    </div>
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20 text-center"></div>
	<div class="panel-body">
		<div>
			<a href="<?php echo '#element.invite.type.'.Form::COLLECTION.'.id.'.(string)$form['_id'] ; ?>" class="btn btn-success btn-xs pull-right margin-10 lbhp"><i class="fa fa-user-plus"></i> Inviter des Admins et des Participants</a>
			<table class="table table-striped table-bordered table-hover  directoryTable" id="panelAdmin">
				<thead>
					<tr>
						<th>Nom</th>
						<th>Email</th>
						<th>Identifiant</th>
						<th>Roles</th>
						<th>Admin</th>
						<th>Action</th>
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
$adminTCO = Form::canSuperAdmin($form["id"], $_GET["session"], $form);
?>
<script type="text/javascript">

	var form =<?php echo json_encode($form); ?>;
	var contextData = {id : form._id.$id, type : "forms"};
	var data =<?php echo json_encode($results); ?>;
	var adminTCO = "<?php echo $adminTCO; ?>";
	var searchAdmin={
		parentSurvey : form.id,
		text:null,
		page:"",
		//type:initType[0]
	};

	jQuery(document).ready(function() {
		bindLBHLinks();
		//bindAnwserList();
		if(typeof data != "undefined"){
			initViewTable(data);
		}

		$(".disconnectConnection").click(function(){
			var $this=$(this); 
			disconnectTo(	contextData.type,
							contextData.id, 
							$this.data("id"),
							$this.data("type"), 
							$this.data("connection"),
							function() { $("#lineMember"+$this.data("id")).fadeOut(); });
		});


		// $("#input-search-table").keyup(function(e){
		// 	//if(e.keyCode == 13){
		// 	searchAdmin.page=0;
		// 	searchAdmin.text = $(this).val();
		// 	if(searchAdmin.text=="")
		// 		searchAdmin.text=null;
		// 	startAdminSearch(true);
		// 	// Init of search for count
		// 	if(searchAdmin.text===true)
		// 		searchAdmin.text=null;
	 //    });

	    $("#input-search-table").on("keyup", function() {
		    var value = $(this).val().toLowerCase();
		    $("#panelAdmin tr.line").filter( function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
				//countLine();
		    });
		});

	   
	});

	// function countLine(){
	// 	var nbLine = $("#panelAdmin tr.line").filter(function() {
	// 			    return $(this).css('display') !== 'none';
	// 			}).length ;
	// 	$("#nbLine").html(nbLine);
	// }


	function startAdminSearch(initPage){
		//$("#second-search-bar").val(search);
	    $('#panelAdmin .directoryLines').html("Recherche en cours. Merci de patienter quelques instants...");
	    var data = {
	    	ifForm : form._id.$id,
	    	text : $("#input-search-table").val(),
	    }

	    $.ajax({ 
	        type: "POST",
	        url: baseUrl+'/'+activeModuleId+"/co/searchadminmembers/",
	        //url: baseUrl+"/"+moduleId+"/admin/directory/tpl/json",
	        data: searchAdmin,
	        dataType: "json",
	        success:function(data) { 
		          initViewTable(data);
		          //bindAnwserList();
		          // if(typeof data.results.count !="undefined")
		          // 	refreshCountBadge(data.results.count);
		          // console.log(data.results);
		          // if(initPage)
		          // 	initPageTable(data.results.count[searchAdmin.type]);
	        },
	        error:function(xhr, status, error){
	            $("#searchResults").html("erreur");
	        },
	        statusCode:{
	                404: function(){
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
			bindMembers();
		});
		//bindAnwserList();
	}

	function bindMembers(){
		mylog.log("bindMembers");
		$(".removeAdmin").off().click(function(e){
			var params = {
		    	parentId : form._id.$id,
		    	parentType : "<?php echo Form::COLLECTION ;?>",
		   		childId : $(this).data("id"),
				childType : $(this).data("type"),
				connect : "members",
				isAdmin : false,
			};

		    $.ajax({ 
		        type: "POST",
		        url: baseUrl+'/'+moduleId+"/link/updateadminlink/",
		        data: params,
		        dataType: "json",
		        success:function(data) { 

			        $("#admin"+params.childId+params.childType).html("Non");
			        $("#removeAdmin"+params.childId).remove();
			        var action = '<li id="addAdmin'+key+'"><a href="javascript:;" data-id="'+params.childId+'" data-type="'+params.childType+'" class="margin-right-5 addAdmin"><span class="fa-stack"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-check fa-stack-2x stack-right-bottom text-danger"></i></span>Ajouter en tant que admin</a></li>' ;
			        $("#actionMenu"+params.childId).append(action);
			        form.links.members[params.childId].isAdmin = false;
			  //       if( form.links.members[key].type == "<?php //echo Person::COLLECTION ; ?>"){
					// 	if( typeof form.links.members[key].isAdmin != "undefined" && 
					// 		form.links.members[key].isAdmin == true) {
					// 		str += " Oui ";
					// 		actions += '<li id="removeAdmin'+key+'"><a href="javascript:;" data-id="'+key+'" data-type="'+form.links.members[key].type+'" class="margin-right-5 removeAdmin"><span class="fa-stack"><i class="fa fa-user-times"></i></i></span>Supprimer de l\'admin</a></li>';
					// 	}else{
					// 		str += " Non ";
					// 		;
					// 	}
					// }
		        },
		        error:function(xhr, status, error){
		            $("#searchResults").html("erreur");
		        },
		        statusCode:{
		                404: function(){
		                    $("#searchResults").html("not found");
		            }
		        }
		    });
	    });

	    $(".addAdmin").off().click(function(e){
			var params = {
		    	parentId : form._id.$id,
		    	parentType : "<?php echo Form::COLLECTION ;?>",
		   		childId : $(this).data("id"),
				childType : $(this).data("type"),
				connect : "members",
				isAdmin : true,
			};

		    $.ajax({ 
		        type: "POST",
		        url: baseUrl+'/'+moduleId+"/link/updateadminlink/",
		        data: params,
		        dataType: "json",
		        success:function(data) { 
			        $("#admin"+params.childId+params.childType).html("Oui");
		        },
		        error:function(xhr, status, error){
		            $("#searchResults").html("erreur");
		        },
		        statusCode:{
		                404: function(){
		                    $("#searchResults").html("not found");
		            }
		        }
		    });
	    });


	    $(".updateRoles").off().click(function(e){
			var id = $(this).data("id");
			var name = $(this).data("name");
			var type = $(this).data("type");
			mylog.log("updateRoles", id, type, name);
			if( typeof form.links.members[id] != "undefined" ){

				var roles = ( ( typeof form.links.members[id].roles != "undefined" ) ? form.links.members[id].roles : [] ) ;
				updateRoles(id, type, name, "members", roles);
			}

	    });
	}

	function updateRoles(childId, childType, childName, connectType, roles) {
		mylog.log("updateRoles", form.custom.roles);
		var formRole = {
				saveUrl : baseUrl+"/"+moduleId+"/link/removerole/",
				dynForm : {
					jsonSchema : {
						title : tradDynForm.modifyoraddroles+"<br/>"+childName,// trad["Update network"],
						icon : "fa-key",
						onLoads : {
							sub : function(){
								$("#ajax-modal .modal-header").removeClass("bg-dark bg-purple bg-red bg-azure bg-green bg-green-poi bg-orange bg-yellow bg-blue bg-turq bg-url")
											  				  .addClass("bg-dark");
								//bindDesc("#ajaxFormModal");
							}
						},
						afterSave : function(data){
							mylog.log("afterSave",data);
							dyFObj.closeForm();
							//loadDataDirectory(connectType, "user", true);
							form.links.members[data.memberid].roles = data.roles ;
							var str = "";
							if( typeof data.roles != "undefined") {
								$.each(data.roles, function(kR, vR){
									str += vR+" ";
								});
							}
							mylog.log("afterSave", "#role"+childId+childType, str);
							$("#role"+childId+childType).html(str);
							//changeHiddenFields();
						},
						properties : {
							contextId : dyFInputs.inputHidden(),
							contextType : dyFInputs.inputHidden(), 
							roles : dyFInputs.tags(form.custom.roles, tradDynForm["addroles"] , tradDynForm["addroles"], 0),
							childId : dyFInputs.inputHidden(), 
							childType : dyFInputs.inputHidden(),
							connectType : dyFInputs.inputHidden()
						}
					}
				}
			};

			var dataUpdate = {
		        contextId : contextData.id,
		        contextType : contextData.type,
		        childId : childId,
		        childType : childType,
		        connectType : connectType,
			};

			if(notEmpty(roles))
				dataUpdate.roles = roles;
			dyFObj.openForm(formRole, "sub", dataUpdate);		
	}

	function buildDirectoryLine(key, value){
		console.log("buildDirectoryLine", key, value);
		actions = "";
		str = '<tr id="lineMember'+key+'" class="line">';
			str += '<td>'+value.name+'</td>';
			str += '<td>'+value.email+'</td>';
			str += '<td>'+key+'</td>';
			
			if(typeof form.links != "undefined" && typeof form.links.members != "undefined"
				&& typeof form.links.members[key] != "undefined"){
				actions += '<li><a href="javascript:;" data-id="'+key+'" data-type="'+form.links.members[key].type+'" data-name="'+value.name+'" class="margin-right-5 updateRoles"><span class="fa-stack"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-check fa-stack-2x stack-right-bottom text-danger"></i></span>Modifier les roles</a></li>';

				str += '<td id="role'+key+form.links.members[key].type+'">';
				if( typeof form.links.members[key].roles != "undefined") {
					$.each(form.links.members[key].roles, function(kR, vR){
						str += vR+"<br/>";
					});
				}
				str += '</td>';
				str += '<td id="admin'+key+form.links.members[key].type+'">';
				if( form.links.members[key].type == "<?php echo Person::COLLECTION ; ?>"){
					if( typeof form.links.members[key].isAdmin != "undefined" && 
						form.links.members[key].isAdmin == true) {
						str += " Oui ";
						actions += '<li id="removeAdmin'+key+'"><a href="javascript:;" data-id="'+key+'" data-type="'+form.links.members[key].type+'" class="margin-right-5 removeAdmin"><span class="fa-stack"><i class="fa fa-user-times"></i></i></span>Supprimer de l\'admin</a></li>';
					}else{
						str += " Non ";
						actions += '<li id="addAdmin'+key+'"><a href="javascript:;" data-id="'+key+'" data-type="'+form.links.members[key].type+'" class="margin-right-5 addAdmin"><span class="fa-stack"><i class="fa fa-user fa-stack-1x"></i><i class="fa fa-check fa-stack-2x stack-right-bottom text-danger"></i></span>Ajouter en tant que admin</a></li>';
					}
				}else{
					str += " ";
				}
				str += '</td>';
				str += '<td class="center">';

				actions += '<li><a href="javascript:;" data-id="'+key+'" data-type="'+form.links.members[key].type+'" data-name="'+value.name+'" data-connection="members" data-parent-hide="'+2+'" class="margin-right-5 disconnectConnection"><span class=""><i class="fa fa-trash"></i></i></span>Supprimer le lien</a></li>';


				if( actions != "" && true == adminTCO ){ 
					str += '<div class="btn-group">'+
								'<a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle btn-sm"><i class="fa fa-cog"></i> <span class="caret"></span></a>'+
								'<ul class="dropdown-menu pull-right dropdown-dark" role="menu">'+
									actions+
								'</ul></div>';
				}
				str += '</td>';
							
			}
			str += '</td>';
		str += '</tr>';
		return str;
	}

	function disconnectTo(parentType,parentId,childId,childType,connectType, callback, linkOption, msg) { 
		var messageBox = (notNull(msg)) ? msg : trad["removeconnection"+connectType];
		$(".disconnectBtnIcon").removeClass("fa-unlink").addClass("fa-spinner fa-spin");
		var formData = {
			"childId" : childId,
			"childType" : childType, 
			"parentType" : parentType,
			"parentId" : parentId,
			"connectType" : connectType,
		};
		if(typeof linkOption != "undefined" && linkOption)
			formData.linkOption=linkOption;
		bootbox.dialog({
	        onEscape: function() {
	            $(".disconnectBtnIcon").removeClass("fa-spinner fa-spin").addClass("fa-unlink");
	        },
	        message: '<div class="row">  ' +
	            '<div class="col-md-12"> ' +
	            '<span>'+messageBox+' ?</span> ' +
	            '</div></div>',
	        buttons: {
	            success: {
	                label: "Ok",
	                className: "btn-primary",
	                callback: function () {
	                    $.ajax({
							type: "POST",
							url: baseUrl+"/"+moduleId+"/link/disconnect",
							data : formData,
							dataType: "json",
							success: function(data){
								if ( data && data.result ) {
									typeConnect=(formData.parentType==  "citoyens") ? "people" : formData.parentType;
									idConnect=formData.parentId;
									if(formData.parentId==userId){
										typeConnect=(formData.childType==  "citoyens") ? "people" : formData.childType;
										idConnect=formData.childId;
									
									}
									// if(typeof removeFloopEntity() != "undefined")
									// 	removeFloopEntity(idConnect, typeConnect);
									toastr.success("Le lien a été supprimé avec succès");
									if (typeof callback == "function") 
										callback();
									else
										urlCtrl.loadByHash(location.hash);
								} else {
								   toastr.error("You leave succesfully");
								}
							}
						});
	                }
	            },
	            cancel: {
	            	label: trad["cancel"],
	            	className: "btn-secondary",
	            	callback: function() {
	            		$(".disconnectBtnIcon").removeClass("fa-spinner fa-spin").addClass("fa-unlink");
	            	}
	            }
	        }
	    });      
	};
</script> 
<?php	
	} else {
		$this->getController()->render("co2.views.default.unTpl",array("msg"=>Yii::t("project", "Unauthorized Access."),"icon"=>"fa-lock"));
	} ?>

