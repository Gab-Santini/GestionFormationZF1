<?php

/**
 * Description of mail
 *
 * @author hmustapha
 */
class Application_Model_classes_pdf implements Application_Model_classes_iobserver {

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
        define('CM_PT', 1 / 0.0352778); 
        $pdf = new Zend_Pdf();
        $pdf1 = Zend_Pdf::load('../public/demandeFormations/formation.pdf');
        $pdf->pages[] = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
        $page1 = $pdf->pages[0];
        //$pdf1->pages[] = $page1;
        $font = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
        $page1->setFont($font, 12); // police de 24 pts
        $page1->drawText("Formation " . $this->_formation . " LDAP : " . $this->_destinataire . "\r\n", 2 * CM_PT, 28 * CM_PT);
        $pdf1->save('../public/demandeFormations/formation.pdf');
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
