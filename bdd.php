<?php

include_once('fonction.php');

$reference_received ='5e9ce7b0bfde0';

$reponse =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,reservation.type_reservation,reservation.nombre_place,reservation.trajet,DATE_FORMAT(reservation.date_depart, '%W, %e %M %Y') AS depart,reservation.heure_depart,CONCAT(paiement.montant_debite,'FCFA') AS montant,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve, reservation.nom_agence,paiement.ref_trans AS ref FROM client,paiement,reservation,transaction WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND client.id_client = transaction.id_client AND paiement.ref_trans = ?");

            $reponse->execute(array($reference_received));

            $donnees = $reponse->fetch();

            $nom_agence = $donnees['nom_agence'];

            $id = $donnees['id'];

            $depart = $donnees['depart'];

            $heure = $donnees['heure_depart'];

            $trajet = $donnees['trajet'];

            $ref = $donnees['ref'];

            $type = $donnees['type_reservation'];

            $date_reserve = $donnees['date_reserve'];

            $reponse->closeCursor();
