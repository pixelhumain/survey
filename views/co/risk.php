<?php if( $canAdmin && array_search('risk', $steps) <= array_search($adminAnswers["step"], $steps)  ){ 


?>
<style type="text/css">
	td,th {padding:10px;text-align: center;}
	#riskCatalogList tr {cursor: pointer;}
</style>
<div class="col-xs-12 padding-20">
	<h1>Risques évalués ?</h1>
	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
	<br>
	<div class="padding-10 margin-bottom-20"  style="border:1px solid #ccc">

		<h2 class="text-center" >Liste des risques détectés <a href="#toto" onclick="$('#riskCatalogue').toggle()" class="btn btn-primary">CATALOGUE DES RISQUES</a></h2>
		<?php if( !@$adminAnswers["risks"]){ ?>
		<h3 id="noriskTtile" class=" text-center text-red">Aucun Risque detecté</h3>
		<?php } ?>
		<table border="1" id="riskList"  class="table table-striped table-bordered table-hover  directoryTable margin-bottom-20" style="width:100%;">
			<tr>
				<th>Qui et Quand</th>
				<th>Type</th>
				<th>Danger </th>
				<th>Actions </th>
				<th class="text-dark">Commentaire </th>
				<th>Probabilité</th>
				<th>Gravité</th>
				<th>Poids</th>
			</tr>

			<?php 
			$totalWeight = 0;
			if( @$adminAnswers["risks"] ){
				foreach ($adminAnswers["risks"] as $key => $value) {?>
					<tr id="srisk<?php echo $key?>">
						<td>
						<small><?php echo date('d/m/Y h:i',$value["date"])?></small>
							<br/><?php echo @$value["addUserName"]?></td>
						<td><?php echo $value["type"] ?></td>
						<td><?php echo $value["desc"]?></td>
						<td><?php foreach ($value["actions"] as $act) {
							echo $act."<br/>";
						 } ?></td>
						<td><?php echo @$value["comment"]?></td>
						<td><?php echo $value["probability"]?></td>
						<td><?php echo $value["gravity"]?></td>
						<td style="color:black; background-color:<?php echo Form::$riskWeight[$value["probability"].$value["gravity"]]["c"]?> "><?php echo $value["weight"]; $totalWeight += (int)$value["weight"];?></td>
						
					</tr>
			<?php } 
			}?>
		</table>
		<?php if( @$adminAnswers["risks"] ){ ?>
		<a href="javascript:;" onclick="riskObj.pingUserRisk()" class="btn btn-danger pull-left"> <i class="fa-thumbs-down fa"></i> Demande de complément</a>
		<?php } ?>
		<div id="toto" style="clear:both"></div>
	</div>
	<div id="riskCatalogue" class=" padding-10"  style="display:none;border:1px solid  #ccc">

		<h2 class="text-center">Catalogue des risques<a href="javascript:;" onclick="$('#riskCatalogue').toggle()" class="pull-right "><i class="text-red fa fa-times"></i></a></h2>
		<div class="text-center margin-bottom-20">
		
		<a href="javascript:;" onclick="showType('lineRisk')" class="btn btn-xs btn-default">Tous</a>
		<?php 
			if(@$riskTypes){
			foreach (@$riskTypes as $key) {?>
				<a href="javascript:;" onclick="showType('<?php echo InflectorHelper::slugify($key); ?>')" class="btn btn-xs btn-default"><?php echo $key; ?></a>
			<?php }
			} ?>
			<a href="javascript:;" onclick="dyFObj.openForm(riskForm)" class=" btn btn-xs btn-danger"><i class="fa fa-plus"></i> AJOUTER UN RISQUE</a><br/>
			<input type="text" id="searchRisks" name="searchRisks" style="width:50%;margin-top: 10px" placeholder="Chercher et filtrer les risques "/>
		</div>
		
		<table border="1" id="riskCatalogList" class="table table-striped table-bordered table-hover  directoryTable margin-bottom-20" style="width:100%">
			<tr>
				<th>Type</th>
				<th>Danger</th>
				<th>Actions</th>
				<th>Ajouter ce risque</th>
			</tr>
			<?php 
			if( @$riskCatalog ){
			foreach ($riskCatalog as $key => $value) {
				$c = (@$adminAnswers["risks"][$key]) ? "hide" :"" ;
				?>
				<tr id="risk<?php echo $key?>" data-id="<?php echo $key?>" class="<?php echo InflectorHelper::slugify($value["type"]) ?> lineRisk">
					<td class="editRisk"><?php echo $value["type"]?></td>
					<td class="editRisk"><?php echo $value["desc"]?></td>
					<td class="editRisk">
					<?php 
					if(@$value["actions"]){
						foreach ($value["actions"] as $act) {
							echo $act."<br/>";
						 } 
					 }?>
					</td>
					<td class="add<?php echo $key?>"><a href="javascript:;" data-id="<?php echo $key?>" class="<?php echo $c ?> addRiskBtn btn btn-primary"><i class="fa fa-plus"></i></a></td>
				</tr>
			<?php } }?>
			
			
		</table>
		<a href="javascript:;" onclick="dyFObj.openForm(riskForm)" class="btn btn-danger"><i class="fa fa-plus"></i>AJOUTER UN RISQUE</a>
		
	</div>
</div>

<div class="form-probGrav" style="display:none;">
  <form class="inputprobGrav" role="form">

    <div class="form-group">
      <label for="probability">Probabilité</label>
      <select class="form-control" id="probability" name="probability" onchange="colorTitle()">
      	<option value="0">Quelle probabilité d'arriver ?</option>
      	<option value="1">Faible</option>
      	<option value="2">Moyenne</option>
      	<option value="3">Forte</option>
      	<option value="4">Très Forte</option>
      </select>
    </div>

    <div class="form-group">
      <label for="gravity">Gravité</label>
      <select class="form-control" id="gravity" name="gravity" onchange="colorTitle()">
      <option value="0">Quel serait l'impact de ce risque ?</option>
      <option value="1">Faible</option>
      	<option value="2">Moyenne</option>
      	<option value="3">Forte</option>
      	<option value="4">Très Forte</option>
      </select>
    </div>

    <div class="form-group">
      <label for="comment">Commentaire</label>
      <br/><textarea type="text" id="comment" name="comment" style="width:100%"></textarea>
    </div>
	
	<div id="explainProbGrav" class="padding-10 bold"></div>

  </form>
</div>
<script type="text/javascript">

$(document).ready(function() { 

	$("#searchRisks").on("keyup", function() {
	    var value = $(this).val().toLowerCase();
	    $("#riskCatalogList tr").filter( function() {
	      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
	});

	$('.editRisk').click( function() { 
		dyFObj.editElement("risks", $(this).parent().data('id'),riskForm);
	})

	riskObj.initAddBtn();
});

function colorTitle () { 
	if( $('.inputprobGrav #probability').last().val() != "0" && $('.inputprobGrav #gravity').last().val() != "0" ){
		var col = riskObj.riskWeight[$('.inputprobGrav #probability').last().val()+""+$('.inputprobGrav #gravity').last().val()].c;
		bgcol = "white";
		txtcol = "black";
		msg = "";
		icon = "";
		var msgAttention = "<br/>Attention, cette note ne sera pas reversible une fois validé.";
		if(col == "lightGreen"){
			bgcol = "lightGreen";
			txtcol = "black";
			icon = "fa-eye";
			msg = "Il faudra simplement surveiller cet aspect du projet."+msgAttention;
		}
		else if(col == "orange"){
			bgcol = "orange";
			txtcol = "black";
			icon = " fa-envelope";
			msg = "Une simple confirmation devra assurer cet aspect du projet."+msgAttention;
		}
		else if(col == "red"){
			bgcol = "red";
			txtcol = "white";
			icon = "fa-warning";
			msg = "Le porteur devra justifier et proposer une parades à cet aspect du projet, il sera automatiquement informer et demander de répondre aprés cette action. "+msgAttention;
		}

		console.log("colorTitle",col ,icon ,msg );
		$(".bootbox-body #explainProbGrav").html( "<i class='pull-left fa fa-3x "+icon+"'></i> "+msg ).css( "background-color",bgcol ).css( "color",txtcol );
		
	}
}

function showType (type) { 
	$(".lineRisk").hide();
	$("."+type).show();
}


var riskObj = {
	selectedRisks : {},
	riskWeight : <?php echo json_encode(Form::$riskWeight); ?>,
	catalog : <?php echo json_encode($riskCatalog); ?>,
	//cancels a risk associated to a project
	cancel : {},
	promptProbGrav : function (riskId) { 
		var modal = bootbox.dialog({
	        message: $(".form-probGrav").html(),
	        title: "Pondérez ce risque.",
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
			            riskObj.selectedRisks[ riskId ].comment = $('.inputprobGrav #comment').last().val();
			            modal.modal("hide");
			            console.log("riskObj.selectedRisks",riskObj.selectedRisks);
						$("#noriskTtile").hide();
						$("#riskList").show();
						var line = "<tr id='srisk"+riskId+"'>"+
						"<td>"+userConnected.name+"</td>"+
						"<td>"+riskObj.selectedRisks[ riskId ].type+"</td>"+
						"<td>"+riskObj.selectedRisks[ riskId ].desc+"</td>"+
						"<td>"+riskObj.selectedRisks[ riskId ].actions.join("<br/>")+"</td>"+
						"<td>"+riskObj.selectedRisks[ riskId ].comment+"</td>"+
						"<td>"+riskObj.selectedRisks[ riskId ].probability+"</td>"+
						"<td>"+riskObj.selectedRisks[ riskId ].gravity+"</td>"+
						"<td style='color:black;background-color:"+riskObj.riskWeight[riskObj.selectedRisks[ riskId ].probability+""+riskObj.selectedRisks[ riskId ].gravity].c+"'>"+riskObj.selectedRisks[ riskId ].weight+"</td></tr>";
						$("#riskList").append( line );
						delete riskObj.selectedRisks[ riskId ]["_id"];
						riskObj.selectedRisks[ riskId ].addUserId = userId;
						riskObj.selectedRisks[ riskId ].addUserName = userConnected.name;
						

						data={
			    			formId : form.id,
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
					    	toastr.success('risk successfully saved!');
					    	$(".add"+riskId).html("");
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
	},
	initAddBtn : function() { 
		$('.addRiskBtn').off().click(function() { 
			if( riskObj.selectedRisks[$(this).data("id")] )
				bootbox.alert("Ce risque est deja déclaré.");
			else {
				//bootbox prompt for probabilité and gravité value
				riskObj.selectedRisks[ $(this).data("id") ] = riskObj.catalog[ $(this).data("id") ];
				riskObj.promptProbGrav( $(this).data("id") );
			}
		});
	},
	pingUserRisk : function() {
		var res = bootbox.dialog({
	        message: "Cette action informera le porteur du projet de venir justifier des actions ou des parades au(x) risque(s) évalué",
	        title: "Demande de complément d'information",
	        buttons: [
	          {
	            label: "Ok",
	            className: "btn btn-primary pull-left",
	            callback: function() {
	            	//ajout attribut sur answer.cte.infoRequest
	            	data={
		    			formId : form.id,
		    			answerSection : "infoRequest" ,
		    			answers : true,
		    			answerUser : adminAnswers.user ,
		    		};
		    		console.log("saving",data);
		          	$.ajax({ 
		          		type: "POST",
				        url: baseUrl+"/survey/co/update",
				        data: data
				    }).done(function (data) { 
				    	toastr.success('risk successfully saved!');
				    });
	            }
	          },
	          {
	            label: "Annuler",
	            className: "btn btn-default pull-left",
	            callback: function() {}
	          }
	        ]
	    });

	}
};

var riskForm = {
    jsonSchema : {
        title : "NOUVEAU RISQUE",
        icon : "warning",
        onLoads : {
	    	onload : function(data){
	    		dyFInputs.setHeader("bg-red");
	    	}
	    },
	    save : function() { 
	    	mylog.log("type : ", $("#ajaxFormModal #type").val());
            var params = { 
               type : $("#ajaxFormModal #type").val() , 
               desc : $("#ajaxFormModal #desc").val() , 
               collection : "risks"
            };

            if($(".addmultifield").length){
	            params.actions = [];
				$.each($(".addmultifield"),function(i,k){
					params.actions.push($(this).val());
				});
			}

			if( $("#ajaxFormModal #id").val() ){
				params.id = $("#ajaxFormModal #id").val();
			}
            $.ajax({
              type: "POST",
              url: baseUrl+"/"+moduleId+'/element/save',
              data: params,
              success: function(data){
                if(data.result){
                  	toastr.success( "SUCCESSFULLY  saved risk !");
                  	mylog.dir(data);
                  	dyFObj.closeForm();
                  	
                  	var newRisk = '<td class="editRisk">'+data.map.type+'</td>'+
						'<td class="editRisk">'+data.map.desc+'</td>'+
						'<td class="editRisk">'+data.map.actions.join('<br>')+'</td>'+
						'<td class="add'+data.id+'"><a href="javascript:;" data-id="'+data.id+'" class="addRiskBtn btn btn-primary"><i class="fa fa-plus"></i></a></td>';
					if( params.id ){
						$("#risk"+params.id).html(newRisk);
						delete params.id;
					}
					else { 
						newRisk = '<tr id="risk'+data.id+'" class="'+data.map.type+' lineRisk">'+
							newRisk+"</tr>";
						$("#riskCatalogList").append( newRisk );
					}
					riskObj.initAddBtn();
					delete params.collection;
					riskObj.catalog[ data.id ] = params; 
                }
                else {
                  toastr.error(data.msg);
                }
                $.unblockUI();
              },
              dataType: "json"
            });
	    },
        properties : {
        	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> Un risque Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>"
            },
            type : {
            	inputType : "tags",
				placeholder : "Selectionner ou créer",
				minimumInputLength : 0,
				values : ["technique",
					"fonctionnelOuTechnique",
					"organisationnel",
					"ressourceHumaine",
					"management",
					"planification",
					"moyens",
					"demarche",
					"contractuel",
					"fonctionnel"],
				label : "Type de Risque"
                /*"inputType" : "select",               
                "options" : {
                    "technique" : "Technique",
			        "fonctionnelOuTechnique" : "Fonctionnel ou technique",
			        "organisationnel" : "Organisationnel",
			        "ressourceHumaine" : "Ressource Humaine",
			        "management" : "Management",
			        "planification" : "Planification",
			        "moyens" : "Moyens",
			        "demarche" : "Démarche",
			        "contractuel" : "Contractuel",
			        "fonctionnel" : "Fonctionnel"
                }*/
            },
            desc : {
            	"label" : "Danger",
                "inputType" : "textarea",
                "placeholder" : "décrivez le risque",
            },
            actions : {
                placeholder : "Quelles actions ou solutions proposées",
                label : "Actions ou Solutions",
		    	inputType : "array",
		        value : [],
		        init:function(){}
            }
        }
    }

};
</script>
<?php } ?>