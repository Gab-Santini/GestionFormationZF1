<?php
class Application_Form_LoginTest extends PHPUnit_Framework_TestCase
{
    protected $_form;
    
    protected function setUp()
    {
        $this->_form = new Application_Form_Login();
        parent::setUp();
    }
    protected function tearDown()
    {
        parent::tearDown();
        $this->_form = null;
    }
    public function goodData()
    {
        
		return array(
			array("wmnasri", "walid@@@"),
			array(" wmnasri ", " @@@")
			
		);
    }
    /**
     * @dataProvider goodData
     */
    public function testFormAcceptsValidData($ldap, $password)
    {
        $data= array('ldap' => $ldap, 'password' => $password);
        $this->assertTrue($this->_form->isValid($data));
    }
    public function badData()
    {
        return array (
            array ('',''),
            array ('', 'http://xkcd.com/327/'),
            array (str_repeat('x', 1000), ''),
        	array (8, 89),
          //  array ('<script>window.location = "http://www.google.com";</script>", '<script>window.location = "http://www.google.com";</script>'),
        );
    }
	/**
     * @dataProvider badData
     */
    public function testFormRejectsBadData($ldap, $password)
    {
        $data= array('ldap' => $ldap, 'password' => $password);
        $this->assertFalse($this->_form->isValid($data));
    }
}