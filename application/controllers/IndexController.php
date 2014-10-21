<?php

/**
 * @package controller
 * @author Mnasri Walid
 * @access public
 * @version 1.1.1
 * @license http://intranet.astek.mu name
 */

class IndexController extends Zend_Controller_Action
{

    /**
     * @access public
     * @param  null, Description: login page
     * @link $this->baseUrl(), description: home page
     */
    
    public function indexAction()
    {
        $page = 'login';
        $this->view->page = $page;
        $authNamespace = new Zend_Session_Namespace('USER');
        if(isset($authNamespace->user)){
            if($authNamespace->user['cp'] == 1 || $authNamespace->user['admin'] == 1){
                $this->_helper->redirector('admin');
            }
            else{
                $this->_redirect("/user/index");
            }
        }
        // load form class
        $form = new Application_Form_Login();
        // add label to submit button
        $form->envoyer->setLabel('Login');
        // return form to view
        $this->view->form = $form;
        $request = $this->getRequest();
        // Onsubmit
        if ($request->isPost()) {
            // validation to form 
            if ($form->isValid($request->getPost())) {
                // get value to input
                $ldap               = $form->getValue ('ldap');
                $password           = $form->getValue ('password');
                // load model db-table employees
                $employees          = new Application_Model_DbTable_Employees();
                // authenticate
                $authAuthenticate   = $employees->login($ldap,$password);
                // if authentication valid redirection to profile
                if(($authAuthenticate->isValid())){
                    // load data to employees class
                    $employees->getIni($ldap);
                    // zend_session
                    $authNamespace = new Zend_Session_Namespace('USER');
                    $session = array();
                    //load data in array
                    $session['ldap']            = $employees->getEmp_ldap(); 
                    $session['employe_id']      = $employees->getId(); 
                    $session['cp']              = $employees->getEmp_cp(); 
                    $session['admin']           = $employees->getEmp_admin(); 
                    $session['firstName']       = $employees->getEmp_firstname(); 
                    $session['lastName']        = $employees->getEmp_lastname(); 
                    //load array $session in session namespace 'user'
                    $authNamespace->user    = $session; 
                    //login admin profile
                    if($employees->getEmp_cp() == 1 || $employees->getEmp_admin() == 1) {
                        $this->_helper->redirector('admin');
                    }
                    // login employees profile
                    else {
                        $this->_helper->redirector('index');
                    }
                }
                // if authentication not valid 
                else
                {
                    $msg_error = 'ldap username or password not valid !';
                    // send error message to view
                    $this->view->msg_error = $msg_error;
                }
            }               
        }
    }

    /**
     * @access admin/cp
     * @param  integer $id , Description: key to employee
     * @link $this->baseUrl()/index/details/id/xxxx, description: detail of employee
     * page
     */
    
    public function detailsAction()
    {
        $page = 'popup';
        $this->view->page = $page;
        $authNamespace = new Zend_Session_Namespace('USER');
        //acces for admin & cp profile
        if($authNamespace->user['cp'] == 1 || $authNamespace->user['admin'] == 1){
            $this->view->sessiondata    =  $authNamespace->user;
            $id = $this->_getParam('id');
            if($id)
            {
                $employees = new Application_Model_DbTable_Employees();
                $this->view->detailEmp = $employees->getEmployeeTask($id);
            }
            else{
                $this->_helper->redirector('notfound');
            }    
        }
        else{ 
            $this->_helper->redirector('notfound');
        }
    }

    /**
     * @access admin/cp
     * @param  no-param , Description: All employees
     * @link $this->baseUrl()/index/admin, description: detail of employee page
     */
    
    public function adminAction()
    {
        $page = 'adminIndex';
        $this->view->page = $page;
        $authNamespace = new Zend_Session_Namespace('USER');
        //acces for admin profile
        if($authNamespace->user['cp'] == 1 || $authNamespace->user['admin'] == 1){
            $this->view->sessiondata    =  $authNamespace->user;
            $employees = new Application_Model_DbTable_Employees();
            $this->view->AllEmployees = $employees->getEmployeeTask();
        }else{
            $this->_helper->redirector('notfound');
        }   
    }

    /**
     * @access public
     * @param  integer $id , Description: key to employee
     * @link $this->baseUrl(), description: detail of employee page
     */
    
    public function logoutAction()
    {
        Zend_Session::destroy();
        $this->_helper->redirector('index');
    }

    public function notfoundAction()
    {
        // action body
        $page = 'notfound';
        $this->view->page = $page;
    }
	
    

    /**
     * Shows the dynamic form demonstration page
     */
    public function dynamicformelementsAction() {
    	// echo 'hellooo';die;
    	$form = new Application_Form_FormDynamic();
    	 
    	// Form has not been submitted - pass to view and return
    	if (!$this->getRequest()->isPost()) {
    		$this->view->form = $form;
    		return;
    	}
    
    	// Form has been submitted - run data through preValidation()
    	$form->preValidation($_POST);
    	 
    	// If the form doesn't validate, pass to view and return
    	if (!$form->isValid($_POST)) {
    		$this->view->form = $form;
    		return;
    	}
    	 
    	// Form is valid
    	$this->view->form = $form;
    }
    
    /**
     * Ajax action that returns the dynamic form field
     */
    public function newfieldAction() {
    	 
    	$ajaxContext = $this->_helper->getHelper('AjaxContext');
    	$ajaxContext->addActionContext('newfield', 'html')->initContext();
    	 
    	$id = $this->_getParam('id', null);
    	 
    	$element = new Zend_Form_Element_Text("newName$id");
    	$element->setRequired(true)->setLabel('Name');
    	 echo $element->__toString();die;
    	$this->view->field = $element->__toString();
    }

}

