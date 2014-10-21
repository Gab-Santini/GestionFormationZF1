<?php
// require_once '../../../../library/Zend/Db/Table.php';
// require_once '../../../../application/models/DbTable/EmployeesTests.php';
// require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Application_Model_DbTable_EmployeesTests test case.
 */
class Application_Model_DbTable_EmployeesTestsTest extends PHPUnit_Framework_TestCase {
	
	/**
	 *
	 * @var Application_Model_DbTable_EmployeesTests
	 */
	private $Application_Model_DbTable_EmployeesTests;
	private $getAll;
	private $getIni;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$this->Application_Model_DbTable_EmployeesTests = new Application_Model_DbTable_EmployeesTests(/* parameters */);
		$this->getAll=$this->Application_Model_DbTable_EmployeesTests->getAll ();
		$this->getIni=$this->Application_Model_DbTable_EmployeesTests->getIni ( 1 );
		
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated TestApplication_Model_DbTable_EmployeesTests::tearDown()
		$this->Application_Model_DbTable_EmployeesTests = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		$parameters = array (
				'host' => 'STERNE',
				'username' => 'gestionForm_root',
				'password' => '$5gest10N5$',
				'dbname' => 'gestionFormation',
				'adapter' => 'Pdo_Mysql' 
		);
		try {
			$db = Zend_Db::factory ( 'Pdo_Mysql', $parameters );
			$db->getConnection ();
		} catch ( Zend_Db_Adapter_Exception $e ) {
		} catch ( Zend_Exception $e ) {
		}
		Zend_Db_Table::setDefaultAdapter ( $db );
	}
	/**
	 * ******** Test pour la fonction save ****************
	 */
	//Tester si la fonction de l'insertion retourne true ou non
	public function testInsert(){
		$this->Application_Model_DbTable_EmployeesTests->_ets_id = 0;
		$this->Application_Model_DbTable_EmployeesTests->_ets_status = 1;
		$this->Application_Model_DbTable_EmployeesTests->_tests_tst_id = 37;
		$this->Application_Model_DbTable_EmployeesTests->_employees_emp_id = 1;
		$this->Application_Model_DbTable_EmployeesTests->_ets_note = 67;
		$this->Application_Model_DbTable_EmployeesTests->_ets_datetest = '2014-03-14';
		//$this->assertTrue($this->Application_Model_DbTable_EmployeesTests->save());
	}
	//Tester si la fonction de la mise á jour retourne true ou non
	public function testUpdate(){
		$this->Application_Model_DbTable_EmployeesTests->_ets_id = 43;
		$this->Application_Model_DbTable_EmployeesTests->_ets_status = 1;
		$this->Application_Model_DbTable_EmployeesTests->_tests_tst_id = 37;
		$this->Application_Model_DbTable_EmployeesTests->_employees_emp_id = 1;
		$this->Application_Model_DbTable_EmployeesTests->_ets_note = 67;
		$this->Application_Model_DbTable_EmployeesTests->_ets_datetest = '2014-03-14';
		$this->assertTrue($this->Application_Model_DbTable_EmployeesTests->save());
	}
	/**
	 * ******** Test pour la fonction getAll() ****************
	 */
	// testr si un valeur existe dans un tableau
	public function testGetAllContains() {
		$this->assertContains ( 60, $this->getAll[0]);
	}
	// Tester si une valeur represente un cle dans un array
	public function testGetAllArrayHasKey() {
		$this->assertArrayHasKey ( 'employees_emp_id', $this->getAll);
	}
	/**
	 * ******** Test pour la fonction getIni($id) ****************
	 */
	// testr si un valeur existe dans un tableau
	public function testGetIniContains() {
		$this->assertContains ( '60', $this->getIni);
	}
	// Tester si une valeur represente un cle dans un array
	public function testGetIniArrayHasKey() {
		$this->assertArrayHasKey ( 'employees_emp_id', $this->getIni);
	}
	// Tester si deux attribut ont la meme valeur
	public function testGetIniEquals() {
		$this->assertEquals ( $this->getIni, $this->getIni );
	}
	public function testGetIniAttributeInternalType() {
		$this->$this->assertAttributeInternalType ( 'string', 'employees_emp_id', $this->getIni);
	}
	public function testGetIniInternalType() {
		$this->$this->assertInternalType ( 'array', $this->getIni);
	}
	// tester si deux attributs ont la meme valeur et de meme type
	public function testGetIniSame()
	{
		$this->assertSame('1', $this->getIni['employees_emp_id']);
	}
	//tester si un attribut se termine par une chaine de caractere donnee
	public function testGetIniStringEndsWith()
	{
		$this->assertStringEndsWith('-06', $this->getIni['date']);
	}
	//tester si un attribut commence par une chaine de caractere donnee
	public function testGetIniStringStartsWith()
	{
		$this->assertStringStartsWith('2014', $this->getIni['date']);
	}
	// tester si le deuxieme attribut est plus grand que le premier
	public function testGetIniGreaterThan()
	{
		$this->assertGreaterThan(50, $this->getIni['note']);
	}
	// tester si le deuxieme attribut est plus petit que le premier
	public function testGetIniLessThan()
	{
		$this->assertLessThan(90, $this->getIni['note']);
	}
	// tester si un chaine de caractere respecte un format donne
	public function testGetIniRegExp()
	{
		$this->assertRegExp('/2014-[0-9][0-9]-[0-9][0-9]/', $this->getIni['ets_datetest']);
	}
	
	/**
	 * Tests Application_Model_DbTable_EmployeesTests->__get()
	 */
	public function test__get() {
		// TODO Auto-generated TestApplication_Model_DbTable_EmployeesTests->test__get()
		$this->markTestIncomplete ( "__get test not implemented" );
		
		$this->Application_Model_DbTable_EmployeesTests->__get(/* parameters */);
	}
	
	/**
	 * Tests Application_Model_DbTable_EmployeesTests->__set()
	 */
	public function test__set() {
		// TODO Auto-generated TestApplication_Model_DbTable_EmployeesTests->test__set()
		$this->markTestIncomplete ( "__set test not implemented" );
		
		$this->Application_Model_DbTable_EmployeesTests->__set(/* parameters */);
	}
}

