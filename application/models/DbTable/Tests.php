<?php

class Application_Model_DbTable_Tests extends Zend_Db_Table_Abstract {

    protected $_name = 'tests';
    private $_tst_id;
    private $_tst_title;
    private $_tst_duration;
    private $_tst_for_id;

    /**
     * function to fetch a test for a particular formation.
     * @param type $formationId
     * @return object Application_Model_DbTable_Tests
     * @throws Exception
     */
    public function getTestByFormation($formationId) {
        $testRow = $this->fetchRow("tst_for_id = " . (int) $formationId);

        if (!$testRow) {
//           throw new Exception("Could not find row $formationId");
            return "";
        } else {
            $test = new Application_Model_DbTable_Tests();
            $test->setTst_id($testRow->tst_id);
            $test->setTst_title($testRow->tst_title);
            $test->setTst_duration($testRow->tst_duration);
            $test->setTst_for_id($testRow->tst_for_id);

            return $test;
        }
    }

    /**
     * function to fetch a formation for a particular test.
     * @param type $test_id
     * @return object Application_Model_DbTable_Tests
     * @throws Exception
     */
    public function getFormationByTest($test_id) {
        //$testRow = $this->fetchRow("tst_for_id = " . (int) $formationId);
        $entity=array();
        try {
            $select = $this->select()
                    ->from(array('tst' => 'tests',array(
                        'duration'=>'tst_duration')))
                    ->setIntegrityCheck(false)
                    ->join(array('for' => 'formations'), 'tst.tst_for_id=for.for_id', array(
                        'for_name' => 'for_name'
                    ))
                    ->where('tst.tst_id=:id')
                    ->bind(array('id' => $test_id));
            $entity = $this->fetchRow($select);
        } catch (Exceptiom $e) {
            print $e->getMessage();
        }
        return $entity->toArray();
    }

    /**
     * function to save a new test or update an existing one
     * @param objet Application_Model_DbTable_Tests
     * @param type $isNew
     * @return boolean
     */
    public function saveTest($isNew = true) {
        $data = array('tst_id' => $this->getTst_id(),
            'tst_title' => $this->getTst_title(),
            'tst_duration' => $this->getTst_duration(),
            'tst_for_id' => $this->getTst_for_id()
        );


        $id = (int) $this->getTst_id();

        // if id is null, add else update
        if ($isNew && ($id == 0 || $id == NULL)) {
            if (!$this->insert($data)) {
                return false;
            } else {
                return $this->getAdapter()->lastInsertId();
            }
        } else {
            if (!$this->update($data, array('tst_id' => $id))) {
                return false;
            } else {
                return $id;
            }
        }
    }

    /**
     * @access public
     * 
     * @param mixed $id test id 
     */
    public function deleteTest($id) {
        $choice_question = new Application_Model_DbTable_QuestionsChoices();
        $choice_question->DeleteQuestionsChoices($id);

        $question = new Application_Model_DbTable_Questions();
        $question->deleteQuestionBytest($id);

        $this->delete('tst_id = ' . (int) $id);
    }

    /**
     * @access public
     * @param aTst_id
     */
    public function setTst_id($aTst_id) {
        $this->_tst_id = $aTst_id;
    }

    /**
     * @access public
     */
    public function getTst_id() {
        return $this->_tst_id;
    }

    /**
     * @access public
     * @param aTst_title
     */
    public function setTst_title($aTst_title) {
        $this->_tst_title = $aTst_title;
    }

    /**
     * @access public
     */
    public function getTst_title() {
        return $this->_tst_title;
    }

    /**
     * @access public
     * @param aTst_duration
     */
    public function setTst_duration($aTst_duration) {
        $this->_tst_duration = $aTst_duration;
    }

    /**
     * @access public
     */
    public function getTst_duration() {
        return $this->_tst_duration;
    }

    /**
     * @access public
     * @param aTst_for_id
     */
    public function setTst_for_id($aTst_for_id) {
        $this->_tst_for_id = $aTst_for_id;
    }

    /**
     * @access public
     */
    public function getTst_for_id() {
        return $this->_tst_for_id;
    }

}
