<?php

class Application_Model_DbTable_Choices extends Zend_Db_Table_Abstract
{

    protected $_name = 'choices';
    private $_chs_id;
    private $_chs_title;
   
    /**
     * fonction qui permet d'ajouter un object Choice dans la base
     * @param object $choice
     * @return last id mis a jour  ou false
     * @access public
     */
    public function saveChoice($isNew=NULL) 
    {
        $data = array('chs_title'     => $this->getChs_title());
        
              // if id is null, add else update
        if ($isNew == 0 || $isNew == NULL){
            if (!$this->insert($data)){
                return false;
            }else{
                return $this->getAdapter()->lastInsertId();
            }
        }
        else {
            //$this->update($data, 'chs_id = '.(int)$isNew);
            if($this->update($data, 'chs_id = '.(int)$isNew)){
                return (int)$isNew;
            }
        }                  
    }
  
    
    /**
     * @access public
     * @param aChs_id
     */
    public function setChs_id($aChs_id) 
    {
            $this->_chs_id = $aChs_id;
    }

    /**
     * @access public
     */
    public function getChs_id() 
    {
            return (int) $this->_chs_id;
    }

    /**
     * @access public
     * @param aChs_title
     */
    public function setChs_title($aChs_title) 
    {
        $this->_chs_title = $aChs_title;
    }

    /**
     * @access public
     */
    public function getChs_title() 
    {
        return $this->_chs_title;
    }
    

}

