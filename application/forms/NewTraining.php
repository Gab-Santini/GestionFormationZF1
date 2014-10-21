<?php

class Application_Form_NewTraining extends Zend_Form {

    public function init() {
        $formations = new Application_Model_DbTable_Formations;
        $liste = $formations->getAll();
        $tab = array('0'=>'Selectionner une formation');
        foreach ($liste as $element) {
            $tab[$element['for_name']] = $element['for_name'];
        }
        $this->setName('Nouvelle formation')
             ->setAction('demanderformation')
             ->setMethod('post');
        $formation = new Zend_Form_Element_Select('formation');
        $formation->setLabel('Formation')
                ->setMultiOptions($tab)
                ->setIsArray(true)
                ->setAttrib('class', 'groupe')
                ->setOptions(array('multiple' => false));
        $autre = new Zend_Form_Element_Text('autre');
        $autre->setLabel('Autre');
        
        $envoyer = new Zend_Form_Element_Submit('envoyer');
        $envoyer->setAttrib('id', 'boutonenvoyer');
        $envoyer->setAttrib('class', 'btn btn-primary');
        $this->addElements(array($formation, $autre, $envoyer));

        $this->setElementDecorators(array(
            'ViewHelper',
            'Label',
            array(
                'HtmlTag',
                'class'=>'lbl',
                array(
                    'tag' => 'div'))));
    }

}
