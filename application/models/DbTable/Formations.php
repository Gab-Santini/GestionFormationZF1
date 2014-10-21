<?php

class Application_Model_DbTable_Formations extends Zend_Db_Table_Abstract {

    protected $_name = 'formations';
    private $_for_id;
    private $_for_name;
    private $_for_description;
    private $_for_duration;
    private $_for_grp_id;
    private $_for_filepath;

    /**
     * @access public
     * 
     */
    public function getAll() {
        $entity = array();
        try {
            $select = $this->select()
                    ->from(array('for' => 'formations'), array('for_id' => 'for.for_id',
                        'for_name' => 'for.for_name',
                        'for_description' => 'for.for_description',
                        'for_duration' => 'for.for_duration',
                        'for_filepath' => 'for.for_filepath',
                        'for_grp_id' => 'for.for_grp_id'
                    ))
                    ->setIntegrityCheck(false)
                    ->join(array('grpFormation' => 'group_formation'), 'for.for_grp_id=grpFormation.grp_id', array('grp_id' => 'grpFormation.grp_id',
                        'grp_name' => 'grpFormation.grp_name'
                    ))
                    ->joinLEFT(array('tst' => 'tests'), 'tst.tst_for_id=for.for_id', array('*'))
                    ->order('for.for_name');
            $row = $this->fetchAll($select);
            if (!empty($row))
                $entity = $row->toArray();
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
        }
        return $entity;
    }

    /**
     * @access public
     * 
     */
    public function getFormationWithoutTest() {

        $tabl_test = new Application_Model_DbTable_Tests();
        $subSelect = new Zend_Db_Expr($tabl_test->select()
                        ->from(array('tst' => 'tests'), array('elemet' => 'tst.tst_for_id'))
        );

        $select = $this->select()
                ->from(array('for' => 'formations'), array('for_id' => 'for.for_id',
                    'for_name' => 'for.for_name'))
                ->where('for.for_id NOT IN(?)', $subSelect);

        $data = $this->fetchAll($select);
        // return $entity;
        return $data->toArray();
    }

    /**
     * @access public
     * 
     * @param mixed $id
     */
    public function getIni($id) {
        $entity = array();
        try {
            $select = $this->select()
                    ->from(array('for' => 'formations'), array('for_id' => 'for.for_id',
                        'for_name' => 'for.for_name',
                        'for_description' => 'for.for_description',
                        'for_duration' => 'for.for_duration',
                        'for_filepath' => 'for.for_filepath',
                        'for_grp_id' => 'for.for_grp_id'
                    ))
                    ->setIntegrityCheck(false)
                    ->join(array('grpFormation' => 'group_formation'), 'for.for_grp_id=grpFormation.grp_id', array('grp_id' => 'grpFormation.grp_id',
                        'grp_name' => 'grpFormation.grp_name'
                    ))
                    ->where('for_id = :id')
                    ->bind(array(':id' => $id));
            $row = $this->fetchRow($select);
            if (!empty($row)) {
                $entity = $row->toArray();
            }
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
        }
        return $entity;
    }

    /**
     * @access public
     * 
     * @param mixed $name
     * @param mixed $description
     * @param mixed $duration
     * @param mixed $content
     * @param mixed $group
     */
    public function addFormation($name, $description, $duration, $content, $group) {
        $data = array(
            'for_name' => $name,
            'for_description' => $description,
            'for_duration' => $duration,
            'for_filepath' => $content,
            'for_grp_id' => $group,
        );
        $this->insert($data);
    }

    /**
     *  @access public
     * 
     * @param mixed $id
     * @param mixed $name
     * @param mixed $description
     * @param mixed $duration
     * @param mixed $content
     * @param mixed $group
     */
    public function updateFormation($id, $name, $description, $duration, $content, $group) {
        $data = array(
            'for_id' => $id,
            'for_name' => $name,
            'for_description' => $description,
            'for_duration' => $duration,
            'for_filepath' => $content,
            'for_grp_id' => $group,
        );
        $this->update($data, 'for_id = ' . (int) $id);
    }

    /**
     * @access public
     * 
     * @param mixed $id
     */
    public function deleteFormation($id) {
        $this->delete('for_id = ' . (int) $id);
    }

    /**
     * @access public
     * 
     * @param mixed $groupId
     */
    public function getFormationByGroup($groupId) {
        
    }

    /**
     * @access public
     * @param aFor_id
     */
    public function setFor_id($aFor_id) {
        $this->_for_id = $aFor_id;
    }

    /**
     * @access public
     */
    public function getFor_id() {
        return $this->_for_id;
    }

    /**
     * @access public
     * @param aFor_name
     */
    public function setFor_name($aFor_name) {
        $this->_for_name = $aFor_name;
    }

    /**
     * @access public
     */
    public function getFor_name() {
        return $this->_for_name;
    }

    /**
     * @access public
     * @param aFor_description
     */
    public function setFor_description($aFor_description) {
        $this->_for_description = $aFor_description;
    }

    /**
     * @access public
     */
    public function getFor_description() {
        return $this->_for_description;
    }

    /**
     * @access public
     * @param aFor_duration
     */
    public function setFor_duration($aFor_duration) {
        $this->_for_duration = $aFor_duration;
    }

    /**
     * @access public
     */
    public function getFor_duration() {
        return $this->_for_duration;
    }

    /**
     * @access public
     * @param aFor_grp_id
     */
    public function setFor_grp_id($aFor_grp_id) {
        $this->_for_grp_id = $aFor_grp_id;
    }

    /**
     * @access public
     */
    public function getFor_grp_id() {
        return $this->_for_grp_id;
    }

    /**
     * @access public
     * @param aFor_filepath
     */
    public function setFor_filepath($aFor_filepath) {
        $this->_for_filepath = $aFor_filepath;
    }

    /**
     * @access public
     */
    public function getFor_filepath() {
        return $this->_for_filepath;
    }

}
