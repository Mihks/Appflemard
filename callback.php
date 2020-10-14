<?php

session_name("flemard");

session_start();


$data_received=file_get_contents("php://input");
$data_received_xml=new SimpleXMLElement($data_received);
$ligne_response=$data_received_xml[0];
$interface_received=$ligne_response->INTERFACEID;
$reference_received=$ligne_response->REF;
$type_received=$ligne_response->TYPE;
$statut_received=$ligne_response->STATUT;
$operateur_received=$ligne_response->OPERATEUR;
$client_received=$ligne_response->TEL_CLIENT;
$message_received=$ligne_response->MESSAGE;
$token_received=$ligne_response->TOKEN;
$agent_received=$ligne_response->AGENT

include_once 'fonction.php';

$_SESSION['code_statut'] = $statut_received;

//$tel = '074'.mt_rand(200040,241743);


 $statut = ($code_statut==200) ? "Succes" : "Echoue" ;


$requete = $bdd->prepare('UPDATE paiement SET code_statut = ? WHERE ref_trans = ? ');
									
$requete->execute(array($statut_received,$reference_received));


$requete = $bdd->prepare('UPDATE transaction SET statut = ?  WHERE ref_trans = ? ');
									
$requete->execute(array($statut,$reference_received));


$requete = $bdd->prepare('UPDATE client SET tel_client = ?  WHERE id_client = ? ');

$requete->execute(array($client_received,$_SESSION['id_client']));


///si le $statut est égal à succes
if($_SESSION['code_statut']==200){

$requete = $bdd->prepare('UPDATE
     reservation
   SET etat_voyage_1 = "Valide", etat_voyage_2 = "Valide"
    WHERE
        id_reservation = ? ');

$requete->execute(array($_SESSION['id_reservation']));


$requete = $bdd->prepare('UPDATE
     voyage
 	SET nombre_place_dispo = ?, nombre_place_reserve = ? ,nombre_place = ?
    WHERE
        date_voyage = ? AND horaire = ? AND nom_trajet = ? AND nom_agence = ? ');

$requete->execute(array($_SESSION['new_place_dispo'],$_SESSION['new_place_reserve'],$_SESSION['new_nombre_place'],$_SESSION['date_voyage'],$_SESSION['horaire'],$_SESSION['trajet'],$_SESSION['_agence']));


if ($_SESSION['type'] =='Aller_retour'){

$requete = $bdd->prepare('UPDATE
     voyage
 	SET nombre_place_dispo = ?, nombre_place_reserve = ? ,nombre_place = ?
    WHERE
        date_voyage = ? AND horaire = ? AND nom_trajet = ? AND nom_agence = ? ');

$requete->execute(array($_SESSION['new_place_dispo_retour'],$_SESSION['new_place_reserve_retour'],$_SESSION['new_nombre_place_retour'],$_SESSION['date_voyage_retour'],$_SESSION['horaire_retour'],$_SESSION['trajet_retour'],$_SESSION['_agence']));

	}

}
////////////////////////////////


/////si $statut est diff de succes
if($_SESSION['code_statut']!=200){

$requete = $bdd->prepare('UPDATE
     reservation
   SET etat_voyage_1 = "Avorte", etat_voyage_2 = "Avorte"
    WHERE
        id_reservation = ? ');
$requete->execute(array($_SESSION['id_reservation']));

}
///////////////////////////////////////////


echo '
<!DOCTYPE html>
<html>
<head>
	<title>resultat</title>

	<meta name="viewport" content="width=device-width, initial-scale=1 ,target- densitydpi=device-dpi,maximum-scale=1.0" />


	<link rel="stylesheet" href="agence/css/style.css" />
	<link rel="stylesheet" type="text/css" href="agence/css/jquery-ui.structure.min.css">
	<link rel="stylesheet" type="text/css" href="agence/css/jquery-ui.theme.min.css">


</head>
<body>';

	


	if (!isset($_SESSION['code_statut'])) {
		
		header("Location:index.php");
		
	
	}else{



		if ($_SESSION['code_statut']==200) {
				
			echo '<header>
			
				<div class="log"><img src="agence/images/yaga.png" alt="logo" width="53" height="53"></div >
				<p class="slogan"></p>
				<span id="heure"></span>
				

				<button class="btn btn-navbar" id="btnMenu">    
					<span class="icon-bar"></span>    
					<span class="icon-bar"></span>    
					<span class="icon-bar"></span> 
				</button> 


				<nav id="nav">

					
					<div>
						
						<ul>

							<li><a href="index.php" class="">Accueil</a></li>
							<li><a href="index.php#reserve" id="lien-reserve">Reservation</a></li>
							<li><a href="index.php#a_propos" >A propos de</a></li>
							<li><a href="index.php#contact">Contact</a></li>

						
						</ul>
					</div>

				</nav>	

				<div id="heure"></div>

			</header>
			
			<br/><br/><br/><br/>';
		
		
	$reponse = $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id
		FROM `reservation`,`client`,`transaction`,`paiement` 
		WHERE reservation.id_reservation = transaction.id_reservation AND 
		paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? 
		
		AND paiement.ref_trans = ? ");

		$reponse->execute(array($_SESSION['_agence'],$_SESSION['ref_trans']));
		
		$donnees = $reponse->fetch();

		echo "		
		<div id='succes'  class='centre-text'>
			<p>votre paiement a été effectué <b>".$_SESSION["nom"]."</b>, merci et a bientot!</p>

			<p style='font-weight: bolder;'>
			Votre identifiant unique lié à votre réservation est le suivant  
			<span style='font-size:15px;color:red;'>".$donnees['id']."</span>
			veuillez présenter ce code à l'agence , ne le divulguez à personne il contient tous les coordonnées de votre voyage .
			</p>
			
		</div>";

		include('agence/includes/footer.php');
			
			

		}else{

			echo '<header>
			
				<div class="log"><img src="images/yaga.png" alt="logo" width="53" height="53"></div >
				<p class="slogan"></p>
				<span id="heure"></span>
				

				<button class="btn btn-navbar" id="btnMenu">    
					<span class="icon-bar"></span>    
					<span class="icon-bar"></span>    
					<span class="icon-bar"></span> 
				</button> 


				<nav id="nav">

					
					<div>
						
						<ul>

							<li><a href="index.php" class="">Accueil</a></li>
							<li><a href="index.php#reserve" id="lien-reserve">Reservation</a></li>
							<li><a href="index.php#a_propos" >A propos de</a></li>
							<li><a href="index.php#contact">Contact</a></li>

						
						</ul>
					</div>

				</nav>	

				<div id="heure"></div>

			</header>
			
			<br/><br/><br/><br/>';

			echo "<div id='echoue'>

			<p class='centre-text'>votre paiement n'a pas été effectué</p>'

		</div>";

		include('agence/includes/footer.php');


		
// Suppression des variables de session et de la session 
		$_SESSION = array();
		session_destroy();

		}	

	}


///////////////////////////////////////

   
// header("Location: resultat_transaction.php");
