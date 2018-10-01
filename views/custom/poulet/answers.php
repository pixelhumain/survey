<?php
$cssJS = array(
    '/plugins/jquery.dynForm.js',
    '/plugins/jquery.dynSurvey.js',
); 
HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->request->baseUrl);
?>

<style type="text/css">
.simple-pagination li a, .simple-pagination li span {
    border: none;
    box-shadow: none !important;
    background: none !important;
    color: #2C3E50 !important;
    font-size: 16px !important;
    font-weight: 500;
}
.simple-pagination li.active span{
	color: #d9534f !important;
    font-size: 24px !important;	
}
</style>

<div class="panel panel-white col-lg-offset-1 col-lg-10 col-xs-12 no-padding margin-top-50">
	<div class="col-md-12 col-sm-12 col-xs-12 text-center">
		<h1><?php echo $form["title"] ?> <a href="/ph/survey/co/index/id/<?php echo $form["id"] ?>"><i class="fa fa-arrow-circle-right"></i></a> </h1>
		<div id="" class="" style="width:80%;  display: -webkit-inline-box;">
	    	<input type="text" class="form-control" id="input-search-table" 
	                        placeholder="search by name or by #tag, ex: 'commun' or '#commun'">
		    <button class="btn btn-default hidden-xs menu-btn-start-search-admin btn-directory-type">
		        <i class="fa fa-search"></i>
		    </button>
	    </div>
    </div>
	
	
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20 text-center"></div>
	<div class="panel-body">
		<div id="answerList">	
			
		</div>
	</div>
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20"></div>
</div>

<script type="text/javascript">

jQuery(document).ready(function() {
	dyFObj.elementData = <?php echo json_encode( $answers ) ?>;
	dyFObj[dyFObj.activeElem] = <?php echo json_encode( $form ) ?>;
    dyFObj.drawAnswers( "#answerList", { session : "#<?php echo @$_GET['session']; ?>" } );
});	
</script>