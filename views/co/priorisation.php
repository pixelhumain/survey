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
		  	$ic = ( !@$adminAnswers[$prioKey][ $va["name"]]["total"] && Form::canAdminRoles((string)$form["_id"], $va["name"], $form) ) ? " <i class='text-red fa fa-cog'></i>" : "";
			echo mb_strtoupper($va["name"]).$ic; ?></a></li>
		  <?php } ?>
			<li class="pull-right">
				<a href="javascript:;" data-id="<?php echo $answers["cte2"]["answers"][Project::CONTROLLER]["id"]; ?>" data-type="<?php echo Project::COLLECTION; ?>" data-name="<?php echo $answers["cte2"]["answers"][Project::CONTROLLER]["name"]; ?>" class="margin-right-5 updateRoles"><i class="text-red margin-top-10 fa fa-pencil"></i></a>
			</li>
	</ul>




	<?php 
	// ---------------------------------------
	// GOLBZAL RESULT TABLE
	// ---------------------------------------
	 ?>
	<div id="eligibleDesc" class="eliSec col-xs-12 padding-20">
		<h2>Récapitulation de la <?php echo mb_strtoupper($prioKey) ?></h2>
		La priorisation permet d'évaluer l'opportunité et la faisabilité du projet dans les différentes thématiques qui lui sont associer.
		<br/><br/><br/>
		<div class="padding-10"  style="border:0px solid red">
			<h4 class="text-center">Matrice de <?php echo mb_strtoupper($prioKey) ?></h4>
			<table border="1" class="text-red text-center bold" style="margin:0px auto;">
				<tr>
					<?php foreach ($adminAnswers["categories"] as $ka => $va ) {
						
						?>
					<th class="padding-10"><a href="javascript:;" onclick="EliTabs('<?php echo $ka ?>')"><?php echo mb_strtoupper($va["name"]) ?></a></th>
					<?php } ?>
					<th class="padding-10">Note globale</th>
					<!-- th class="padding-10">Classification</th-->
				</tr>
				<tr>
					<?php foreach ($adminAnswers["categories"] as $ka => $va ) {?>
					<td><a href="javascript:;" onclick="changeCategoryWeight('<?php echo $ka ?>','<?php echo @$va["pourcentage"] ?>')"><?php echo @$va["pourcentage"]."%" ?></a></td>
					<?php } ?>
					<td>100%</td>
					<!-- td>Note</td-->
				</tr>
				<tr>
					<?php 
					$tot = 0;
					$ctot = 0;
					if(@$adminAnswers[$prioKey]){ 
						foreach ( @$adminAnswers[$prioKey] as $ka => $va ) {?>
							<td class="<?php echo $ka ?>_Totaldesc">
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
					<!--td></td-->
				</tr>
			</table>
		</div>
	</div>

	<?php foreach ($adminAnswers["categories"] as $key => $vey ) {?>
			<div id="<?php echo $key ?>" style="display:none" class="eliSec col-xs-12 padding-20">
				<div class="col-xs-12 text-center " >
					<h2 class=""><?php echo mb_strtoupper($prioKey) ?> <?php echo $key ?></h2>

					<?php 
						$showHide = (@$adminAnswers[$prioKey][$key]) ? "" : "hide";
						$showHide = "";
					// ---------------------------------------
					// GLOBAL RESULT TABLE FOR EACH CATEGORY
					// ---------------------------------------
					 ?>
					<div class="margin-bottom-20 padding-10 <?php echo $showHide ?> <?php echo $key?>_Priorisation"  style="border:1px solid red">
						<h3 class="text-center text-red" >Matrice de <?php echo mb_strtoupper($prioKey) ?>  <?php echo $key ?></h3>
						<table border="1" class="text-center padding-10" style="margin:0px auto;">
							<tr>
								<?php 
								foreach ($prioTypes as $prioType ) 
								{  ?>
								<th class="padding-10"><a href="javascript:;" onclick="showTableOrForm('<?php echo $key ?>','<?php echo $prioType ?>')"><i class="fa fa-pencil"></i> <?php echo mb_strtoupper($prioType) ?></a></th>
								<?php } ?>
								<th class="padding-10">Note globale</th>
								<!-- th class="padding-10">Classification</th-->
							</tr>
							<tr>
								<?php 
								foreach ($prioTypes as $prioType ) 
								{  ?>
								<td><?php echo floor( (100/count($prioTypes)) ) ?>%</td>
								<?php } ?>
								<td class="text-red" >100%</td>
								<!--td class="text-red">Note</td-->
							</tr>
							<tr>
								<?php 
								$countRes = 0;
								$countTotal = 0; 
								foreach ($prioTypes as $prioType ) 
								{  ?>
								<td class="<?php echo $key?>_Total <?php echo $key?>_<?php echo $prioType ?>TotalNum">
									<?php if( @$adminAnswers[$prioKey][ $key ][ $prioType ]["total"] ) {
										echo $adminAnswers[$prioKey][ $key ][ $prioType ]["total"]; 
										$countRes++;
										$countTotal += (float)$adminAnswers[$prioKey][ $key ][ $prioType ]["total"];
									} ?>
								</td>
								<?php } ?>
								<td  class="text-red <?php echo $key?>_totalTotal">
									<?php if($countRes == count($prioTypes) )
										echo floor( ( $countTotal / count($prioTypes) )*100 )/100; ?>
								</td>
								<!--td></td-->
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
						$btnColor = "btn-default" ;
						$hideTable = "";
						$hideTable = "display:none;";
						if(@$adminAnswers[$prioKey][$key][ $prioType ]["total"]){
							$score = "[NOTE : ".$adminAnswers[$prioKey][$key][ $prioType ]["total"]."]";
							$titleResult = "résultat ".$prioType;
							$btnColor = "btn-default" ;
							//$hideTable = "display:none;";
						}
					?>

					<div class="padding-10 <?php echo $key?>_DataTables" id="<?php echo $key?>_<?php echo $prioType ?>Table"  style="<?php echo $hideTable ?> border:1px solid #666">

						<?php if( Form::canAdminRoles((string)$form["_id"], $vey["name"], $form) )  { ?>
						<a href="javascript:;" data-section="<?php echo $prioKey?>" data-category="<?php echo $key?>" data-step="<?php echo $prioType ?>" data-form="<?php echo substr( $adminForm["parentSurvey"], 0, -5 )?>" class="adminStep btn <?php echo $btnColor; ?>"><?php echo $adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ]["title"] ?></a>
					<?php } ?>
						<h3 class="text-center <?php echo $key?>_<?php echo $prioType ?>ResultHead <?php echo $key?>_prioTitle <?php echo $showHide ?>"><span class="<?php echo $key?>_<?php echo $prioType ?>ResultHeadLabel"><?php echo $titleResult ?></span> <span class="text-red <?php echo $key?>_<?php echo $prioType ?>Total"><?php echo $score ?></span></h3>


						<table border="1" class="text-center  <?php echo $key?>_<?php echo $prioType ?>Result" style="margin:0px auto;">

							<tr class="<?php echo $key?>_<?php echo $prioType ?>ResultTitle">
								<?php 
								if(@$adminAnswers[$prioKey][ $key ][ $prioType ]){
								foreach (@$adminAnswers[$prioKey][ $key ][ $prioType ] as $k => $v ) {

									if(!in_array( @$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["inputType"],array("text", "textarea") )  && $k != "total")
										echo '<th class="padding-10">'.@$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["placeholder"]."</th>"; 
									
								}} ?>
							</tr>
						

							<tr class="<?php echo $key?>_<?php echo $prioType ?>ResultWeight">
								<?php 
								if(@$adminAnswers[$prioKey][ $key ][ $prioType ]){
								foreach (@$adminAnswers[$prioKey][ $key ][ $prioType ] as $k => $v ) {
									?>
									<?php 
										if (!in_array( @$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["inputType"],array("text", "textarea") )  && $k != "total")
											echo (@$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["weight"]) ? '<td>'.@$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["weight"]."% </td>" : "";
											 ?>
								<?php }} ?>
							</tr>
						

							<tr class="<?php echo $key?>_<?php echo $prioType ?>ResultAnswer">
								<?php 
								if(@$adminAnswers[$prioKey][ $key ][ $prioType ]){
								foreach (@$adminAnswers[$prioKey][ $key ][ $prioType ] as $k => $v ) {?>
									<?php 
										if(! in_array( @$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["inputType"],array("text", "textarea") ) && $k != "total" )
											echo '<td>'.$v.'</td>' ?>
								<?php }} ?>
							</tr>

							<tr class="<?php echo $key?>_<?php echo $prioType ?>LabelAnswer">
								<?php 
								if(@$adminAnswers[$prioKey][ $key ][ $prioType ]){
								foreach (@$adminAnswers[$prioKey][ $key ][ $prioType ] as $k => $v ) {?>
									<?php 
										if(! in_array( @$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["inputType"],array("text", "textarea") ) 
											&& $k != "total" 
											&& @$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["options"][$v])
											echo '<td class="padding-10">'.$adminForm["scenario"][$prioType][ "json" ][ "jsonSchema" ][ "properties" ][$k]["options"][$v].'</td>'; ?>
								<?php }} ?>
							</tr>
						

						</table>
						<div class="col-xs-12 <?php echo $key?>_<?php echo $prioType ?>Comment"><?php echo (@$adminAnswers[$prioKey][ $key ][ $prioType ]["prioDesc"]) ? "Commentaire : <br/>".@$adminAnswers[$prioKey][ $key ][ $prioType ]["prioDesc"]:""; ?></div>
						<div style="clear:both"></div>
					</div>
					<hr>
					<?php } ?>
					

					
				</div>

			</div>
	<?php } ?>
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
    			answerUser : adminAnswers.user ,
    			total : true
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

//<<<<<<< HEAD
		if( adminAnswers[updateForm.section] && 
			adminAnswers[updateForm.section][updateForm.cat] &&
			adminAnswers[updateForm.section][updateForm.cat][updateForm.step])
			dyFObj.editStep( editForm, adminAnswers[updateForm.section][updateForm.cat][updateForm.step] );
// =======
// 		if(adminAnswers.answers &&
// 			adminAnswers.answers.priorisation && 
// 			adminAnswers.answers.priorisation[updateForm.cat] &&
// 			adminAnswers.answers.priorisation[updateForm.cat][updateForm.step])
// 			dyFObj.editStep( editForm, adminAnswers.answers.priorisation[updateForm.cat][updateForm.step] );
// >>>>>>> master
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