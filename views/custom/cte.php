<?php 
    Yii::app()->params["logoUrl"]=Yii::app()->getModule("eco")->assetsUrl."/images/custom/leport/tco.png";
    Yii::app()->params["logoUrl2"]=Yii::app()->getModule("eco")->assetsUrl."/images/custom/leport/tco.png";
?> 
<style type="text/css">
  .banner-tce{
    position: absolute;
    background-color: gray;
    background-repeat: round;
    background-image: url(/pixelhumain/ph/assets/721d71b4/images/custom/leport/banner.png);
    border: none;
    height: 450px;
    /* padding: 50px; */
    overflow: hidden;
    left: -20px;
    right: -20px;
    filter: saturate(12%) blur(2px) sepia(100%);
  }
  .content-header{
    height: 375px;
    margin-top: 75px;
    border-radius: 5px 5px 0px 0px;
    border: 1px solid #ccc;
    background-color: rgba(250,250,250,0.9)
  }
  .logo-survey {
    overflow: hidden;
    max-height: 373px;
  }
  .logo-survey .img-responsive{
    display: block;
    width: 100%;
    min-width: 100%;
    min-height: 375px;
  }
  .header-survey{
   height: : 373px;
   color: #333; 
  }
</style>
<div class="row margin-top-20">
  <div class="banner-tce">
  </div>
  <div class="content-header col-xs-offset-1 col-xs-10 no-padding">
      <div class="col-xs-5 logo-survey no-padding">
          <img class="img-responsive" src='<?php echo Yii::app()->getModule("eco")->assetsUrl; ?>/images/custom/leport/tco.png'> 
      </div>
      <div class="col-xs-7 header-survey text-center padding-20" >
        <h4 class="text-center padding-20"> Contrat de Transition Écologique Du TCO </h4>
        <?php if(@$form["description"]) echo "<span class='text-center pull-left padding-20'>".$form["description"]."</span>" ?>
        <?php if(!isset(Yii::app()->session['userId'])) { ?>
        <br/>
        <button class="btn btn-default bg-green margin-top-15" data-toggle="modal" data-target="#modalLogin">
          <i class="fa fa-sign-in"></i> <?php echo Yii::t("login","Log in") ?>
        </button>
        <button class="btn btn-link margin-top-15" data-toggle="modal" data-target="#modalRegister">
          <i class="fa fa-plus-circle"></i> <?php echo Yii::t("login","Create an account") ?>
         </button>
        
        <?php }else{ 
            $count=count($answers);
            $label=($count > 0) ? "Reprendre le dossier" : "Déposer une candidature"; 
          ?>
          <a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/index/id/cte<?php echo $count+1 ?>" class="btn bg-green-k answered<?php echo $count+1 ?>"  style="width:90%"><i class="fa fa-sign-in"></i> <?php echo $label ?></a>
        <?php  } ?>
      </div>
  </div>
  <div class="col-xs-offset-1 col-xs-10 shadow2" >
    <?php if(@$form["description"]) echo "<span class='text-center pull-left padding-20'>".$form["description"]."</span>" ?>
    <h2 class="text-center">
    <?php if( count($form["scenario"]) > count($answers)) { ?>
        Inscrivez votre <b> projet de transition écologique</b>
    <?php } else {?>
        Merci pour votre participation au CTE, <br/>
        Votre projet sera très prochainement évalué <br/>
        Et vous serez informé de la suite.<br/><br/>
        <a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/answer/id/<?php echo $form["id"] ?>/user/<?php echo Yii::app()->session["userId"] ?>" class="btn btn-primary">Revoir vos réponses</a>
    <?php } ?>
    </h2>
    <div id="surveyDesc" class="col-xs-12"></div>
  </div>
  
  <div class="content-header col-xs-12 no-padding">
    
    <div class="card col-xs-2">
        <div class="card-body padding-15" style="border: 2px solid #3071a9; border-radius: 10px;min-height:265px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-folder-open-o fa-2x"></i><br/>
              1. Récolte
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding margin-bottom-20">
          </span>
      </div>
    </div>

    <div class="card col-xs-2">
        <div class="card-body padding-15" style="border: 2px solid #3071a9; border-radius: 10px;min-height:265px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-gavel fa-2x"></i><br/>
              2. Eligibilité
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding margin-bottom-20">
          </span>
      </div>
    </div>

    <div class="card col-xs-2">
        <div class="card-body padding-15" style="border: 2px solid #3071a9; border-radius: 10px;min-height:265px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-refresh fa-2x"></i><br/>
              3. Instruction - Consultation
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding margin-bottom-20">
          </span>
      </div>
    </div>

    <div class="card col-xs-2">
        <div class="card-body padding-15" style="border: 2px solid #3071a9; border-radius: 10px;min-height:265px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-check-circle-o fa-2x"></i><br/>
              4. Selection - Priorisation
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding margin-bottom-20">
          </span>
      </div>
    </div>

    <div class="card col-xs-2">
        <div class="card-body padding-15" style="border: 2px solid #3071a9; border-radius: 10px;min-height:265px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-cogs fa-2x"></i><br/>
              5. Fiche Actions
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding margin-bottom-20">
          </span>
      </div>
    </div>
  </div>

</div>

 