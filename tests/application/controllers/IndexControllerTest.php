<?php

	/**
	 * @category test for controller index class 
	 * @author wmnasri
	 *
	 */

class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{	
	/**
	 * 
	 * (non-PHPdoc)
	 * @see Zend_Test_PHPUnit_ControllerTestCase::setUp()
	 */
	
	public function setUp()
	{
		$this->bootstrap = new Zend_Application(
				APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
		parent::setUp();
	}
	
	/**
	 * 
	 * 
	 */
	
	public function testIndexAction() 
	{
		$this->dispatch('/index');
		$this->assertController('index');
		$this->assertAction('index');
	}
	
	/**
	 *
	 *
	 */
	
	public function testSessionAdmin()
	{
		 
		$authNamespace = new Zend_Session_Namespace('USER');
		$session = array();
		//load data in array
		$session['cp']              = '1';
		$session['admin']           = '1';
		//load array $session in session namespace 'user'
		$authNamespace->user    = $session;
		$this->dispatch('/index');
		$this->assertRedirectTo('/index/admin');
		
		$this->dispatch('/index/admin');
		$this->assertRoute('default');
		$this->assertModule('default');
		$this->assertController('index');
		$this->assertAction('admin');

	
	}
	/**
	 *
	 *
	 */
	
	public function testSessionUser()
	{
			
		$authNamespace = new Zend_Session_Namespace('USER');
		$session = array();
		//load data in array
		$session['cp']              = '0';
		$session['admin']           = '0';
		//load array $session in session namespace 'user'
		$authNamespace->user    = $session;
		$this->dispatch('/index');
		$this->assertRedirectTo('/user/index');	
		$this->dispatch('/user/index');
		$this->assertRoute('default');
		$this->assertModule('default');
		$this->assertController('user');
		$this->assertAction('index');
	
	
	}
	
	/**
	 * 
	 * 
	 */
	
 	public function testIndexActionShouldContainLoginForm()
    {
        $this->dispatch('/index');
        $this->assertAction('index');
        $this->assertQueryCount('form#login', 1);
    }
    
    /**
     * 
     * 
     */
    
    public function testValidLoginShouldGoToProfileAdminPage()
    {
    	$this->request->setMethod('POST')
    	->setPost(array(
    			'ldap' => 'wmnasri',
    			'password' => '@@'
    	));
    	$this->dispatch('/index');
    	$this->assertRedirectTo('/index/admin');
    
    	$this->resetRequest()
    	->resetResponse();
    	
    	$this->request->setMethod('GET')
    	->setPost(array());
    	$this->dispatch('/index/admin');
    	$this->assertRoute('default');
    	$this->assertModule('default');
    	$this->assertController('index');
    	$this->assertAction('admin');
    	$this->assertNotRedirect();
    	$this->assertQuery('li');
    	$this->assertQueryContentContains('span', 'WAsrfdszdxI');
    }
    
    /**
     * 
     * 
     */
    
    public function testValidLoginShouldGoToProfileUserPage()
    {
    	$this->request->setMethod('POST')
    	->setPost(array(
    			'ldap' => 'pmartin',
    			'password' => 'pmartin'
    	));
    	$this->dispatch('/index');
    	$this->assertRedirectTo('/');
    
    	$this->resetRequest()
    	->resetResponse();
    	 
    	$this->request->setMethod('GET')
    	->setPost(array());
    	$this->dispatch('/user');
    	$this->assertRoute('default');
    	$this->assertModule('default');
    	$this->assertController('user');
    	$this->assertAction('index');
    	$this->assertNotRedirect();
    }
    
    /**
     * 
     * 
     */
    /**
     *
     *
     */
    
    public function testNotValidLogin()
    {
    	$this->request->setMethod('POST')
    	->setPost(array(
    			'ldap' => 'sdas',
    			'password' => '@'
    	));
    	$this->dispatch('/index/index');
    
    	$this->resetRequest()
    	->resetResponse();
    	 
    	$this->request->setMethod('GET')
    	->setPost(array());
    	$this->dispatch('/index/index');
    	$this->assertRoute('default');
    	$this->assertModule('default');
    	$this->assertController('index');
    	$this->assertAction('index');;
    }
    
    public function testLogOut()
    {
    	$authNamespace = new Zend_Session_Namespace('USER');

    	$this->assertEmpty($authNamespace->user);
    	$this->dispatch('/index/logout');
    	$this->assertRedirectTo('/');
    	
    	$this->dispatch('/index/index');
    	$this->assertRoute('default');
    	$this->assertModule('default');
    	$this->assertController('index');
    	$this->assertAction('index');
    }
    
    /**
     *
     *
     */
    
    public function testNotFoundHomeAdmin()
    {
    	$authNamespace = new Zend_Session_Namespace('USER');
		$session = array();
		//load data in array
		$session['cp']              = '0';
		$session['admin']           = '0';
		//load array $session in session namespace 'user'
		$authNamespace->user    = $session;
		$this->dispatch('/index/admin');
		$this->assertRedirectTo('/index/notfound');
		
		$this->dispatch('/index/notfound');
		$this->assertRoute('default');
		$this->assertModule('default');
		$this->assertController('index');
		$this->assertAction('notfound');
    }
    
    /**
     *
     *
     */
    
    public function testNotFoundDetailsAdmin()
    {
    	$authNamespace = new Zend_Session_Namespace('USER');
    	$session = array();
    	//load data in array
    	$session['cp']              = '0';
    	$session['admin']           = '0';
    	//load array $session in session namespace 'user'
    	$authNamespace->user    = $session;
    	$this->dispatch('/index/details');
    	$this->assertRedirectTo('/index/notfound');
    
    	$this->dispatch('/index/notfound');
    	$this->assertRoute('default');
    	$this->assertModule('default');
    	$this->assertController('index');
    	$this->assertAction('notfound');
    }
    
}