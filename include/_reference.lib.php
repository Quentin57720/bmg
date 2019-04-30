<?php 
/** 
 * 
 * BMG
 * © GroSoft
 * 
 * References
 * Classes métier
 *
 *
 * @package 	default
 * @author 	dk
 * @version    	1.0
 */

/*
 *  ====================================================================
 *  Classe Genre : représente un genre d'ouvrage 
 *  ====================================================================
*/

class Genre {
    private $_code;
    private $_libelle;

    /**
     * Constructeur 
    */				
    public function __construct(
            $p_code,
            $p_libelle
    ) {
        $this->setCode($p_code);
        $this->setLibelle($p_libelle);
    }  
    
    /**
     * Accesseurs
    */
    public function getCode() {
        return $this->_code;
    }

    public function getLibelle() {
        return $this->_libelle;
    }
    
    /**
     * Mutateurs
    */   
    public function setCode($p_code) {
        $this->_code = $p_code;
    }

    public function setLibelle($p_libelle) {
        $this->_libelle = $p_libelle;
    }

}
/*
 *  ====================================================================
 *  Classe Auteur : représente un auteur 
 *  ====================================================================
*/

class Auteur {
    private $_id;
    private $_nom;
    private $_prenom;
    private $_alias;
    private $_notes;

   
    

    /**
     * Constructeur 
    */				
    public function __construct(
            $a_id = null,
            $a_nom = null,
            $a_prenom = "",
            $a_alias = "",
            $a_notes = ""
    ) {
       $this->setId($a_id);
        $this->setNom($a_nom);
        $this->setPrenom($a_prenom);
        $this->setAlias($a_alias);
        $this->setNotes($a_notes);
    }  
    
    /**
     * Accesseurs
    */
    public function getId() {
        return $this->_id;
    }

    public function getNom() {
        return $this->_nom;
    }
    
     public function getPrenom() {
        return $this->_prenom;
    }
    
     public function getAlias() {
        return $this->_alias;
    }
    
     public function getNotes() {
        return $this->_notes;
    }
    
    /**
     * Mutateurs
    */   
    public function setId($a_id) {
        $this->_id = $a_id;
    }

    public function setNom($a_nom) {
        $this->_nom = $a_nom;
    }

    public function setPrenom($a_prenom) {
        $this->_prenom = $a_prenom;
    }
    
    public function setAlias($a_alias) {
        $this->_alias = $a_alias;
    }
    
    public function setNotes($a_notes) {
        $this->_notes = $a_notes;
    }

}

/*
 *  ====================================================================
 *  Classe Ouvrage : représente un genre d'ouvrage 
 *  ====================================================================
*/

class Ouvrage {
    private $num;
    private $titre;
    private $salle;
    private $rayon;
    private $code_genre;
    private $acquisition;
    private $lesAuteurs; //non utilisé pour la mission 6
    private $dernier_pret;
    private $disponibilite;
    private $listeNomsAuteurs;

    /**
     * Constructeur 
    */                                
    public function __construct(
            $p_num,
            $p_titre,
            $p_salle,
            $p_rayon,
            $p_code_genre,
            $p_acquisition = null
    ) {
        $this->setNum($p_num);
        $this->setTitre($p_titre);
        $this->setSalle($p_salle);
        $this->setRayon($p_rayon);
        $this->setCode_genre($p_code_genre);
        $this->setAcquisition($p_acquisition);
        $this->lesAuteurs = array();
    }  
    
    /**
     * Accesseurs
    */
    public function getNum () {
        return $this->_Num;
    }

    public function getTitre () {
        return $this->_Titre;
    }
    
    public function getSalle () {
        return $this->_Salle;
    }

    public function getRayon () {
        return $this->_Rayon;
    }
    
    public function getCode_genre () {
        return $this->_Code_genre;
    }

    public function getAcquisition () {
        return $this->_Acquisition;
    }
    
    public function getAuteur () {
        return $this-> listeNomsAuteurs;
    }

    public function getDernier_pret () {
        return $this->_Dernier_pret;
    }
    
    public function getDisponibilite () {
        return $this->_Disponibilite;
    }
    
    
    /**
     * Mutateurs
    */   
    public function setNum ($p_num) {
        $this->_Num = $p_num;
    }

    public function setTitre ($p_titre) {
        $this->_Titre = $p_titre;
    }
    
    public function setSalle ($p_salle) {
        $this->_Salle = $p_salle;
    }

    public function setRayon ($p_rayon) {
        $this->_Rayon = $p_rayon;
    }
    
    public function setCode_genre ($p_code_genre) {
        $this->_Code_genre = $p_code_genre;
    }

    public function setAcquisition ($p_acquisition) {
        $this->_Acquisition = $p_acquisition;
    }
    
    public function setAuteur ($p_auteur) {
        $this->listeNomsAuteurs = $p_auteur;
    }

    public function setDernier_pret ($p_dernier_pret) {
        $this->_Dernier_pret = $p_dernier_pret;
    }
    
    public function setDisponibilite ($p_disponibilite) {
        $this->_Disponibilite = $p_disponibilite;
    }
}

/*
 *  ====================================================================
 *  Classe Client : représente un client 
 *  ====================================================================
*/

class Client {
    private $_id;
    private $_nom;
    private $_prenom;
    private $_rue;
    private $_codePost;
    private $_ville;
    private $_date_inscr;
    private $_login;
    private $_password;
    private $_mel;
    private $_etat_client;
    private $_caution;
    private $_caution_encaissee;
    private $_montant_compte;
    private $_date_dernier_pret;

    /**
     * Constructeur
    */
    public function __construct(

            $c_id = null,
            $c_nom = null,
            $c_prenom = null,
            $c_rue = "",
            $c_codePost = null,
            $c_ville = null,
            $c_date_inscr = null,
            $c_mel = "",
            $c_etat_client = null,
            $c_montant_compte = null,
            $c_login = "",
            $c_password= "",
            $c_caution = null,
            $c_caution_encaisse = null,
            $c_dernier_pret = null
    ) {
        $this->setId($c_id);
        $this->setNom($c_nom);
        $this->setPrenom($c_prenom);
        $this->setRue($c_rue);
        $this->setCodePost($c_codePost);
        $this->setVille($c_ville);
        $this->setDateInscr($c_date_inscr);
        $this->setLogin($c_login);
        $this->setPassword($c_password);
        $this->setMel($c_mel);
        $this->setEtatClient($c_etat_client);
        $this->setCaution($c_caution);
        $this->setCautionEncaissee($c_caution_encaisse);
        $this->setMontantCompte($c_montant_compte);
        $this->setDateDernierPret($c_dernier_pret);
    }

    /**
     * Accesseurs
    */
    public function getId() {
        return $this->_id;
    }

    public function getNom() {
        return $this->_nom;
    }

    public function getPrenom() {
        return $this->_prenom;
    }

    public function getRue() {
        return $this->_rue;
    }

    public function getCodePost() {
        return $this->_codePost;
    }

    public function getVille() {
        return $this->_ville;
    }

    public function getDateInscr() {
        return $this->_dateInscr;
    }

    public function getLogin() {
        return $this->_login;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function getMel() {
        return $this->_mel;
    }

    public function getEtatClient() {
        return $this->_etat_client;
    }

    public function getCaution() {
        return $this->_caution;
    }

    public function getCautionEncaissee() {
        return $this->_caution_encaissee;
    }

    public function getMontantCompte() {
        return $this->_montantCompte;
    }

    public function getDateDernierPret() {
        return $this->_date_dernier_pret;
    }

    /**
     * Mutateurs
    */

    public function setId($p_Id) {
        $this->_id = $p_Id;
    }

    public function setNom($p_Nom) {
        $this->_nom = $p_Nom;
    }

    public function setPrenom($p_Prenom) {
        $this->_prenom = $p_Prenom;
    }

    public function setRue($p_Rue) {
        $this->_rue = $p_Rue;
    }

    public function setCodePost($p_CodePost) {
        $this->_codePost = $p_CodePost;
    }
    public function setVille($p_Ville) {
        $this->_ville = $p_Ville;
    }

    public function setDateInscr($p_Date_Inscr) {
        $this->_dateInscr = $p_Date_Inscr;
    }

    public function setLogin($p_Login) {
        $this->_login = $p_Login;
    }

    public function setPassword($p_Password) {
        $this->_password = $p_Password;
    }

    public function setMel($p_Mel) {
        $this->_mel = $p_Mel;
    }

    public function setEtatClient($p_Etat_Client) {
        $this->_etat_client = $p_Etat_Client;
    }

    public function setCaution($p_Caution) {
        $this->_caution = $p_Caution;
    }

    public function setCautionEncaissee($p_Caution_Encaisse) {
        $this->_caution_encaissee = $p_Caution_Encaisse;
    }

    public function setMontantCompte($p_Montant_Compte) {
        $this->_montantCompte = $p_Montant_Compte;
    }

     public function setDateDernierPret($p_Dernier_Pret) {
        $this->_date_dernier_pret = $p_Dernier_Pret;
    }
}
/*
 *  ====================================================================
 *  Classe PRet : représente un genre d'ouvrage 
 *  ====================================================================
*/

class Pret {
    private $_id;
    private $_noClient;
    private $_noOuvrage;
    private $_dateEmp;
    private $_dateRet;
    private $_penalite;
    private $_titre;
    private $_salle;
    private $_rayon;
    private $_nom_client;
    private $_prenom;
    private $_dateLim;
    private $_duree;
    

    /**
     * Constructeur 
    */				
    public function __construct(
            
            $p_id = null,
            $p_client = null,
            $p_ouvrage = null,
            $p_dateEmp = null,
            $p_dateRet = null,
            $p_penalite = null,
            $p_titre = null,
            $p_salle = null,
            $p_rayon = null,
            $p_nom = null,
            $p_prenom = null,
            $p_dateLim = null,
            $p_duree = null
            
    ) {
        $this->setId($p_id);
        $this->setClient($p_client);
        $this->setOuvrage($p_ouvrage);
        $this->setDateEmp($p_dateEmp);
        $this->setDateRet($p_dateRet);
        $this->setPenalite($p_penalite);
        $this->setTitre($p_titre);
        $this->setSalle($p_salle);
        $this->setRayon($p_rayon);
        $this->setNom($p_nom);
        $this->setPrenom($p_prenom);
        $this->setDateLim($p_dateLim);
        $this->setDuree($p_duree);
    }  
    
    /**
     * Accesseurs
    */
    public function getId() {
        return $this->_id;
    }

    public function getClient() {
        return $this->_noClient;
    }
    
    public function getOuvrage() {
        return $this->_noOuvrage;
    }
    
    public function getDateEmp() {
        return $this->_dateEmp;
    }
    
    public function getDateRet() {
        return $this->_dateRet;
    }
    
    public function getPenalite() {
        return $this->_penalite;
    }
    
     public function getTitre () {
        return $this->_Titre;
    }
    
    public function getSalle () {
        return $this->_Salle;
    }

    public function getRayon () {
        return $this->_Rayon;
    }
    
    public function getNom() {
        return $this->_nom;
    }

    public function getPrenom() {
        return $this->_prenom;
    }
    
    public function getDateLim() {
        return $this->_dateLim;
    }

    public function getDuree() {
        return $this->_duree;
    }
    
    /**
     * Mutateurs
    */   
    public function setId($p_id) {
        $this->_id = $p_id;
    }

    public function setClient($p_client) {
        $this->_noClient = $p_client;
    }
    
    public function setOuvrage($p_ouvrage) {
        $this->_noOuvrage = $p_ouvrage;
    }
    
    public function setDateEmp($p_dateEmp) {
        $this->_dateEmp = $p_dateEmp;
    }
    
    public function setDateRet($p_dateRet) {
        $this->_dateRet = $p_dateRet;
    }
    
    public function setPenalite($p_penalite) {
        $this->_penalite = $p_penalite;
    }
    
    public function setTitre ($p_titre) {
        $this->_Titre = $p_titre;
    }
    
    public function setSalle ($p_salle) {
        $this->_Salle = $p_salle;
    }

    public function setRayon ($p_rayon) {
        $this->_Rayon = $p_rayon;
    }
    
    public function setNom($p_Nom) {
        $this->_nom = $p_Nom;
    }

    public function setPrenom($p_Prenom) {
        $this->_prenom = $p_Prenom;
    }
    
    public function setDateLim($p_DateLim) {
        $this->_dateLim = $p_DateLim;
    }

    public function setDuree($p_Duree) {
        $this->_duree = $p_Duree;
    }
}

