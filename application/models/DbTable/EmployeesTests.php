<?php
class Application_Model_DbTable_EmployeesTests extends Zend_Db_Table_Abstract {
	protected $_name = 'employees_tests';
	private $_ets_id;
	private $_ets_status;
	private $_tests_tst_id;
	private $_employees_emp_id;
	private $_ets_note;
	private $_ets_datetest;
	private $_attributs = array ();
	
	/**
	 * fonction qui permet d'ajouter un object employee_test dans la base
	 * 
	 * @param object $employees_tests        	
	 * @return boolean
	 * @access public
	 */
	public function save() {
		try {
			$aData = array (
					'ets_id' => $this->_attributs ['_ets_id'],
					'ets_status' => $this->_attributs ['_ets_status'],
					'tests_tst_id' => $this->_attributs ['_tests_tst_id'],
					'employees_emp_id' => $this->_attributs ['_employees_emp_id'],
					'ets_note' => $this->_attributs ['_ets_note'],
					'ets_datetest' => $this->_attributs ['_ets_datetest'] 
			);
			if ($this->_attributs ['_ets_id'] == 0) {
				return ($this->insert ( $aData )==0)? true : false;
			} else {
                return ($this->update($aData, 'ets_id = ' . (int) $this->_attributs['_ets_id'])==0)? true:false;
			}
		} catch ( Zend_Exception $e ) {
			echo $e->getMessage ();
		return false;
		}
	}
	
	/**
	 * fonction qui permet de retourner toutes les tests des tous les employees
	 * 
	 * @return array $entities
	 * @access public
	 */
	public function getAll() {
		$entities = array ();
		try {
			$select = $this->select ()->from ( array (
					'ets' => 'employees_tests' 
			) )->columns ( array (
					'test_emp_id' => 'ets.ets_id',
					'status' => 'ets.ets_status',
					'test_id' => 'ets.tests_tst_id',
					'emp_id' => 'ets.employees_emp_id',
					'note' => 'ets.ets_note',
					'date' => 'ets.ets_datetest' 
			) )->order ( 'ets_id' );
			$rows = $this->fetchAll ( $select );
			if (! empty ( $rows )) {
				$entities = $rows->toArray ();
			}
		} catch ( Zend_Exception $e ) {
			echo $e->getMessage ();
		}
		return $entities;
	}
	
	/**
	 * fonction qui permet de retourner un seul test
	 * 
	 * @param int $id        	
	 * @return array $entity
	 * @access public
	 */
	public function getIni($id) {
		$entity = array ();
		try {
			$select = $this->select ()->from ( array (
					'ets' => 'employees_tests' 
			) )->columns ( array (
					'test_emp_id' => 'ets.ets_id',
					'status' => 'ets.ets_status',
					'test_id' => 'ets.tests_tst_id',
					'emp_id' => 'ets.employees_emp_id',
					'note' => 'ets.ets_note',
					'date' => 'ets.ets_datetest' 
			) )->where ( 'ets_id = :id' )->bind ( array (
					':id' => $id 
			) );
			$row = $this->fetchRow ( $select );
			if (! empty ( $row )) {
				$entity = $row->toArray ();
			}
		} catch ( Zend_Exception $e ) {
			echo $e->getMessage ();
		}
		return $entity;
	}
	
	/**
	 * fonction qui permet de retourner la resultat d'un test pass� par un employee
	 * 
	 * @param int $id        	
	 * @return array $entity
	 * @access public
	 */
	public function getResult($id) {
		$entity = array ();
		try {
			$select = $this->select ()->from ( array (
					'ets' => 'employees_tests' 
			), array (
					'test_emp_id' => 'ets.ets_id',
					'status' => 'ets.ets_status',
					'test_id' => 'ets.tests_tst_id',
					'emp_id' => 'ets.employees_emp_id',
					'note' => 'ets.ets_note',
					'date' => new Zend_Db_Expr ( 'DATE_FORMAT(ets.ets_datetest,\'%d/%m/%Y\')' ) 
			) )->setIntegrityCheck ( false )->join ( array (
					'emp' => 'employees' 
			), 'emp.emp_id=ets.employees_emp_id', array (
					'firstname' => 'emp.emp_firstname',
					'lasttname' => 'emp.emp_lastname',
					'ldap' => 'emp.emp_ldap' 
			) )->where ( 'ets_id = :id' )->bind ( array (
					':id' => $id 
			) );
			$row = $this->fetchAll ( $select );
			if (! empty ( $row )) {
				$entity = $row->toArray ();
			}
		} catch ( Zend_Exception $e ) {
			echo $e->getMessage ();
		}
		return $entity;
	}
	
	/**
	 * fonction qui permet de retourner la resultat d'un test passe par un employee
	 * 
	 * @param int $formatiom_id        	
	 * @param int $emp_id        	
	 * @return array $entities
	 * @access public
	 */
	public function getNoteByTestByEmployee($formation_id, $emp_id) {
		$entities = array ();
		try {
			$select = $this->select ()->from ( array (
					'ets' => 'employees_tests' 
			), array (
					'test_emp_id' => 'ets.ets_id',
					'status' => 'ets.ets_status',
					'test_id' => 'ets.tests_tst_id',
					'emp_id' => 'ets.employees_emp_id',
					'note' => 'ets.ets_note',
					'date' => new Zend_Db_Expr ( 'DATE_FORMAT(ets.ets_datetest,\'%d/%m/%Y\')' ) 
			) )->setIntegrityCheck ( false )->join ( array (
					'tst' => 'tests' 
			), 'tst.tst_id=ets.tests_tst_id' )->where ( 'tst.tst_for_id = :for_id' )->where ( 'employees_emp_id = :emp_id' )->bind ( array (
					':for_id' => $formation_id,
					':emp_id' => $emp_id 
			) );
			$row = $this->fetchAll ( $select );
			if (! empty ( $row )) {
				$entities = $row->toArray ();
			}
		} catch ( Zend_Exception $e ) {
			echo $e->getMessage ();
		}
		return $entities;
	}
	
	/**
	 * fonction qui permet de telecharger un fichier passe en paramettre
	 * 
	 * @param file $filename        	
	 * @access public
	 */
	public static function download($filename) {
		$dossier = "repDownload";
		$filepath = $dossier . "/" . $filename;
		$filesize = filesize ( $filepath );
		$filemd5 = md5_file ( $filepath );
		
		// Gestion du cache
		header ( 'Pragma: public' );
		header ( 'Last-Modified: ' . gmdate ( 'D, d M Y H:i:s' ) . ' GMT' );
		header ( 'Cache-Control: must-revalidate, pre-check=0, post-check=0, max-age=0' );
		// Informations sur le contenu à envoyer
		// header('Content-Tranfer-Encoding: ' . $type . "\n");
		header ( 'Content-Length: ' . $filesize );
		header ( 'Content-MD5: ' . base64_encode ( $filemd5 ) );
		header ( 'Content-Type: application/force-download; name="' . $filename . '"' );
		header ( 'Content-Disposition: attachement; filename="' . $filename . '"' );
		// Informations sur la réponse HTTP elle-même
		header ( 'Date: ' . gmdate ( 'D, d M Y H:i:s', time () ) . ' GMT' );
		header ( 'Expires: ' . gmdate ( 'D, d M Y H:i:s', time () + 1 ) . ' GMT' );
		header ( 'Last-Modified: ' . gmdate ( 'D, d M Y H:i:s', time () ) . ' GMT' );
		readfile ( $filepath );
		exit ();
	}
	
	/**
	 * Methode magique pour getter les variable
	 * 
	 * @param mixed $nom        	
	 * @return array $attributs
	 * @access public
	 */
	public function __get($nom) {
		if (isset ( $this->_attributs [$nom] )) {
			return $this->_attributs [$nom];
		}
	}
	
	/**
	 * Methode magique pour setter les variables
	 * 
	 * @param mixed $nom        	
	 * @param mixed $valeur        	
	 * @access public
	 */
	public function __set($nom, $valeur) {
		$this->_attributs [$nom] = $valeur;
	}
}
