
<?php

 
session_name('flemadmin');

session_start();


    include_once 'fonction.php';


$agence = $_SESSION['agence'];

$trajet = $_POST['trajet'];

$date_depart = $_POST['date'];

$heure_depart = $_POST['hora'];

       ?>

             
<div id="nbre_place_reservees_total"><?php


	
if (preg_match('#trajet_confondu#', $trajet)) {
       
    

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
        reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Valide' AND reservation.type_reservation = 'Aller_simple' AND reservation.heure_depart = ? AND reservation.date_depart = ? 
    UNION

SELECT
    SUM(reservation.nombre_place) AS total
    
FROM
    reservation,
    TRANSACTION,
    CLIENT
WHERE
    reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Valide' AND reservation.type_reservation = 'Aller_retour' AND reservation.heure_depart = ? AND reservation.date_depart = ?
UNION
SELECT
    SUM(reservation.nombre_place) AS total
    
FROM
    reservation,
    TRANSACTION,
    CLIENT
WHERE
    reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_2 = 'Valide' AND reservation.type_reservation = 'Aller_retour' AND reservation.heure_retour = ? AND reservation.date_retour = ?
) AS nombre_total; ");

        
 $rep->execute(array($agence,$heure_depart,$date_depart,$agence,$heure_depart,$date_depart,$agence,$heure_depart,$date_depart));

		
        $donnees = $rep->fetch();

		
        if ($donnees['nbre_place_reservees_total']=='') {
           
           echo "0";
        

        }else{
           
            echo $donnees['nbre_place_reservees_total'];
		
            }


    }else{



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
        reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Valide' AND reservation.type_reservation = 'Aller_simple' AND reservation.heure_depart = ? AND reservation.date_depart = ? AND reservation.trajet = ?
    UNION

SELECT
    SUM(reservation.nombre_place) AS total
    
FROM
    reservation,
    TRANSACTION,
    CLIENT
WHERE
    reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Valide' AND reservation.type_reservation = 'Aller_retour' AND reservation.heure_depart = ? AND reservation.date_depart = ? AND reservation.trajet = ?
UNION
SELECT
    SUM(reservation.nombre_place) AS total
    
FROM
    reservation,
    TRANSACTION,
    CLIENT
WHERE
    reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_2 = 'Valide' AND reservation.type_reservation = 'Aller_retour' AND reservation.heure_retour = ? AND reservation.date_retour = ? AND reservation.trajet_retour = ?
) AS nombre_total; ");

        
        $rep->execute(array($agence,$heure_depart,$date_depart,$trajet,$agence,$heure_depart,$date_depart,$trajet,$agence,$heure_depart,$date_depart,$trajet));

        
        $donnees = $rep->fetch();

        
        if ($donnees['nbre_place_reservees_total']=='') {
           
           echo "0";
        

        }else{
           
            echo $donnees['nbre_place_reservees_total'];
        
            }


    }


?></div>


<div id="nbre_place_dispo_total"><?php


if (preg_match('#trajet_confondu#', $trajet)) {
        
   	
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
        reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Annule' AND reservation.etat_voyage_2 IS NULL AND reservation.type_reservation = 'Aller_simple' AND reservation.heure_depart = ? AND reservation.date_depart = ? 
  
UNION
SELECT
    SUM(reservation.nombre_place) AS total
    
FROM
    reservation,
    TRANSACTION,
    CLIENT
WHERE
    reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Annule' AND reservation.type_reservation = 'Aller_retour' AND reservation.heure_depart = ? AND reservation.date_depart = ? 
UNION
SELECT
    SUM(reservation.nombre_place) AS total
    
FROM
    reservation,
    TRANSACTION,
    CLIENT
WHERE
    reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_2 = 'Annule' AND reservation.type_reservation = 'Aller_retour' AND reservation.heure_retour = ? AND reservation.date_retour = ? 
) AS nombre_total; ");


        $rep->execute(array($agence,$heure_depart,$date_depart,$agence,$heure_depart,$date_depart,$agence,$heure_depart,$date_depart));

		$donnees = $rep->fetch();

		
        if ($donnees['nbre_place_dispo_total']=='') {
       
            echo "0";
		
         }else{

            echo $donnees['nbre_place_dispo_total'];
         }



 }else{


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
        reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Annule' AND reservation.etat_voyage_2 IS NULL AND reservation.type_reservation = 'Aller_simple' AND reservation.heure_depart = ? AND reservation.date_depart = ? AND reservation.trajet = ?
  
UNION
SELECT
    SUM(reservation.nombre_place) AS total
    
FROM
    reservation,
    TRANSACTION,
    CLIENT
WHERE
    reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Annule' AND reservation.type_reservation = 'Aller_retour' AND reservation.heure_depart = ? AND reservation.date_depart = ? AND reservation.trajet = ?
UNION
SELECT
    SUM(reservation.nombre_place) AS total
    
FROM
    reservation,
    TRANSACTION,
    CLIENT
WHERE
    reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_2 = 'Annule' AND reservation.type_reservation = 'Aller_retour' AND reservation.heure_retour = ? AND reservation.date_retour = ? AND reservation.trajet_retour = ?
) AS nombre_total; ");


        $rep->execute(array($agence,$heure_depart,$date_depart,$trajet,$agence,$heure_depart,$date_depart,$trajet,$agence,$heure_depart,$date_depart,$trajet));

        $donnees = $rep->fetch();

        
        if ($donnees['nbre_place_dispo_total']=='') {
       
            echo "0";
        
         }else{

            echo $donnees['nbre_place_dispo_total'];
         }

 }


?></div>