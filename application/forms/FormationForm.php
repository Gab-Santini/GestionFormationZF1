<?php

class Application_Form_FormationForm extends Zend_Form
{

    public function init()
    {
        $this->setName('formation');
                
        $id = new Zend_Form_Element_Hidden('for_id');
        $id->addFilter('Int');
            
        $nom = new Zend_Form_Element_Text('for_name');
        $nom->setLabel('Nom*')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setAttrib('class','oneThree');
        $nom->getDecorator('Label')->setOption('class', 'red');
        
        $description = new Zend_Form_Element_Textarea('for_description');
        $description->setLabel('Description*')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setAttrib('id','editor');
        $description->getDecorator('Label')->setOption('class', 'red');
            
        $duration = new Zend_Form_Element_Text('for_duration');
        $duration->setLabel('Durée (jours)*')
            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')
            ->setAttribs(array('class'=>'oneThree','style'=>'width:100%'));
        $duration->addValidator('regex', false, array('/^[0-9]/i'));
        $duration->getDecorator('Label')->setOption('class', 'red');
        
//        $content = new Zend_Form_Element_File('for_filepath_input');
//        $content->setLabel('Contenu')
//            ->addValidator('Extension', false, 'xlsx,xls')
//            ->setRequired(false);
//            ->addValidator('Count', false,  array('min' => 1, 'max' => 2))
//            ->setMultiFile(2);
        $content = new Zend_Form_Element_File('for_filepath_input');
        $content->setLabel('Contenu')
                ->setDestination("./repDownload/");
        // Fait en sorte qu'il y ait un seul fichier
        $content->addValidator('Count', false, 1);
        // limite à 100K
        $content->addValidator('Size', false, 102400);
        // seulement des excel, txt, et csv
        $content->addValidator('Extension', false, 'xlsx,xls,txt,csv');
        
        $content_data = new Zend_Form_Element_Text('for_filepath');
        $content_data->setAttribs(array('readonly'=>true,'placeholder'=>'For edit purposes only'));
              
        $group = new Zend_Form_Element_Select('for_grp_id');
        $group->setLabel('Groupe Formation*')
            ->setRequired(true)
            ->addMultiOptions($this->getGroupOptions())
            ->setAttrib('class','chzn-single')
            ->addValidator('NotEmpty');
        $group->getDecorator('Label')->setOption('class', 'red');
          
       $submit = new Zend_Form_Element_Submit('submit');
       $submit->setAttribs(array('id'=>'submitbutton','class'=>'button greenB'));
       $submit->setDecorators(array( 'ViewHelper', 'Description', 'Errors',
               array(array('data'=>'HtmlTag'), array('tag' => 'td')),
               array(array('row'=>'HtmlTag'),array('tag'=>'tr', 'openOnly'=>true))
//               array(array('data'=>'HtmlTag'), array('tag' => 'br', 'openOnly'=>true))
       ));
               
        $reset = new Zend_Form_Element_Button('clear_criteria');
        $reset->setLabel("Re-initialiser")
                ->setValue("Annuler")
                ->setAttrib('class','button brownB');; 
        $reset->setAttrib('onclick', 'window.location.href = "/formation/add"; ');
        $reset->setDecorators(array( 'ViewHelper', 'Description', 'Errors',
             array(array('data'=>'HtmlTag'), array('tag' => 'td'))
       
        ));
                       
        $back = new Zend_Form_Element_Button('retour');
        $back->setLabel("Retour")
                ->setValue("retour")
                ->setAttrib('class','button redB');
        $back->setAttrib('onclick', 'window.location.href = "/formation/index"; ');
        $back->setDecorators(array( 'ViewHelper', 'Description', 'Errors',
             array(array('data'=>'HtmlTag'), array('tag' => 'td')),
             array(array('row'=>'HtmlTag'),array('tag'=>'tr', 'closeOnly'=>'true')) 
       
        ));
        
        $this->addElements(array($id, $nom,$description, $duration, $content, $content_data, $group, $submit, $reset, $back));
        
    }
    
    
    public function getGroupOptions()
    {
            $groups  =  new Application_Model_DbTable_GroupFormation();
            $groupOptions = $groups->fetchAll();
            
            $entities = array();
            $entities[''] = '---Veuillez choisir---';
            $i=0;
            foreach ($groupOptions as $row) { 
                $entities[$row->grp_id ] = $row->grp_name;
                $i++;     
            }
            return $entities  ;
    }
    
}

