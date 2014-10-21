<?php

/**
 * Description of mail
 *
 * @author hmustapha
 */
class Application_Model_classes_mail implements Application_Model_classes_iobserver {

    private $_expediteur ;
    private $_destinataire="hmustpha@astek.mu";
    private $_message;
    private $_formation;
    private $_attributs = array();

    function __construct($destinataire, $formation) {
        $this->_destinataire = $destinataire;
        $this->_formation = $formation;
    }
/**
 * Methode qui permet d'envoyer un e-mail au cp pour une nouvelle formation
 * $return boolean true if message has been sent false else not has been sent
 * $acces public
 */
    public function update() {
        $mail = new Zend_Mail();
        $mail->setBodyText('Bonjour \n Je souhaite bénéficier de la formation '.$this->_formation.'\n CP '.$this->_expediteur);
        //$mail->setFrom('somebody@example.com', 'un expéditeur');
        $mail->addTo($this->_expediteur, 'un destinataire');
        $mail->setSubject('Demander une nouvelle formation');
        $mail->send();
    }

    /**
     * Methode magique pour getter les variable
     * @param mixed $nom
     * @return array $attributs
     * @access public
     */
    public function __get($nom) {
        if (isset($this->_attributs[$nom])) {
            return $this->_attributs[$nom];
        }
    }

    /**
     * Methode magique pour setter les variables
     * @param mixed $nom
     * @param mixed $valeur
     * @access public
     */
    public function __set($nom, $valeur) {
        $this->_attributs[$nom] = $valeur;
    }

}
