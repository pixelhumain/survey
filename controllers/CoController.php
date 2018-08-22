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
	        'save'  => 'survey.controllers.actions.SaveAction',
	        'update'=> 'survey.controllers.actions.UpdateAction',
	        'roles'=> 'survey.controllers.actions.RolesAction',
	        'logs'=> 'survey.controllers.actions.LogsAction',
	        'answers'  => 'survey.controllers.actions.AnswersAction',
	        'answer'  => 'survey.controllers.actions.AnswerAction',
	        'action'  => 'survey.controllers.actions.ActionAction',
	        'active'  => 'survey.controllers.actions.ActiveAction',
	        'searchadminform'  => 'survey.controllers.actions.SearchAdminFormAction',
	        'updatedocumentids'=> 'survey.controllers.actions.UpdateDocumentIdsAction',
	        'admin'=> 'survey.controllers.actions.AdminAction',
	        'members'=> 'survey.controllers.actions.MembersAction',
	        'searchadminmembers' => 'survey.controllers.actions.SearchAdminMembersAction',
	        'updatepriorisation'=> 'survey.controllers.actions.UpdatePriorisationAction',
	    );
	}

}
