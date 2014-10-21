<?php
/**
* 
* @access public
* @author Walid MNASRI
* @version 1.0.0
* Application_Model_DbTable_Employees is a class relative to table employees
*   
*/
class Application_Model_DbTable_Employees extends Zend_Db_Table_Abstract
{

    // table name
    protected   $_name = 'employees';
    //key employee
    protected   $_id;
    protected   $_emp_firstname;
    private     $_emp_lastname;
    private     $_emp_cp;
    private     $_emp_admin;
    private     $_emp_ldap;
    private     $_emp_pwd;
    private     $_table_employees;
    
    /**
     * 
     * @param varchar $ldap
     * @param varchar $password
     * @return boolean
     */
    
    function login($ldap,$password)
    {
        $authAdapter = new Zend_Auth_Adapter_DbTable ( Zend_Db_Table::getDefaultAdapter () );
        $authAdapter->setTableName ('employees')
                    ->setIdentityColumn ('emp_ldap')
                    ->setCredentialColumn ('emp_pwd')
                    ->setIdentity ( $ldap )
                    ->setCredential ($password);
        // RETURN TRUE IF AUTHENTICATE EXIST
        return $authAuthenticate = $authAdapter->authenticate ();
    }
    
    /**
     * 
     * @return All Employees
     * 
     */
    
    public function getAll() {
        $resultSet = $this->fetchAll();
        $this->setTableEmployees($resultSet->toArray());
    }

   /**
    * @access public
    * @param  varchar  $ldap Description
    * 
    */
    
   public function getIni($ldap) {

        $row = $this->fetchRow("emp_ldap = '". $ldap."'");
        if (!$row) {
            throw new Exception("Impossible de trouver l'enregistrement $ldap");
        }
        $row_result = $row->toArray(); 
        $this->setId($row_result['emp_id']);
        $this->setEmp_firstname($row_result['emp_firstname']);
        $this->setEmp_lastname($row_result['emp_lastname']);
        $this->setEmp_admin($row_result['emp_admin']);
        $this->setEmp_cp($row_result['emp_cp']);
        $this->setEmp_ldap($row_result['emp_ldap']);
        $this->setEmp_pwd($row_result['emp_pwd']);  
   }

   /**
   * @access public
   * 
   */
   
   public function getCP($cp) {
      
       $cp = (int) $cp;
         $resultSet = $this->fetchRow(array('emp_id' => (int) $cp));
         if (!$resultSet) {
           throw new \Exception("Could not find row $cp");
        }
        $entities = array();
        $entity = new Employees();
        foreach ($resultSet as $row) { 
            $entity->setId($row->emp_id);
            $entity->setEmp_firstname($row->emp_firstname);
            $entity->setEmp_lastname($row->emp_lastname);
            $entity->setEmp_admin($row->emp_admin);
            $entity->setEmp_cp($row->emp_cp);
            $entity->setEmp_ldap($row->emp_ldap);
            $entity->setEmp_pwd($row->emp_pwd);
            $entities[] = $entity;
        }
        return $entities ;
   }

   /**
    * @access public
    * @param date $date Description date of formation duration
    */
   
   public function getEmployeeTask($id=null) {
       if($id != null){
            $where = 'E.emp_id = '.$id ;
        }
        else{
            $where = '1=1';
        }
        $date = new Zend_Date();
       $select =   $this->select()
                         ->from(array('E'=>'employees'),array('*'))
                         ->setIntegrityCheck(false)
                         ->joinLeft(array('EMP'=>'employees_projects'), " EMP.employees_emp_id= E.emp_id", 
                                    array('*'))
                         ->joinLeft(array('PRJ'=>'projects'), "PRJ.prj_id = EMP.projects_prj_id", 
                                    array('*') )
                         ->joinLeft(array('EHF'=>'employees_formations'), "EHF.employees_emp_id = E.emp_id", 
                                    array('*'))
                         ->joinLeft(array('FOR'=>'formations'), "FOR.for_id = EHF.formations_for_id", 
                                    array('*'))
                         ->joinLeft(array('GFO'=>'group_formation'), "GFO.grp_id = FOR.for_grp_id", 
                                    array('*'))
                         //->where(  'EHF.emf_startdate  < ?'    , $date)
                         //->where(  'EHF.emf_enddate    > ?'    , $date);
                         ->where(  'EHF.emf_responsable = ? or EMP.epr_cp = ?'   ,0,0)
                         ->where($where);

        
        $resultSet = $this->fetchAll($select);
        if (!$resultSet) {
           throw new \Exception("Could not find ");
        }
        $entities = array();
        $i=0;
        foreach ($resultSet as $row) {  
            $resp   =   $this->getEmployeeResponsable($row->for_id,  date('Y-m-d'));
            $cp     =   $this->getEmployeeCP($row->prj_id);
            if ($row->emf_startdate) {
                $date_start = $row->emf_startdate;
            } else {
                $date_start = '0000-00-00';
            }
            $date->set($date_start,Zend_Date::DATES);
            $date_started = $date->get(Zend_Date::DAY).'/'.$date->get(Zend_Date::MONTH).'/'.$date->get(Zend_Date::YEAR);
            if ($row->emf_startdate) {
                $date_end = $row->emf_enddate;
            } else {
                $date_end = '0000-00-00';
            }
            $date->set($date_end,Zend_Date::DATES);
            $date_end = $date->get(Zend_Date::DAY).'/'.$date->get(Zend_Date::MONTH).'/'.$date->get(Zend_Date::YEAR);
            $entities[$i]['id_employee']          =   $row->emp_id;
            $entities[$i]['id_project']           =   $row->prj_id;
            $entities[$i]['first_name']           =   $row->emp_firstname;
            $entities[$i]['last_name']            =   $row->emp_lastname;
            $entities[$i]['cp']                   =   $row->emp_cp;
            $entities[$i]['admin']                =   $row->emp_admin;
            $entities[$i]['ldap']                 =   $row->emp_ldap;
            $entities[$i]['project_name']         =   $row->prj_name;
            $entities[$i]['date_start']           =   $date_started;
            $entities[$i]['responsable']          =   $resp['first_name'].' '.$resp['last_name'];
            $entities[$i]['cp']                   =   $cp['first_name'].' '.$cp['last_name'];
            $entities[$i]['date_end']             =   $date_end;
            $entities[$i]['name_formation']       =   $row->for_name;
            $entities[$i]['description']          =   $row->for_description;
            $entities[$i]['duration']             =   $row->for_duration;
            $entities[$i]['status']               =   $row->emf_statusformation;
            $i++;     
        }
        // return table admin home
        return $entities;
   } 
    
    /**
    * @access public
    * @param integer $id_formation Description
    * @param date $date 
    */
   
   public function getEmployeeResponsable($id_formation,$date) {
       $id_formation = (int) $id_formation;
       $select =    $this->select()
                        ->from(array('E'=>'employees'),
                               array('E.emp_id','E.emp_firstname','E.emp_lastname','E.emp_ldap'))
                        ->setIntegrityCheck(false)
                        ->join(array('EHF'=>'employees_formations'), "EHF.employees_emp_id = E.emp_id",
                               array('EHF.emf_startdate','EHF.emf_enddate','formations_for_id','EHF.emf_responsable')
                               )
                        ->join(array('FOR'=>'formations'), "FOR.for_id = EHF.formations_for_id")               
                        ->where('EHF.emf_startdate < ?'     ,$date)
                        ->where('EHF.emf_enddate   > ?'     ,$date)
                        ->where('EHF.formations_for_id = ?' ,$id_formation)
                        ->where('EHF.emf_responsable = ?'   ,1);
       $row = $this->fetchRow($select);
       //var_dump($select);die;
         if (!$row) {
            $entities['id_employee']          =   1;
            $entities['first_name']           =   'Mnasri ';
            $entities['last_name']            =   'Walid';
            $entities['ldap']                 =   'wmnasri';
        }
        else{
        //print_r($row);die;
            $entities['id_employee']          =   $row->emp_id;
            $entities['first_name']           =   $row->emp_firstname;
            $entities['last_name']            =   $row->emp_lastname;
            $entities['ldap']                 =   $row->emp_ldap;
        }
        return $entities;
   } 
    
    /**
    * @access public
    * @param integer $id_formation Description
    * @param date $date 
    */
   
   public function getEmployeeCP($id_project) {
       $id_project = (int) $id_project;
       $select =    $this->select()
                        ->from(array('E'=>'employees'),
                               array('E.emp_id','E.emp_firstname','E.emp_lastname','E.emp_ldap'))
                        ->setIntegrityCheck(false)
                        ->join(array('EPR'=>'employees_projects'), "EPR.employees_emp_id = E.emp_id", 
                               array('projects_prj_id'))
                        ->join(array('PRJ'=>'projects'), "PRJ.prj_id = EPR.projects_prj_id")               
                        ->where('EPR.projects_prj_id = ?' ,$id_project)
                        ->where('EPR.epr_cp = ?'   ,1);
       $row = $this->fetchRow($select); 
       //echo $select;
        if (!$row) {
           $entities['id_employee']          =   1;
           $entities['first_name']           =   'Mnasri ';
           $entities['last_name']            =   'Walid';
           $entities['ldap']                 =   'wmnasri';
        }
        else{
        //print_r($row);die;
            $entities['id_employee']          =   $row->emp_id;
            $entities['first_name']           =   $row->emp_firstname;
            $entities['last_name']            =   $row->emp_lastname;
            $entities['ldap']                 =   $row->emp_ldap;
        }
        return $entities;
   } 
   
    public function getAllCP()
    {
        $entities = array();
        try {
            $select = $this->select()
                    ->from(array('emp' => 'employees'), array('emp_id' => 'emp.emp_id',
                        'emp_firstname' => 'emp.emp_firstname',
                        'emp_lastname' => 'emp.emp_lastname'
                    ))
                    ->where('emp.emp_cp = 1');
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
     * @access public
     * @param aId
     */
    public function setId($aId) {
            $this->_id = $aId;
    }

    /**
     * @access public
     */
    public function getId() {
            return $this->_id;
    }

    /**
     * @access public
     * @param aEmp_firstname
     */
    public function setEmp_firstname($aEmp_firstname) {
            $this->_emp_firstname = $aEmp_firstname;
    }

    /**
     * @access public
     */
    public function getEmp_firstname() {
            return $this->_emp_firstname;
    }

    /**
     * @access public
     * @param aEmp_lastname
     */
    public function setEmp_lastname($aEmp_lastname) {
            $this->_emp_lastname = $aEmp_lastname;
    }

    /**
     * @access public
     */
    public function getEmp_lastname() {
            return $this->_emp_lastname;
    }

    /**
     * @access public
     * @param aEmp_cp
     */
    public function setEmp_cp($aEmp_cp) {
            $this->_emp_cp = $aEmp_cp;
    }

    /**
     * @access public
     */
    public function getEmp_cp() {
            return $this->_emp_cp;
    }

    /**
     * @access public
     * @param aEmp_admin
     */
    public function setEmp_admin($aEmp_admin) {
            $this->_emp_admin = $aEmp_admin;
    }

    /**
     * @access public
     */
    public function getEmp_admin() {
            return $this->_emp_admin;
    }

    /**
     * @access public
     * @param aEmp_ldap
     */
    public function setEmp_ldap($aEmp_ldap) {
            $this->_emp_ldap = $aEmp_ldap;
    }

    /**
     * @access public
     */
    public function getEmp_ldap() {
            return $this->_emp_ldap;
    }

    /**
     * @access public
     * @param aEmp_pwd
     */
    public function setEmp_pwd($aEmp_pwd) {
            $this->_emp_pwd = $aEmp_pwd;
    }

    /**
     * @access public
     */
    public function getEmp_pwd() {
            return $this->_emp_pwd;
    }
    
    /**
     * @access public
     * @param aEmp_pwd
     */
    public function setTableEmployees($aEmp_pwd) {
            $this->_table_employees = $aEmp_pwd;
    }

    /**
     * @access public
     */
    public function getTableEmployees() {
            return $this->_table_employees;
    }
}

