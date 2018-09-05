<?php
$cssJS = array(
    
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
    // SHOWDOWN
	'/plugins/showdown/showdown.min.js',
	//MARKDOWN
	'/plugins/to-markdown/to-markdown.js',
	'/plugins/select2/select2.min.js' ,
	'/plugins/select2/select2.css',
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

<div class="container">

	<h2 class="text-center">

	<?php
	
	if( !@$_GET['role'] ){

		echo "Les thématique : <br/><br/>";
	}


	$lblRole = array();
	foreach ($roles as $key) {
		$lblRole[InflectorHelper::slugify($key)] = $key;
		?>

		<a href="<?php echo Yii::app()->createUrl("/survey/co/roles/id/".$_GET["id"]."/role/".InflectorHelper::slugify($key) ) ?>" class="btn btn-xs btn-default"><?php echo $key; ?></a>
	<?php } ?>
	</h2>

	<h1 class="text-center">
	<?php if( @$_GET['role'] ){ ?>thématique : <?php echo $lblRole[ $_GET['role'] ];  ?></h1>
	<br/>
	<h4>Les fiches actions <?php //if(@$_GET["role"])echo $lblRole[$_GET["role"]]; ?> </h4>
	<!-- dyFObj.openForm(actionForm) -->
	<a href="javascript:;" onclick="dyFObj.openForm('action','sub')" class="btn btn-primary"><i class="fa fa-plus"></i> Ajouter une FICHE ACTION</a>
	<div class="card-columns col-xs-12 padding-15 ">
		<?php
		if(@$actions){
			$c = 1;
			foreach ( $actions as $key => $value ) {?>
				<div class="card col-xs-12 col-md-4 margin-bottom-10">
					<div class="card-body padding-15 " style="border: 2px solid MidnightBlue;border-radius: 10px;min-height:265px;">
						<h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
							<i class="margin-5 fa fa-lightbulb fa-2x"></i><br><?php echo "#".$c." ".$value["name"] ?></h4>

						<span class="card-text text-center col-xs-12 no-padding margin-bottom-20"><?php echo @$value["description"] ?></span> 
						<a href="<?php echo Yii::app()->createUrl("/survey/co/action/id/".$_GET["id"]."/aid/".(string)$value["_id"]) ?>" class="btn btn-default answeredfalse" style="width:100%"> Détail </a>
						 <div class="margin-top-10 rounded-bottom mdb-color lighten-3 text-center pt-3">
						    <ul class="list-unstyled list-inline font-small">
						      <li class="list-inline-item pr-2 white-text"><i class="fa fa-clock-o pr-1"></i> <?php echo date("d/m/Y",@$value["created"]) ?></li>
						      <li class="list-inline-item pr-2"><i class="fa fa-comments-o pr-1"></i>12</li>
						      <li class="list-inline-item pr-2"><i class="fa fa-thumbs-up pr-1"> </i>21</li>
						      <li class="list-inline-item"><i class="fa fa-thumbs-down pr-1"> </i>5</li>
						    </ul>
						  </div>
					</div>
				</div>
			<?php 
			$c++;
			} 
		}?>

	</div>
	<hr>
	<?php 
	}
	
	if( @$_GET['role'] ){ 
		if( count(@$answers) ){ ?>
		

		<h4>Les projets associés à la thématique : <?php echo $lblRole[$_GET["role"]] ?></h4>

		<div class="card-columns col-xs-12 padding-15">
			
			<?php 
			$c = 1;
			foreach ( $answers as $key => $value ) {
				//var_dump($value["answers"]["cte2"]["project"]); echo "<br/>";
				?>

				<div class="card col-xs-12 col-md-4">
					<div class="card-body padding-15 bg-green " style="border: 2px solid MidnightBlue;border-radius: 10px;min-height:265px;">
						<h4 class="card-title bold text-center padding-5" style="border-bottom:1px solid white">
							<i class="margin-5 fa fa-lightbulb fa-2x"></i><br><?php echo "#".$c." ".$value["answers"]["cte2"]["project"]["name"] ?></h4>

						<span class="card-text text-center col-xs-12 no-padding margin-bottom-20"><?php echo @$value["answers"]["cte2"]["project"]["shortDescription"] ?></span> 
						<a href="<?php echo Yii::app()->createUrl('/survey/co/answer/id/'.$_GET["id"].'/user/'.$value["answers"]["cte2"]["user"]) ; ?>" class="btn btn-default answeredfalse" style="width:100%" target="_blank"> Voir Réponses </a>
						 <div class="margin-top-10 rounded-bottom mdb-color lighten-3 text-center pt-3">
						    <ul class="list-unstyled list-inline font-small">
						      <li class="list-inline-item pr-2 white-text"><i class="fa fa-clock-o pr-1"></i><?php echo date("d/m/Y",@$value["answers"]["cte2"]["created"]) ?></li>
						      <li class="list-inline-item pr-2"><i class="fa fa-comments-o pr-1"></i>12</li>
						      <li class="list-inline-item pr-2"><i class="fa fa-thumbs-up pr-1"> </i>21</li>
						      <li class="list-inline-item"><i class="fa fa-thumbs-down pr-1"> </i>5</li>
						    </ul>
						  </div>
					</div>
				</div>
			<?php 
			$c++;
			} ?>

		</table>

	<?php } else { ?>

		<h2 class="text-center margin-top-50"> <i class="fa fa-circle-thin text-red"></i> <span class="text-red">Aucunes réponses validées</span> pour le moment </h2>

	<?php	}
	} else { ?>
		<p>
		
		</p>
	<?php } ?>
</div>
<?php 

$r = "";
if(@$_GET["role"])
	$r = $lblRole[ $_GET['role'] ]; ?>
<script type="text/javascript">
var currentRoomId = "";
var form =<?php echo json_encode($form); ?>;
var contextData = { id : form.parentId, type : form.parentType } ;
var role = "<?php echo $r; ?>";


var actionForm = {
    jsonSchema : {
        title : "NOUVELLE FICHE ACTION",
        icon : "cogs",
        onLoads : {
	    	onload : function(data){
	    		dyFInputs.setHeader("bg-azure");
	    	}
	    },
	    save : function() { 
	  //   	mylog.log("type : ", $("#ajaxFormModal #type").val());
   //          var params = { 
   //             titre : $("#ajaxFormModal #type").val() , 
   //             desc : $("#ajaxFormModal #desc").val() , 
   //             projects : {}
   //          };

   //          if($(".addmultifield").length){
	  //           params.actions = [];
			// 	$.each($(".addmultifield"),function(i,k){
			// 		params.actions.push($(this).val());
			// 	});
			// }

			// if( $("#ajaxFormModal #id").val() ){
			// 	params.id = $("#ajaxFormModal #id").val();
			// }
   //          $.ajax({
   //            type: "POST",
   //            url: baseUrl+"/"+moduleId+'/element/save',
   //            data: params,
   //            success: function(data){
   //              if(data.result){
   //                	toastr.success( "SUCCESSFULLY  saved risk !");
   //                	mylog.dir(data);
   //                	dyFObj.closeForm();
                  	
   //                	var newRisk = '<td class="editRisk">'+data.map.type+'</td>'+
			// 			'<td class="editRisk">'+data.map.desc+'</td>'+
			// 			'<td class="editRisk">'+data.map.actions.join('<br>')+'</td>'+
			// 			'<td class="add'+data.id+'"><a href="javascript:;" data-id="'+data.id+'" class="addRiskBtn btn btn-primary"><i class="fa fa-plus"></i></a></td>';
			// 		if( params.id ){
			// 			$("#risk"+params.id).html(newRisk);
			// 			delete params.id;
			// 		}
			// 		else { 
			// 			newRisk = '<tr id="risk'+data.id+'" class="'+data.map.type+' lineRisk">'+
			// 				newRisk+"</tr>";
			// 			$("#riskCatalogList").append( newRisk );
			// 		}
			// 		riskObj.initAddBtn();
			// 		delete params.collection;
			// 		riskObj.catalog[ data.id ] = params; 
   //              }
   //              else {
   //                toastr.error(data.msg);
   //              }
   //              $.unblockUI();
   //            },
   //            dataType: "json"
   //          });
	    },
        properties : {
        	info : {
                inputType : "custom",
                html:"<p><i class='fa fa-info-circle'></i> Un risque Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>"
            },
            titre : {
	    		inputType : "text",
		    	label : "Titre de votre action",
		    	placeholder : "Titre de votre action",
		    	rules : {required : true} 
		    },
            desc : {
            	"label" : "Description",
                "inputType" : "textarea",
                "placeholder" : "décrivez l'action",
            },
            actions : {
                placeholder : "Quelles projets partenaires",
                label : "Projets partenaires",
		    	inputType : "array",
		        value : [],
		        init:function(){}
            }
        }
    }

};
</script>