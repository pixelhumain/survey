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
			<h3><?php echo $title ?></h3>
   		</div> 
		<ul class="list-group text-left no-margin">
		<?php if( Role::isSuperAdmin(Role::getRolesUserId(Yii::app()->session["userId"]) )) { ?>

			<li class="list-group-item col-md-4 col-sm-6 ">
				<a class="text-green col-xs-12 text-center" id="btn-projects" style="cursor:pointer;" href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/answers/id/<?php echo $_GET['id']; ?>">
					<i class="fa fa-tasks fa-2x"></i>
					<?php echo Yii::t("common", "Les réponses"); ?>
				</a>
			</li>
			<li class="list-group-item col-md-4 col-sm-6 ">
				<a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/members/id/<?php echo $_GET['id']; ?>" class="col-xs-12 text-center text-yellow" id="btn-members" style="cursor:pointer;">
					<i class="fa fa-users fa-2x"></i>
					<?php echo Yii::t("admin", "Les membres"); ?>
				</a>
			</li>

			
		</ul>
	</div>
	<?php }else{ ?>
	<div class="col-md-12 col-sm-12 col-xs-12 text-center margin-top-50">
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/LOGOS/CO2/logo-min.png" 
	                     class="" height="100"><br/>
	         <h3><?php echo Yii::t("common","Administration portal") ?></h3>
   		</div>
		<div class="col-md-10 col-sm-10 col-xs-10 alert-danger text-center margin-top-20"><strong><?php echo Yii::t("common","You are not authorized to access this admin panel ! <br/>Login or contact an existing admin") ?></strong></div>
	<?php } ?>
</div>

<?php } ?>