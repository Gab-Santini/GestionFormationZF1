<?php

class Application_Form_TestQuestions extends Zend_Form {

    /**Fonction en cours pour afficher le questionnaire 
     **
     */
    public function init() 
    {
        $tests=new Application_Model_DbTable_Questions();
        $liste=$tests->getQuestionsByTest(1);
        $choices= new Application_Model_DbTable_QuestionsChoices();
        $choices->getChoicesByQuestion1(1);
        $tab = array();
        foreach ($liste as $key=>$element)
        {
        //echo $element['qst_title'];
        foreach($choices=$element['reponse'] as $key_ch=>$element_ch)
        {
        $this->addElement('radio', 'q', array(
                   //'label' => $liste[$cle]['q'.$cle],
                 'label' => 'salut',
                   'class'=>'qst',
                   'id'=>'ds',
                   //'onClick'=>'requestResponse(this);',
                   'multiOptions' => $element_ch,
                   'Separator' => ('')
               ));
        }
        } 
        $submit = new Zend_Form_Element_Submit('soumettre');
        $submit->setAttrib('id', 'boutonenvoyer');
        $submit->setAttrib('class', 'btn btn-primary');
        $submit->setLabel('soumettre le test');
        $this->addElements(array($submit));
        $this->clearDecorators();
        $this->addDecorator('FormElements')
                ->addDecorator('HtmlTag', array('tag' => '<ul>'))
                ->addDecorator('Form');

        $this->setElementDecorators(array(
            array('ViewHelper'),
            array('Errors'),
            array('Description'),
            array('Label', array('separator' => ' ')),
            array('HtmlTag', array('tag' => 'li', 'class' => 'element-group')),
        ));
        $submit->setDecorators(array(
        array('ViewHelper'),
        array('Description'),
        array('HtmlTag', array('tag' => 'div', 'class'=>'submit-group')),
        ));
    }

}
