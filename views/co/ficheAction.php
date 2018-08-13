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
		<table border="1" id="riskList"  class="text-red text-center bold" style="margin:0px auto;">
			<tr>
				<th class="padding-10">Type</th>
				<th class="padding-10">Danger</th>
				<th class="padding-10">Actions</th>
				<th class="padding-10">Probabilité</th>
				<th class="padding-10">Gravité</th>
				<th class="padding-10">Poids</th>
				<th class="padding-10">Remove</th>
			</tr>
			<?php 
			$riskWeight = array(
					"11" => array( "w" => 1 , "c" => "lightGreen"),
					"12" => array( "w" => 2 , "c" => "lightGreen"),
					"13" => array( "w" => 3 , "c" => "lightGreen"),
					"14" => array( "w" => 4 , "c" => "yellow"),
					"21" => array( "w" => 5 , "c" => "lightGreen"),
					"22" => array( "w" => 6 , "c" => "lightGreen"),
					"23" => array( "w" => 7 , "c" => "yellow"),
					"24" => array( "w" => 8 , "c" => "red"),
					"31" => array( "w" => 9 , "c" => "lightGreen"),
					"32" => array( "w" => 10 , "c" => "yellow"),
					"33" => array( "w" => 11 , "c" => "red"),
					"34" => array( "w" => 12 , "c" => "red"),
					"41" => array( "w" => 13 , "c" => "yellow"),
					"42" => array( "w" => 14 , "c" => "red"),
					"43" => array( "w" => 15 , "c" => "red"),
					"44" => array( "w" => 16 , "c" => "red")
				);
			$totalWeight = 0;
			foreach ($adminAnswers["risks"] as $key => $value) {?>
				<tr id="risk<?php echo $key?>">
					<td><?php echo $riskTypes["list"][ $value["type"] ]["title"] ?></td>
					<td><?php echo $value["desc"]?></td>
					<td>
					<?php foreach ($value["actions"] as $act) {
						echo $act."<br/>";
					 } ?>
					</td>
					<td><?php echo $value["probability"]?></td>
					<td><?php echo $value["gravity"]?></td>
					<td style="color:black; background-color:<?php echo $riskWeight[$value["probability"].$value["gravity"]]["c"]?> "><?php echo $value["weight"]; $totalWeight += (int)$value["weight"];?></td>
					<td><a href="javascript:;" onclick='$(this).parent().parent().remove()' class="addRiskBtn btn btn-danger"><i class="fa fa-times"></i></a></td>
				</tr>
			<?php } ?>
		</table>
		<div id="toto"></div>
	</div>
	<div id="riskCatalogue" class=" padding-10"  style="display:none;border:1px solid  #ccc">

		<h2 class="text-center">Catalogue des risques<a href="javascript:;" onclick="$('#riskCatalogue').toggle()" class="pull-right "><i class="text-red fa fa-times"></i></a></h2>
		<div class="text-center margin-bottom-20">
		<?php 
			foreach ($riskTypes["list"] as $key => $v) {?>
				<a href="javascript:;" onclick="showType('<?php echo $key; ?>')" class="btn btn-xs btn-default"><?php echo $v["title"]; ?></a>
			<?php } ?>
			<a href="javascript:;" onclick="dyFObj.openForm(riskForm)" class="btn btn-xs btn-danger"><i class="fa fa-plus"></i> AJOUTER UN RISQUE</a>
			<input type="text" id="searchRisks" name="searchRisks" style="width:50%;margin-top: 10px" placeholder="Chercher et filtrer les risques "/>
		</div>
		<style type="text/css">
			td,th {padding:10px;}
		</style>
		<table border="1" id="riskCatalogList" class=" text-center bold margin-bottom-20" style="margin:0px auto;">
			<tr>
				<th>Type</th>
				<th>Danger</th>
				<th>Actions</th>
				<th>Ajouter ce risque</th>
			</tr>
			<?php foreach ($riskCatalog as $key => $value) {
				$c = (@$adminAnswers["risks"][$key]) ? "hide" :"" ;
				?>
				<tr id="risk<?php echo $key?>" class="<?php echo $value["type"] ?> lineRisk">
					<td><?php echo (@$riskTypes["list"][$value["type"]]) ? $riskTypes["list"][$value["type"]]["title"]:$value["type"] ?></td>
					<td><?php echo $value["desc"]?></td>
					<td>
					<?php 
					if(@$value["actions"]){
						foreach ($value["actions"] as $act) {
							echo $act."<br/>";
						 } 
					 }?>
					</td>
					<td><a href="javascript:;" data-id="<?php echo $key?>" class="<?php echo $c ?> addRiskBtn btn btn-primary"><i class="fa fa-plus"></i></a></td>
				</tr>
			<?php } ?>
			
			
		</table>
		<a href="javascript:;" onclick="dyFObj.openForm(riskForm)" class="btn btn-danger"><i class="fa fa-plus"></i>AJOUTER UN RISQUE</a>
		
	</div>
</div>

<div class="form-probGrav" style="display:none;">
  <form class="inputprobGrav" role="form">
    <div class="form-group">
      <label for="probability">Probabilité</label>
      <select class="form-control" id="probability" name="probability">
      	<option value="0">Quelle probabilité d'arriver ?</option>
      	<option value="1">Faible</option>
      	<option value="2">Moyenne</option>
      	<option value="3">Forte</option>
      	<option value="4">Très Forte</option>
      </select>
    </div>
    <div class="form-group">
      <label for="gravity">Gravité</label>
      <select class="form-control" id="gravity" name="gravity">
      <option value="0">Quel serait l'impact de ce risque ?</option>
      <option value="1">Faible</option>
      	<option value="2">Moyenne</option>
      	<option value="3">Forte</option>
      	<option value="4">Très Forte</option>
      </select>
    </div>
  </form>
</div>
<script type="text/javascript">

$(document).ready(function() { 

	$("#searchRisks").on("keyup", function() {
	    var value = $(this).val().toLowerCase();
	    $("#riskCatalogList tr").filter(function() {
	      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
	});

	riskObj.initAddBtn();
});


function showType (type) { 
	$(".lineRisk").hide();
	$("."+type).show();
}


var riskObj = {
	riskTypes : <?php echo json_encode($riskTypes); ?>,
	selectedRisks : {},
	riskWeight : <?php echo json_encode($riskWeight); ?>,
	riskCatalog : <?php echo json_encode($riskCatalog); ?>,
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
			            modal.modal("hide");
			            console.log("riskObj.selectedRisks",riskObj.selectedRisks);
						$("#noriskTtile").hide();
						$("#riskList").show();
						var line = "<tr>"+
						"<td>"+riskObj.selectedRisks[ riskId ].type+"</td>"+
						"<td>"+riskObj.selectedRisks[ riskId ].desc+"</td>"+
						"<td>"+riskObj.selectedRisks[ riskId ].actions.join("<br/>")+"</td>"+
						"<td>"+riskObj.selectedRisks[ riskId ].probability+"</td>"+
						"<td>"+riskObj.selectedRisks[ riskId ].gravity+"</td>"+
						"<td style='color:black;background-color:"+riskObj.riskWeight[riskObj.selectedRisks[ riskId ].probability+""+riskObj.selectedRisks[ riskId ].gravity].c+"'>"+riskObj.selectedRisks[ riskId ].weight+"</td>"+
						"<td><a href='javascript:;' class='btn btn-danger' onclick='riskObj.cancelRisk()'><i class='fa fa-times'></i></a></td></tr>";
						$("#riskList").append( line );
						delete riskObj.selectedRisks[ riskId ]["_id"];
						riskObj.selectedRisks[ riskId ].addByUser = userId;
						data={
			    			formId : form.id,
			    			answerSection : "risks."+riskId ,
			    			answers : riskObj.selectedRisks[ riskId ],
			    			answerUser : adminAnswers.user 
			    		};
			    		console.log("saving",data);
			          	$.ajax({ 
			          		type: "POST",
					        url: baseUrl+"/survey/co/update",
					        data: data
					    }).done(function (data) { 
					    	toastr.success('risk successfully saved!');
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
				riskObj.selectedRisks[ $(this).data("id") ] = riskObj.riskCatalog[ $(this).data("id") ];
				riskObj.promptProbGrav( $(this).data("id") );
				$(this).remove();
			}
		});
	}
};
var riskForm = {
    jsonSchema : {
        title : "NOUVEAU RISQUE",
        icon : "warning",
        onLoads : {
	    	onload : function(data){
	    		dyFInputs.setHeader("bg-red")
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


            $.ajax({
              type: "POST",
              url: baseUrl+"/"+moduleId+'/element/save',
              data: params,
              success: function(data){
                if(data.result){
                  	toastr.success( "SUCCESSFULLY  saved risk !");
                  	mylog.dir(data);
                  	dyFObj.closeForm();
                  	var newRisk = '<tr id="risk'+data.id+'" class="'+data.map.type+' lineRisk">'+
						'<td>'+riskObj.riskTypes.list[data.map.type].title+'</td>'+
						'<td>'+data.map.desc+'</td>'+
						'<td>'+data.map.actions.join('<br>')+'</td>'+
						'<td><a href="javascript:;" data-id="'+data.id+'" class="addRiskBtn btn btn-primary"><i class="fa fa-plus"></i></a></td></tr>';
					$("#riskCatalogList").append( newRisk );
					initAddBtn();
					delete params.collection;
					riskObj.riskCatalog[ data.id ] = params; 
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