<?php

class UserController extends Zend_Controller_Action {

    public function indexAction() {
        $authNamespace = new Zend_Session_Namespace('USER');
        $emp_test = new Application_Model_DbTable_EmployeesTests();
        $emp_formation = new Application_Model_DbTable_EmployeesFormation();
        $layout = Zend_Layout::getMvcInstance();
        $layout->setLayout('layout-user');
        $form = new Application_Form_NewTraining();
        $this->view->form = $form;
        $this->view->HeadScript()->appendFile('/js/script.js', 'text/javascript');
        $this->view->formations = $emp_formation->getFormationsByEmploye($authNamespace->user['ldap']);
    }

    public function testsAction() {
        $tests = new Application_Model_DbTable_Tests();
        $layout = Zend_Layout::getMvcInstance();
        $layout->setLayout('layout-user');
        $this->view->formation = $tests->getFormationByTest($this->_getParam('id'));
        $this->view->HeadScript()->appendFile('/js/script.js', 'text/javascript');
        $this->view->HeadScript()->appendFile('/js/jquery-chron.min.js', 'text/javascript');
    }

    public function noteAction() {
        $emp_test = new Application_Model_DbTable_EmployeesTests();
        $authNamespace = new Zend_Session_Namespace('USER');
        $authNamespace->user['employe_id'];
        //recuperer la note d'une formation param formation_id emp_id
        echo json_encode($emp_test->getNoteByTestByEmployee($this->_getParam('for_id'), (int) $authNamespace->user['employe_id']));
        die;
    }

    /**
     * Fonction qui permet d accpter une formation
     */
    public function accepterformationAction() {
        $emp_formation = new Application_Model_DbTable_EmployeesFormation();
        $date = new Zend_Date();
        $current_date = $date->get('YYYY-MM-dd');
        $emp_formation->_emf_id = $this->_getParam('for_id');
        $emp_formation->_emf_startdate = $current_date;
        $emp_formation->_emf_statusformation = 2;
        echo json_encode($emp_formation->acceptFormation());
        die;
    }

    /**
     * Fonction qui permet de deposer une demande d'une nouvelle formation
     */
    public function demanderformationAction() {
        if ($this->getRequest()->isPost()) {
            $authNamespace = new Zend_Session_Namespace('USER');
            $ldap = $authNamespace->user['ldap'];
            $formData = $this->getRequest()->getPost();
            ($formData['formation'][0] != '0') ? $formation = $formData['formation'][0] : $formation = $formData['autre'];
            $observer_formation = new Application_Model_classes_observerFormation();
            //on va attacher l'observateur qu'on veut l'envoyer une notification
            $observer_formation->attach(new Application_Model_classes_text($ldap, $formation));
            $observer_formation->attach(new Application_Model_classes_pdf($ldap, $formation));
            $observer_formation->notify();
            $this->_forward('index', 'index');
        }
    }

    /**
     * Telecharger un fichier
     */
    public function downloadAction() {
        Application_Model_DbTable_EmployeesTests::download($this->_getParam('file'));
        die;
    }

    /**
     * Commencer un test
     */
    public function startAction() {
        //$questions = new Application_Form_TestQuestions();
        //$this->view->form = $questions;
        $tests = new Application_Model_DbTable_Tests();
        $detail_test = $tests->getFormationByTest($this->_getParam('id'));
        $questions = new Application_Model_DbTable_Questions();
        $liste = $questions->getQuestionsByTest($this->_getParam('id'));
        $this->view->questions = $liste;
        $layout = Zend_Layout::getMvcInstance();
        $layout->setLayout('layout-vide');
        $this->view->details = $detail_test;
        $this->render('start');
    }

    /**
     * finir le test et afficher la resulat
     */
    public function endAction() {
        $questions = new Application_Model_DbTable_Questions();
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            unset($formData['soumettre']);
            $note = 0;
            foreach ($formData as $key => $element) {
                if ($element == $questions->getReponsesByQuestion($key)) {
                    $note++;
                }
            }
        }
        $emp_test = new Application_Model_DbTable_EmployeesTests();
        $authNamespace = new Zend_Session_Namespace('USER');
        /** implemention de la fonction save() */
        $emp_test->_ets_id = 0;
        $emp_test->_ets_status = 1;
        $emp_test->_tests_tst_id = (int) $this->_getParam('id');
        $emp_test->_employees_emp_id = (int) $authNamespace->user['employe_id'];
        $emp_test->_ets_note = $note;
        $emp_test->_ets_datetest = $date = date("Y-m-d");
        $emp_test->save();
        $layout = Zend_Layout::getMvcInstance();
        $this->view->note = $note . '/' . $questions->getNumerQuestionByTest($this->_getParam('id'));
        $layout->setLayout('layout-user');
        $this->render('end');
    }

    public function reponseAction() {
        $choice = new Application_Model_DbTable_Questions();
        echo '<pre>';
        print_r($choice->getQuestionsByTest(1));
        die;
    }

}
