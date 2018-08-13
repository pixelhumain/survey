<?php $cssJS = array(
    
    '/plugins/jquery.dynForm.js',
    
    '/plugins/jQuery-Knob/js/jquery.knob.js',
    '/plugins/jQuery-Smart-Wizard/js/jquery.smartWizard.js',
    '/plugins/jquery.dynSurvey/jquery.dynSurvey.js',

	'/plugins/jquery-validation/dist/jquery.validate.min.js',
    '/plugins/select2/select2.min.js' , 
    '/plugins/moment/min/moment.min.js' ,
    '/plugins/moment/min/moment-with-locales.min.js',

    // '/plugins/bootbox/bootbox.min.js' , 
    // '/plugins/blockUI/jquery.blockUI.js' , 
    
    '/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js' , 
    '/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css',
    '/plugins/jquery-cookieDirective/jquery.cookiesdirective.js' , 
    '/plugins/ladda-bootstrap/dist/spin.min.js' , 
    '/plugins/ladda-bootstrap/dist/ladda.min.js' , 
    '/plugins/ladda-bootstrap/dist/ladda.min.css',
    '/plugins/ladda-bootstrap/dist/ladda-themeless.min.css',
    '/plugins/animate.css/animate.min.css',
);

HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->request->baseUrl);
$cssJS = array(
    '/js/dataHelpers.js',
    '/js/sig/geoloc.js',
    '/js/sig/findAddressGeoPos.js',
    '/js/default/loginRegister.js'
);
HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->getModule( Yii::app()->params["module"]["parent"] )->getAssetsUrl() );
$cssJS = array(
'/assets/css/default/dynForm.css',

);
HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->theme->baseUrl);
?>

<?php
//assets from ph base repo
$cssAnsScriptFilesTheme = array(
	// SHOWDOWN
	'/plugins/showdown/showdown.min.js',
	//MARKDOWN
	'/plugins/to-markdown/to-markdown.js',
	'/plugins/select2/select2.min.js' ,
	'/plugins/select2/select2.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesTheme, Yii::app()->request->baseUrl);

//gettting asstes from parent module repo
$cssAnsScriptFilesModule = array( 
	'/js/dataHelpers.js',
	//'/css/md.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getModule( Yii::app()->params["module"]["parent"] )->getAssetsUrl() );

$cssAnsScriptFilesModule = array( 
	'/js/eligible.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getModule( "survey" )->getAssetsUrl() );

if( $this->layout != "//layouts/empty"){
	$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
	$this->renderPartial($layoutPath.'header',array("page"=>"ressource","layoutPath"=>$layoutPath));
}


	$canAdmin = Form::canAdmin($form["id"]);
	$showStyle = ( $canAdmin ) ? "display:none; " : "";
?>

<div class="panel panel-dark col-lg-offset-1 col-lg-10 col-xs-12 no-padding ">
	<div class="col-xs-12 text-center">
		
			<h2>
				<?php if( $canAdmin ){ ?>
				<a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/answers/id/<?php echo $form["id"]; ?>"> 
				<?php 
				} ?>
					<?php /*if(@$form["custom"]['logo']){ ?>
					<img class="img-responsive margin-20" style="vertical-align: middle; height:150px" src='<?php echo Yii::app()->getModule("survey")->assetsUrl.$form["custom"]['logo']; ?>'  >
					<?php } */ 
					
					echo @$answers["cte2"]["answers"]["project"]["name"]."<br/><small> par ".@$answers["cte1"]["answers"]["organization"]["name"]."</small>";//$form["title"]; 
					
				if( $canAdmin ){ ?>
				</a>
				<?php } ?> 
			</h2>
		
    </div>

	<div class="pageTable col-xs-12  text-center"></div>

		<div class="panel-body">
			<div>	
			<style type="text/css">
				.titleBlock{
					border-bottom: 1px solid #666;
				}

				.stepNumber i{margin-top: 8px}
			</style>

<?php 
/* ---------------------------------------------
	SECTION STEPPER WIZARD
	---------------------------------------------- */?>				
		
		<div id="wizard" class="swMain">
			<ul id="wizardLinks">
				<?php 
				$ct = 0;
				$currentStep = (@$adminAnswers["step"]) ? $adminAnswers["step"] : "" ;
				if($adminForm["scenarioAdmin"]){
				foreach ( @$adminForm["scenarioAdmin"] as $k => $v) { 
					$aClass = ( $currentStep != "") ? $currentStep : "";
					if( $aClass != "" && $currentStep != $k )
						$aClass == "class='done'";
					else if( $aClass != "" && $currentStep == $k )
						$aClass == "class='selected'";
					?>
					<li><a onclick="nextState($(this).attr('href'),$(this).attr('class'));" href="#<?php echo $k ?>" <?php echo $aClass ?> ><div class="stepNumber"><i class="fa  fa-<?php echo $v["icon"] ?>"></i></div><span class="stepDesc"> <?php echo $v["title"] ?> </span></a></li>	
				<?php } }?>
			</ul>
			<?php  ?>
			<div class="progress progress-xs transparent-black no-radius active">
				<div aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar partition-green step-bar">
					<span class="sr-only"> 0% Complete (success)</span>
				</div>
			</div>
		
			<div class="errorHandler alert alert-danger no-display">
				<i class="fa fa-remove-sign"></i> You have some form errors. Please check below.
			</div>

			
<div id='dossier' class='section0'>
<?php 
/* ---------------------------------------------
	SECTION DOSSIER
	---------------------------------------------- */

echo $this->renderPartial( "dossier",array("adminAnswers"=>$adminAnswers,
												"adminForm"=>$adminForm,
												"answers" => $answers,
												"form" => $form,
												"user" => $user,
												)); ?>
</div>

<?php 
	/* ---------------------------------------------
	SECTION ELIGIBILITé
	---------------------------------------------- */
 ?>


<div id='eligible' class='section1 hide'>

<?php if( $canAdmin ){ 
	echo $this->renderPartial( "eligible",array("adminAnswers"=>$adminAnswers,
												"adminForm"=>$adminForm,
												"answers" => $answers
												));
	}?>

</div>


<?php 
	/* ---------------------------------------------
	SECTION PRIORISATION
	---------------------------------------------- */ 
	$prioKey = $adminForm['key'];
?>


<div id='priorisation' class='section2 hide'>

<?php 
if( $canAdmin ){ 
	echo $this->renderPartial( "priority",array("adminAnswers"=>$adminAnswers,
												"adminForm"=>$adminForm,
												"form" => $form,
												"prioKey" => $prioKey
												));
	 
} ?>
</div>

<?php 
	/* ---------------------------------------------
	SECTION GESTION DES RISQUES
	---------------------------------------------- */
 ?>

<div id='risk' class='section3 hide'>
	
	<?php if( $canAdmin && $adminAnswers["step"] == "risk" ){ 
		echo $this->renderPartial( "risk",array("adminAnswers"=>$adminAnswers,
												"riskTypes"=>@$riskTypes,
												"riskCatalog"=>@$riskCatalog,
												));
	} ?>
</div>



</div>
</div>
</div>
</div>



<?php 
if(@$form["custom"]['footer']){
	echo $this->renderPartial( $form["custom"]["footer"],array("form"=>$form,"answers"=>$answers));
}
?>

<script type="text/javascript">
var form = <?php echo json_encode($form); ?>;
var adminForm = <?php echo json_encode($adminForm); ?>;
var answers  = <?php echo json_encode($answers); ?>;
var adminAnswers  = <?php echo json_encode($adminAnswers); ?>;
var rolesListCustom = <?php echo json_encode(@$roles); ?>;
var canAdmin = <?php echo $canAdmin; ?>;
var updateForm = null;

$(document).ready(function() { 
	
	$('#doc').html( dataHelper.markdownToHtml( $('#doc').html() ) );
	
	$.each($('.markdown'),function(i,el) { 
		$(this).html( dataHelper.markdownToHtml( $(this).html() ) );	
	});

	$('.editStep').click(function() { 

		if( $(this).data("type") )
		{
			//alert($(this).data("type")+" : "+$(this).data("id"));
			updateForm = {
				form : $(this).data("form"),
				step : $(this).data("step"),
				type : $(this).data("type"),
				id : $(this).data("id"),
				path : modules.co2.url + form.scenario[ $(this).data("form") ].form.scenario[$(this).data("step")].path	
			};

			var subType = "";
			if( $(this).data("type") == "project" ){
				subType = "project2";
				modules.project2 = {
			        form : modules.co2.url+form.scenario[$(this).data("form")].form.scenario[$(this).data("step")].path
			    };
			} else if( $(this).data("type") == "organization" ){
				subType = "organization2";
				modules.organization2 = {
			        form : modules.co2.url+form.scenario[$(this).data("form")].form.scenario[$(this).data("step")].path
			    };
			}

			dyFObj.editElement( $(this).data("type"), $(this).data("id"), subType );
		}
		else 
		{
			//alert($(this).data("form")+" : "+$(this).data("step"));
			updateForm = {
				form : $(this).data("form"),
				step : $(this).data("step")	
			};

			var editForm = form.scenario[$(this).data("form")].form.scenario[$(this).data("step")].json;
			editForm.jsonSchema.onLoads = {
				onload : function(){
					dyFInputs.setHeader("bg-dark");
					$('.form-group div').removeClass("text-white");
					dataHelper.activateMarkdown(".form-control.markdown");
				}
			};
			
			editForm.jsonSchema.save = function(){
				
				data={
	    			formId : updateForm.form,
	    			answerSection : updateForm.step ,
	    			answers : getAnswers(form.scenario[updateForm.form].form.scenario[updateForm.step].json),
	    			answerUser : adminAnswers.user 
	    		};
	    		
	    		console.log("save",data);
	    		
	    		$.ajax({ type: "POST",
			        url: baseUrl+"/survey/co/update",
			        data: data,
					type: "POST",
			    }).done(function (data) {
			    	if( $('.fine-uploader-manual-trigger').fineUploader('getUploads').length == 0 ){
				    	window.location.reload();
				    	updateForm = null;
				    } 
			    });
			};


			var editData = answers[$(this).data("form")]['answers'][$(this).data("step")];
			dyFObj.editStep( editForm , editData);	
		}
	});

	$('.adminStep').click(function() {

		updateForm = {
			form : $(this).data("form")	,
			category : $(this).data("section")+"."+$(this).data("category")	,
			cat : $(this).data("category"),
			step : $(this).data("step")	
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
    			answerSection : "answers."+updateForm.category+"."+updateForm.step ,
    			answerKey : "<?php echo $prioKey ?>" ,
    			answerStep : updateForm.cat ,
    			answers : getAnswers(adminForm.scenario[ updateForm.step ].json),
    			answerUser : adminAnswers.user ,
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
			    	if(data.total != null){
			    		$("#"+updateForm.cat+"Btn i").hide();

			    	}
			    	updateForm = null;
			    } 
		    });
		};

		dyFObj.editStep( editForm );	

	})
	
	bindAnwserList();

	initWizard();
});

function initWizard () { 
	$("#wizard").smartWizard({
	    selected: 0,
	    keyNavigation: true,
	    //enableAllSteps : true,
	    //onLeaveStep: function(){ console.log("leaveAStepCallback");},
	    onShowStep: function(obj, context)
	    {
	    	console.log("test onShowStep",dySObj.navBtnAction,context.toStep,context.fromStep,Math.abs( context.toStep - context.fromStep));
	    	if( !dySObj.navBtnAction ){
	        	$(".section0"+dySObj.activeSection).addClass("hide");
	        	dySObj.activeSection =  context.toStep -1 ;
				console.log("top wisard direct link",dySObj.activeSection);
				$(".section"+dySObj.activeSection).removeClass("hide");	

			}
			dySObj.animateBar(context.toStep);
	    },
	});

	if(canAdmin){
		var ix = 0;
		$.each(adminForm.scenarioAdmin, function(k,v) { 
			ix++;
			if( adminAnswers.step && k == adminAnswers.step ){
				$("#wizard").smartWizard("goToStep",ix);
				return false;
			}else{
				$("#wizard").smartWizard("enableStep",ix);
			}
		});
	}
//dySObj.animateBar();
}

function getAnswers(dynJson)
{
	//alert("get Answers");
	var editAnswers = {};
	var total = 0;
	if( $("."+updateForm.cat+"_"+updateForm.step+"Result") )
	{
		$("."+updateForm.cat+"_"+updateForm.step+"ResultHeadLabel").html('Résultats '+updateForm.step);	
		$("."+updateForm.cat+"_"+updateForm.step+"ResultTitle").html("");
		$("."+updateForm.cat+"_"+updateForm.step+"ResultWeight").html("");
		$("."+updateForm.cat+"_"+updateForm.step+"ResultAnswer").html('');
	}
	$.each( dynJson.jsonSchema.properties , function(field,fieldObj) { 
        console.log($(this).data("step")+"."+field, $("#"+field).val() );
        if( fieldObj.inputType ){
            if(fieldObj.inputType=="uploader"){
         		if( $('#'+fieldObj.domElement).fineUploader('getUploads').length > 0 ){
					$('#'+fieldObj.domElement).fineUploader('uploadStoredFiles');
					editAnswers[field] = "";
            	}
            }else{
            	editAnswers[field] = $("#"+field).val();
            	if( $("."+updateForm.cat+"_"+updateForm.step+"Result"))
            	{
            		if(!isNaN( parseInt($("#"+field).val()) ) ){
	            		$("."+updateForm.cat+"_"+updateForm.step+"ResultTitle").append( "<td class='padding-10'>"+field+"</td>" );
	            		$("."+updateForm.cat+"_"+updateForm.step+"ResultWeight").append( "<td>"+((fieldObj.weight) ? fieldObj.weight+"%" : "")+"</td>" );
	            		$("."+updateForm.cat+"_"+updateForm.step+"ResultAnswer").append( "<td>"+$("#"+field).val()+"</td>" );
	            		  	if(fieldObj.weight){
			  	          		var w = 1 + (parseInt(fieldObj.weight) / 100);
			  	          		console.log("w",w,"cal", parseFloat( parseInt( $("#"+field).val() ) / w ).toFixed(2) );
			  	          		total += parseFloat( parseFloat( parseInt( $( "#"+field ).val() ) / w ).toFixed(2) );
			  	          	}
			  	          	else 
			  	          		total += parseInt($("#"+field).val());
		  	        } else {
		  	        	//the field is a comment or a string 
						$("."+updateForm.cat+"_"+updateForm.step+"Comment").html("").append( "<h3>"+field+"</h3>"+dataHelper.markdownToHtml( $("#"+field ).val() ) );
		  	        }
	            }
            }
        }
    });
    
    $("."+updateForm.cat+"_"+updateForm.step+"Total").html( "[ Note : "+( parseFloat(total).toFixed(2) )+" ]" );
    $("."+updateForm.cat+"_"+updateForm.step+"TotalNum").html( parseFloat(total).toFixed(2) );
    $("."+updateForm.cat+"_"+updateForm.step+"ResultTitle").append( "<td class='bold'>Note</td>" );
	$("."+updateForm.cat+"_"+updateForm.step+"ResultWeight").append( "<td>100%</td>" );	
	$("."+updateForm.cat+"_"+updateForm.step+"ResultAnswer").append( "<td>"+( parseFloat(total).toFixed(2) )+"</td>" );

    editAnswers.total = total;

    
    $("."+updateForm.cat+"_Priorisation").removeClass('hide');	
    
    calcPrio( updateForm.cat );
	
	console.log("editAnswers",editAnswers);
    return editAnswers;
}

function calcPrio (key) 
{
	var t = 0;
	$("."+key+"_Total").each( function(i,v){ 
		console.log(i,v);
		t += parseFloat( $(v).html() );
	} );
	t = parseFloat( t / $("."+key+"_Total").length ).toFixed(2) ;
	//alert(t);
	$( "."+key+"_totalTotal" ).html( t );
	return false;
}

function showTableOrForm(key,type){
	$("."+key+"_DataTables").hide();
	$("#"+key+"_"+type+"Table").show();
}

function nextState(step,c) { 
	if( canAdmin && c =="disabled"){
		bootbox.dialog({
	      message: "Ce dossier passera à l'étape : "+step ,
	      title: "Cette action est irréversible, est vous sûr ?",
	      buttons: {
	        annuler: {
	          label: "Annuler",
	          className: "btn-default",
	          callback: function() {
	            console.log("Annuler");
	          }
	        },
	        danger: {
	          label: "Confirmer",
	          className: "btn-primary",
	          callback: function() {
	          	data={
	    			formId : form.id,
	    			answerSection : "step" ,
	    			answers : step.substring(1),
	    			answerUser : adminAnswers.user 
	    		};
	          	$.ajax({ 
	          		type: "POST",
			        url: baseUrl+"/survey/co/update",
			        data: data
			    }).done(function (data) { 
			    	window.location.reload();
			    });
	          }
	        },
	      }
	    });
	}
	return false;
 }

 function changeCategoryWeight(key,v) { 
 	if( canAdmin ){
 		bootbox.prompt(	{
	        title: "Dans ce projet que représente la catégorie "+key+" ?", 
	        value : v, 
	        callback : function(result){ 
	        	$.ajax({ 
	        		type: "POST",
			        url: baseUrl+"/survey/co/update",
			        data: {
		    			formId        : form.id,
		    			answerSection : "categories."+key ,
		    			answers       : result,
		    			answerUser : adminAnswers.user 
		    		}
			    }).done( function (data) { 
			    	console.log("data",data);
			    	alert();
			    	//window.location.reload();
			    });
	        }
	    });
	}
}

</script>

<?php 

/*

bug 
- [RAPHA] Rapatrier correction de dev sur master :
	- btn pour voir les réponses
	- list des réponse avec etape 
- page title + descriptif issue de la page TCO
- extraire les templates des etapes 
- [RAPHA] ajouter HomePage : http://www.tco.re/competences-et-projets/cte-contrat-de-transition-ecologique/le-contrat-de-transition-ecologique-du-territoire-de-la-cote-ouest
	Territoire Tropical Bioclimatique
		Eco-Construction tropicale 
		Ville jardin désirable et support de biodiversité 
	Territoire smart et décarbonné* 
		Production renouvelable 
		Maîtrise de l’énergie 
		Eco-mobilités 
	Territoire collaboratif écologique et solidaire* 
		Economie Sociale et solidaire 
		Economie circulaire et circuits courts
- PROJET SOUTENU par 
	- citoyen 
	- organisateur 
	- financeur 
	- donne un contexte au projet localement 
- changer de role 
- [RAPHA] btn mes parametres
- Gestion du risque 
	- pourcentage de risk : al ahauteur du risque le plus elevé
	- remove a risk ??? gestion d'etat d'un risque
		non , on enleve pas mais doit pouvoir évoluer 
		risque bloquant , affiche les risque dans la page dossier 
		le user pourra commenter avec une parade et ce sera visualisable sur la page liste des risques
	- quels historique de changement ?
	- pouvoir modifier les actions d'un risk 
	- sur le risque ajouter un commentaire
		yes
	- ajouter le user sur le risk associé + date
- [RAPHA] Calendrier cte2.2
- Syhthese par thematique avec la listes de plusieurs projets
- ajouter point et info de contacts
- ajouter les etapes remplis dans answerLists

- edit formualire 
- demande de complément d'info
- drive du dossier 
- chat du dossier 
- geoloc du projet et de la liste des projets


inscrit > paiement > Custom 
mutualisation d'un community manager


devis le port Site Web 
reproduire et améliorer 
	qui parle du port : mention pour tout 
	flux rss du quotidien le port dans le live 

nouveau projet
	liste d'action opérationnel AO
	devisable > validation et accepttion par les différents acteurs
	chaque AO et divisé en liste d'actions fonctionnelles AF
	3 niveau de recette 
		travailleur : j'ai terminé une AO 
		client : 
			je valide l'AO 
			je n evalide pas encore l'AO 
				commentaire et liste AF
					recevable ou non 

communauté 
	supprimer une invitation 


gestion des sessions
	nouvelle session 
	changer les dte start end 



Key Partnerships
Key Activities
Key Resources
Value Propositions
Customer Relationships
Channels
Customer Segments
Cost Structure
Revenue Streams



*/

 ?>

 





