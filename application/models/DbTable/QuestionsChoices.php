<?php

class Application_Model_DbTable_QuestionsChoices extends Zend_Db_Table_Abstract {

    protected $_name = 'questions_choices';
    private $_qch_id;
    private $_questions_qst_id;
    private $_choices_chs_id;

    /**
     * 
     * @param type $questionId
     * @return Array of 4 choices
     * @throws \Exception
     */
    public function getArrayChoicesByQuestion($questionId) {

        $select = $this->select()
                ->from(array('qc' => 'questions_choices'), array('qc.questions_qst_id'))
                ->setIntegrityCheck(false)
                ->join(array('c' => 'choices'), 'qc.choices_chs_id = c.chs_id', array('c.chs_id', 'c.chs_title'))
                ->where('qc.questions_qst_id =' . (int) $questionId);

        $choicesResultSet = $this->fetchAll($select)->toArray();
        if (!$choicesResultSet) {
            throw new \Exception("Could not find rowset $questionId");
        }

        return $choicesResultSet;
    }

    public function getChoicesByQuestion1($questionId) {

        $select = $this->select()
                ->from(array('qc' => 'questions_choices'), array())
                ->setIntegrityCheck(false)
                ->join(array('ch' => 'choices'), 'ch.chs_id=qc.choices_chs_id', array('choice_title' => 'chs_title'))
                ->where('questions_qst_id =' . (int) $questionId);

        $choicesResultSet = $this->fetchAll($select)->toArray();

        return $choicesResultSet;
    }

    /**
     * function to add or edit a question to an existing test.
     * @param QuestionsChoices $questionChoices
     * @param type $isNew
     * @return boolean
     */
    public function saveQuestionsChoices($isNew = true) {
        $data = array('qch_id' => $this->getQch_id(),
            'questions_qst_id' => $this->getQuestions_qst_id(),
            'choices_chs_id' => $this->getChoices_chs_id()
        );

        $id = (int) $this->getQch_id();

        // if id is null, add else update
        if ($isNew && ($id == 0 || $id == NULL)) {
            if (!$this->insert($data)) {
                return false;
            } else {
                return $this->getAdapter()->lastInsertId();
            }
        } else {
            if (!$this->update($data, array('qch_id' => $id))) {
                return false;
            } else {
                return $id;
            }
        }
    }

    /**
     * function to delete question choice.
     * @param int $id_test
     * @return boolean
     */
    public function DeleteQuestionsChoices($id_test) {
        $tabl_test = new Application_Model_DbTable_Questions();
        $subSelect = new Zend_Db_Expr($tabl_test->select()
                        ->from(array('qst' => 'questions'), array('id' => 'qst.qst_id'))
                        ->where('qst.qst_tst_id = ?', (int) $id_test)
        );

        $this->delete('questions_qst_id IN (' . $subSelect . ')');
    }

    /**
     * @access public
     * @param aQch_id
     */
    public function setQch_id($aQch_id) {
        $this->_qch_id = $aQch_id;
    }

    /**
     * @access public
     */
    public function getQch_id() {
        return $this->_qch_id;
    }

    /**
     * @access public
     * @param aQuestions_qst_id
     */
    public function setQuestions_qst_id($aQuestions_qst_id) {
        $this->_questions_qst_id = $aQuestions_qst_id;
    }

    /**
     * @access public
     */
    public function getQuestions_qst_id() {
        return $this->_questions_qst_id;
    }

    /**
     * @access public
     * @param aChoices_chs_id
     */
    public function setChoices_chs_id($aChoices_chs_id) {
        $this->_choices_chs_id = $aChoices_chs_id;
    }

    /**
     * @access public
     */
    public function getChoices_chs_id() {
        return $this->_choices_chs_id;
    }

}
