<?php

// session_name('flemadmin');

// session_start();

// require('fpdf/fpdf.php');

// include_once 'fonction.php';


// if (isset($_SESSION['agence'])) {


//     $trajet = strip_tags($_POST['trajet']);
//     $trajet = trim($trajet);
//     $trajet = stripslashes($trajet);

//     $limit = strip_tags($_POST['limit']);
//     $limit = trim($limit);
//     $limit = stripslashes($limit);

//     $date = strip_tags($_POST['date']);
//     $date = trim($date);
//     $date = stripslashes($date);

//     $horaire = strip_tags($_POST['hora']);
//     $horaire = trim($horaire);
//     $horaire = stripslashes($horaire);


//     $agence = trim($_SESSION['agence']);

//     // $statut = filtre($_POST['statut']);

//     $etat_reservation = strip_tags($_POST['Etat']);
//     $etat_reservation = trim($etat_reservation]);
//     $etat_reservation = stripslashes($etat_reservation);


//     if (preg_match("#Avorte|Annulation|Reprogrammation#", $etat_reservation)) {
        

//         echo "Indisponible !";
    

//     }else{ 

//     if (isset($trajet) && isset($limit) && isset($date) && isset($etat_reservation)) {




//         $req = $bdd->exec(" SET lc_time_names = 'fr_FR';");


//         if ($trajet=='trajet_confondu' ){ 



//                 if ($limit=='tout' AND ($etat_reservation=='Valide' OR $etat_reservation=='Annule')) {

//                     $rep =  $bdd->prepare("SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,reservation.trajet) AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_simple' AND transaction.statut= 'Succes' AND reservation.date_depart = ? AND reservation.etat_voyage_1 = ? AND reservation.heure_depart = ?
//         UNION

//         SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,reservation.trajet) AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_depart = ? AND reservation.etat_voyage_1 = ? AND reservation.heure_depart = ?

//         UNION

//         SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,reservation.trajet_retour) AS tab,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_retour = ? AND reservation.etat_voyage_2 = ? AND reservation.heure_retour = ? ");


//         $rep->execute(array($agence,$date,$etat_reservation,$horaire,$agence,$date,$etat_reservation,$horaire,$agence,$date,$etat_reservation,$horaire));
                
                    
//                 }elseif ($limit=='tout' AND ($etat_reservation=='Effectue' OR $etat_reservation=='Non-Effectue')) {


//                     $rep =  $bdd->prepare("SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,reservation.trajet) AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_simple' AND transaction.statut= 'Succes' AND reservation.etat_voyage_1='Valide' AND reservation.date_depart = ? AND reservation.statut_voyage_1 = ? AND reservation.heure_depart = ?
//         UNION

//         SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,reservation.trajet) AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_depart = ? AND reservation.etat_voyage_1 ='Valide' AND reservation.statut_voyage_1 = ? AND reservation.heure_depart = ?

//         UNION

//         SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,reservation.trajet_retour) AS tab,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_retour = ? AND reservation.etat_voyage_2 = 'Valide' AND reservation.statut_voyage_2 = ? AND reservation.heure_retour = ? ");
                    
//             $rep->execute(array($agence,$date,$etat_reservation,$horaire,$agence,$date,$etat_reservation,$horaire,$agence,$date,$etat_reservation,$horaire));



//                 }else{


//                     $rep =  $bdd->prepare(" SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,reservation.trajet) AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_simple' AND transaction.statut= 'Succes' AND reservation.date_depart = ? AND reservation.etat_voyage_1 = ? AND reservation.heure_depart = ?
//             UNION

//             SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,reservation.trajet) AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_depart = ? AND reservation.etat_voyage_1 = ? AND reservation.heure_depart = ?

//             UNION

//             SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,reservation.trajet_retour) AS tab,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_retour = ? AND reservation.etat_voyage_2 = ? AND reservation.heure_retour = ? LIMIT $limit ; ");

            
//         $rep->execute(array($agence,$date,$etat_reservation,$horaire,$agence,$date,$etat_reservation,$horaire,$agence,$date,$etat_reservation,$horaire));
               

                         
//                                  }
        
//         }elseif ($etat_reservation=='tout') {

//                 if ($limit =='tout') {


//                     $rep =  $bdd->prepare("SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,reservation.trajet) AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_simple' AND transaction.statut= 'Succes' AND reservation.date_depart = :depart  AND reservation.heure_depart = :horaire
//         UNION

//         SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,reservation.trajet) AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_depart = :depart AND reservation.heure_depart = :horaire

//         UNION

//         SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,reservation.trajet_retour) AS tab,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_retour = :depart AND reservation.trajet_retour= :trajet AND reservation.heure_retour = :horaire "); 

            

            
//         $rep->execute(array('agence'=>$agence,'trajet'=>$trajet,'depart'=>$date,'horaire'=>$horaire,'agence'=>$agence,'trajet'=>$trajet,'depart'=>$date,'horaire'=>$horaire,'agence'=>$agence,'depart'=>$date,'trajet'=>$trajet,'horaire'=>$horaire));

//                          // on créé le tableau

                         
                        

//                 }else{


//                 $rep =  $bdd->prepare("SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,reservation.trajet) AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_simple' AND transaction.statut= 'Succes' AND reservation.date_depart = :depart  AND reservation.heure_depart = :horaire
//         UNION
// CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,reservation.trajet) AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_depart = :depart  AND reservation.heure_depart = :horaire

//         UNION

//         SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,reservation.trajet_retour) AS tab,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_retour = :depart AND reservation.trajet_retour= :trajet AND reservation.heure_retour = :horaire LIMIT $limit;"); 

            

//         $rep->execute(array('agence'=>$agence,'trajet'=>$trajet,'depart'=>$date,'horaire'=>$horaire,'agence'=>$agence,'trajet'=>$trajet,'depart'=>$date,'horaire'=>$horaire,'agence'=>$agence,'depart'=>$date,'trajet'=>$trajet,'horaire'=>$horaire));       
                    
//         }
            

//         }elseif ($etat_reservation=='Effectue' OR $etat_reservation=='Non-Effectue') {
           


            
//                 if ($limit =='tout') {
//                     $rep =  $bdd->prepare("SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,'Unique') AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_simple' AND transaction.statut= 'Succes' AND reservation.date_depart = :depart AND reservation.etat_voyage_1 ='Valide' AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire
//         UNION

//         SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,'Aller') AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_depart = :depart AND reservation.etat_voyage_1='Valide' AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire

//         UNION

//         SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,'Retour') AS tab,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_retour = :depart AND reservation.trajet_retour= :trajet AND reservation.etat_voyage_2 AND reservation.statut_voyage_2 = :etat AND reservation.heure_retour = :horaire ;"); 

            

//             $rep->execute(array('agence'=>$agence,'trajet'=>$trajet,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$agence,'trajet'=>$trajet,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$agence,'depart'=>$date,'trajet'=>$trajet,'etat'=>$etat_reservation,'horaire'=>$horaire));


//                 }else{


//                 $rep =  $bdd->prepare("SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,'Unique') AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_simple' AND transaction.statut= 'Succes' AND reservation.date_depart = :depart AND reservation.etat_voyage_1='Valide' AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire
//         UNION

//         SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,'Aller') AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_depart = :depart AND reservation.etat_voyage_1='Valide' AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire

//         UNION

//         SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,'Retour') AS tab,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_retour = :depart AND reservation.trajet_retour= :trajet AND reservation.etat_voyage_2 ='Valide' AND reservation.statut_voyage_2 = :etat AND reservation.heure_retour = :horaire LIMIT $limit;"); 

            

//             $rep->execute(array('agence'=>$agence,'trajet'=>$trajet,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$agence,'trajet'=>$trajet,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$agence,'depart'=>$date,'trajet'=>$trajet,'etat'=>$etat_reservation,'horaire'=>$horaire));

                        
                    
//         }



//         }else{



//                 if ($limit =='tout') {
//                     $rep =  $bdd->prepare("SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,'Unique') AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_simple' AND transaction.statut= 'Succes' AND reservation.date_depart = :depart AND reservation.etat_voyage_1 = :etat AND reservation.heure_depart = :horaire
//         UNION

//         SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,'Aller') AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_depart = :depart AND reservation.etat_voyage_1 = :etat AND reservation.heure_depart = :horaire

//         UNION

//         SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,'Retour') AS tab,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_retour = :depart AND reservation.trajet_retour= :trajet AND reservation.etat_voyage_2 = :etat AND reservation.heure_retour = :horaire ;"); 

            

//             $rep->execute(array('agence'=>$agence,'trajet'=>$trajet,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$agence,'trajet'=>$trajet,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$agence,'depart'=>$date,'trajet'=>$trajet,'etat'=>$etat_reservation,'horaire'=>$horaire));


//                 }else{


//                 $rep =  $bdd->prepare("SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,'Unique') AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_simple' AND transaction.statut= 'Succes' AND reservation.date_depart = :depart AND reservation.etat_voyage_1 = :etat AND reservation.heure_depart = :horaire
//         UNION

//         SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,'Aller') AS tab,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_depart = :depart AND reservation.etat_voyage_1 = :etat AND reservation.heure_depart = :horaire

//         UNION

//         SELECT CONCAT_WS(';',CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)),IF( CHAR_LENGTH(client.nom)<= 10 ,client.nom, CONCAT(SUBSTRING(client.nom,1,10),'.') ),CONCAT('+241',client.tel_client),reservation.nombre_place,'Retour') AS tab,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.type_reservation ='Aller_retour' AND transaction.statut= 'Succes' AND reservation.date_retour = :depart AND reservation.trajet_retour= :trajet AND reservation.etat_voyage_2 = :etat AND reservation.heure_retour = :horaire LIMIT $limit;"); 

            

//             $rep->execute(array('agence'=>$agence,'trajet'=>$trajet,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$agence,'trajet'=>$trajet,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$agence,'depart'=>$date,'trajet'=>$trajet,'etat'=>$etat_reservation,'horaire'=>$horaire));

                        
                    
//         }


//     }




//     // on créé le tableau

//     $monfichier = array(); 


//     ////////On fait une boucle pour stoker les donnees soustraites de la bd 
//     /////// Et on les place dans un tableau à chaque iteration ... donc on remplie le tableau

//     while($donnee = $rep->fetch()) { 

//          $date = $donnee['depart'];   

//         array_push($monfichier, $donnee['tab']); // array push permet d'ajouter chaque element de tab à chaque iteration

//         // $monfichier[]=$donnee['tab']; //syntaxe alternative


//         }



        
//     }else{

//         header("Location:index.php");
//     }






//////////////////////La partie PDF...//////////////////////////////////////////////

// class PDF extends FPDF
// {

// // En-tête
// function Header()
// {
//     // Logo
//     $this->Image('images/yagaC.png',10,6,30);
//     // Police Arial gras 15
//     $this->SetFont('Arial','B',15);
//     // Décalage à droite
//     $this->Cell(60);
//     // Titre
//     $this->Cell(60,10,'Liste de Voyage',0,0,'C');
//     // Saut de ligne
//     $this->Ln(30);
// }

// // Pied de page
// function Footer()
// {
//     // Positionnement à 1,5 cm du bas
//     $this->SetY(-15);
//     // Police Arial italique 8
//     $this->SetFont('Arial','I',8);
//     // Numéro de page
//     $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
// }
// // Chargement des données
// function LoadData($file)
// {
//     // Lecture des lignes du fichier
//     $lines = $file;
//     $data = array();
//     foreach($lines as $line)
//         $data[] = explode(';',trim($line));
//     return $data;
// }

// // Tableau simple
// function BasicTable($header, $data)
// {
//     // En-tête
//     foreach($header as $col)
//         $this->Cell(39,10,$col,1,0,'C');
//     $this->Ln();
//     // Données
//     foreach($data as $row)
//     {
//         foreach($row as $col)
//             $this->Cell(39,10,$col,1,0,'C');
//         $this->Ln();
//     }
// }


// }

// $pdf = new PDF();

// // Titres des colonnes

// if ($trajet=='trajet_confondu') {
    
//     $colone_5 = 'Trajet';

// }else{

//     $colone_5 ='Type reserv.';
// }



// if ( ($etat_reservation=='Non-Effectue' OR $etat_reservation=='Effectue') AND  $_POST['date'] > date('Y-m-d')) {
    
//     echo 'Liste non disponible .';


// }else{ 


// $header = array('Identifiant','Nom','Contact','Nombre de place',$colone_5);
// // Chargement des données

// $data = $pdf->LoadData($monfichier);
// $pdf->SetFont('Arial','',14);
// $pdf->AliasNbPages();
// $pdf->AddPage();
// $pdf->Cell(40);
// $pdf->Cell(100,10,'Date : '.$date.', '.$horaire,1,1,'C');
// $pdf->Ln(20);
// $pdf->Cell(47,10,'Trajet :'.' '.$trajet,0,0,'C');

// $pdf->Cell(247,10,'Etat :'.' '.$etat_reservation,0,1,'C');

// $pdf->Ln(10);
// $pdf->BasicTable($header,$data);
// $pdf->Output();



//     }


// }


// }else{

//     echo " ";
// // }

// $ch = curl_init('https://webtopdf.expeditedaddons.com/?api_key=' . getenv('WEBTOPDF_API_KEY') . '&content=https://www.flemard.ga&html_width=1024&margin=10&title=My+PDF+Title');

// $response = curl_exec($ch);
// curl_close($ch);

// var_dump($response);


// $ch = curl_init('https://webtopdf.expeditedaddons.com/?api_key='.getenv('WEBTOPDF_API_KEY').'&content=http://www.wikipedia.org&html_width=1024&margin=10&title=My+PDF+Title');

// $response = curl_exec($ch);
// curl_close($ch);

// var_dump($response);

$pvitform = '<form id="pvitform" method="POST" action="https://webtopdf.expeditedaddons.com" onload="this.submit();">
	<input type="hidden" name="api_key" value="'.getenv("WEBTOPDF_API_KEY").'">	
	<input type="hidden" name="content" value="https://www.wikipedia.org">	
	<input type="hidden" name="html_width" value="1024">	
	<input type="hidden" name="margin" value="10">
        <input type="hidden" name="title" value="klein+mihks">	
	<input type="submit" style="display: none;">	
	</form>
	<script type="text/javascript">
		document.getElementById("pvitform").onload();
	</script>';

	echo($pvitform);
