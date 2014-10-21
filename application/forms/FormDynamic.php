<?php
     
     
    /**
     * Proof of concept: dynamically adding elements to a Zend_Form
     */
    class Application_Form_FormDynamic extends Zend_Form {
           
      public function init() {
           
        $this->addElement('hidden', 'id', array(
          'value' => 1
        ));
       
        $this->addElement('text', 'name', array(
          'required' => true,
          'label'    => 'Name',
          'order'    => 2,
        ));
       
        $this->addElement('button', 'addElement', array(
          'label' => 'Add',
          'order' => 91
        ));
       
        $this->addElement('button', 'removeElement', array(
          'label' => 'Remove',
          'order' => 92
        ));
       
        // Submit
        $this->addElement('submit', 'submit', array(
          'label' => 'Submit',
          'order' => 93
        ));
      }
     
      /**
       * After post, pre validation hook
       *
       * Finds all fields where name includes 'newName' and uses addNewField to add
       * them to the form object
       *
       * @param array $data $_GET or $_POST
       */
      
     
      /**
       * Adds new fields to form
       *
       * @param string $name
       * @param string $value
       * @param int    $order
       */
     
    }

