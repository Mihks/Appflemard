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

$_POST['id'] = filtre($_POST['id']);


$reponse = $bdd->prepare("SELECT reservation.type_reservation AS type,reservation.date_depart AS depart, reservation.date_retour AS retour , reservation.id_reservation FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? ");


	$reponse->execute(array($_SESSION['agence'],$_POST['id']));


	$donnee = $reponse->fetch();

	$type = $donnee['type'];

	$depart = $donnee['depart'];

	$id_reservation = $donnee['id_reservation'];

	$retour = $donnee['retour'];





if ( preg_match("#^Aller_simple$#", $type) && $depart == date('Y-m-d') && is_null($retour) ) {
				

		$requete = $bdd->prepare(" UPDATE reservation SET statut_voyage_1 = 'Effectue' WHERE nom_agence = ? AND id_reservation = ?  ");

		$requete->execute(array($_SESSION['agence'],$id_reservation)); 

		
		$reponse = $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation ='Aller_simple','Unique','') AS type,reservation.nombre_place,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite,reservation.date_depart, reservation.id_reservation FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND reservation.etat_voyage_1 ='Valide'   AND reservation.type_reservation='Aller_simple' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? ");

		$reponse->execute(array($_SESSION['agence'],$_POST['id'])); 
	
			
		$donnees = $reponse->fetch();

		echo "<p style='color:red;text-align:center;font-weight:bolder;font-size:25px;'>Voyage Effectué</p><br/>";

		echo "<table id='tab_qrc'>
						<thead>
						<tr>
						<th>Identifiant</th>
						<td>".$donnees['id']."</td></tr>


						<tr><th>Nom</th>
						<td>".$donnees['nom']."</td></tr>


						<tr><th>N° de téléphone</th>
						<td>".$donnees['num_tel']."</td></tr>"

					 ."<tr><th>Type de réservation</th>
					 	<td>".$donnees['type']."</td></tr>"

					 ."<tr><th>Nombre de place</th>
					   <td>".$donnees['nombre_place']."</td></tr>"


					 ."<tr><th>Trajet</th>
					   <td>".$donnees['trajet']."</td></tr>"


					 ."<tr><th>Date de depart</th>
					   <td>".$donnees['depart']." ".$donnees['heure']."</td></tr>"
					 									 
					 ."<tr><th>Date de réservation</th>
					    <td>".$donnees['date_reserve']."</td></tr>"
					 

					 ."<tr><th>Reference</th>
					   <td>".$donnees['ref_trans']."</td></tr>"
					 
					 ."<tr>
					 	<th>Prix du billet</th>
						<td>".$donnees['montant_debite']." XAF</td></tr>";

			


				echo '</thead></table>';


				$reponse->closeCursor();



}elseif ( preg_match("#^Aller_retour$#", $type) && $depart == date('Y-m-d') ) {
				
	
	$requete = $bdd->prepare(" UPDATE reservation SET statut_voyage_1 = 'Effectue' WHERE nom_agence = ? AND id_reservation = ?  ");

	$requete->execute(array($_SESSION['agence'],$id_reservation)); 


	$reponse = $bdd->prepare(" 

		SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite,reservation.date_depart,reservation.id_reservation FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND reservation.etat_voyage_1 ='Valide' AND reservation.type_reservation='Aller_retour' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? ");

		$reponse->execute(array($_SESSION['agence'],$_POST['id'])); 

		$donnees = $reponse->fetch();

				echo "<p style='color:red;text-align:center;font-weight:bolder;font-size:25px;'>Voyage Effectué</p><br/>";
				
				echo "<table id='tab_qrc'>

				<thead>
				</tr>
					<th>Identifiant</th>
				  	<td>".$donnees['id']."</td></tr>"


					 ."<tr><th>Nom</th>
					 	<td>".$donnees['nom']."</td></tr>"
					  

					  ."<tr><th>N° de téléphone</th>
					  	<td>".$donnees['num_tel']."</td></tr>"	
					 
					 ."<tr><th>Type de réservation</th>
					 	<td>".$donnees['type']."</td></tr>"
					 
					 ."<tr><th>Nombre de place</th>
					 	<td>".$donnees['nombre_place']."</td></tr>"
					 
					 ."<tr><th>Trajet</th>
					 	<td>".$donnees['trajet']."</td></tr>"
					 

					 ."<tr><th>Date de depart</th>
					 	<td>".$donnees['depart']." ".$donnees['heure']."</td></tr>"
					 					 

					 ."<tr><th>Date de réservation</th>
					 	<td>".$donnees['date_reserve']."</td></tr>"
					 
					 ."<tr><th>Reference</th>
					 	<td>".$donnees['ref_trans']."</td></tr>"
					 
					 ."<tr><th>Prix du billet</th>
					 	<td>".$donnees['montant_debite']." XAF</td></tr></thead>";

			

				echo '</table>';


				$reponse->closeCursor();


}elseif ( preg_match("#^Aller_retour$#", $type) && $retour == date('Y-m-d') ) {

				

			$requete = $bdd->prepare(" UPDATE reservation SET statut_voyage_2 = 'Effectue' WHERE nom_agence = ? AND id_reservation = ?  ");

				$requete->execute(array($_SESSION['agence'],$id_reservation)); 


			$reponse = $bdd->prepare(" SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,(reservation.trajet_retour) AS trajet,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart ,(reservation.heure_retour) AS heure,(reservation.etat_voyage_2) AS etat,(reservation.statut_voyage_2) AS stat_voy,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite ,reservation.date_retour,reservation.id_reservation FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.etat_voyage_2 ='Valide' AND reservation.type_reservation='Aller_retour' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ?  ");

				$reponse->execute(array($_SESSION['agence'],$_POST['id'])); 

			$donnees = $reponse->fetch();

				echo "<p style='color:red;text-align:center;font-weight:bolder;font-size:25px;'>Voyage Effectué</p><br/>";


			echo "<table id='tab_qrc'>

				<thead>
				</tr>
					<th>Identifiant</th>
				  	<td>".$donnees['id']."</td></tr>"

					 ."<tr><th>Nom</th>
					 	<td>".$donnees['nom']."</td></tr>"


					  ."<tr><th>N° de téléphone</th>
					  	<td>".$donnees['num_tel']."</td></tr>"

					 ."<tr><th>Type de réservation</th>
					 	<td>".$donnees['type']."</td></tr>"

					 ."<tr><th>Nombre de place</th>
					 	<td>".$donnees['nombre_place']."</td></tr>"

				 	 ."<tr><th>Trajet</th>
					 	<td>".$donnees['trajet']."</td></tr>"
					 

					 ."<tr><th>Date de depart</th>
					 	<td>".$donnees['depart']." ".$donnees['heure']."</td></tr>"


					 ."<tr><th>Reference</th>
					 	<td>".$donnees['ref_trans']."</td></tr>"

					 ."<tr><th>Prix du billet</th>
					 	<td>".$donnees['montant_debite']." XAF</td></tr></thead></table>";

 			$reponse->closeCursor();


}else{


	echo "<p style='color:red;font-weight:bolder;'>Billet non valide ou la date de voyage est différente d'aujourd'hui !</p>";
	
		}



}