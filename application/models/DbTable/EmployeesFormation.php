<?php

class Application_Model_DbTable_EmployeesFormation extends Zend_Db_Table_Abstract
{

    protected $_name = 'employees_formations';
    private $_emf_id;
    private $_emf_responsable;
    private $_emf_startdate;
    private $_emf_enddate;
    private $_employees_emp_id;
    private $_formations_for_id;
    private $_emf_statusformation;
    private $_attributs = array();

    /**
     * Methode magique pour getter les variable
     * @param mixed $nom
     * @return array $attributs
     * @access public
     */
    public function __get($nom)
    {
        if (isset($this->_attributs[$nom])) {
            return $this->_attributs[$nom];
        }
    }

    /**
     * Methode magique pour setter les variables
     * @param mixed $nom
     * @param mixed $valeur
     * @access public
     */
    public function __set($nom, $valeur)
    {
        $this->_attributs[$nom] = $valeur;
    }

    /**
     * Methode pour avoir les employees par formation
     * @param mixed $id
     * @access public
     */
    public function getEmployeesByFormation($id)
    {
        $entities = array();
        try {
            $select = $this->select()
                    ->from(array('emp' => 'employees'), array('emp_id' => 'emp.emp_id',
                        'emp_firstname' => 'emp.emp_firstname',
                        'emp_lastname' => 'emp.emp_lastname'
                    ))
                    ->setIntegrityCheck(false)
                    ->join(array('emf' => 'employees_formations'), 'emp.emp_id=emf.employees_emp_id')
                    ->join(array('for' => 'formations'), 'emf.formations_for_id=for.for_id', array('formation_id' => 'for.for_id'
                    ))
                    ->where('for.for_id = :for_id')
                    ->bind(array(':for_id' => $id
            ));
            $row = $this->fetchAll($select);
            if (!empty($row)) {
                $entities = $row->toArray();
            }
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
        }
        return $entities;
    }

  
    /**
     * fonction qui permet de retourner la liste des formations assignees un en employee donne
     * @param int $test_id
     * @param int $emp_id
     * @return array $entity
     * @access public
     */
    public function getFormationsByEmploye($ldap) {
        $entities = array();
        try {
            $select = $this->select()
                    ->from(array('emp' => 'employees'), array('ldap' => 'emp.emp_ldap',
                    ))
                    ->setIntegrityCheck(false)
                    ->join(array('emf' => 'employees_formations'), 'emp.emp_id=emf.employees_emp_id')
                    ->join(array('for' => 'formations'), 'emf.formations_for_id=for.for_id', array('formation_id' => 'for.for_id',
                        'formation' => 'for.for_name',
                        'statut' => 'emf.emf_statusformation',
                        'date_debut' => 'emf.emf_startdate',
                        'date_fin' => 'emf.emf_enddate',
                        'contenu' => 'for_filepath'
                    ))
                    ->join(array('tst' => 'tests'), 'tst.tst_for_id=for.for_id', array(
                        'test_id' => 'tst.tst_id',
                    ))
                    ->where('emp.emp_ldap = :ldap')
                    ->bind(array(':ldap' => $ldap
            ));
            $row = $this->fetchAll($select);
            if (!empty($row))
                $entities = $row->toArray();
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
        }
        return $entities;
    }

    /**
     * Methode pour affection une formation a un employee
     * @param mixed 
     * @access public
     */
    public function assignFormation()
    {
        try {
            $aData = array('emf_id' => $this->_attributs['_emf_id'],
                'emf_responsable' => $this->_attributs['_emf_responsable'],
                'employees_emp_id' => $this->_attributs['_employees_emp_id'],
                'formations_for_id' => $this->_attributs['_formations_for_id'],
                'emf_statusformation' => $this->_attributs['_emf_statusformation']
            );
            
            if ($this->_attributs['_emf_id'] == 0) {
                $this->insert($aData);
            } else {
                $this->update($aData, 'emf_id = ' . (int) $this->_attributs['_emf_id']);
            }
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Methode pour affection une formation a un employee
     * @param mixed 
     * @access public
     */
    public function acceptFormation()
    {
        try {
            $aData = array('emf_id' => $this->_attributs['_emf_id'],
                'emf_startdate' => $this->_attributs['_emf_startdate'],
                'emf_statusformation' => $this->_attributs['_emf_statusformation']
            );

            $this->update($aData, 'emf_id = ' . (int) $this->_attributs['_emf_id']);
        } catch (Zend_Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function deleteEmployeesFormation($id) 
    {
        $this->delete('formations_for_id = '.(int)$id);
    }

}
