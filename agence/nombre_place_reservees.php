<?php
 
session_name('flemadmin');

session_start();



    include_once 'fonction.php';


$agence = $_SESSION['agence'];

             ?>

             
<div id="nbre_place_reservees_total"><?php


	
			$rep =  $bdd->prepare("SELECT
    SUM(total) AS nbre_place_reservees_total
FROM
    (
    SELECT
        SUM(reservation.nombre_place) AS total
       
    FROM
        reservation,
        TRANSACTION,
        CLIENT
    WHERE
        reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Valide' AND reservation.etat_voyage_2 IS NULL AND reservation.type_reservation = 'Aller_simple'
    UNION
SELECT
    SUM(reservation.nombre_place)*2 AS total
    
FROM
    reservation,
    TRANSACTION,
    CLIENT
WHERE
    reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Valide' AND reservation.etat_voyage_2 = 'Valide' AND reservation.type_reservation = 'Aller_retour'
UNION
SELECT
    SUM(reservation.nombre_place) AS total
    
FROM
    reservation,
    TRANSACTION,
    CLIENT
WHERE
    reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Valide' AND reservation.etat_voyage_2 = 'Annule' AND reservation.type_reservation = 'Aller_retour'
UNION
SELECT
    SUM(reservation.nombre_place) AS total
    
FROM
    reservation,
    TRANSACTION,
    CLIENT
WHERE
    reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Annule' AND reservation.etat_voyage_2 = 'Valide' AND reservation.type_reservation = 'Aller_retour' 
) AS nombre_total; ");

        $rep->execute(array($agence,$agence,$agence,$agence));

		
        $donnees = $rep->fetch();

		
        if ($donnees['nbre_place_reservees_total']=='') {
           
           echo "0";
        

        }else{
           
            echo $donnees['nbre_place_reservees_total'];
		
            }


?></div>


<div id="nbre_place_dispo_total"><?php


	
			$rep =  $bdd->prepare("SELECT
    SUM(total) AS nbre_place_dispo_total
FROM
    (
    SELECT
        SUM(reservation.nombre_place) AS total
       
    FROM
        reservation,
        TRANSACTION,
        CLIENT
    WHERE
        reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Annule' AND reservation.etat_voyage_2 IS NULL AND reservation.type_reservation = 'Aller_simple'
    UNION
SELECT
    SUM(reservation.nombre_place)*2 AS total
    
FROM
    reservation,
    TRANSACTION,
    CLIENT
WHERE
    reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Annule' AND reservation.etat_voyage_2 = 'Annule' AND reservation.type_reservation = 'Aller_retour'
UNION
SELECT
    SUM(reservation.nombre_place) AS total
    
FROM
    reservation,
    TRANSACTION,
    CLIENT
WHERE
    reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Annule' AND reservation.etat_voyage_2 = 'Valide' AND reservation.type_reservation = 'Aller_retour'
UNION
SELECT
    SUM(reservation.nombre_place) AS total
    
FROM
    reservation,
    TRANSACTION,
    CLIENT
WHERE
    reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Valide' AND reservation.etat_voyage_2 = 'Annule' AND reservation.type_reservation = 'Aller_retour' 
) AS nombre_total; ");


        $rep->execute(array($agence,$agence,$agence,$agence));

		$donnees = $rep->fetch();

		
        if ($donnees['nbre_place_dispo_total']=='') {
       
            echo "0";
		
         }else{

            echo $donnees['nbre_place_dispo_total'];
         }


?></div>