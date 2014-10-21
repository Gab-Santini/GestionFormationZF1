<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Application_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setName('login');

        $ldap = new Zend_Form_Element_Text('ldap');
        $ldap->setLabel('Ldap User')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('class','span12 sharp');

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty')
              ->setAttrib('class','span12 sharp');

        $envoyer = new Zend_Form_Element_Submit('envoyer');
        $envoyer->setAttribs(array('id'=>'submitbutton','class'=>'btn btn-small btn-primary sharp'));

        $this->addElements(array($ldap, $password, $envoyer));
    }
}
