<?php
$cssJS = array(
    '/js/dataHelpers.js'
);
HtmlHelper::registerCssAndScriptsFiles($cssJS, Yii::app()->getModule( Yii::app()->params["module"]["parent"] )->getAssetsUrl() );

?>

<!-- start: PAGE CONTENT -->
<style type="text/css">
	#content-view-admin, #goBackToHome{
		display: none;
	}
	#content-social{
		min-height:700px;
		background-color: white;
	}
	.addServices, .show-form-new-circuit{
		display:none;
	}
</style>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding" id="content-social">
<?php 

if(@Yii::app()->session["userIsAdmin"] || Yii::app()->session["userIsAdminPublic"]){ 
		$title=(@Yii::app()->session["userIsAdmin"]) ? Yii::t("common","Administration portal") : Yii::t("common","Public administration portal");
		?>
	<div class="col-md-12 col-sm-12 col-xs-12" id="navigationAdmin">
		<div class="col-md-12 col-sm-12 col-xs-12 text-center">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/LOGOS/CO2/logo-min.png" 
	                     class="" height="100"><br/>
	         <h3><?php echo $title ?></h3>
   		</div> 
		<ul class="list-group text-left no-margin">
		<?php if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )) { ?>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a href="javascript:;" class=" text-yellow" id="btn-members" style="cursor:pointer;">
					<i class="fa fa-user fa-2x"></i>
					<?php echo Yii::t("admin", "Members"); ?>
				</a>
			</li>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="text-green" id="btn-projects" style="cursor:pointer;" href="javascript:;">
					<i class="fa fa-upload fa-2x"></i>
					<?php echo Yii::t("common", "Project"); ?>
				</a>
			</li>
		</ul>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12 no-padding" id="goBackToHome">
		<a href="javascript:;" class="col-md-12 col-sm-12 col-xs-12 padding-20 text-center bg-orange" id="btn-home" style="font-size:20px;"><i class="fa fa-home"></i> Back to administrator home</a>
	</div>
	<div id="content-view-admin" class="col-md-12 col-sm-12 col-xs-12 no-padding"></div>
	<?php }else{ ?>
	<div class="col-md-12 col-sm-12 col-xs-12 text-center margin-top-50">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/LOGOS/CO2/logo-min.png" 
	                     class="" height="100"><br/>
	         <h3><?php echo Yii::t("common","Administration portal") ?></h3>
   		</div>
		<div class="col-md-10 col-sm-10 col-xs-10 alert-danger text-center margin-top-20"><strong><?php echo Yii::t("common","You are not authorized to acces adminastrator panel ! <br/>Connect you or contact us in order to become admin system") ?></strong></div>
	<?php } ?>
</div>
<!-- end: PAGE CONTENT-->
<script type="text/javascript">
	//	initKInterface(); 
	var edit=true;
	var urlPage = "";
	var idForm="<?php echo @$_GET['id']; ?>";
	var subView="<?php echo @$_GET['view']; ?>";
	var dir="<?php echo @$_GET['dir']; ?>";
	jQuery(document).ready(function() {
		urlPage = baseUrl+'/'+activeModuleId+"/co/admin/";
		bindAdminButtonMenu();
		getAdminSubview(subView, dir);
	});

	function getAdminSubview(sub, dir){ 
		console.log("getProfilSubview", sub, dir);
		if(sub!=""){
			if(sub=="members")
				loadMembers();
			else if(sub=="projects")
				loadProjects();
		} else
			loadIndex();
	}
	function bindAdminButtonMenu(){
		console.log("bindAdminButtonMenu");
		$("#btn-home").click(function(){
			location.hash=urlPage;
			loadIndex();
		});

		$("#btn-members").click(function(){
			//location.hash=urlPage+"/view/members";
			window.location.replace(urlPage+"view/members");
			loadMembers();
		});

		$("#btn-projects").click(function(){
			//location.hash=hashUrlPage+".view.answers";
			window.location.replace(urlPage+"view/answers");
			loadProjects();
		});
	}

	function loadIndex(){
		console.log("loadIndex");
		initDashboard(true);
	}

	function loadMembers(){
		console.log("loadMembers");
		initDashboard();
		var url = "co/members/id/"+idForm;
		$("#goBackToHome").show(700);
		ajaxPost('#content-view-admin', baseUrl+'/'+activeModuleId+'/'+url, null, function(){},"html");

	}

	function loadProjects(){
		console.log("loadProjects");
		initDashboard();
		var url = "co/answers/id/"+idForm;
		$("#goBackToHome").show(700);
		ajaxPost('#content-view-admin', baseUrl+'/'+activeModuleId+'/'+url, null, function(){},"html");

	}
	
	function showLoader(id){
		$(id).html("<center><i class='fa fa-spin fa-refresh margin-top-50 fa-2x'></i></center>");
	}

	function inintDescs() {
		return true;
	}

	function initDashboard(home){
		if(home){
			$("#goBackToHome, #content-view-admin").hide(700);
			$("#navigationAdmin").show(700);
		} else {
			$("#navigationAdmin").hide(700);
			$("#goBackToHome, #content-view-admin").show(700);
			showLoader('#content-view-admin');
		}
	}
</script>

<?php } ?>