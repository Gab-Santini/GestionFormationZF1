<?php

class Application_Form_EmployeeFormationForm extends Zend_Form
{	
    public function init()
    {
        $this->setName('employee_formation');

        $formations = new Application_Model_DbTable_Formations;
        $listeFormations = $formations->getAll();
        $tab = array();
        foreach ($listeFormations as $element) {
            $tab[$element['for_id']] = $element['for_name'];
        }

        $selFormation = new Zend_Form_Element_Select('selFormation');
        $selFormation->setLabel('Formation')
                ->addMultiOptions(array('' => 'Sélectionner une formation'))
                ->addMultiOptions($tab)
                ->removeDecorator('label')
                ->setRequired(TRUE)
                ->addValidator('NotEmpty')
                ->removeDecorator('HtmlTag')
                ->setOptions(array('multiple' => false, 'class'=> 'validate[required]'));
        
        $employees = new Application_Model_DbTable_Employees();
        $listeCp = $employees->getAllCP();
        $arrAllCp = array();
        foreach ($listeCp as $element) {
            $arrAllCp[$element['emp_id']] = ucfirst(strtolower($element['emp_firstname'])).' '.strtoupper($element['emp_lastname']);
        }

        $selResponsable = new Zend_Form_Element_Select('selResponsable');
        $selResponsable->setLabel('Responsable')
                ->addMultiOptions(array('' => 'Sélectionner un responsable'))
                ->addMultiOptions($arrAllCp)
                ->setRequired(TRUE)
                ->addValidator('NotEmpty')
                ->removeDecorator('label')
                ->removeDecorator('HtmlTag')
                ->setOptions(array('multiple' => false,'class'=> 'validate[required]'));
        $employees->getAll();
        $employees->getTableEmployees();
        $emp = array();
        foreach ($employees->getTableEmployees() as $element) {
            $emp[$element['emp_id']] = ucfirst(strtolower($element['emp_firstname'])).' '.strtoupper($element['emp_lastname']);
        }

        $multiSelEmployee = new Zend_Form_Element_Multiselect('multiSelEmployee');
        $multiSelEmployee->addMultiOptions($emp)
                ->removeDecorator('label')
                ->removeDecorator('HtmlTag')
        		->setRegisterInArrayValidator(false);
        $multiSelEmployee->setOptions(array('multiple' => true,'id'=>'box1View','class'=>'multiple','style'=>'height:300px;'));
        //
        $multiSelEmployeeSelected = new Zend_Form_Element_Multiselect('multiSelEmployeeSelected');
        $multiSelEmployeeSelected->removeDecorator('label')
        						 ->removeDecorator('HtmlTag')
        						 ->setRegisterInArrayValidator(false);

        $multiSelEmployeeSelected->setOptions(array('multiple' => true,'id'=>'box2View','class'=>'multiple validate[required]','style'=>'height:300px;'));
        //
        $to2 = new Zend_Form_Element_Button('to2');
        $to2->setLabel('>')
            ->removeDecorator('HtmlTag');
        $to2->setOptions(array('id'=>'to2','class'=>'basic mr5 mb15'));
        
        $allTo2 = new Zend_Form_Element_Button('allTo2');
        $allTo2->setLabel('>>')
                ->removeDecorator('HtmlTag');
        $allTo2->setOptions(array('id'=>'allTo2','class'=>'basic'));
        
        $to1 = new Zend_Form_Element_Button('to1');
        $to1->setLabel('<');
        $to1->removeDecorator('HtmlTag');
        $to1->setOptions(array('id'=>'to1','class'=>'basic mr5'));
        
        $allTo1 = new Zend_Form_Element_Button('allTo1');
        $allTo1->setLabel('<<')
               ->removeDecorator('HtmlTag');
               
 
        $allTo1->setOptions(array('id'=>'allTo1','class'=>'basic'));
        
        $this->addElements(array($selFormation, $selResponsable, $multiSelEmployee,$to2,$allTo2,$to1,$allTo1,$multiSelEmployeeSelected));

        
    }/*
    
    
    public function init()
    {
    	$this->addElement('text', 'username', array(
    			'decorators' => $this->elementDecorators,
    			'label'      => 'Username:')
        );
        $this->addElement('text', 'firstname', array(
            'decorators' => $this->elementDecorators,
            'label'       => 'First Name:')
    	);
    	$this->addElement('text', 'lastname', array(
    			'decorators' => $this->elementDecorators,
    			'label'       => 'Last Name:')
        );
        $this->addElement('submit', 'save', array(
            'decorators' => $this->buttonDecorators,
            'label'       => 'Save')
    	);
    }
    
    public function loadDefaultDecorators()
    {
    	$this->setDecorators(array(
    			'FormElements',
    			array('HtmlTag', array('tag' => 'table')),
    			'Form'
    	));
    }*/

}
