<?php 
if( $canAdmin && array_search('priorisation', $steps) <= array_search($adminAnswers["step"], $steps)) {

if(@$adminAnswers["categories"]){
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
	.nav li a{font-size:14px;}
	.nav li.active {border-right : 3px solid red;border-left : 3px solid red}
	.nav li.active a{font-weight: bolder;}
</style>
<div id="categories" class="col-xs-12">

	<?php 
	// ---------------------------------------
	// GOLBZAL RESULT TABLE
	// ---------------------------------------
	 ?>
	<div id="eligibleDesc" class="eliSec col-xs-12 padding-20">
		La priorisation permet d'évaluer l'opportunité et la faisabilité du projet dans les différentes thématiques qui lui sont associer.
		<br/><br/>
		

		
		<table class="bold" style="margin:0px auto;">
			<?php foreach ($adminAnswers["categories"] as $key => $vey ) {?>
				<tr>
					<td class="bold"><?php echo mb_strtoupper($prioKey) ?> <?php echo $key ?></td>
					<td> <a href="" data-category="<?php echo $key?>" data-value="high" class="btn btn-success">FORTE</a> </td>
					<td> <a href="" data-category="<?php echo $key?>" data-value="moy" class="btn btn-warning">MOYENNE</a> </td>
					<td> <a href="" data-category="<?php echo $key?>" data-value="low"  class="btn btn-danger">FAIBLE</a> </td>
				</tr>
			<?php } ?>
		</table>
		
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() { 
	
	

	$('.adminStep').click(function() {

		updateForm = {
			form : $(this).data("form")	,
			category : $(this).data("section")+"."+$(this).data("category")	,
			cat : $(this).data("category"),
			step : $(this).data("step"),
			section : $(this).data("section")
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
    			answerId : adminAnswers["_id"]["$id"],
    			session : formSession,
    			answerSection : updateForm.category+"."+updateForm.step ,
    			answerKey : "<?php echo $adminForm['key'] ?>" ,
    			answerStep : updateForm.cat ,
    			answers : getAnswers( adminForm.scenario[ updateForm.step ].json ),
    			answerUser : adminAnswers.user 
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
			    	if(data.total != null)
			    		$("#"+updateForm.cat+"Btn i").hide();
			    	updateForm = null;
			    } 
		    });
		};

		if( adminAnswers[updateForm.section] && 
			adminAnswers[updateForm.section][updateForm.cat] &&
			adminAnswers[updateForm.section][updateForm.cat][updateForm.step])
			dyFObj.editStep( editForm, adminAnswers[updateForm.section][updateForm.cat][updateForm.step] );
		else 
			dyFObj.editStep( editForm );	

	});

	$(".updateRoles").off().click(function(e){
		var id = $(this).data("id");
		var name = $(this).data("name");
		var type = $(this).data("type");
		mylog.log("updateRoles", id, type, name, form, form.links, form.links.projectExtern , form.links.projectExtern[id]);
		if( typeof form.links.projectExtern[id] != "undefined" ){

			var roles = ( ( typeof form.links.projectExtern[id].roles != "undefined" ) ? form.links.projectExtern[id].roles : [] ) ;
			updateRoles(id, type, name, "projectExtern", roles, adminAnswers._id.$id);
		}

    });
});

function updateRoles(childId, childType, childName, connectType, roles, answer) {
	mylog.log("updateRoles !", form.custom.roles);
	var contextData = {id : form._id.$id, type : "forms"};
	var formRole = {
			saveUrl : baseUrl+'/'+activeModuleId+"/co/updatepriorisation/",
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
					beforeSave : function(){
						mylog.log("beforeSave");
				    	//removeFieldUpdateDynForm(contextData.type);
				    },
					afterSave : function(data){
						mylog.dir(data);
						dyFObj.closeForm();
						location.reload();
					},
					properties : {
						contextId : dyFInputs.inputHidden(),
						contextType : dyFInputs.inputHidden(), 
						roles : dyFInputs.tags(form.custom.roles, tradDynForm["addroles"] , tradDynForm["addroles"], 0),
						childId : dyFInputs.inputHidden(), 
						childType : dyFInputs.inputHidden(),
						answer : dyFInputs.inputHidden(),
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
	        answer : answer,
	        connectType : connectType,
		};

		if(notEmpty(roles))
			dataUpdate.roles = roles;
		dyFObj.openForm(formRole, "sub", dataUpdate);		
}
</script>
<?php } 
}
?>