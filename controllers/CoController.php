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
	        'index'  => 'survey.controllers.actions.IndexAction',
	        'form'  => 'survey.controllers.actions.FormAction',
	        'edit'  => 'survey.controllers.actions.EditAction',
	    );
	}

}
