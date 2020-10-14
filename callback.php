<?php

session_name("flemard");

session_start();

include_once 'fonction.php';
		
$code_statut = 200;

$_SESSION['code_statut'] = $code_statut;

$tel = '074'.mt_rand(200040,241743);


 $statut = ($code_statut==200) ? "Succes" : "Echoue" ;


$requete = $bdd->prepare('UPDATE paiement SET code_statut = ? WHERE ref_trans = ? ');
									
$requete->execute(array($code_statut,$_SESSION['ref_trans']));


$requete = $bdd->prepare('UPDATE transaction SET statut = ?  WHERE ref_trans = ? ');
									
$requete->execute(array($statut,$_SESSION['ref_trans']));


$requete = $bdd->prepare('UPDATE client SET tel_client = ?  WHERE id_client = ? ');

$requete->execute(array($tel,$_SESSION['id_client']));


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



///////////////////////////////////////

   
// header("Location: resultat_transaction.php");
