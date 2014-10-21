<?php

class FormationController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // action body
        $page = 'formation';
        $this->view->page = $page;
        $authNamespace = new Zend_Session_Namespace('USER');
          //acces for admin & cp profile
        if($authNamespace->user['cp'] == 1 || $authNamespace->user['admin'] == 1){
                $this->view->sessiondata    =  $authNamespace->user;
            // load model db-table employees
                $listeFormations  =  new Application_Model_DbTable_Formations();
                //$this->view->formations = $listeFormations->getAll();
                $this->view->assign('formations', $listeFormations->getAll());
        }
        else{ 
           $this->_redirect("/index/notfound");
        }
    }
    
     /**
     * @access public
     *
     */
    
    public function addAction() 
    {   
        $page                       = 'formation';
        $this->view->page           = $page;
        $authNamespace              = new Zend_Session_Namespace('USER');
        $this->view->sessiondata    =  $authNamespace->user; 
        if($authNamespace->user['cp'] == 1 || $authNamespace->user['admin'] == 1){    
            $form = new Application_Form_FormationForm();
            $form->submit->setLabel('Ajouter');
            $form->for_filepath->setAttrib('style', 'display:none;');
            $this->view->form = $form;
            $output_dir = "./repDownload/";
         
            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
//                move_uploaded_file($_FILES["for_filepath_input"]["tmp_name"],$output_dir. $_FILES["for_filepath_input"]["name"]);    
                if ($form->isValid($formData)) {
                        $name           = $form->getValue('for_name');
                        $description    = $form->getValue('for_description');
                        $duration       = $form->getValue('for_duration');
                        $content        = $form->getValue('for_filepath_input');
                        $group          = $form->getValue('for_grp_id');
                        $formations     = new Application_Model_DbTable_Formations();
                        $formations->addFormation($name, $description, $duration, $content, $group);
                        $this->_redirect("/formation/index");
                    } else {
                        $form->populate($formData);
                    }                
            }
        }
        else{ 
           $this->_redirect("/index/notfound");
        }
    }
    
     /**
     * @access public
     */
    public function editAction() 
    {
        $page                       = 'formation';
        $this->view->page           = $page;
        $authNamespace              = new Zend_Session_Namespace('USER');
        $this->view->sessiondata    =  $authNamespace->user; 
        if($authNamespace->user['cp'] == 1 || $authNamespace->user['admin'] == 1){ 
            $form = new Application_Form_FormationForm();
            $form->submit->setLabel('Sauvegarder');
            $form->clear_criteria->setAttrib('style', 'display:none;');
            $this->view->form = $form;
            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();

                if ($form->isValid($formData)) { 
                    $id             = (int) $form->getValue('for_id');
                    $name           = $form->getValue('for_name');
                    $description    = $form->getValue('for_description');
                    $duration       = $form->getValue('for_duration');
                    $content        = $form->getValue('for_filepath_input');
                    if ($content === null){
                           $content = $form->getValue('for_filepath');
                    }
                    $group = $form->getValue('for_grp_id');

                    $formations = new Application_Model_DbTable_Formations();
                    $formations->updateFormation($id, $name, $description, $duration, $content, $group);
                    $this->_helper->redirector('index');
                } else {
                    $form->populate($formData);
                }
            } else {
                $id = $this->_getParam('id', 0);
                if ($id > 0) {
                    $formations = new Application_Model_DbTable_Formations();
                    $form->populate($formations->getIni($id));
                }
            }
        }else{ 
           $this->_redirect("/index/notfound");
        }
    }
    
    /**
     * @access public
     * @description: delete formation 
     */
    public function deleteAction() 
    {
        $page = 'popup';
        $this->view->page = $page;
        $authNamespace = new Zend_Session_Namespace('USER');
        $this->view->sessiondata    =  $authNamespace->user; 
        if($authNamespace->user['cp'] == 1 || $authNamespace->user['admin'] == 1){
            $id = $this->_getParam('id');
            $emp_formations = new Application_Model_DbTable_EmployeesFormation();
            $checkEmpFormation = $emp_formations->getEmployeesByFormation($id);
            
            $test = new Application_Model_DbTable_Tests();
            $checkTest = $test->getTestByFormation($id); 

            if (!empty($checkEmpFormation)) {
                echo "KO"; exit;
            }
            else if (!empty($checkTest)) {
                echo "TEST";exit;
            }
            else {
                $formations = new Application_Model_DbTable_Formations();
                $formations->deleteFormation($id); 
                echo "OK"; exit;           
            }  
        }     
    }
    
    /**
     * @access public
     * @description: delete test 
     */
    public function deletetestAction() 
    {
        
        $page = 'popup';
        $this->view->page = $page;
        $authNamespace = new Zend_Session_Namespace('USER');
        $this->view->sessiondata    =  $authNamespace->user; 
        if($authNamespace->user['cp'] == 1 || $authNamespace->user['admin'] == 1){
            $id = $this->_getParam('id');
            $tests = new Application_Model_DbTable_Tests();
            $tests->deleteTest($id);
            echo'hello';die;
        }     
    }
    
    /**
     * @access public
     */
    public function detailAction() {
    }
    
    /**
    * @access public
    * @return download fichier excel ou texte 
    */
    public function downloadAction() 
    {
        $id = $this->_getParam('id', 0);
        if (!$id) {
            $this->_helper->redirector('index');
        }

        try {
            $formations = new Application_Model_DbTable_Formations();
            $formation = $formations->getIni($id);
        }
        catch (\Exception $ex) {
            return $this->_helper->redirector('index');
        }

        $fileName = $formation['for_filepath'];     
        $filePath = $_SERVER["DOCUMENT_ROOT"] . "/repDownload/".$fileName;

        if(!file_exists($filePath)) {
            echo 'File not found';
            exit();
        }
        else {         
                /*  simple file download */  
                header($_SERVER['SERVER_PROTOCOL'].' 200 OK');  
                header('Cache-Control: public'); // needed for i.e.
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Transfer-Encoding: Binary');
                header('Content-Length:'.filesize($filePath));
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                readfile($filePath);
                die(); // stop execution of further script because we are only outputting the file               
            } 
    }
     
    /**
     * @access public
     * @link baseUrl()/formation/assign description
     */
    
    public function assignAction()
    {
        $page = 'assign';
        $this->view->page = $page;
        $authNamespace = new Zend_Session_Namespace('USER');
        $msg ='';
        //acces for admin & cp profile
        if ($authNamespace->user['cp'] == 1 || $authNamespace->user['admin'] == 1) {
            $this->view->sessiondata = $authNamespace->user;

            $form = new Application_Form_EmployeeFormationForm();
            $this->view->form = $form;


            if ($this->getRequest()->isPost()) {
                $formData = $this->getRequest()->getPost();
                //var_dump($_POST);die;
                if ($form->isValid($formData)) {
                	
                    $formationId = (int) $form->getValue('selFormation');
                    $employeesId = $form->getValue('multiSelEmployeeSelected');
                    $responsableId = (int) $form->getValue('selResponsable');

                    $emp_formation = new Application_Model_DbTable_EmployeesFormation();
                    $emp_formation->deleteEmployeesFormation($formationId);

                    foreach ($employeesId as $empId) {
                        $emp_formation->_formations_for_id = $formationId;
                        $emp_formation->_employees_emp_id = (int) $empId;
                        $emp_formation->_emf_responsable = $responsableId;
                        $emp_formation->_emf_statusformation = 1; //assigned status
                        $emp_formation->_emf_id = 0;
                        $emp_formation->assignFormation();
                    }
                    $msg = ' Les affectation ont bien été envoyées !';
                    $this->view->msg = $msg;
                    //exit;
                } else {
                    $form->populate($formData);
                    $msg = ' Une erreure d\'envoi !';
                    $this->view->msg = $msg;
                }
            }
        } else {
            $this->_redirect("/index/notfound");
        }
    }

     /**
      * @access public
      * @link baseUrl()/formation/test description
     */
    
    public function testAction()
    {
        $page = 'formation';
        $this->view->page = $page;
        $authNamespace = new Zend_Session_Namespace('USER');
        //acces for admin & cp profile
        if ($authNamespace->user['cp'] == 1 || $authNamespace->user['admin'] == 1) {
            $this->view->sessiondata = $authNamespace->user;
            $formation =  new  Application_Model_DbTable_Formations();
           // $this->view->data_formation = $formation->getAll();
            $this->view->data_formation = $formation->getFormationWithoutTest();
            if ($this->getRequest()->isPost()) {
               //insert test details in DB
                $newTest = new Application_Model_DbTable_Tests();
                $newTest->setTst_title($this->getRequest()->getPost('title'));
                $newTest->setTst_duration($this->getRequest()->getPost('duration'));
                $newTest->setTst_for_id($this->getRequest()->getPost('formation'));
                $lastInsertedTestId=$newTest->saveTest();
                $data = serialize($_POST['Hide']);
                //$countNumberQuest=2;
                //insert all questions in DB
               foreach( unserialize($data) as $countQuest => $value ){
                   ECHO  $countQuest;
                   $newQuestion = new Application_Model_DbTable_Questions();
                    $newQuestion->setQst_tst_id($lastInsertedTestId);
                    $newQuestion->setQst_title($this->getRequest()->getPost('editor_'.$countQuest));
                    $newQuestion->setQst_answer($this->getRequest()->getPost('good_answer_'.$countQuest));
                    //$newQuestion->setQst_answer("answer2");
                    $lastInsertedQuestionId=$newQuestion->saveQuestion();
                    //insert 4 choices in DB
                    for ($i = 1; $i <= 4; $i++) {
                        $newChoice = new Application_Model_DbTable_Choices();
                        $newChoice->setChs_title($this->getRequest()->getPost('choice'.$i.'_'.$countQuest));
                        $lastInsertedChoiceId=$newChoice->saveChoice();
                        //insert QuestionChoices in DB
                        $newQC = new Application_Model_DbTable_QuestionsChoices();
                        $newQC->setQuestions_qst_id($lastInsertedQuestionId);
                        $newQC->setChoices_chs_id($lastInsertedChoiceId);
                        $newQC->saveQuestionsChoices();
                    }  
               }  
              $this->view->succes = 'ok';
            }
        } else {
            $this->_redirect("/index/notfound");
        }
    }   
}





