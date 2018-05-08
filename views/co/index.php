<?php 
//assets from ph base repo
$cssJS = array(
    
    '/plugins/jquery.dynForm.js',
    '/assets/css/default/dynForm.css',

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
);
HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->getModule( Yii::app()->params["module"]["parent"] )->getAssetsUrl() );
?>
<a class="btn btn-danger pull-right " href="javascript:;" onclick="$('#todo').slideToggle()">show Todo</a>
<div class="container " >
    <div class="row" style="display:none" id="todo">
        <h1 class="text-center bold bg-green padding-15">Surveys Endpoints</h1>
        <ul>
        	<li><i class='fa fa-check-square-o'></i> <?php echo (Yii::app()->session["userId"]) ? "loggued In : ".Yii::app()->session["user"]["username"]." <i class='fa fa-unlock'></i>" : "<a href='/ph/connect' target='_blank'>not loggued <i class='fa fa-lock'></i></a>" ?></li>
            <?php if(@$_GET['id']){ ?>
            <li><?php echo "id : ".@$_GET["id"].", type : ".@$_GET["type"] ?></li>
            <?php } else { ?>
            <a class="btn btn-primary btn-xs " href='http://127.0.0.1/ph/survey/co?type=organizations&id=592e54d1539f2278258b456c'>set contextData</a>
            
            <?php } ?>
        	<li> <a class="btn btn-primary btn-xs " href="javascript:dyFObj.openForm('poi')">open Dyn Form</a>
                <ul class="text-red">
                    <li> bug CSS open Form</li>
                    <li> add global search for name input</li>
                    <li> test file upload </li>
                    <li> how to set the context Data </li>
                </ul>
            </li>
        	<li>open DynSurvey
                <ul>
                    <li>get dynSurvey from co2/assets/js/dynForm/commons.js</li>
                </ul>
            </li>
        	<li  class="text-red"> 
                Scenario<br/>
                <ul>
                    <li>log out before testing</li>
                    <li>1 step User : create account or Login</li>
                    <li>2 add an Element </li>
                    <li>3 answer survey</li>
                </ul></li>
        </ul>
    </div>

    <div id="commonsChart" class="formChart col-xs-12" >
        <h3 style="font-variant:small-caps;"><span class="stepFormChart"></span><?php echo Yii::t("chart","Evaluate") ?></h3>
        <form id="opendata"></form>
    </div>

</div>

<script type="text/javascript">
jQuery(document).ready(function() {
    getSurveyJson("commons");
});

var surveys = {}

function getSurveyJson(name) {
    mylog.log("getSurveyJson",name);
    if(jsonHelper.notNull( "surveys."+name))
        buildSurvey( buildSurveySections(surveys[name]) );
    else {
        var DSPath = parentModuleUrl+'/js/dynForm/'+name+'.js';
        mylog.log("getSurveyJson ajax",DSPath);
        $.ajax({
          type: "GET",
          url: DSPath,
          dataType: "json"
        }).done( function(data){
            mylog.log("getSurveyJson",data);
            surveys[name] = data;
            buildSurvey( buildSurveySections(data) );
            //toastr.success("values well updated");
        });
    }
}

function buildSurveySections(json){
    mylog.log( "buildSurveySections" );
    var surveyObj={};
    var i=1;
    $.each(json, function(e,form){
        surveyObj["section"+i]={dynForm : form, key : e};
        i++;
    });
    return surveyObj;
}

function buildSurvey(surveyJson) {  
    mylog.log("buildSurvey",surveyJson);
    var form = $.dynSurvey({
        surveyId : "#opendata",
        surveyObj : surveyJson,
        surveyValues : {},
        onLoad : function(){
            //$(".description1, .description2, .description3, .description4, .description5, .description6").focus().autogrow({vertical: true, horizontal: false});
        },
        onSave : function(params) {
            //mylog.dir( $(params.surveyId).serializeFormJSON() );
            var result = {};
            result[str]={};
            mylog.log(params.surveyObj);
            $.each( params.surveyObj,function(section,sectionObj) { 
                result[str][sectionObj.key] = {};
                mylog.log(sectionObj.dynForm.jsonSchema.properties);
                $.each( sectionObj.dynForm.jsonSchema.properties,function(field,fieldObj) { 
                    mylog.log(sectionObj.key+"."+field, $("#"+section+" #"+field).val() );
                    if( fieldObj.inputType ){
                        result[str][sectionObj.key][field] = {};
                        result[str][sectionObj.key][field] = $("#"+section+" #"+field).val();
                    }
                });
            });
            mylog.dir( result );
            $.ajax({
              type: "POST",
              url: params.savePath,
              data: {properties:result, id: "<?php echo $_GET["id"] ?>", type: <?php echo $_GET["type"] ?>},
              dataType: "json"
            }).done( function(data){
                toastr.success("values well updated') ?>");
            });
        },
        collection : "commonsChart",
        key : "SCSurvey",
        savePath : baseUrl+"/"+moduleId+"/chart/editchart"
    });
}
</script>
