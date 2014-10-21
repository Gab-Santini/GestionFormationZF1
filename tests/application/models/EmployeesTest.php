<?php

/**
 * Application_Model_DbTable_Employees test case.
 */
class Application_Model_DbTable_EmployeesTest extends PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var Application_Model_DbTable_Employees
	 */
	private $Application_Model_DbTable_Employees;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		
		parent::setUp ();$this->bootstrap = new Zend_Application(
				APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
		$this->Application_Model_DbTable_Employees = new Application_Model_DbTable_Employees();
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->login()
	 */
	public function testLogin() {
		
		$this->Application_Model_DbTable_Employees->login();
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->getAll()
	 */
	public function testGetAll() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testGetAll()
		$this->markTestIncomplete ( "getAll test not implemented" );
		
		$this->Application_Model_DbTable_Employees->getAll();
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->getIni()
	 */
	public function testGetIni() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testGetIni()
		$this->markTestIncomplete ( "getIni test not implemented" );
		
		$this->Application_Model_DbTable_Employees->getIni();
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->getCP()
	 */
	public function testGetCP() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testGetCP()
		$this->markTestIncomplete ( "getCP test not implemented" );
		
		$this->Application_Model_DbTable_Employees->getCP(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->getEmployeeTask()
	 */
	public function testGetEmployeeTask() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testGetEmployeeTask()
		$this->markTestIncomplete ( "getEmployeeTask test not implemented" );
		
		$this->Application_Model_DbTable_Employees->getEmployeeTask(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->getEmployeeResponsable()
	 */
	public function testGetEmployeeResponsable() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testGetEmployeeResponsable()
		$this->markTestIncomplete ( "getEmployeeResponsable test not implemented" );
		
		$this->Application_Model_DbTable_Employees->getEmployeeResponsable(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->getEmployeeCP()
	 */
	public function testGetEmployeeCP() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testGetEmployeeCP()
		$this->markTestIncomplete ( "getEmployeeCP test not implemented" );
		
		$this->Application_Model_DbTable_Employees->getEmployeeCP(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->getAllCP()
	 */
	public function testGetAllCP() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testGetAllCP()
		$this->markTestIncomplete ( "getAllCP test not implemented" );
		
		$this->Application_Model_DbTable_Employees->getAllCP(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->setId()
	 */
	public function testSetId() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testSetId()
		$this->markTestIncomplete ( "setId test not implemented" );
		
		$this->Application_Model_DbTable_Employees->setId(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->getId()
	 */
	public function testGetId() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testGetId()
		$this->markTestIncomplete ( "getId test not implemented" );
		
		$this->Application_Model_DbTable_Employees->getId(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->setEmp_firstname()
	 */
	public function testSetEmp_firstname() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testSetEmp_firstname()
		$this->markTestIncomplete ( "setEmp_firstname test not implemented" );
		
		$this->Application_Model_DbTable_Employees->setEmp_firstname(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->getEmp_firstname()
	 */
	public function testGetEmp_firstname() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testGetEmp_firstname()
		$this->markTestIncomplete ( "getEmp_firstname test not implemented" );
		
		$this->Application_Model_DbTable_Employees->getEmp_firstname(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->setEmp_lastname()
	 */
	public function testSetEmp_lastname() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testSetEmp_lastname()
		$this->markTestIncomplete ( "setEmp_lastname test not implemented" );
		
		$this->Application_Model_DbTable_Employees->setEmp_lastname(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->getEmp_lastname()
	 */
	public function testGetEmp_lastname() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testGetEmp_lastname()
		$this->markTestIncomplete ( "getEmp_lastname test not implemented" );
		
		$this->Application_Model_DbTable_Employees->getEmp_lastname(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->setEmp_cp()
	 */
	public function testSetEmp_cp() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testSetEmp_cp()
		$this->markTestIncomplete ( "setEmp_cp test not implemented" );
		
		$this->Application_Model_DbTable_Employees->setEmp_cp(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->getEmp_cp()
	 */
	public function testGetEmp_cp() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testGetEmp_cp()
		$this->markTestIncomplete ( "getEmp_cp test not implemented" );
		
		$this->Application_Model_DbTable_Employees->getEmp_cp(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->setEmp_admin()
	 */
	public function testSetEmp_admin() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testSetEmp_admin()
		$this->markTestIncomplete ( "setEmp_admin test not implemented" );
		
		$this->Application_Model_DbTable_Employees->setEmp_admin(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->getEmp_admin()
	 */
	public function testGetEmp_admin() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testGetEmp_admin()
		$this->markTestIncomplete ( "getEmp_admin test not implemented" );
		
		$this->Application_Model_DbTable_Employees->getEmp_admin(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->setEmp_ldap()
	 */
	public function testSetEmp_ldap() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testSetEmp_ldap()
		$this->markTestIncomplete ( "setEmp_ldap test not implemented" );
		
		$this->Application_Model_DbTable_Employees->setEmp_ldap(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->getEmp_ldap()
	 */
	public function testGetEmp_ldap() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testGetEmp_ldap()
		$this->markTestIncomplete ( "getEmp_ldap test not implemented" );
		
		$this->Application_Model_DbTable_Employees->getEmp_ldap(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->setEmp_pwd()
	 */
	public function testSetEmp_pwd() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testSetEmp_pwd()
		$this->markTestIncomplete ( "setEmp_pwd test not implemented" );
		
		$this->Application_Model_DbTable_Employees->setEmp_pwd(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->getEmp_pwd()
	 */
	public function testGetEmp_pwd() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testGetEmp_pwd()
		$this->markTestIncomplete ( "getEmp_pwd test not implemented" );
		
		$this->Application_Model_DbTable_Employees->getEmp_pwd(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->setTableEmployees()
	 */
	public function testSetTableEmployees() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testSetTableEmployees()
		$this->markTestIncomplete ( "setTableEmployees test not implemented" );
		
		$this->Application_Model_DbTable_Employees->setTableEmployees(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_Employees->getTableEmployees()
	 */
	public function testGetTableEmployees() {
		// TODO Auto-generated Application_Model_DbTable_EmployeesTest->testGetTableEmployees()
		$this->markTestIncomplete ( "getTableEmployees test not implemented" );
		
		$this->Application_Model_DbTable_Employees->getTableEmployees(/* parameters */);
	}
}

