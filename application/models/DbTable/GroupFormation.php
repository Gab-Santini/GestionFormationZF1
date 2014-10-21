<?php
/**
* 
* @access public
* @author Walid MNASRI
* @version 1.0.0
* Application_Model_DbTable_GroupFormation is a class relative to table group_formation
*   
*/

class Application_Model_DbTable_GroupFormation extends Zend_Db_Table_Abstract
{
    // table name 
    protected $_name = 'group_formation';
    // attribute name 
    private $_grp_id;
    private $_grp_name;
    private $_table_groupe_employee;
    /**
     * @access public
     */
    public function getAllGroups() {
         $resultSet = $this->fetchAll();
        $this->setTableGroup($resultSet->toArray());
    }
    
        /**
     * @access public
     */
    public function getAllSelectOptions() {
         $resultSet = $this->select(function (Select $select) {
                    $select->order('grp_name ASC');
                });
        $entities = array();
        $i=0;
        foreach ($resultSet as $row) { 
            $entities[$row->grp_id ] = $row->grp_name;
            $i++;     
        }
        return $entities  ;
    }
    
    /**
     * @access public
     * @param aGrp_id
     */
    public function setGrp_id($aGrp_id) {
            $this->_grp_id = $aGrp_id;
    }

    /**
     * @access public
     */
    public function getGrp_id() {
            return $this->_grp_id;
    }

    /**
     * @access public
     * @param aGrp_name
     */
    public function setGrp_name($aGrp_name) {
            $this->_grp_name = $aGrp_name;
    }

    /**
     * @access public
     */
    public function getGrp_name() {
            return $this->_grp_name;
    }
    /**
     * @access public
     * @param aGrp_name
     */
    public function setTableGroup($aGrp_tab) {
            $this->_table_groupe_employee = $aGrp_tab;
    }

    /**
     * @access public
     */
    public function getTableGroup() {
            return $this->_table_groupe_employee;
    }
}

