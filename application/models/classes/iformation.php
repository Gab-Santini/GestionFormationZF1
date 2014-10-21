<?php


/**
 * Description of isubject
 *
 * @author hmustapha
 */
interface Application_Model_classes_iformation {
public function attach(Application_Model_classes_iobserver $observateur);
public function detach(Application_Model_classes_iobserver $observateur);
public function notify();
}
