<?php

/**
 * Description of observer
 *
 * @author hmustapha
 */
class Application_Model_classes_observerFormation implements Application_Model_classes_iformation {

    protected $observers = array();
    public function __construct() {
        
    }
    public function attach(\Application_Model_classes_iobserver $observateur) {
        $this->observers[] = $observateur;
    }

    public function detach(\Application_Model_classes_iobserver $observateur) {
        if (is_int($key = array_search($observateur, $this->observers, true))) {
            unset($this->observers[$key]);
        }
    }

    public function notify() {
        foreach ($this->observers as $observer) {
            $observer->update();
        }

        

        
    }

//put your code here
}
