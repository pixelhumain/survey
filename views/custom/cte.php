<?php 
    Yii::app()->params["logoUrl"]=Yii::app()->getModule("eco")->assetsUrl."/images/custom/leport/tco.png";
    Yii::app()->params["logoUrl2"]=Yii::app()->getModule("eco")->assetsUrl."/images/custom/leport/tco.png";
?> 
<style type="text/css">
  .bannerCustom{
    position: absolute;
    background-repeat: no-repeat;
    
    background-image: url(<?php echo Yii::app()->getModule("survey")->assetsUrl; ?>/images/custom/cte/banniere-tco-cteV2.jpg);
    border: none;
    height: 560px;
    width: 100%;
    /* padding: 50px; */
    top:120px;
    /*opacity: 0.7;*/
    /*filter: saturate(12%) blur(2px) sepia(100%);*/
  }
    

  .content-header{
    margin-top: 20px;
    border-radius: 5px 5px 0px 0px;
    border: 1px solid #ccc;
    background-color: rgba(250,250,250,0.9)
  }
  .logo-survey {
    overflow: hidden;
    max-height: 373px;
  }
  
  .header-survey{
   height: : 373px;
   color: #333; 
  }
  .bannertitle{
    font-size: 4em;
    background-color: #333;
    opacity: 0.75;
    width: 80%;
    line-height: 1.25;
    position: absolute;
    top: 280px;
    padding-left: 10px;
  }
</style>


<img class="img-responsive" style="display: block; margin: 0 auto;" src="<?php echo Yii::app()->getModule("survey")->assetsUrl; ?>/images/custom/cte/banniere-tco-cteV2.jpg">

<div class="container col-xs-12" >
    
    <div id="surveyContent" class="formChart  col-xs-offset-1 col-xs-10 padding-bottom-20" >

<div class="row">
  
  <div class="content-header col-xs-offset-1 col-xs-10 no-padding margin-bottom-20">
      
      <div class="col-xs-12 col-md-12  header-survey text-center padding-20" >
        
        <?php if(@$form["description"]) echo "<span class='pull-left padding-20' style='font-size: 16px; text-align: left;'>".$form["description"]."</span>" ?>
        <?php if(!isset(Yii::app()->session['userId'])) { ?>
        <br/>
        <button class="btn btn-default bg-green margin-top-15 btn-lg" data-toggle="modal" data-target="#modalLogin">
          <i class="fa fa-sign-in"></i> <?php echo Yii::t("login","Log in") ?>
        </button>
        <button class="btn btn-link margin-top-15 btn-lg" data-toggle="modal" data-target="#modalRegister">
          <i class="fa fa-plus-circle"></i> <?php echo Yii::t("login","Create an account") ?>
         </button>
        
        <?php }else{ 
            $count=count($answers);
            if(count($answers) < count($form["scenario"]) ){
            $label=($count > 0) ? "Reprendre le dossier" : "Déposer une candidature"; 
          ?>
          <a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/index/id/cte<?php echo $count+1 ?>" style="background-color:<?php echo $form["custom"]["color"] ?>" class="btn btn-default answered<?php echo $count+1 ?>"  style="width:90%"><i class="fa fa-sign-in"></i> <?php echo $label ?></a>
        <?php  } else {
          ?>
          <a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/answer/id/cte/user/<?php echo Yii::app()->session['userId'] ?>" style="background-color:<?php echo $form["custom"]["color"] ?>" class="btn btn-default answered<?php echo $count+1 ?>"  style="width:90%"><i class="fa fa-list"></i> REVOIR VOS RÉPONSES </a>
          <?php
          }
        } ?>
      </div>
  </div>
  <div class="col-xs-offset-1 col-xs-10 shadow2" >
    <?php //if(@$form["description"]) echo "<span class='text-center pull-left padding-20'>".$form["description"]."</span>" ?>
    <h2 class="text-center" style="color:#00B794" >
    <?php if( count($form["scenario"]) > count($answers)) { ?>
        Inscrivez votre <b> projet de transition écologique</b>
    <?php } else {?>
        Merci pour votre participation au CTE, <br/>
        Votre projet sera très prochainement évalué <br/>
        Et vous serez informé de la suite.<br/><br/>
        <a href="<?php echo Yii::app()->getRequest()->getBaseUrl(true) ?>/survey/co/answer/id/<?php echo $form["id"] ?>/user/<?php echo Yii::app()->session["userId"] ?>" class="btn btn-primary">Revoir vos réponses</a>
    <?php } ?>
    </h2>
    <div id="surveyDesc" class="col-xs-12 padding-20"></div>
    
  </div>

<div class="space50"></div>

  <div class="col-xs-offset-1 col-xs-10 shadow2 padding-20 margin-top-20">


  <div class="col padding-20-xs-12 col-md-6">
    <img class="img-responsive" src="http://www.tco.re/wp-content/uploads/2018/07/vignette-1_contrats-de-transition-ecologique-768x768.png" class="margin-15 pull-left">
  </div>
  <div class="col-xs-12 col-md-6 padding-20" style="font-size: 1.5em;">
    <p>En décembre 2017, le gouvernement a annoncé la création de  <span style="font-weight:bold;">«Contrats de transition écologique» </span> (CTE) pour que les territoires fassent leur transition écologique.</p> 
    <p>
      <span style="font-weight:bold;">L’ambition </span> de ces contrats est : <br/> 
    <ul>
      <li>
        d’accélérer l’action locale pour traduire les engagements pris par la France au niveau national <a href="http://www.tco.re/competences-et-projets/cte-contrat-de-transition-ecologique" target="_blank">(Plan climat)</a> et international (<a href="https://www.ecologique-solidaire.gouv.fr/accord-paris-et-cadre-international-lutte-contre-changement-climatique#e2" target="_blank">COP21</a>, One Planet Summit) ; 
      </li>
      <li>
        d’impliquer tous les acteurs du territoire autour d’un projet de transition durable (élus, acteurs économiques, partenaires sociaux, services déconcentrés, citoyens) ; et d’accompagner les mutations professionnelles.
       </li>
      </ul>
      </p>
    <p>
      <span style="font-weight:bold;">L’enjeu</span> est de mobiliser la société autour de l’objectif de neutralité carbone d’ici 2050.
    </p>
      
  </div>

<div class="col-xs-12"></div>

  <div class="col-xs-12 col-md-6 padding-20" style="font-size: 1.5em;">
    <p>
      Sur la vingtaine de <b>« Territoires d’expérimentations »</b> qui devrait être identifié au niveau national, la <b><a href="www.tco.re" target="_blank">Communauté d’agglomération du Territoire de la Côte Ouest</a></b> (TCO) a été désignée le 26 avril dernier comme territoire pilote.
    </p> 
    <p>
      Du 28 mai au 31 mai 2018, le TCO a organisé des rencontres bilatérales avec les maires et des séances de travail associant les institutions, les organismes parapublics, les organisations socioprofessionnelles et le monde économique. 
    </p>

    <p>
      Ces réunions de travail ont permis d’établir le fil rouge du CTE (Axes stratégiques) et de recenser des premiers projets concrets (publics et privés) matures : ayant fait l’objet d’une instruction par les services publics et/ou organismes parapublics ; qui correspondent aux <b>critères d’éligibilité du CTE 

    </p>

    <ul>
      <li>actions innovantes et réplicables</li>
      <li>actions chiffrées et mesurables</li>
      <li>actions financées</li>
      <li>actions prêtes au déploiement et réalisables dans les 3 ans</li>
    </ul>
  </b>. 
  <p>Le 06 juin 2018, Monsieur Sébastien LECORNU, Ministre de la Transition Ecologique a procédé au <a href="http://www.tco.re/actualite-du-tco/top-depart-pour-le-contrat-de-transition-ecologique-du-tco-20875.html"target="_blank">lancement de la séquence d’initialisation du CTE</a>.</p>
  </div>
  <div class="col-xs-12 col-md-6 padding-20" style="font-size: 1.3em;">
  <img class="img-responsive" src="http://www.tco.re/wp-content/uploads/2018/07/vignette-2_contrats-de-transition-ecologique-768x768.png" class="margin-15 pull-left">
</div>

<div class="col-xs-12"></div>

 <div class="col-xs-12 col-md-6 padding-20">
    <img class="img-responsive" src="http://www.tco.re/wp-content/uploads/2018/07/vignette-3_contrats-de-transition-ecologique-768x768.png" class="margin-15 pull-left">
  </div>
  <div class="col-xs-12 col-md-6 padding-20" style="font-size: 1.5em;">
  <p>
    <b>Le Contrat de transition écologique (CTE) du TCO sera opérationnel sur la période 2018-2021</b>
  </p>
  <p>
    Pour 2018, le contrat de transition écologique comporte <b>deux étapes</b>
   <ul>

      <li> <b>1ère étape</b> : Une sélection de projets maturesissus de la séquence d’initialisation.</li>
   
   </ul></p>

   <p>
    Ces projets seront intégrés au premier contrat de transition écologique (CTE1) du TCO qui devrait être signé à la mi-juillet 2018</b>
   <ul> 
      <li><b>2ème étape </b> : la plateforme collaborative « COMMUNECTER » devrait être opérationnel à compter du 09 juillet afin que les acteurs économiques puissent déclarer leurs projets en ligne du 17 juillet au 18 août 2018, dans le cadre de l'avis d'appel à projet CTE</li>
  </ul>
</p>
<p>
  <a href="http://www.tco.re/competences-et-projets/cte-contrat-de-transition-ecologique" target="_blank"><i class="fa fa-plus"></i> Plus d'informations sur le Contrat de transition écologique du TCO</a>
</p>
</div>

 </div>

 <div class="space50"></div>

  <div class="col-xs-offset-1 col-xs-10 shadow2 padding-20 margin-top-20">
    <h3 class="text-center ">4 étapes du CTE </h3>
    <div class="card col-xs-12 col-md-3">
        <div class="card-body padding-15" style="border: 2px solid <?php echo $form["custom"]["color"] ?>; border-radius: 10px;min-height:200px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-folder-open-o fa-2x"></i><br/>
              1. Collecte
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding ">
          17 juil. au 17 aout<br/>
          Soumettre un projet
          </span>

      </div>
    </div>

    <div class="card col-xs-12 col-md-3">
        <div class="card-body padding-15" style="border: 2px solid <?php echo $form["custom"]["color"] ?>; border-radius: 10px;min-height:200px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-gavel fa-2x"></i><br/>
              2. Eligibilité
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding ">
          17 aout au 17 sept<br/>
          Établir le lien avec le CTE
          </span>
      </div>
    </div>

    <div class="card col-xs-12 col-md-3">
        <div class="card-body padding-15" style="border: 2px solid <?php echo $form["custom"]["color"] ?>; border-radius: 10px;min-height:200px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-flag-checkered fa-2x"></i><br/>
              3. Instruction - Selection 
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding ">
          17 sept. au 17 oct.<br/>
          Consolider le projet
          </span>
      </div>
    </div>

    <div class="card col-xs-12 col-md-3">
        <div class="card-body padding-15" style="border: 2px solid <?php echo $form["custom"]["color"] ?>; border-radius: 10px;min-height:200px;">
          <h4 class="card-title bold text-dark text-center padding-5" style="border-bottom:1px solid white">
              <i class="margin-5 fa fa-cogs fa-2x"></i><br/>
              4. Écosystème
          </h4> 
          <span class="card-text text-center col-xs-12 no-padding">
          17 oct. au 17 nov.<br/>
          Interconnecter les acteurs
          </span>
      </div>
    </div>
  </div>

  <div class="space20"></div>

</div>

 