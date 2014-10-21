<?php

class Application_Model_DbTable_Questions extends Zend_Db_Table_Abstract {

    protected $_name = 'questions';
    private $_qst_id;
    private $_qst_title;
    private $_qst_answer;
    private $_qst_tst_id;

    /**
     * function to retrieve all questions for a particular test.
     * @param type $testId
     * @return an array of Questions
     * @throws \Exception
     */
    public function getQuestionsByTest($testId) {
        $tab=array();
        $choices = new Application_Model_DbTable_QuestionsChoices();
        $select = $this->select()
                ->where('qst_tst_id =' . (int) $testId);

        $questionsResultSet = $this->fetchAll($select);

        if (!$questionsResultSet) {
            throw new \Exception("Could not find rowset $testId");
        }
        //$questions = $questionsResultSet->toArray();
        foreach( $questionsResultSet as $question){
            $tab[]=array('qst_id'=>$question['qst_id'],
                'qst_title'=>$question['qst_title'],
                'reponse'=>$choices->getChoicesByQuestion1($question['qst_id']));
            
        }
        return $tab;
    }
     /**
     * function to retrieve responsefor a particular test.
     * @param type $questionId
     * @return an row of Questions
     * @throws \Exception
     */
      public function getReponsesByQuestion($question_id) {
        
        $select = $this->select()
                ->from(array('q'=>'questions'))
                       ->where('qst_id ='.(int)$question_id);
               
        $row = $this->fetchRow($select);
        
       return $row['qst_answer'];
        
    }
      /**
     * function to retrieve responsefor a particular test.
     * @param type $test_id
     * @return an row of number
     * @throws \Exception
     */
      public function getNumerQuestionByTest($test_id) {
        
        $select = $this->select()
                ->from(array('q'=>'questions'),array('number'=>'count(*)'))
                ->where('qst_tst_id ='.(int)$test_id);
               
        $row = $this->fetchRow($select);
        
       return $row['number'];
        
    }
    /**
     * function to add or edit a question to an existing test.
     * @param Questions $question
     * @param type $isNew
     * @return boolean
     */
    public function saveQuestion($isNew = true) {
        $data = array('qst_id' => $this->getQst_id(),
            'qst_title' => $this->getQst_title(),
            'qst_answer' => $this->getQst_answer(),
            'qst_tst_id' => $this->getQst_tst_id()
        );

        $id = (int) $this->getQst_id();

        // if id is null, add else update
        if ($isNew && ($id == 0 || $id == NULL)) {
            if (!$this->insert($data)) {
                return false;
            } else {
                return $this->getAdapter()->lastInsertId();
            }
        } else {
            if (!$this->update($data, array('qst_id' => $id))) {
                return false;
            } else {
                return $id;
            }
        }
    }

    /**
     * @access public
     * 
     * @param mixed $id
     */
    public function deleteQuestion($id) {
        $this->delete('qst_id = ' . (int) $id);
    }

    /**
     * @access public
     * @param aQst_id
     */
    public function setQst_id($aQst_id) {
        $this->_qst_id = $aQst_id;
    }

    /**
     * @access public
     */
    public function getQst_id() {
        return $this->_qst_id;
    }

    /**
     * @access public
     * @param aQst_title
     */
    public function setQst_title($aQst_title) {
        $this->_qst_title = $aQst_title;
    }

    /**
     * @access public
     */
    public function getQst_title() {
        return $this->_qst_title;
    }

    /**
     * @access public
     * @param aQst_answer
     */
    public function setQst_answer($aQst_answer) {
        $this->_qst_answer = $aQst_answer;
    }

    /**
     * @access public
     */
    public function getQst_answer() {
        return $this->_qst_answer;
    }

    /**
     * @access public
     * @param aQst_tst_id
     */
    public function setQst_tst_id($aQst_tst_id) {
        $this->_qst_tst_id = $aQst_tst_id;
    }

    /**
     * @access public
     */
    public function getQst_tst_id() {
        return $this->_qst_tst_id;
    }

}
