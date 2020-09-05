<?php

session_name('flemadmin');

session_start();


header('Content-Type: text/html; charset=utf-8');


if (isset($_SESSION['agence']) && !empty($_SESSION['agence']) && isset($_POST['id']) && isset($_POST['limit']) ) {
	


function callTab($id,$rep,$agence)
{
	$rep->execute(array($_SESSION['agence'],$id,$_SESSION['agence'],$id,$_SESSION['agence'],$id));

		

	if (preg_match('#^terrestre$#', $_SESSION['type_agence'])) {
			
		
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
						<th>Etat de reservation</th>
						<th>Etat de voyage</th>
						<th>Date de reserv/annul</th>
						<th>Reference</th>
						<th>Prix du billet (XAF)</th></tr>
						</thead><tr>";

		while ($donnees = $rep->fetch()) {
			
			echo "<td>".$donnees['id']."</td>"
				 ."<td>".$donnees['nom']."</td>"
				  ."<td>".$donnees['num_tel']."</td>"	
				 ."<td>".$donnees['type']."</td>"
				 ."<td>".$donnees['nombre_place']."</td>"
				 ."<td>".$donnees['trajet']."</td>"
				 ."<td>".$donnees['depart']." ".$donnees['heure']."</td>"
				 ."<td>".$donnees['etat']."</td>"
				 ."<td>".$donnees['stat_voy']."</td>"
				 ."<td>".$donnees['date_reserve']."</td>"
				 ."<td>".$donnees['ref_trans']."</td>"
				 ."<td>".$donnees['montant_debite']."</td></tr>";

		}


		echo '</table>';

	}elseif (preg_match('#^maritime$#', $_SESSION['type_agence'])) {
		
		echo "<table>
						<thead>
						<tr>
						<th>Identifiant</th>
						<th>Nom</th>
						<th>N° de telephone</th>
						<th>Type de reservation</th>
						<th>Nombre de place</th>
						<th>Categorie</th>
						<th>Classe</th>
						<th>Trajet</th>
						<th>Date de depart</th>
						<th>Etat de reservation</th>
						<th>Etat de voyage</th>
						<th>Date de reserv/annul</th>
						<th>Reference</th>
						<th>Montant (XAF)</th></tr>
						</thead><tr>";

		while ($donnees = $rep->fetch()) {
			
			echo "<td>".$donnees['id']."</td>"
				 ."<td>".$donnees['nom']."</td>"
				  ."<td>".$donnees['num_tel']."</td>"	
				 ."<td>".$donnees['type']."</td>"
				 ."<td>".$donnees['nombre_place']."</td>"
				 ."<td>".$donnees['seuil']."</td>"
				  ."<td>".$donnees['classe']."</td>"
				 ."<td>".$donnees['trajet']."</td>"
				 ."<td>".$donnees['depart']." ".$donnees['heure']."</td>"
				 ."<td>".$donnees['etat']."</td>"
				 ."<td>".$donnees['stat_voy']."</td>"
				 ."<td>".$donnees['date_reserve']."</td>"
				 ."<td>".$donnees['ref_trans']."</td>"
				 ."<td>".$donnees['montant_debite']."</td></tr>";

		}


		echo '</table>';
	}
}


	include_once 'fonction.php';


	$req = $bdd->exec(" SET lc_time_names = 'fr_FR';");
function filtre($value)
{
	$nom = strip_tags($value);
	$nom = trim($nom);
	$nom = stripslashes($nom);
	return  $nom;
}

	$id = filtre($_POST['id']);

	$limit = filtre($_POST['limit']);





if (preg_match('#^terrestre$#', $_SESSION['type_agence'])) {
			


	if(isset($id) && !empty($id) && preg_match("#^[A-Za-z -]+$#", $id)){
		

		if ($limit=='tout') {
			
			$rep = $bdd->prepare(" SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation ='Aller_simple','Unique','') AS type,reservation.nombre_place,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_simple' AND statut IS NOT NULL AND client.nom LIKE CONCAT('%',?,'%') 

			UNION
				SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND reservation.type_reservation='Aller_retour' AND statut IS NOT NULL AND client.nom LIKE CONCAT('%',?,'%')
			UNION
			  SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,(reservation.trajet_retour) AS trajet,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart ,(reservation.heure_retour) AS heure,(reservation.etat_voyage_2) AS etat,(reservation.statut_voyage_2) AS stat_voy,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,CONCAT('-') FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND reservation.type_reservation='Aller_retour' AND statut IS NOT NULL AND client.nom LIKE CONCAT('%',?,'%') ORDER BY ref_trans ASC ;");

			callTab($id,$rep,$_SESSION['agence']);
		


		}else{


			$rep = $bdd->prepare(" SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation ='Aller_simple','Unique','') AS type,reservation.nombre_place,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y  %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_simple' AND statut IS NOT NULL AND client.nom LIKE CONCAT('%',?,'%') 

			UNION
				SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND reservation.type_reservation='Aller_retour' AND statut IS NOT NULL AND client.nom LIKE CONCAT('%',?,'%')
			UNION
			  SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,(reservation.trajet_retour) AS trajet,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart ,(reservation.heure_retour) AS heure,(reservation.etat_voyage_2) AS etat,(reservation.statut_voyage_2) AS stat_voy,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,CONCAT('-') FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND reservation.type_reservation='Aller_retour' AND statut IS NOT NULL AND client.nom LIKE CONCAT('%',?,'%') ORDER BY ref_trans ASC LIMIT $limit ;");

			callTab($id,$rep,$_SESSION['agence']);


		}

	}elseif (isset($id) && !empty($id) && preg_match("#^[0-9a-zA-Z -]+$#",$id)) {
		

		$reponse = $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,reservation.type_reservation AS type,reservation.nombre_place,(reservation.trajet) AS trajet,(reservation.trajet_retour) AS trajet_retour,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS retour,(reservation.heure_depart) AS heure,(reservation.heure_depart) AS heure_retour,(reservation.etat_voyage_1) AS etat,(reservation.etat_voyage_2) AS etat_2,(reservation.statut_voyage_1) AS stat_voy,(reservation.statut_voyage_2) AS stat_voy_2,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reserv,paiement.ref_trans,paiement.montant_debite,reservation.penalite_1 AS penalite,reservation.penalite_2 AS penalite_2,reservation.excedent_1 AS excedent,reservation.excedent_2 AS excedent_2,DATE_FORMAT(paiement.date_paiement, '%W %e %M %Y') AS date_paiement FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? ");

		$reponse->execute(array($_SESSION['agence'],$_POST['id'])); 
	
			
		$donnees = $reponse->fetch();


		$total = ($donnees['type']=='Aller_simple') ? $donnees['penalite'] + $donnees['excedent']+ $donnees['montant_debite'] :    $donnees['penalite']+ $donnees['excedent']+ $donnees['montant_debite']+ $donnees['penalite_2']+$donnees['excedent_2'];

		if ($donnees['type']=='Aller_simple') {
			# code...
		
				//type  de reservation aller
				$etat = ($donnees['etat']=='Annule') ? "Date d'annulation" : "Date de réservation" ;


				echo "<div style='float:right;position:relative;right:200px;'>

					<ul style='list-style:none;'>

						<li style='font-weight:bolder;color:rgb(0,128,128)'>Identifiant</li>
						<li>".$donnees['id']."</li>

						<br/>

						<li style='font-weight:bolder;color:rgb(0,128,128)'>Nom</li>
						<li>".$donnees['nom']."</li>

						<br/>

						<li style='font-weight:bolder;color:rgb(0,128,128)'>N° de téléphone</li>
						<li>".$donnees['num_tel']."</li>

						
					</ul>

				<p><b style='color:rgb(0,128,128);'>Date de paiement</b> : ".$donnees['date_paiement']." | <b style='color:rgb(0,128,128);'>Reference</b> : ".$donnees['ref_trans']."

				<br/> <b style='color:rgb(0,128,128);'>Prix du billet</b> : <b>".$donnees['montant_debite']."</b> XAF

				<br/> <b style='color:rgb(0,128,128);'>Total</b> : <b>".$total."</b> XAF</p></div>
					
					</div>";

			echo "<table id='tab_qrc'>
						<thead>
						

					 <tr><th>Réservation</th>
					 	<td><b style='font-size:16px;'>Unique</b></td></tr>"

					 ."<tr><th>Nombre de place</th>
					   <td>".$donnees['nombre_place']."</td></tr>"


					 ."<tr><th>Trajet</th>
					   <td>".$donnees['trajet']."</td></tr>"


					 ."<tr><th>Date de depart</th>
					   <td>".$donnees['depart']." ".$donnees['heure']."</td></tr>"
					 									 
					 ."<tr><th>".$etat."</th>
					    <td>".$donnees['date_reserve']."</td></tr>"
					 

					 ."<tr><th>Etat de réservation</th>
					   <td>".$donnees['etat']."</td></tr>"

 					."<tr>
					 	<th>Etat de voyage</th>
						<td>".$donnees['stat_voy']."</td></tr>"

					 ."<tr><th>Pénalité</th>
						<td><b style='color:red;'>".$donnees['penalite']."</b> XAF</td></tr>"

					 ."<tr><th>Excédent</th>
						<td><b style='color:lime;'>".$donnees['excedent']."</b> XAF</td></tr>";

			


				echo '</thead></table>';


				$reponse->closeCursor();

			}elseif ($donnees['type']=='Aller_retour') {
				
				//type reservation Retour
				$etat_2 = ($donnees['etat_2']=='Annule') ? "Date d'annulation" : "Date de réservation" ;


				//type  de reservation aller
				$etat = ($donnees['etat']=='Annule') ? "Date d'annulation" : "Date de réservation" ;



				echo "<div style='float:right;'><table id='tab_qrc' >
						<thead>


					 <tr><th>Réservation</th>
					 	<td><b style='font-size:16px;'>Retour</b></td></tr>"


					 ."<tr><th>Trajet</th>
					   <td>".$donnees['trajet_retour']."</td></tr>"


					 ."<tr><th>Date de depart</th>
					   <td>".$donnees['retour']." ".$donnees['heure_retour']."</td></tr>"
					 									 
					 ."<tr><th>".$etat_2."</th>
					    <td>".$donnees['date_reserv']."</td></tr>"
					 

					 ."<tr><th>Etat de réservation</th>
					   <td>".$donnees['etat_2']."</td></tr>"
					 
					 ."<tr>
					 	<th>Etat de voyage</th>
						<td>".$donnees['stat_voy_2']."</td></tr>"

					 ."<tr><th>Pénalité</th>
						<td><b style='color:red;'>".$donnees['penalite_2']."</b> XAF</td></tr>"

					 ."<tr><th>Excédent</th>
						<td><b style='color:lime;'>".$donnees['excedent_2']."</b> XAF</td></tr>";

			


				echo "</thead></table>

				<p><b style='color:rgb(0,128,128);'>Date de paiement</b> : ".$donnees['date_paiement']." | <b style='color:rgb(0,128,128);'>Reference</b> : ".$donnees['ref_trans']."

				<br/> <b style='color:rgb(0,128,128);'>Prix du billet</b> : <b>".$donnees['montant_debite']."</b> XAF

				<br/> <b style='color:rgb(0,128,128);'>Total</b> : <b>".$total."</b> XAF</p></div>";


				

				echo "<div style='float:right;position:relative;right:100px;'>

					<ul style='list-style:none;'>

						<li style='font-weight:bolder;color:rgb(0,128,128)'>Identifiant</li>
						<li>".$donnees['id']."</li>

						<br/>

						<li style='font-weight:bolder;color:rgb(0,128,128)'>Nom</li>
						<li>".$donnees['nom']."</li>

						<br/>

						<li style='font-weight:bolder;color:rgb(0,128,128)'>N° de téléphone</li>
						<li>".$donnees['num_tel']."</li>

						<br/>

						<li style='font-weight:bolder;color:rgb(0,128,128)'>Nombre de place</li>
						<li><div align='center'>".$donnees['nombre_place']."</div></li>
						
					</ul>

					
					</div>";



				echo "<table id='tab_qrc'>
						<thead>
						

					 <tr><th>Réservation</th>
					 	<td><b style='font-size:16px;'>Aller</b></td></tr>"

					 ."<tr><th>Trajet</th>
					   <td>".$donnees['trajet']."</td></tr>"


					 ."<tr><th>Date de depart</th>
					   <td>".$donnees['depart']." ".$donnees['heure']."</td></tr>"
					 									 
					 ."<tr><th>".$etat."</th>
					    <td>".$donnees['date_reserve']."</td></tr>"
					 
					 ."<tr><th>Etat de réservation</th>
					   <td>".$donnees['etat']."</td></tr>"

 					."<tr>
					 	<th>Etat de voyage</th>
						<td>".$donnees['stat_voy']."</td></tr>"

					 ."<tr><th>Pénalité</th>
						<td><b style='color:red;'>".$donnees['penalite']."</b> XAF</td></tr>"

					 ."<tr><th>Excédent</th>
						<td><b style='color:lime;'>".$donnees['excedent']."</b> XAF</td></tr>";

			


				echo '</thead></table>';




				$reponse->closeCursor();



			}
	

	}else{
	
		echo "<div id='aucunResultat'>Aucun resultat</div>";
	}
	  

}elseif (preg_match('#^maritime$#', $_SESSION['type_agence'])) {
	

	if(isset($id) && !empty($id) && preg_match("#^[A-Za-z -]+$#", $id)){

		

		if ($limit=='tout') {
			
			$rep = $bdd->prepare(" SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation ='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil ,reservation.classe,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_simple' AND statut IS NOT NULL AND client.nom LIKE CONCAT('%',?,'%') 

			UNION
				SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil ,reservation.classe,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND reservation.type_reservation='Aller_retour' AND statut IS NOT NULL AND client.nom LIKE CONCAT('%',?,'%')
			UNION
			  SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil ,reservation.classe,(reservation.trajet_retour) AS trajet,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart ,(reservation.heure_retour) AS heure,(reservation.etat_voyage_2) AS etat,(reservation.statut_voyage_2) AS stat_voy,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,CONCAT('-') FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND reservation.type_reservation='Aller_retour' AND statut IS NOT NULL AND client.nom LIKE CONCAT('%',?,'%') ORDER BY ref_trans ASC ;");

			callTab($id,$rep,$_SESSION['agence']);
		


		}else{


			$rep = $bdd->prepare(" SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation ='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil ,reservation.classe,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y  %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ? AND reservation.type_reservation='Aller_simple' AND statut IS NOT NULL AND client.nom LIKE CONCAT('%',?,'%') 

			UNION
				SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil ,reservation.classe,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND reservation.type_reservation='Aller_retour' AND statut IS NOT NULL AND client.nom LIKE CONCAT('%',?,'%')
			UNION
			  SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil ,reservation.classe,(reservation.trajet_retour) AS trajet,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart ,(reservation.heure_retour) AS heure,(reservation.etat_voyage_2) AS etat,(reservation.statut_voyage_2) AS stat_voy,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,CONCAT('-') FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND reservation.type_reservation='Aller_retour' AND statut IS NOT NULL AND client.nom LIKE CONCAT('%',?,'%') ORDER BY ref_trans ASC LIMIT $limit ;");

			callTab($id,$rep,$_SESSION['agence']);


		}

	}elseif (isset($id) && !empty($id) && preg_match("#^[0-9a-zA-Z -]+$#",$id)) {
		

		if ($limit=='tout') {
				
			$rep = $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation ='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil ,reservation.classe,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND statut IS NOT NULL AND reservation.type_reservation='Aller_simple' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? 

			UNION
				SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil ,reservation.classe,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND statut IS NOT NULL AND reservation.type_reservation='Aller_retour' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? 
			UNION
			  SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil ,reservation.classe,(reservation.trajet_retour) AS trajet,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart ,(reservation.heure_retour) AS heure,(reservation.etat_voyage_2) AS etat,(reservation.statut_voyage_2) AS stat_voy,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,CONCAT('-') FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND statut IS NOT NULL AND reservation.type_reservation='Aller_retour' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? ORDER BY ref_trans ASC ; ");

			callTab($id,$rep,$_SESSION['agence']);
		
		}else{

			$rep = $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation ='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil ,reservation.classe,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND statut IS NOT NULL AND reservation.type_reservation='Aller_simple' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? 

			UNION
				SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil ,reservation.classe,(reservation.trajet) AS trajet,DATE_FORMAT(reservation.date_depart, '%W %e %M %Y') AS depart,(reservation.heure_depart) AS heure,(reservation.etat_voyage_1) AS etat,(reservation.statut_voyage_1) AS stat_voy,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,paiement.montant_debite FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND statut IS NOT NULL AND reservation.type_reservation='Aller_retour' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? 
			UNION
			  SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil ,reservation.classe,(reservation.trajet_retour) AS trajet,DATE_FORMAT(reservation.date_retour, '%W %e %M %Y') AS depart ,(reservation.heure_retour) AS heure,(reservation.etat_voyage_2) AS etat,(reservation.statut_voyage_2) AS stat_voy,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reserve,paiement.ref_trans,CONCAT('-') FROM `reservation`,`client`,`transaction`,`paiement` WHERE reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans  AND client.id_client = transaction.id_client AND reservation.nom_agence = ?  AND statut IS NOT NULL AND reservation.type_reservation='Aller_retour' AND CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) = ? ORDER BY ref_trans ASC LIMIT $limit; ");

			callTab($id,$rep,$_SESSION['agence']);

		}


	

	}else{
	
		echo "<div id='aucunResultat'>Aucun resultat</div>";
	}


}



}else{


	include_once 'fonction.php';

	demandeReconnexion();
}