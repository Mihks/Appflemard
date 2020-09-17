<?php 

session_name('flemadmin');

session_start();

    include_once 'fonction.php';



$trajet = $_POST['trajet'];

$date_depart = $_POST['date'];

$heure_depart = $_POST['hora'];

    

if (isset($_SESSION['agence']) && !empty($_SESSION['agence']) && isset($trajet) && !empty($trajet) && isset($date_depart) && !empty($date_depart) && isset($heure_depart) && !empty($heure_depart)) {
    

    
     if (preg_match('#trajet_confondu#', $trajet)){
	  
	  	
	  	$reponse = $bdd->prepare(" SELECT SUM(nombre_place_reserve) AS nombre_place_reserve FROM voyage WHERE nom_agence = ? AND date_voyage = ? AND horaire = ?  ");

		$reponse->execute(array($_SESSION["agence"],$date_depart,$heure_depart));

		$donnees = $reponse->fetch();

		$place_aller_reserve = $donnees['nombre_place_reserve'];

// 		$reponse->closeCursor();

        if ($donnees['nombre_place_reserve']=='') {
               
             echo "0";
            
          }else{
           
              echo $place_aller_reserve;
            
              }

		
	  
	  
	  
	  }else{
	

		$reponse = $bdd->prepare(" SELECT nombre_place_reserve FROM voyage WHERE nom_agence = ? AND date_voyage = ? AND nom_trajet = ? AND horaire = ?  ");

		$reponse->execute(array($_SESSION["agence"],$date_depart,$trajet,$heure_depart));

		$donnees = $reponse->fetch();

		 

		//$reponse->closeCursor();

        if ($donnees['nombre_place_reserve']=='') {
               
                echo "0";
            
          }else{
            
               $place_aller_reserve = $donnees['nombre_place_reserve'];
            
                 echo $place_aller_reserve;
            
              }

		
	  }
	 
    
    
    	
//     if (preg_match('#trajet_confondu#', $trajet)) {
           
        

//     			$rep =  $bdd->prepare("SELECT
       
//         SUM(total) AS nbre_place_reservees_total
//     FROM
//         (
//         SELECT
//             SUM(reservation.nombre_place) AS total
           
//         FROM
//             reservation,
//             TRANSACTION,
//             CLIENT
//         WHERE
//             reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Valide' AND reservation.type_reservation = 'Aller_simple' AND reservation.date_depart = ? AND reservation.heure_depart = ? 
//         UNION ALL

//     SELECT
//         SUM(reservation.nombre_place) AS total
        
//     FROM
//         reservation,
//         TRANSACTION,
//         CLIENT
//     WHERE
//         reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Valide' AND reservation.type_reservation = 'Aller_retour' AND reservation.date_depart = ? AND reservation.heure_depart = ?
//     UNION ALL
//     SELECT
//         SUM(reservation.nombre_place) AS total
        
//     FROM
//         reservation,
//         TRANSACTION,
//         CLIENT
//     WHERE
//         reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_2 = 'Valide' AND reservation.type_reservation = 'Aller_retour' AND reservation.date_retour = ? AND reservation.heure_retour = ?
//     ) AS nombre_total; ");

            
//      $rep->execute(array($_SESSION['agence'],$date_depart,$heure_depart,$_SESSION['agence'],$date_depart,$heure_depart,$_SESSION['agence'],$date_depart,$heure_depart));

    		
//             $donnees = $rep->fetch();

    		
//             if ($donnees['nbre_place_reservees_total']=='') {
               
//                echo "0";
            

//             }else{
               
//                 echo $donnees['nbre_place_reservees_total'];
    		
//                 }


//         }else{



//             $rep =  $bdd->prepare("SELECT
       
//         SUM(total) AS nbre_place_reservees_total
//     FROM
//         (
//         SELECT
//             SUM(reservation.nombre_place) AS total
           
//         FROM
//             reservation,
//             TRANSACTION,
//             CLIENT
//         WHERE
//             reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Valide' AND reservation.type_reservation = 'Aller_simple' AND reservation.heure_depart = ? AND reservation.date_depart = ? AND reservation.trajet = ?
//         UNION ALL

//     SELECT
//         SUM(reservation.nombre_place) AS total
        
//     FROM
//         reservation,
//         TRANSACTION,
//         CLIENT
//     WHERE
//         reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_1 = 'Valide' AND reservation.type_reservation = 'Aller_retour' AND reservation.heure_depart = ? AND reservation.date_depart = ? AND reservation.trajet = ?
//     UNION ALL
//     SELECT
//         SUM(reservation.nombre_place) AS total
        
//     FROM
//         reservation,
//         TRANSACTION,
//         CLIENT
//     WHERE
//         reservation.id_reservation = TRANSACTION.id_reservation AND CLIENT.id_client = TRANSACTION.id_client AND reservation.nom_agence = ? AND TRANSACTION.statut = 'Succes' AND reservation.etat_voyage_2 = 'Valide' AND reservation.type_reservation = 'Aller_retour' AND reservation.heure_retour = ? AND reservation.date_retour = ? AND reservation.trajet_retour = ?
//     ) AS nombre_total; ");

            
//             $rep->execute(array($_SESSION['agence'],$heure_depart,$date_depart,$trajet,$_SESSION['agence'],$heure_depart,$date_depart,$trajet,$_SESSION['agence'],$heure_depart,$date_depart,$trajet));

            
//             $donnees = $rep->fetch();

            
//             if ($donnees['nbre_place_reservees_total']=='') {
               
//                echo "0";
            

//             }else{
               
//                 echo $donnees['nbre_place_reservees_total'];
            
//                 }


//         }


}else{

    echo '...';
}
