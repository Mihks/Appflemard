<?php

session_name('flemadmin');

session_start(); 


if (!isset($_SESSION['agence'])) {
	
	echo "connectez-vous !";
}else{ 


	include_once 'fonction.php';




$req = $bdd->exec(" SET lc_time_names = 'fr_FR';");



function filtre($value)
{
	$nom = strip_tags($value);
	$nom = trim($nom);
	$nom = stripslashes($nom);
	return  $nom;
}




function FunctionGroupe($bdd)

{




$id = filtre($_POST['id']);


$reponse = $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation ='Aller_simple','Unique','') AS type,reservation.nombre_place,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite,reservation.date_depart, reservation.id_reservation FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND reservation.etat_voyage_1 ='Valide' AND reservation.statut_voyage_1 ='Non-Effectue'  AND reservation.type_reservation='Aller_simple' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? 

			UNION
				SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite,reservation.date_depart,reservation.id_reservation FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND reservation.etat_voyage_1 ='Valide' AND reservation.statut_voyage_1 ='Non-Effectue' AND reservation.type_reservation='Aller_retour' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? 
			UNION
			  SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,(reservation.trajet_retour) AS trajet,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart ,(reservation.heure_retour) AS heure,(reservation.etat_voyage_2) AS etat,(reservation.statut_voyage_2) AS stat_voy,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,CONCAT('-'),reservation.date_retour,reservation.id_reservation FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.etat_voyage_2 ='Valide' AND reservation.statut_voyage_2 ='Non-Effectue' AND reservation.type_reservation='Aller_retour' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ?  ");


		$reponse->execute(array($_SESSION['agence'],$id,$_SESSION['agence'],$id,$_SESSION['agence'],$id));

		return $reponse;

}


	$reponse = FunctionGroupe($bdd);

		while ($donnees = $reponse->fetch()) {

			$type_reservation[] = $donnees['type'];

			$depart[] = $donnees['date_depart'];

			$date_voyage[] = $donnees['depart'];

			$id_reservation = $donnees['id_reservation'];
		}


		echo '</table>';


		$reponse->closeCursor();


		if (isset($id_reservation) ) {

			echo "<table>
						<thead>
						<tr>
						<th>Identifiant</th>
						<th>Nom</th>
						<th>N° de telephone</th>
						<th>Type de reservation</th>
						<th>Nombre de place</th>
						<th>Trajet</th>
						<th>Date de depart</th>
						<th>Heure de depart</th>
						<th>Etat de reservation</th>
						<th>Etat de voyage</th>
						<th>Date de reservation</th>
						<th>Reference</th>
						<th>Montant (XAF)</th>
						</thead><tr>";

			if ( preg_match("#Unique|Aller#", $type_reservation[0]) && $depart[0] == date('Y-m-d') ) {
				

			$requete = $bdd->prepare(" UPDATE reservation SET statut_voyage_1 = 'Effectue' WHERE nom_agence = ? AND id_reservation = ?  ");

			$requete->execute(array($_SESSION['agence'],$id_reservation)); 

			$reponse = FunctionGroupe($bdd);
			
			
			while ($donnees = $reponse->fetch()) {
				
				echo "<td>".$donnees['id']."</td>"
					 ."<td>".$donnees['nom']."</td>"
					  ."<td>".$donnees['num_tel']."</td>"	
					 ."<td>".$donnees['type']."</td>"
					 ."<td>".$donnees['nombre_place']."</td>"
					 ."<td>".$donnees['trajet']."</td>"
					 ."<td>".$donnees['depart']."</td>"
					 ."<td>".$donnees['heure']."</td>"
					 ."<td>".$donnees['etat']."</td>"
					 ."<td>".$donnees['stat_voy']."</td>"
					 ."<td>".$donnees['date_reserve']."</td>"
					 ."<td>".$donnees['ref_trans']."</td>"
					 ."<td>".$donnees['montant_debite']."</td></tr>";

			}


				echo '</table>';


				$reponse->closeCursor();



			}elseif (preg_match("#Unique|Aller#", $type_reservation[0]) && $depart[0] != date('Y-m-d')) {
				

				$reponse = FunctionGroupe($bdd);

				while ($donnees = $reponse->fetch()) {
				
				echo "<td>".$donnees['id']."</td>"
					 ."<td>".$donnees['nom']."</td>"
					  ."<td>".$donnees['num_tel']."</td>"	
					 ."<td>".$donnees['type']."</td>"
					 ."<td>".$donnees['nombre_place']."</td>"
					 ."<td>".$donnees['trajet']."</td>"
					 ."<td>".$donnees['depart']."</td>"
					 ."<td>".$donnees['heure']."</td>"
					 ."<td>".$donnees['etat']."</td>"
					 ."<td>".$donnees['stat_voy']."</td>"
					 ."<td>".$donnees['date_reserve']."</td>"
					 ."<td>".$donnees['ref_trans']."</td>"
					 ."<td>".$donnees['montant_debite']."</td></tr>";

			}

				echo '</table>';


				$reponse->closeCursor();


			echo "<script>alert('Le voyage nest pas prévu pour daujourd'hui !');</script>";

			}


			////////////////////////::

			if (preg_match("#Unique#", $type_reservation[0])) {
				
				$type_reservation[1] = NULL;

				$depart[1] = NULL;

				$date_voyage[1] = NULL;
			}


			if ( preg_match("#Retour#", $type_reservation[1]) && $depart[1] == date('Y-m-d')) {
				
				$requete = $bdd->prepare(" UPDATE reservation SET statut_voyage_2 = 'Effectue' WHERE nom_agence = ? AND id_reservation = ?  ");

				$requete->execute(array($_SESSION['agence'],$id_reservation)); 


				$reponse = FunctionGroupe($bdd);


				while ($donnees = $reponse->fetch()) {
				
				echo "<td>".$donnees['id']."</td>"
					 ."<td>".$donnees['nom']."</td>"
					  ."<td>".$donnees['num_tel']."</td>"	
					 ."<td>".$donnees['type']."</td>"
					 ."<td>".$donnees['nombre_place']."</td>"
					 ."<td>".$donnees['trajet']."</td>"
					 ."<td>".$donnees['depart']."</td>"
					 ."<td>".$donnees['heure']."</td>"
					 ."<td>".$donnees['etat']."</td>"
					 ."<td>".$donnees['stat_voy']."</td>"
					 ."<td>".$donnees['date_reserve']."</td>"
					 ."<td>".$donnees['ref_trans']."</td>"
					 ."<td>".$donnees['montant_debite']."</td></tr>";

			}

				echo '</table>';


				$reponse->closeCursor();



			}elseif (preg_match("#Retour#", $type_reservation[1]) && $depart[1] != date('Y-m-d')) {

				
				if ($depart[1] < date('Y-m-d')) {

				echo "<script>alert('Le voyage retour est ou est deja passé. Veuillez reprogrammer votre voyage si votre billet est encore valide !');</script>";

				}else if( $depart[1] > date('Y-m-d')) {

					
					echo "<script>alert('Le voyage retour est ou est deja passé. Veuillez reprogrammer votre voyage si votre billet est encore valide !');</script>";
 
			}

			
			}


		}else{

			echo "Billet non valide !";
		}





}

