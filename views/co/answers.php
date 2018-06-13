<?php
//echo CHtml::scriptFile(Yii::app()->request->baseUrl. '/plugins/DataTables/media/js/jquery.dataTables.min.1.10.4.js');
//echo CHtml::cssFile(Yii::app()->request->baseUrl. '/plugins/DataTables/media/css/DT_bootstrap.css');
//echo CHtml::scriptFile(Yii::app()->request->baseUrl. '/plugins/DataTables/media/js/DT_bootstrap.js');
$cssAnsScriptFilesModule = array(
    '/plugins/jquery-simplePagination/jquery.simplePagination.js',
	'/plugins/jquery-simplePagination/simplePagination.css'
);
HtmlHelper::registerCssAndScriptsFiles($cssAnsScriptFilesModule, Yii::app()->getRequest()->getBaseUrl(true));

$layoutPath = 'webroot.themes.'.Yii::app()->theme->name.'.views.layouts.';
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
		<div>	
			<?php //var_dump($projects) ?>
			<table class="table table-striped table-bordered table-hover  directoryTable" id="panelAdmin">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Read Answers</th>
					</tr>
				</thead>
				<tbody class="directoryLines">
				<?php  foreach ($results as $key => $v) { ?>
					<tr>
						<td><?php echo $v["name"]; ?></td>
						<td><?php echo $v["email"]; ?></td>
						<td><a href="<?php echo "/ph/survey/co/answer/id/".(string)$v["_id"]; ?>" >Read</a></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			
		</div>
	</div>
	<div class="pageTable col-md-12 col-sm-12 col-xs-12 padding-20"></div>
</div>

<script type="text/javascript">

jQuery(document).ready(function() {
	

});	
</script>