<?php 
    Yii::app()->params["logoUrl"]=Yii::app()->getModule("eco")->assetsUrl."/images/custom/leport/tco.png";
    Yii::app()->params["logoUrl2"]=Yii::app()->getModule("eco")->assetsUrl."/images/custom/leport/tco.png";
?> 
<div class="row margin-top-20">
  <h1 class="text-dark text-center"> CONTRAT de TRANSITION ÉCOLOGIQUE DU TCO </h1>
  <div class="col-xs-7">
    <img class="img-responsive" src='<?php echo Yii::app()->getModule("eco")->assetsUrl; ?>/images/custom/leport/banner.png'> 
  </div>
  <div class="col-xs-5" >
    <img class="img-responsive" src='<?php echo Yii::app()->getModule("eco")->assetsUrl; ?>/images/custom/leport/tco.png'> 
  </div>
    <div class="col-xs-12" >
    
    <h2 class="text-center">
    <?php if(count($form["scenario"]) > count($answers)) { ?>
        Inscrivez votre <b> projet de transition écologique</b>
    <?php } else {?>
        Merci pour votre participation au CTE, <br/>
        Votre projet sera très prochainement évalué <br/>
        Et vous serez informé de la suite.
    <?php } ?>

      <?php if(!isset(Yii::app()->session['userId'])) { ?>
        <br/>
        <button class="btn btn-default margin-top-15" data-toggle="modal" data-target="#modalLogin">
          <i class="fa fa-sign-in"></i> <?php echo Yii::t("login","Log in") ?>
        </button>
        <button class="btn btn-link bg-red margin-top-15" data-toggle="modal" data-target="#modalRegister">
          <i class="fa fa-plus-circle"></i> <?php echo Yii::t("login","Create an account") ?>
         </button>
        
      <?php } ?>
    </h2>
  </div>
</div>
