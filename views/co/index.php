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

<div class="container">
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
    	<li><a class="btn btn-danger btn-xs " href="javascript:dyFObj.openForm('poi')">open DynSurvey</a></li>
    	<li  class="text-red"> create tripple objective DynSurvey : login (check existence) + create orga (check existence) + answer survey </li>
    </ul>
</div>
