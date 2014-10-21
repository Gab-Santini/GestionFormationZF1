<?php

/**
 * Description of mail
 *
 * @author hmustapha
 */
class Application_Model_classes_text implements Application_Model_classes_iobserver {

    private $_expediteur = "cp@astek.mu";
    private $_destinataire;
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
        $monfichier = fopen('../public/demandeFormations/fromations.txt', 'a+');
        $pages_vues = fgets($monfichier); 
        fseek($monfichier, 0); // On remet le curseur au début du fichier
        fputs($monfichier, "Formation " . $this->_formation . " LDAP : " . $this->_destinataire . "\r\n"); // On écrit le nouveau nombre de pages vues
        fclose($monfichier);
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
