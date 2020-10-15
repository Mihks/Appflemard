<?php

session_name("flemard");

session_start();

include_once 'fonction.php';

$data_received = file_get_contents("php://input");

$data_received_xml = new SimpleXMLElement($data_received);

$ligne_response = $data_received_xml[0];

$interface_received=$ligne_response->INTERFACEID;

$reference_received=$ligne_response->REF;

$type_received=$ligne_response->TYPE;

$statut_received=$ligne_response->STATUT;

$operateur_received=$ligne_response->OPERATEUR;

$client_received=$ligne_response->TEL_CLIENT;

$message_received=$ligne_response->MESSAGE;

$token_received=$ligne_response->TOKEN;

$agent_received=$ligne_response->AGENT;


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


///////////////////////////////////////

 header("Location: resultat_transaction.php");
