

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



	// function __construct($bdd,$trajet,$typeReservation,$nom,$dateDepart,$nbrePlace)
	// {
	// 	# code...

	// 	$this->bdd = $bdd;

	// 	$this->trajet = $trajet;

	// 	$this->nom = $nom;

	// 	$this->typeReservation = $typeReservation;

	// 	$this->dateDepart = $dateDepart;

	// 	$this->nbrePlace = $nbrePlace;

	// }



	// public function setbdd($bdd)
	// {
	// 	$this->bdd = $bdd ;
	// }


// ///////////date depart//////////

// 	public function setdateDepart($date)
// 	{
// 		$this->dateDepart = $date ;
// 	}


// 	public function getdateDepart()
// 	{
// 		return $this->dateDepart;
// 	}



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
		 $this->heure = $heure;
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


	public function getTrajet($trajet)
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
		
		$reponse = $this->bdd->prepare(" SELECT place_dispo(:date_voyage,:trajet,:nom_agence,:heure) ");


		if (preg_match('#Aller_simple#', $typeReservation)) {
			

			$reponse->execute(array('date_voyage' => $this->getdateDepart(),'trajet' =>$this->getTrajet(),'nom_agence' => $_SESSION['_agence'],'heure' => $this->getheureDepart()));


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
							
		$reponse->execute(array($this->getTrajet() ,$this->$_SESSION['_agence'])) or die(print_r($this->bdd->errorInfo())); //renvoie une erreur en cas d'erreur

		
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


	private function calculMontantReservationBus($prixUnitaire,$remise) {


		if ($this->typeReservation == "Aller_simple"){
			
			$montant = $prixUnitaire*$this->nbrePlace;

			return $montant;

		}elseif ($this->$typeReservation == "Aller_retour") {
			
			$montant = $prixUnitaire*$this->nbrePlace*(2-$remise);

			return $montant;
		
		}else

			return false;
			
	}




	public function insertion($refTrans)
	{


		$montant = $this->calculMontantReservationBus($this->getPrixTrajet(),$this->getRemise()); 

		/////insertion dans la table reservation
		$requete = $this->bdd->prepare('INSERT INTO reservation (nom_agence,date_depart,heure_depart,trajet,nombre_place,type_reservation) VALUES(?,?,?,?,?,?)');



		////////// insertion dans la table client .....					//introduction des villes
		$requete2 = $this->bdd->prepare('INSERT INTO client (nom,ville_client ,ville_destination_client) VALUES(upper(?),?,?)'); 

		$requete2->execute(array($this->nom,$this->getvilleClient(),$this->getvilleDestinationClient()));

	
		///insertion dans la table paiement 
		$requete1 = $this->bdd->prepare('INSERT INTO paiement (ref_trans,nom_paiement,code_statut,montant_debite,date_paiement ) VALUES(?,?,?,?, NOW())');
							
		$requete1->execute(array($refTrans,NULL,NULL,$montant));


	

		if (preg_match('#Aller_simple#', $this->typeReservation)) {
			
			$requete->execute(array($_SESSION['_agence'],$this->getdateDepart() ,$this->getheureDepart(),$this->trajet,$this->nbrePlace,$this->typeReservation));
		

			


		}elseif (preg_match('#Aller_retour#', $this->typeReservation)) {
			
			$requete->execute(array($_SESSION['_agence'],$this->getdateRetour(),$this->getheureRetour() ,$this->getTrajetRetour(),$this->nbrePlace,$this->typeReservation));
		}




				// recupere moi l'id du client qui est en train de senregistrer ainsi que son id_reservation
		$reponse = $this->bdd->prepare(" SELECT client.id_client,reservation.id_reservation FROM client,reservation,paiement WHERE paiement.ref_trans = ? "); 
		
		$reponse->execute(array($refTrans)) or die(print_r($this->bdd->errorInfo())); //renvoie une erreur en cas d'erreur

		$donnees = $reponse->fetch(); 

		$id_client = $donnees['id_client'];
		$id_reservation = $donnees['id_reservation'];

		$reponse->closeCursor();

		$_SESSION['id_reservation'] = $id_reservation;
		$_SESSION['id_client']	= $id_client;


		$requete = $this->bdd->prepare('INSERT INTO transaction (id_client,id_reservation,ref_trans,date_reservation,date_reservation_2) VALUES(?,?,?,NOW(),NOW())');
							
		$requete->execute(array($id_client,$id_reservation,$refTrans));



	}


	public function setVilleClient($ville)
	{
		
		$this->villeClient = $ville ; 
	}

	public function getVilleClient()
	{
		if (preg_match('#Aller_simple#', $this->typeReservation)) {
			
			$tab = explode('-', $this->trajet,2);

			$this->villeClient = $tab[0];
		
		}elseif (preg_match('#Aller_retour#', $this->typeReservation)) {
			
			$tab = explode('-', $this->trajetRetour,2);

			$this->villeClient = $tab[0];

			
		}

		return $this->villeClient ; 
	}



	public function setvilleDestinationClient($ville)
	{
		
		$this->villeDestinationClient = $ville ; 
	}



	public function getvilleDestinationClient()
	{

		if (preg_match('#Aller_simple#', $this->typeReservation)) {
			
			$tab = explode('-', $this->trajet,2);
		
			$this->villeDestinationClient = $tab[1];

		
		}elseif (preg_match('#Aller_retour#', $this->typeReservation)) {
			
			$tab = explode('-', $this->trajetRetour,2);
		
			$this->villeDestinationClient = $tab[1];

			
		}

		return $this->villeDestinationClient ;

	}





}



