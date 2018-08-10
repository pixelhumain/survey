<style type="text/css">
	.pubTpl .link-custom{
		background-color: #0095FF;
		color: white;
	}
	.pubTpl .link-custom:hover{
		background-color: white;
		color: #0095FF;
		border:2px solid #0095FF; 
	}
	@media (max-width: 767px) {
		.pubTpl{
			margin-bottom: 15px;
		}
	}

	@media (min-width: 768px) and (max-width: 979px){
		.pubTpl{
			margin-top: 30px;
		}
	}
</style>
<?php if(@$central){ ?>
<div class="col-xs-12 col-sm-12">
<div class="col-xs-12  col-sm-12 hidden-md hidden-lg bg-white shadow2 padding-20 pubTpl">
	<div class="col-xs-3 contain-image-pub no-padding">
		<img class="img-responsive" style="display: block; margin: 0 auto;" src="<?php echo Yii::app()->getModule("survey")->assetsUrl; ?>/images/custom/cte/contrats-de-transition-ecologique.png">
	</div>
	<div class="col-xs-9 text-center">
		<span class="bold text-dark col-xs-12 padding-10">Dans le cadre de l’avis d’appel à projets CTE du TCO,<br/> les acteurs économiques peuvent déclarer leurs projets en ligne,<br/> jusqu’au 18 août 2018</span>
		<a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/index/id/cte" target="_blank" class="btn col-xs-10 col-xs-offset-1 link-custom margin-top-10">Déposer votre projet</a>
	</div>
</div>
</div>
<?php }else{ ?>
<div class="col-md-12 hidden-sm hidden-xs bg-white shadow2 padding-10 pubTpl">
	<div class="col-xs-12 contain-image-pub no-padding">
		<img class="img-responsive" style="display: block; margin: 0 auto;" src="<?php echo Yii::app()->getModule("survey")->assetsUrl; ?>/images/custom/cte/contrats-de-transition-ecologique.png">
	</div>
	<div class="col-xs-12 text-center no-padding margin-top-5">
		<span class="bold text-dark margin-bottom-10">Dans le cadre de l’avis d’appel à projets CTE du TCO, les acteurs économiques peuvent déclarer leurs projets en ligne, jusqu’au 18 août 2018</span>
		<a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/index/id/cte" target="_blank" class="btn col-xs-12 link-custom margin-top-10">Déposer <span class="hidden-md">votre projet</span></a>
	</div>
</div>
<?php } ?>