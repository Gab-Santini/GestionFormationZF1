<?php

/**
 * FormationController test case.
 */
class FormationControllerTest extends Zend_Test_PHPUnit_ControllerTestCase {
	
	/**
	 *
	 * @var FormationController
	 */
	private $FormationController;
	
	public function setUp()
	{
		$this->bootstrap = new Zend_Application(
				APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
		parent::setUp();
	}
	
	/**
	 * Tests FormationController->indexAction()
	 */
	public function testIndexAction() {
		$this->dispatch('/formation');
		$this->assertController('formation');
		$this->assertAction('index');
	}
	
	/**
	 * Get data from database for index page
	 */
	public function testIndexActionGetAll() {
		$listeFormations  =  new Application_Model_DbTable_Formations();
		$this->assertTrue($listeFormations->getAll() !== false);
		$totalRecords = count($listeFormations->getAll());
		echo "Total formation records: ".$totalRecords;
	}
	
	/**
	 * Tests FormationController->addAction()
	 */
	public function testAddAction() {
		$params = array('action' => 'add', 'controller' => 'formation');
		$urlParams = $this->urlizeOptions($params);
		$url = $this->url($urlParams);
		$this->dispatch($url);
	}
	
	/**
	 * Add action should contain formation form
	 */
	/*public function testAddActionShouldContainForm()
	{
		$this->dispatch('/formation/add');
		$this->assertQueryCount('form#formation', 1);
	}*/
	
	/**
	 * Add action should add data to database
	 */
	public function testAddActionShouldAddToDB() {
		$formation = new Application_Model_DbTable_Formations();
		$name = 'test_add_name';
		$description = 'test_add_description';
		$duration = 40;
		$content = 'test_content.xlsx';
		$group = 1;
	
		$this->assertTrue($formation->addFormation($name, $description, $duration, $content, $group) !== false);
	}
	
	/**
	 * After adding valid data to database, add action should redirect to index
	 */
	public function testAddActionShouldRedirectToIndex() {
		$testAccess = array(
				"ldap" => "mautar",
				"employe_id" => 4,
				"admin" => 1,
				"firstName" => "Melvina",
				"lastName" => "Autar"
		);
		
		$authNamespace = new Zend_Session_Namespace('USER');
		$authNamespace->user = $testAccess;
// 				var_dump($authNamespace->user);
		$this->request->setMethod('POST')
		->setPost(array(
				'for_name' => 'test_add_name',
				'for_description'    => 'test_add_description',
				'for_duration' => 40,
				'for_filepath_input' => 'test_content.xlsx',
				'for_grp_id' => 1,
		));
// 		     print_r($_POST);
		//$this->dispatch('/formation/add');
		//$this->assertRedirectTo('/formation/index');
	}
		
	
	/**
	 * Tests FormationController->editAction()
	 */
	public function testEditAction() {
		// TODO Auto-generated FormationControllerTest->testEditAction()
		$this->markTestIncomplete ( "editAction test not implemented" );
		
		$this->FormationController->editAction(/* parameters */);
	}
	
	/**
	 * Tests FormationController->deleteAction()
	 */
	public function testDeleteAction() {
		// TODO Auto-generated FormationControllerTest->testDeleteAction()
		$this->markTestIncomplete ( "deleteAction test not implemented" );
		
		$this->FormationController->deleteAction(/* parameters */);
	}
	
	/**
	 * Tests FormationController->deletetestAction()
	 */
	public function testDeletetestAction() {
		// TODO Auto-generated FormationControllerTest->testDeletetestAction()
		$this->markTestIncomplete ( "deletetestAction test not implemented" );
		
		$this->FormationController->deletetestAction(/* parameters */);
	}
	
	/**
	 * Tests FormationController->detailAction()
	 */
	public function testDetailAction() {
		// TODO Auto-generated FormationControllerTest->testDetailAction()
		$this->markTestIncomplete ( "detailAction test not implemented" );
		
		$this->FormationController->detailAction(/* parameters */);
	}
	
	/**
	 * Tests FormationController->downloadAction()
	 */
	public function testDownloadAction() {
		// TODO Auto-generated FormationControllerTest->testDownloadAction()
		$this->markTestIncomplete ( "downloadAction test not implemented" );
		
		$this->FormationController->downloadAction(/* parameters */);
	}
	
	/**
	 * Tests FormationController->assignAction()
	 */
	public function testAssignAction() {
		// TODO Auto-generated FormationControllerTest->testAssignAction()
		$this->markTestIncomplete ( "assignAction test not implemented" );
		
		$this->FormationController->assignAction(/* parameters */);
	}
	
	/**
	 * Tests FormationController->testAction()
	 */
	public function testTestAction() {
		// TODO Auto-generated FormationControllerTest->testTestAction()
		$this->markTestIncomplete ( "testAction test not implemented" );
		
		$this->FormationController->testAction(/* parameters */);
	}
}

