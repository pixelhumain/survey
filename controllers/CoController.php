<?php
/**
 * CoController.php
 *
 * Cocontroller always works with the PH base 
 *
 * @author: Tibor Katelbach <tibor@pixelhumain.com>
 * Date: 14/03/2014
 */
class CoController extends CommunecterController {


    protected function beforeAction($action) {
        //parent::initPage();
		return parent::beforeAction($action);
  	}

  	public function actions()
	{
	    return array(
	        'test'  => 'survey.controllers.actions.TestAction',
	    );
	}

	public function actionIndex() 
	{
    	if(Yii::app()->request->isAjaxRequest)
       		echo $this->renderPartial("index");
      	else
      	{
	        $this->layout = "//layouts/empty";
	        $this->render("index");
      	}
  	}
}
