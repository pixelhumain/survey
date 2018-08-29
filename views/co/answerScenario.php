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
    // SHOWDOWN
	'/plugins/showdown/showdown.min.js',
	//MARKDOWN
	'/plugins/to-markdown/to-markdown.js',
	'/plugins/select2/select2.min.js' ,
	'/plugins/select2/select2.css'
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
	/* ---------------------------------------------
	ETAPE DU SCENARIO
	---------------------------------------------- */

foreach ( $form[ $scenario ] as $k => $v ) {
	
	//echo count(array_keys( $v["form"] ));
	if(	!@$answers[$k]["answers"] || count( array_keys($answers[$k]["answers"])) != count(array_keys( $v["form"]["scenario"] )) )
	{
		foreach ( $v["form"]["scenario"] as $step => $f ) 
		{
			//echo $step;
			if( !@$answers[$k]["answers"][$step] )
			{
				$answers["answers"] = array();
				$answers["answers"][$step] = array();
				if( @$f["json"]['jsonSchema']["properties"] )
				{
					foreach ( $f["json"]['jsonSchema']["properties"] as $key => $value ) 
					{

						if (@$value["properties"]){

							$answers[$k]["answers"][$step][$key] = []; 
							$tmp = array();
							foreach ($value["properties"] as $ki => $vi) {
								$tmp[$ki] = "";
							}
							$answers[$k]["answers"][$step][$key][] = $tmp;
						}
						else 
							$answers[$k]["answers"][$step][$key] = "";
					}
				}
				$answers[$k]["created"] = time();
			} 

		}
		$v["form"]["title"] = $v["title"];
		$v["form"]["description"] = $v["description"];
		$v["form"]["icon"] = $v["icon"];
	}

	if(@$answers[$k]){  ?>
		
		<div class=" titleBlock col-xs-12 text-center" style="cursor:pointer; background-color: <?php echo (@$form["custom"]["color"]) ? $form["custom"]["color"] : "LightSeaGreen" ; ?>"  onclick="$('#<?php echo @$v["form"]["id"]; ?>').toggle();">
			<h1> 
			<?php echo $v["title"]; ?><i class="fa pull-right <?php echo @$v["icon"]; ?>"></i>
			</h1>
			
		</div>

		<div class='col-xs-12' id='<?php echo @$v["form"]["id"]; ?>'>

		<?php 
			foreach ( $answers[$k]["answers"] as $key => $value ) 
			{
 
			$editBtn = "";
			if(@$v["form"]["scenario"][$key]["saveElement"]) 
				$editBtn = "<a href='javascript:'  data-form='".$k."' data-step='".$key."' data-type='".$value["type"]."' data-id='".$value["id"]."' class='editStep btn btn-default'><i class='fa fa-pencil'></i></a>";
			else if(!@$v["form"]["scenario"][$key]["arrayForm"])
				$editBtn = ( (string)$user["_id"] == Yii::app()->session["userId"] ) ? "<a href='javascript:'  data-form='".$k."' data-step='".$key."' class='editStep btn btn-default'><i class='fa fa-pencil'></i></a>" : "";

			echo "<div class='col-xs-12'>".
					"<h2> [ step ] ".@$v["form"]["scenario"][$key]["title"]." ".$editBtn."</h2>";
			
			$head =  '<thead><tr>'.
						'<th>'.Yii::t("common","Question").'</th>'.
						'<th>Réponse</th>'.
					'</tr></thead>';
			if(@@$v["form"]["scenario"][$key]["arrayForm"]  ){
				$q = array_keys($v["form"]["scenario"][$key]["json"]["jsonSchema"]["properties"])[0];
				$head =  '<thead><tr>'.
						'<th>Ajouter une ligne</th>'.
						"<th><a href='javascript:;' data-form='".$k."' data-step='".$key."' data-q='".$q."' class='addAF btn btn-primary'><i class='fa fa-plus'></i> Ajouter</a></th>".
					'</tr></thead>';
				if( count($value[$q]) > 0 )
					$head = "";
			}

			echo '<table class="table table-striped table-bordered table-hover  directoryTable" id="panelAdmin">'.
				$head.
				'<tbody class="directoryLines">';
			if( @$v["form"]["scenario"][$key]["json"] )
			{
				$formQ = @$v["form"]["scenario"][$key]["json"]["jsonSchema"]["properties"];
				foreach ($value as $q => $a) 
				{
					if( @$formQ[$q]["inputType"] == "arrayForm" ){
						echo '<tr>';
						foreach ($formQ[$q]["properties"] as $ik => $iv) {
							echo "<th>".$iv["placeholder"]."</th>";
						}
						echo "<th><a href='javascript:;' data-form='".$k."' data-step='".$key."' data-q='".$q."' class='addAF btn btn-primary'><i class='fa fa-plus'></i> Ajouter</a></td>";
						echo '</tr>';
						foreach ($a as $sq => $sa) {
							echo '<tr>';
								foreach ($formQ[$q]["properties"] as $ik => $iv) {
									echo "<td>".$sa[$ik]."</td>";
								}
								echo "<td>".
									"<a href='javascript:;' data-form='".$k."' data-step='".$key."' data-q='".$q."' data-pos='".$sq."' class='editAF btn btn-default'><i class='fa fa-pencil'></i></a> ".
									"<a href='javascript:;' data-form='".$k."' data-step='".$key."' data-q='".$q."' data-pos='".$sq."' class='deleteAF btn btn-danger'><i class='fa fa-times'></i></a>".
								"</td>";
							echo '</tr>';
						}
					}
					else if(is_string($a)){
						echo '<tr>';
							echo "<td>".@$formQ[ $q ]["placeholder"]."</td>";
							$markdown = (strpos(@$formQ[ $q ]["class"], 'markdown') !== false) ? 'markdown' : "";
							echo "<td class='".$markdown."'>".$a."</td>";
						echo '</tr>';
					}else if(@$a["type"] && $a["type"]==Document::COLLECTION){
						$document=Document::getById($a["id"]);
						$path=Yii::app()->getRequest()->getBaseUrl(true)."/upload/communecter/".$document["folder"]."/".$document["name"];
						echo '<tr>';
							echo "<td>".@$formQ[ $q ]["placeholder"]."</td>";
							echo "<td>";
								echo "<a href='".$path."' target='_blank'><i class='fa fa-file-pdf-o text-red'></i> ".$document["name"]."</a>";
							echo "</td>";
						echo '</tr>';
					}
				}
			}
			else if (@$v["form"]["scenario"][$key]["saveElement"]) 
			{
				$el = Element::getByTypeAndId( $value["type"] , $value["id"] );

				echo '<tr>';
					echo "<td> ".Yii::t("common","Name")."</td>";
					echo "<td> <a target='_blank' class='btn btn-default' href='".Yii::app()->createUrl("#@".$el["slug"]).".view.detail'>".$el["name"]."</a></td>";
				echo '</tr>';

				if(@$el["type"]){
					echo '<tr>';
						echo "<td>".Yii::t("common","Type")."</td>";
						echo "<td>".$el["type"]."</td>";
					echo '</tr>';
				}

				if(@$el["description"]){
					echo '<tr>';
						echo "<td>".Yii::t("common", "Description")."</td>";
						echo "<td>".$el["description"]."</td>";
					echo '</tr>';
				}

				if(@$el["tags"]){
					echo '<tr>';
						echo "<td>".Yii::t("common","Tags")."</td>";
						echo "<td>";
						$it=0;
						foreach($el["tags"] as $tags){
							if($it>0)
								echo ", ";
							echo "<span class='text-red'>#".$tags."</span>";
							$it++;
						}
						echo "</td>";
					echo '</tr>';
				}

				if(@$el["shortDescription"]){
					echo '<tr>';
						echo "<td>".Yii::t("common","Short description")."</td>";
						echo "<td>".$el["shortDescription"]."</td>";
					echo '</tr>';
				}

				if(@$el["email"]){
					echo '<tr>';
						echo "<td>".Yii::t("common","Email")."</td>";
						echo "<td>".$el["email"]."</td>";
					echo '</tr>';
				}
				
				if(@$el["profilImageUrl"]){
					echo '<tr>';
						echo "<td>".Yii::t("common","Profil image")." </td>";
						echo "<td><img src='".Yii::app()->createUrl($el["profilImageUrl"])."' class='img-responsive'/></td>";
					echo '</tr>';
				}

				if(@$el["url"]){
					echo '<tr>';
						echo "<td>".Yii::t("common","Website URL")."</td>";
						echo "<td><a href='".$el["url"]."'>".$el["url"]."</a></td>";
					echo '</tr>';
				}

			}
			echo "</tbody></table></div>";
		}
	} else { ?>
	<div class="bg-red col-xs-12 text-center text-large text-white margin-bottom-20">
		<h1> <?php echo $k;?> </h1>
	<?php 
		echo "<h3 style='' class=''> <i class='fa fa-2x fa-exclamation-triangle'></i> ".Yii::t("surveys","This step {num} hasn't been filed yet",array('{num}'=>$k))."</h3>".
			"<a href='".Yii::app()->createUrl('survey/co/index/id/'.$k)."' class='btn btn-success margin-bottom-10'>".Yii::t("surveys","Go back to this form")."</a>";

	}
	echo "</div>";

?>

<script type="text/javascript">
//if(typeof form == "undefined ")
var form = <?php echo json_encode($form); ?>;
//if(typeof answers == "undefined ")
var answers  = <?php echo json_encode($answers); ?>;

var scenarioKey = "<?php echo $scenario ?>";
var answerCollection = "<?php echo @$answerCollection ?>";
var answerId = "<?php echo @$answerId ?>";


$(document).ready(function() { 
	
	$('#doc').html( dataHelper.markdownToHtml( $('#doc').html() ) );
	
	$.each($('.markdown'),function(i,el) { 
		$(this).html( dataHelper.markdownToHtml( $(this).html() ) );	
	});

	$('.editStep').off().click(function() { 

		//editing typed elements like projects, organizations
		if( $(this).data("type") )
		{
			//alert($(this).data("type")+" : "+$(this).data("id"));
			updateForm = {
				form : $(this).data("form"),
				step : $(this).data("step"),
				type : $(this).data("type"),
				id : $(this).data("id"),
				path : modules.co2.url + form[scenarioKey][ $(this).data("form") ].form[scenarioKey][$(this).data("step")].path	
			};

			var subType = "";
			if( $(this).data("type") == "project" ){
				subType = "project2";
				modules.project2 = {
			        form : modules.co2.url+form[scenarioKey][$(this).data("form")].form[scenarioKey][$(this).data("step")].path
			    };
			} else if( $(this).data("type") == "organization" ){
				subType = "organization2";
				modules.organization2 = {
			        form : modules.co2.url+form[scenarioKey][$(this).data("form")].form[scenarioKey][$(this).data("step")].path
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

			console.log("path",scenarioKey,$(this).data("form"),$(this).data("step"));
			var editForm = form[scenarioKey][$(this).data("form")].form["scenario"][$(this).data("step")].json;

			editForm.jsonSchema.onLoads = {
				onload : function(){
					dyFInputs.setHeader("bg-dark");
					$('.form-group div').removeClass("text-white");
					dataHelper.activateMarkdown(".form-control.markdown");
				}
			};
			
			editForm.jsonSchema.save = function(){
				//alert("save");
				data = {
	    			formId : updateForm.form,
	    			answerSection : updateForm.form+".answers."+updateForm.step ,
	    			answers : getAnswers(editForm , true)
	    		};
	    		
	    		var urlPath = baseUrl+"/survey/co/update";
	    		if(answerCollection) {
	    			//use case when answers are in a different collection than answers
	    			//ex : ficheAction
	    			data.collection = answerCollection;
	    			data.id = answerId;
	    			urlPath = baseUrl+"/survey/co/update2";
	    		}
	    		console.log("save",data);

	    		$.ajax({ type: "POST",
			        url: urlPath,
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
			console.log("editForm",editForm,updateForm,editData);
			dyFObj.editStep( editForm , editData);	
		}
	});

	$('.deleteAF').off().click(function() { 
		arrayForm.del($(this).data("form"),$(this).data("step"),$(this).data("q"),$(this).data("pos"));
	});

	$('.addAF').off().click(function() { 
		arrayForm.add($(this).data("form"),$(this).data("step"),$(this).data("q"));
	});

	$('.editAF').off().click(function() { 
		arrayForm.edit($(this).data("form"),$(this).data("step"),$(this).data("q"),$(this).data("pos"));
	});
});

function getAnswers(dynJson)
{
	var editAnswers = {};
	$.each( dynJson.jsonSchema.properties , function(field,fieldObj) { 
        console.log($(this).data("step")+"."+field, $("#"+field).val() );
        if( fieldObj.inputType ){
            if(fieldObj.inputType=="uploader"){
         		if( $('#'+fieldObj.domElement).fineUploader('getUploads').length > 0 ){
					$('#'+fieldObj.domElement).fineUploader('uploadStoredFiles');
					editAnswers[field] = "";
            	}
            } else {
            	console.log(field,$("#"+field).val());
            	editAnswers[field] = $("#"+field).val();
            }
        }
    });
    
	
	console.log("editAnswers",editAnswers);
    return editAnswers;
}

var arrayForm = {
	form : null,
	buildFormSchema : function(f, k, q) { 
		arrayForm.form = {
			jsonSchema : {
				title : form[scenarioKey][f].form.scenario[k].json.jsonSchema.title,
				icon : form[scenarioKey][f].form.scenario[k].json.jsonSchema.icon,
				onLoads : {
					onload : function(){
						dyFInputs.setHeader("bg-dark");
						$('.form-group div').removeClass("text-white");
						dataHelper.activateMarkdown(".form-control.markdown");
					}
				},
				save : function() { 
					data = {
		    			formId : f,
		    			answerSection : f+".answers."+k+"."+q ,
		    			arrayForm : true,
		    			answers : getAnswers(arrayForm.form , true)
		    		};
		    		
		    		data.collection = answerCollection;
	    			data.id = answerId;
	    			urlPath = baseUrl+"/survey/co/update2";
		    		
		    		console.log("save",data);

		    		$.ajax({ type: "POST",
				        url: urlPath,
				         data: data,
						type: "POST",
				    }).done(function (data) {
				    	window.location.reload(); 
				    });
				},
				properties : form[scenarioKey][f].form.scenario[k].json.jsonSchema.properties[q].properties
			}
		};
		console.log("buildFormSchema AF form",arrayForm.form);
		
	},
	add : function (f, k, q) { 
		console.log("add AF",f, k, q);
		arrayForm.buildFormSchema(f,k,q);
		dyFObj.openForm( arrayForm.form );
	},
	del : function  (f,k,q,pos) { 
		console.log("del AF",f,k,q,pos);
		data = {
			formId : f,
			answerSection : f+".answers."+k+"."+q+"."+pos ,
			answers : null,
			pull : f+".answers."+k+"."+q
			
		};
		
		// if(answers[f].answers[k][q].length > 1)
		// 	data.answerSection = data.answerSection+"."+pos;

		data.collection = answerCollection;
		data.id = answerId;
		urlPath = baseUrl+"/survey/co/update2";
		
		console.log("save",data);

		$.ajax({ type: "POST",
	        url: urlPath,
	         data: data,
			type: "POST",
	    }).done(function (data) {
	    	window.location.reload(); 
	    });
	},
	edit : function  (f,k, q,pos) { 
		console.log("edit AF",f,k,q,pos);
	},
}

</script>

<?php } ?>