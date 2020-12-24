<?php
session_name("flemard");
session_start(); 
include_once 'fonction.php';
include_once 'callback.php';

$_SESSION['ref']= $reference_received;

$req = $bdd->exec(" SET lc_time_names = 'fr_FR';");

///si le $statut est égal à succes
if(isset($statut_received) && !empty($statut_received)){	
	
$statut = ($statut_received==200) ? "Succes" : "Echoue";

$requete = $bdd->prepare('UPDATE paiement SET code_statut = ? WHERE ref_trans = ? ');
									
$requete->execute(array($statut_received,$reference_received));

$requete = $bdd->prepare('UPDATE transaction SET statut = ?  WHERE ref_trans = ? ');
									
$requete->execute(array($statut,$reference_received));

// $requete = $bdd->prepare('UPDATE client SET tel_client = ?  WHERE id_client = ? ');

// $requete->execute(array($client_received,$_SESSION['id_client']));

if ($statut_received !=200) {
    # code...

$reponse = $bdd->prepare("SELECT reservation.type_reservation,reservation.nombre_place,

	reservation.id_reservation,reservation.trajet,
	reservation.date_depart,reservation.heure_depart,
	reservation.trajet_retour,reservation.date_retour,reservation.heure_retour,nom_agence 
	FROM reservation,paiement 
	WHERE reservation.id_reservation = paiement.id_reservation AND paiement.ref_trans = ? ");
$reponse->execute(array($reference_received));

$donnees = $reponse->fetch();

$reponse = $bdd->prepare(" SELECT nombre_place_dispo, nombre_place_reserve FROM voyage WHERE nom_agence = ? AND date_voyage = ? AND nom_trajet = ? AND horaire = ?  ");

$reponse->execute(array($donnees['nom_agence'],$donnees['date_depart'],$donnees['trajet'],$donnees['heure_depart']));

$donnee = $reponse->fetch();

$new_place_dispo = $donnee['nombre_place_dispo'] - $donnees['nombre_place'] ;
	
$new_place_reserve = $donnee['nombre_place_reserve'] + $donnees['nombre_place'] ;
	
	
$requete = $bdd->prepare('UPDATE
     reservation
   SET etat_voyage_1 = "Valide", etat_voyage_2 = "Valide"
    WHERE
        id_reservation = ? ');

$requete->execute(array($donnees['id_reservation']));

$requete = $bdd->prepare('UPDATE
     voyage
 	SET nombre_place_dispo = ?, nombre_place_reserve = ? 
    WHERE
        date_voyage = ? AND horaire = ? AND nom_trajet = ? AND nom_agence = ? ');

$requete->execute(array($new_place_dispo,$new_place_reserve,$donnees['date_depart'],$donnees['heure_depart'],$donnees['trajet'],$donnees['nom_agence']));
//////////////////////////////////////////////////////infos billet//////////////////////////////
	
	
  $reponse =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,reservation.type_reservation,reservation.nombre_place,reservation.trajet,DATE_FORMAT(reservation.date_depart, '%W, %e %M %Y') AS depart,reservation.heure_depart,CONCAT(paiement.montant_debite,'FCFA') AS montant,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve, reservation.nom_agence,paiement.ref_trans AS ref FROM client,paiement,reservation,transaction WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND client.id_client = transaction.id_client AND paiement.ref_trans = ?");

            $reponse->execute(array($reference_received));

            $donnees = $reponse->fetch();

            $_SESSION['agence'] = $donnees['nom_agence'];

            $_SESSION['id'] = $donnees['id'];

            $_SESSION['date_voyage'] = $donnees['depart'];

           $_SESSION['heure'] = $donnees['heure_depart'];

           $_SESSION['trajet'] = $donnees['trajet'];

            $_SESSION['ref_trans'] = $donnees['ref'];

           $_SESSION['type'] = $donnees['type_reservation'];

            $_SESSION['nom'] = $donnees['nom'];

            $reponse->closeCursor();	
	
	
//////////////////////////////////////////////////////////////////////////////////////////////////

if ($donnees['type_reservation'] =='Aller_retour'){

	$reponse = $bdd->prepare(" SELECT nombre_place_dispo, nombre_place_reserve FROM voyage WHERE nom_agence = ? AND date_voyage = ? AND nom_trajet = ? AND horaire = ?  ");

	$reponse->execute(array($donnees['nom_agence'],$donnees['date_retour'],$donnees['trajet_retour'],$donnees['heure_retour']));

	$donnee = $reponse->fetch();

	$new_place_dispo = $donnee['nombre_place_dispo'] - $donnees['nombre_place'] ;
	
	$new_place_reserve = $donnee['nombre_place_reserve'] + $donnees['nombre_place'] ;

$requete = $bdd->prepare('UPDATE
     voyage
 	SET nombre_place_dispo = ?, nombre_place_reserve = ? 
    WHERE
        date_voyage = ? AND horaire = ? AND nom_trajet = ? AND nom_agence = ? ');

$requete->execute(array($new_place_dispo,$new_place_reserve,$donnees['date_retour'],$donnees['heure_retour'],$donnees['trajet_retour'],$donnees['nom_agence']));

	}
	
	
	header('Location:billet.php');
	
	
	}
	
	
	header('Location:billet.php');

}else{
////////////////////////////////


/////si $statut est diff de succes
if($statut_received!=200){

$requete = $bdd->prepare('UPDATE
     reservation
   SET etat_voyage_1 = "Avorte", etat_voyage_2 = "Avorte"
    WHERE
        id_reservation = ? ');
$requete->execute(array($donnees['id_reservation']));

}
	
header("Location:index.php");
	
}
