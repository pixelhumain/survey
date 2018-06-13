<?php 
//assets from ph base repo
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
    
    
);

HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->request->baseUrl);
$cssJS = array(
'/js/dataHelpers.js',
);
HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->getModule( Yii::app()->params["module"]["parent"] )->getAssetsUrl() );
$cssJS = array(
'/assets/css/default/dynForm.css',
);
HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->theme->baseUrl);
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
                    <li> test an existing organosation scenario</li>
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
                    <li>show scenario steps</li>
                    <li>make steps dependant</li>
                    <li>1 step User : create account or Login</li>
                    <li>2 add an Element </li>
                    <li>3 answer survey</li>
                </ul></li>
            <li>Save Forms in collection "forms"</li>
            <li>Save > collections "answers" </li>
            <li>Home page d'un survey </li>
            <li class="text-red">Ideas : 
            <ul> 
                <li>Récompence de gamification pour avoir répondu</li>
                <li>steps > invite > survey > results</li>
                <li>ne pas répété les meme réponses</li>
                <li>view someones Q & A </li>
                <li>someone can choose on their Q & A public or private </li>
                <li>visualise a community who answered a survey (list + map)</li>
                <li>proposer des survey pour des observatoires</li>
                <li>observatoires d'une fillière</li>
                <li>question unique</li>
                <li>add to list of answered : [xxxx,xxx,xxx,...]</li>
            </ul></li>
        </ul>
    </div>

    <div id="surveyContent" class="formChart col-xs-12" >
        <h3 style="font-variant:small-caps;"><span class="stepFormChart"></span> <?php echo $form["title"] ?></h3>
         <div id="surveyBtn" class="margin-top-15"></div>
        <div id="surveyDesc">
            <h4><?php echo $form["description"] ?></h4>
        </div>
       
        <form id="ajaxFormModal"></form>
    </div>

</div>

<script type="text/javascript">

jQuery(document).ready(function() {
    //dySObj.getSurveyJson("commons",parentModuleUrl+'/js/dynForm/commons.js');
    //dySObj.getSurveyJson("commons",baseUrl+"/survey/co/form/id/commons");
    dySObj.surveyId = "#ajaxFormModal";
    dySObj.surveys = <?php echo json_encode( $form ) ?>;
    dySObj.surveys.json={};

    //scenario is a list of many survey definitions that can be put together in different ways
    //$("#surveyDesc").html("");
    if(dySObj.surveys.scenario){
        $("#surveyDesc").append("<h1>"+Object.keys(dySObj.surveys.scenario).length+" easy steps : </h1>");
        var prev = null;
        var step = 1;
        var surveyType = (dySObj.surveys.surveyType) ? dySObj.surveys.surveyType : null ;
        var str = "";

        //build front end interface 
        var sizeCol = 12 / Object.keys(dySObj.surveys.scenario).length;
        $.each(dySObj.surveys.scenario, function(i,v) { 
            icon = (v.icon) ? v.icon : "fa-square-o";
            str += '<div class="card col-xs-'+sizeCol+'" >'+
              //'<img src="https://unsplash.it/g/300">'+
              '<div class="card-body padding-15 bg-dark" style="border:6px solid #3071a9;">'+
                '<h4 class="card-title bold text-white text-center padding-5" style="border-bottom:1px solid white">'+
                    '<i class="margin-5 fa '+icon+' fa-2x"></i><br/>'+
                    step+'. '+v.title+
                '</h4>'+
                '<p class="card-text">'+v.description+'</p>';

            if( surveyType != "oneSurvey"  && ( prev == null || dySObj.surveys.answers[prev] == {} ) ) {
                dType = (v.type) ? v.type : "json" ;
                dynType = (v.dynType) ? v.dynType : "dynForm" ;
                str +='<a href="javascript:;" onclick="dySObj.openSurvey(\''+i+'\',\''+dType+'\',\''+dynType+'\')" class="btn btn-primary"  style="width:100%">C\'est parti <i class="fa fa-arrow-circle-right fa-2x "></i></a>';
            }
            str +='</div></div>';  
            prev = i;
            step++;
        }); 

        $("#surveyDesc").append("<div class='card-columns'>"+str+'</div>');
        
        if ( surveyType == "oneSurvey" ){
            //build survey json asynchronessly
            if(userId)
                $("#surveyBtn").append('<div class="margin-top-15 hidden" id="startSurvey"><a href="javascript:;" onclick="dySObj.openSurvey(null,null,\''+surveyType+'\')" class="btn btn-primary"  style="width:100%">C\'est parti <i class="fa fa-arrow-circle-right fa-2x "></i></a></div>');
            else 
                $("#surveyBtn").append('<div class="margin-top-15 hidden"><a href="javascript:;" onclick="" class="btn btn-danger">Login first to Access <i class="fa fa-arrow-circle-right fa-2x "></i></a></div>');
            if(dySObj.surveys.author == userId){
                $("#surveyBtn").append('<div class="margin-top-15" id="seeAnswers"><a href="/ph/survey/co/answers/id/'+dySObj.surveys.id+'" class="btn btn-default"  style="width:100%">All answers <i class="fa fa-list fa-2x "></i></a></div>');
            }
            dySObj.buildOneSurveyFromScenario();
        }

    } else {
        // other wise it's jsut one survey that can be shown
        dySObj.surveys.commons = <?php echo json_encode( $form ) ?>;  
        dyFObj.buildSurvey( dySObj.surveyId, dySObj.buildSurveySections( surveys["commons"].json) );
    }
});

/*
"login" : {
    "title" : "Identity",
    "description" : "please login to conintu please login to conintu please login ",
    "path" : "/surveys/login.js",
    "type" : "script",
    "icon" : "fa-vcard-o"
},
*/

</script>