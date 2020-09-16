

<?php 



/**
 * 
 */
class Reservation
{

	//////////////declaration des variables;..
	protected $dateDepart;
	protected $heureDepart;
	protected $trajet;
	protected $nomAgence;

	protected $bdd;

	protected $nom;

	protected $nbrePlace;

	protected $typeReservation;

	protected $villeClient;

	protected $villeDestinationClient;

	protected $dateRetour;
	protected $heureRetour;
	protected $trajetRetour;



	function __construct($bdd,$trajet,$typeReservation,$nom,$dateDepart,$nbrePlace,$heureDepart)
	{
		# code...

		$this->bdd = $bdd;

		$this->trajet = $trajet;

		$this->nom = $nom;

		$this->typeReservation = $typeReservation;

		$this->dateDepart = $dateDepart;

		$this->nbrePlace = $nbrePlace;

		$this->heureDepart = $heureDepart;

		// $this->heureDepart = $heureDepart;

	}



	public function setbdd($bdd)
	{
		$this->bdd = $bdd ;
	}


///////////date depart//////////

	public function setdateDepart($date)
	{
		$this->dateDepart = $date ;
	}


	public function getdateDepart()
	{
		return $this->dateDepart;
	}



///////////date retour//////////

	public function setdateRetour($date)
	{
		$this->dateRetour = $date ;
	}


	public function getdateRetour()
	{
		return $this->dateRetour;
	}



///////////////////////////////////////////


//////////////////////heure depart	
	public function getheureDepart()
	{
		return $this->heureDepart;
	}


	public function setheureDepart($heure)
	{
		 $this->heureDepart = $heure;
	}

////////////////////////////////////////


//////////////////////////heure retour
	public function getheureRetour()
	{
		return $this->heureRetour;
	}


	public function setheureRetour($heure)
	{
		 $this->heureRetour = $heure;
	}

///////////////////////////////////////////////////////////

	public function setNomAgence($agence)
	{

		$reponse = $this->bdd->query(" SELECT DISTINCT nom_agence FROM agence ");

		while ($donnee = $reponse->fetch()) {
			
			
			if ($agence == $donnee['nom_agence']) {
				
				$this->nomAgence = $donnee['nom_agence'];			

			}


		}
		
	}

	public function getNomAgence()
	{
		return $this->nomAgence;
	}



	public function setTrajet($trajet)
	{
		
		$this->trajet = trim($trajet);
		
	}


	public function getTrajet()
	{
		
		return $this->trajet;
		
	}



	public function getTrajetRetour()
		{
			$this->trajetRetour = $this->getvilleDestinationClient().'-'.$this->getvilleClient();

			return $this->trajetRetour;
		}






	public function getPlaceDispo($typeReservation)
	{
		
		$reponse = $this->bdd->prepare(" SELECT place_dispo(:date_voyage,:trajet,:nom_agence,:heure) ")  or die(print_r($this->bdd->errorInfo()));


		if (preg_match('#Aller_simple#', $typeReservation)) {
			

			$reponse->execute(array('date_voyage' => $this->getdateDepart(),'trajet' =>$this->getTrajet(),'nom_agence' => $_SESSION['_agence'],'heure' => $this->heureDepart));


		}elseif (preg_match('#Aller_retour#', $typeReservation)) {
			
			$reponse->execute(array('date_voyage' => $this->getdateRetour(),'trajet' =>$this->getTrajetRetour(),'nom_agence' => $_SESSION['_agence'],'heure' => $this->getheureRetour()));
		
		}


			$donnee = $reponse->fetch();

			$placeDispo = ($donnee[0]=='') ? 0 : $donnee[0];

			$reponse->closeCursor();

			return $placeDispo;


	}




	public function getPrixTrajet()
	{
		
		$reponse = $this->bdd->prepare(" SELECT prix_trajet FROM trajets WHERE nom_trajet = ? AND nom_agence = ?"); 
							
		$reponse->execute(array($this->getTrajet() ,$_SESSION['_agence'])) or die(print_r($this->bdd->errorInfo())); //renvoie une erreur en cas d'erreur

		
		$donnees = $reponse->fetch(); 

		
		$prixUnitaire = $donnees['prix_trajet'];

		$reponse->closeCursor();
		

		return $prixUnitaire;
					
			
	
	}



	public function getRemise()
	{
		
	// je recupere dans la bdd les infos de l'agence: le numero de tel et sa remise en cas d'aller retour
		$reponse = $this->bdd->prepare(" SELECT  `remise` FROM `agence` WHERE nom_agence = ? ");  
	
		$reponse->execute(array($_SESSION['_agence'])) or die(print_r($this->bdd->errorInfo())); //renvoie une erreur en cas d'erreur

		$donnees = $reponse->fetch(); 

		$remise = $donnees['remise'];
			
		$reponse->closeCursor();

		return $remise;

	}


	public function calculMontantReservationBus() {


		if ($this->typeReservation == "Aller_simple"){
			
			$montant = $this->getPrixTrajet()*$this->nbrePlace;

			return $montant;

		}elseif ($this->typeReservation == "Aller_retour") {
			
			$montant = $this->getPrixTrajet()*$this->nbrePlace*(2-$this->getRemise());

			return $montant;
		
		}else

			return false;
			
	}


	public function getinfoCompte($nom_operateur='airtel')
	{
		$reponse = $this->bdd->prepare(" SELECT CONCAT_WS(';',token,id_operateur)  AS infos 

			FROM compte_marchand  WHERE nom_operateur = ? "); 
							
		$reponse->execute(array($id_operateur)) or die(print_r($this->bdd->errorInfo())); //renvoie une erreur en cas d'erreur

		
		$donnees = $reponse->fetch();

		return $donnees['infos']; 
	}

	public function insertion()
	{

		$_SESSION['montant'] = $this->calculMontantReservationBus();


		if ( $_SESSION['montant'] < 100 || $_SESSION['montant'] > 490000  ) {

			$montant = $_SESSION['montant'];

			// Suppression des variables de session et de la session 
			$_SESSION = array();
			session_destroy();


			echo("<br><br><div style='font-size: 24px ;font-weight:bolder;text-align: center;'>Désolé le prix de votre billet s'élève à ".$montant." fcfa , <br>le montant d'une transaction est limité à  490 000 fcfa!<br><br><a href='index.php#reserve' style='font-weight:bolder;text-align: center;text-decoration:none;font-size: 24px;' >retour</a></div><br>");

			include('includes/footer.php');

			exit;

		}

		 



		if (preg_match('#^Aller_simple$#', $this->typeReservation)) {

			/////insertion dans la table reservation
		
			$requete = $this->bdd->prepare('INSERT INTO reservation (nom_agence,date_depart,heure_depart,trajet,nombre_place,type_reservation ) VALUES(?,?,?,?,?,?)');
			
			$requete->execute(array($_SESSION['_agence'],$this->getdateDepart() ,$this->getheureDepart(),$this->getTrajet(),$this->nbrePlace,$this->typeReservation));
		

		}elseif (preg_match('#^Aller_retour$#', $this->typeReservation)) {
			
			/////insertion dans la table reservation
		
			$requete = $this->bdd->prepare('INSERT INTO reservation (nom_agence,date_depart,heure_depart,trajet,nombre_place,type_reservation,trajet_retour,heure_retour,date_retour ) VALUES(?,?,?,?,?,?,?,?,?)');

			$requete->execute(array($_SESSION['_agence'],$this->getdateDepart(),$this->getheureDepart(),$this->getTrajet(),$this->nbrePlace,$this->typeReservation,$this->getTrajetRetour(),$this->getheureRetour(),$this->getdateRetour()));
		}



		//insertion dans la table paiement

		$requete1 = $this->bdd->prepare('INSERT INTO paiement (ref_trans,nom_paiement,code_statut,montant_debite,date_paiement,id_reservation ) VALUES(?,?,?,?, NOW(),LAST_INSERT_ID())');
							
		$requete1->execute(array($_SESSION['ref_trans'],NULL,NULL,$_SESSION['montant']));



		////////// insertion dans la table client .....					//introduction des villes
		$requete2 = $this->bdd->prepare('INSERT INTO client (nom,ville_client ,ville_destination_client) VALUES(upper(?),?,?)'); 

		$requete2->execute(array($this->nom,$this->getvilleClient(),$this->getvilleDestinationClient()));



		$_SESSION['id_reservation'] = $this->selectIDReservation();


		$requete = $this->bdd->prepare('INSERT INTO transaction (id_client,id_reservation,ref_trans,date_reservation,date_reservation_2) VALUES(LAST_INSERT_ID(),?,?,NOW(),NOW())');
							
		$requete->execute(array($_SESSION['id_reservation'],$_SESSION['ref_trans']));




		$_SESSION['id_client'] = $this->selectIDClient();




	}


	public function setvilleClient($ville)
	{
		
		$this->villeClient = $ville ; 
	}

	public function getvilleClient()
	{

		$tab = explode('-', $this->trajet,2);

		$this->villeClient = $tab[0];

		return $this->villeClient ; 
	}



	public function setvilleDestinationClient($ville)
	{
		
		$this->villeDestinationClient = $ville ; 
	}



	public function getvilleDestinationClient()
	{

			
		$tab = explode('-', $this->trajet,2);
		
		$this->villeDestinationClient = $tab[1];

		
		return $this->villeDestinationClient ;

	}





	public function selectIDReservation()
	{
		
		// recupere moi l'id du client qui est en train de senregistrer ainsi que son id_reservation
		$reponse = $this->bdd->prepare(" SELECT id_reservation FROM paiement WHERE paiement.ref_trans = ? "); 
		
		$reponse->execute(array($_SESSION['ref_trans'])) or die(print_r($this->bdd->errorInfo())); //renvoie une erreur en cas d'erreur

		$donnees = $reponse->fetch(); 
		
		$id_reservation = $donnees['id_reservation'];

		$reponse->closeCursor();

		return $id_reservation;
			
	}



		public function selectIDClient()
	{
		
		// recupere moi l'id du client qui est en train de senregistrer ainsi que son id_reservation
		$reponse = $this->bdd->prepare(" SELECT id_client FROM transaction WHERE transaction.ref_trans = ? "); 
		
		$reponse->execute(array($_SESSION['ref_trans'])) or die(print_r($this->bdd->errorInfo())); //renvoie une erreur en cas d'erreur

		$donnees = $reponse->fetch(); 
		
		$id_client = $donnees['id_client'];

		$reponse->closeCursor();

		return $id_client;
			
	}



}



