<?php 

session_name('flemadmin');

session_start();


if (!isset($_SESSION['agence'])) {
	
	include_once 'fonction.php';

	demandeReconnexion();
	

}else{

 ?>


<!DOCTYPE html>
<html>
<head>
	<title></title>

	<style type="text/css">
		
		#nonDispo{

			font-family: 'chiller';
			font-size: 60px;
			color: rgb(0,128,128);
			position: relative;
			width: 500px;
			text-shadow: 1px 1px 30px black;
			top: 100px;
			left: 430px;  
		}

		
	</style>

<?php



	include_once 'fonction.php';

	 
	function filtre($value)
{
	$nom = strip_tags($value);
	$nom = trim($nom);
	$nom = stripslashes($nom);
	return  $nom;
}


	//variable definies et envoyees par un fichier via une methode Ajax (major.php)
	$trajet = filtre($_POST['trajet']);

	$limit = filtre($_POST['limit']);

	$date = filtre($_POST['date']);

	$etat_reservation = filtre($_POST['etat_reservation']);

	$statut = (filtre($_POST['etat_reservation'])=='Avorte') ? "Echoue" : filtre($_POST['statut']);



	$horaire = filtre($_POST['hora']);

		
	$etat_reserv = ($etat_reservation=='Annule') ? 'Date d\'annulation' : 'Date de réservation' ;

	$req = $bdd->exec(" SET lc_time_names = 'fr_FR';");



// $reponse =  $bdd->prepare(" SELECT penalite FROM agence WHERE nom_agence = ? ");

// $reponse->execute(array($_SESSION['agence']));

// $data = $reponse->fetch() ;

// $penalite = $data['penalite'];

// $reponse->closeCursor() ;


if ( preg_match('#Annulation|Reprogrammation#', $etat_reservation)) {
	

	$motif = $etat_reservation;


	if (preg_match('#trajet_confondu#', $trajet)) {
	

		
		$reponse = $bdd->prepare(' SELECT 

				CONCAT(SUBSTRING(UPPER(nom_agence),1,3),SUBSTRING(id_reservation,-3),SUBSTRING(nom,1,3),SUBSTRING(id_client,-3)) AS id,
				nom,
				CONCAT("+241",num_tel) AS num_tel,
				type_reservation,
				nombre_place,
				trajet,
				DATE_FORMAT(date_voyage, "%W %e %M %Y") AS date_voyage,
				heure_depart,
				DATE_FORMAT(date_reservation, "%W %e %M %Y %T") AS date_reservation,
				reference,
				DATE_FORMAT(date_histo, "%W %e %M %Y %T") AS date_histo,
				motif 
				FROM historique_reservation 

				WHERE nom_agence = ? AND motif = ? AND heure_depart = ? AND date(date_histo) = ? ;');

	$reponse->execute(array($_SESSION['agence'],$motif,$_POST['hora'],$_POST['date']));

	echo "<table>
		<thead>
			<tr>
				<th>Identifiant</th>
				<th>Nom</th>
				<th>N° de telephone</th>
				<th>Type de réservation</th>
				<th>Nombre de place</th>
				<th>Trajet</th>
				<th>Ancienne date de voyage</th>
				<th>Ancienne heure de depart</th>
				<th>Ancienne Date de reservation</th>
				<th>Reference</th>
				<th>Date d'historisation</th>
				<th>Motif</th>
			</tr>
		</thead>";

			while ($donnees = $reponse->fetch()) {
				
				echo "<tr><td>".$donnees['id']."</td>"
					 ."<td>".$donnees['nom']."</td>"
					  ."<td>".$donnees['num_tel']."</td>"	
					 ."<td>".$donnees['type_reservation']."</td>"
					 ."<td>".$donnees['nombre_place']."</td>"
					 ."<td>".$donnees['trajet']."</td>"
					 ."<td>".$donnees['date_voyage']."</td>"
					 ."<td>".$donnees['heure_depart']."</td>"
					 ."<td>".$donnees['date_reservation']."</td>"
					 ."<td>".$donnees['reference']."</td>"
					 ."<td>".$donnees['date_histo']."</td>"
					 ."<td>".$donnees['motif']."</td></tr>";

			}


			echo '</table>';

			
			$reponse->closeCursor();	
	


	}else{

	

$reponse = $bdd->prepare(' SELECT 

				CONCAT(SUBSTRING(UPPER(nom_agence),1,3),SUBSTRING(id_reservation,-3),SUBSTRING(nom,1,3),SUBSTRING(id_client,-3)) AS id,
				nom,
				CONCAT("+241",num_tel) AS num_tel,
				type_reservation,
				nombre_place,
				trajet,
				DATE_FORMAT(date_voyage, "%W %e %M %Y") AS date_voyage,
				heure_depart,
				DATE_FORMAT(date_reservation, "%W %e %M %Y %T") AS date_reservation,
				reference,
				DATE_FORMAT(date_histo, "%W %e %M %Y %T") AS date_histo,
				motif 
				FROM historique_reservation 

				WHERE nom_agence = ? AND motif = ? AND heure_depart = ? AND trajet = ? AND date(date_histo) = ? ;');

	$reponse->execute(array($_SESSION['agence'],$motif,$_POST['hora'],$_POST['trajet'],$_POST['date']));

	echo "<table>
		<thead>
			<tr>
				<th>Identifiant</th>
				<th>Nom</th>
				<th>N° de telephone</th>
				<th>Type de réservation</th>
				<th>Nombre de place</th>
				<th>Trajet</th>
				<th>Ancienne date de voyage</th>
				<th>Ancienne heure de depart</th>
				<th>Ancienne Date de reservation</th>
				<th>Reference</th>
				<th>Date d'historisation</th>
				<th>Motif</th>
			</tr>
		</thead>";

			while ($donnees = $reponse->fetch()) {
				
				echo "<tr><td>".$donnees['id']."</td>"
					 ."<td>".$donnees['nom']."</td>"
					  ."<td>".$donnees['num_tel']."</td>"	
					 ."<td>".$donnees['type_reservation']."</td>"
					 ."<td>".$donnees['nombre_place']."</td>"
					 ."<td>".$donnees['trajet']."</td>"
					 ."<td>".$donnees['date_voyage']."</td>"
					 ."<td>".$donnees['heure_depart']."</td>"
					 ."<td>".$donnees['date_reservation']."</td>"
					 ."<td>".$donnees['reference']."</td>"
					 ."<td>".$donnees['date_histo']."</td>"
					 ."<td>".$donnees['motif']."</td></tr>";

			}


			echo '</table>';

			
			$reponse->closeCursor();	 }	


}else{


if (preg_match("#^terrestre$#", $_SESSION['type_agence'])) {
	


	if ($trajet =='trajet_confondu' AND ($etat_reservation=='Effectue' OR $etat_reservation=='Non-Effectue')) {
		# code...
		
		if ($limit =='tout') {
				$rep =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve, reservation.trajet AS trajet , reservation.excedent_1 AS excedent,reservation.penalite_1 AS penalite,DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement,reservation.heure_depart AS heure FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.type_reservation ='Aller_simple' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire 
	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,reservation.trajet AS trajet , reservation.excedent_1 AS excedent,reservation.penalite_1 AS penalite , DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement,reservation.heure_depart AS heure  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire

	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog_2 AS nbre_Xreprog,(reservation.statut_voyage_2) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reserve,reservation.trajet_retour AS trajet, reservation.excedent_2 AS excedent,reservation.penalite_2 AS penalite , DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement,reservation.heure_retour AS heure  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_2 ='Valide' AND transaction.statut= :statut AND reservation.date_retour = :depart AND reservation.statut_voyage_2 = :etat AND reservation.heure_retour = :horaire ORDER BY date_reserve DESC;"); 

			
			if (($date > date('Y-m-d') OR $date <= date('Y-m-d')) AND $statut=='Echoue' ) {
				
				echo "<div id ='nonDispo'>Non disponible...<div>";
			
			}elseif ($date > date('Y-m-d')) {
				
			
				echo "<div id ='nonDispo'>Non disponible...<div>";



			}else{

	$rep->execute(array('agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire));

					echo "<table>
							<thead>
							<tr>
							<th>Identifiant</th>
							<th>Nom</th>
							<th>N° de téléphone</th>
							<th>Type de réservation</th>
							<th>Nombre de place</th>
							<th>Trajet</th>
							<th>Date de réservation</th>
							<th>Reference</th>
							<th>Date de paiement</th>
							<th>Prix du billet(XAF)</th>
							<th>Excédent(XAF)</th>
							<th>Penalité(XAF)</th>
							<th>Total(XAF)</th>
							</tr></thead><tr>";
				
						


						while ($donnees = $rep->fetch()) {

						
 						


 						$penal = ($donnees['penalite']== 0) ? 'Aucune' : $donnees['penalite'];

						$excedent = ($donnees['excedent']== 0) ? 'Aucun' : $donnees['excedent'] ;
						
						$Total = $donnees['montant_debite'] +  $donnees['excedent'] + $donnees['penalite'];


								echo "<td>".$donnees['id']."</td>"
									."<td>".$donnees['nom']."</td>"
									."<td><a href='tel:".$donnees['num_tel']."' style='text-decoration:none;color:rgb(0,128,128);font-weight:bolder;' > ".$donnees['num_tel']."</a></td>"
									."<td>".$donnees['type']."</td>"	
									."<td>".$donnees['nombre_place']."</td>"

									."<td>".$donnees['trajet']."</td>"
									."<td>".$donnees['date_reserve']."</td>"
									."<td>".$donnees['ref_trans']."</td>"
									."<td>".$donnees['date_paiement']."</td>"									
									."<td>".$donnees['montant_debite']."</td>"
									."<td>".$excedent."</td>";
									
									if ($penal=="Aucune") {
										
										echo "<td>".$penal."</td>";
									
									} else {
										
										echo "<td><span style='color:red;' >".$penal."</span></td>";
									}
									
									
									echo "<td>".$Total."</td>".'</tr>';

							
						}


						$rep->closeCursor();
						echo "</table>"; }

			}else{


			$rep =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,reservation.trajet AS trajet,reservation.excedent_1 AS excedent, reservation.penalite_1 AS penalite , DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement , reservation.heure_depart AS heure  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_simple' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire
	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,reservation.trajet AS trajet,reservation.excedent_1 AS excedent, reservation.penalite_1 AS penalite, DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement, reservation.heure_depart AS heure  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire

	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog_2 AS nbre_Xreprog,(reservation.statut_voyage_2) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reserve,reservation.trajet_retour AS trajet,reservation.excedent_2 AS excedent, reservation.penalite_2 AS penalite , DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement, reservation.heure_retour AS heure  FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_2='Valide' AND transaction.statut= :statut AND reservation.date_retour = :depart AND reservation.statut_voyage_2 = :etat AND reservation.heure_retour = :horaire ORDER BY date_reserve ASC LIMIT $limit;"); 

		

			if (($date > date('Y-m-d') OR $date <= date('Y-m-d')) AND $statut=='Echoue' ) {
				
				echo "<div id ='nonDispo'>Non disponible...<div>";
			
			}elseif ($date > date('Y-m-d')) {
				
			
				echo "<div id ='nonDispo'>Non disponible...<div>";



			}else{
		$rep->execute(array('agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation));

					echo "<table>
							<thead>
							<tr>
							<th>Identifiant</th>
							<th>Nom</th>
							<th>N° de téléphone</th>
							<th>Type de réservation</th>
							<th>Nombre de place</th>
							<th>Trajet</th>
							<th>Date de réservation</th>
							<th>Reference</th>
							<th>Date de paiement</th>							
							<th>Prix du billet(XAF)</th>
							<th>Excédent(XAF)</th>
							<th>Penalité(XAF)</th>
							<th>Total(XAF)</th>
							</tr></thead><tr>";
				
				

						while ($donnees = $rep->fetch()) {


							
 						$penal = ($donnees['penalite']== 0) ? 'Aucune' : $donnees['penalite'];

						$excedent = ($donnees['excedent']== 0) ? 'Aucun' : $donnees['excedent'] ;
						
						$Total = $donnees['montant_debite'] +  $donnees['excedent'] + $donnees['penalite'];


								echo "<td>".$donnees['id']."</td>"
									."<td>".$donnees['nom']."</td>"
									."<td>".$donnees['num_tel']."</td>"
									."<td>".$donnees['type']."</td>"	
									."<td>".$donnees['nombre_place']."</td>"
									
									."<td>".$donnees['trajet']."</td>"
									
									."<td>".$donnees['date_reserve']."</td>"
									."<td>".$donnees['ref_trans']."</td>"
									."<td>".$donnees['date_paiement']."</td>"									
									."<td>".$donnees['montant_debite']."</td>"
									."<td>".$excedent."</td>";
									
									if ($penal=="Aucune") {
										
										echo "<td>".$penal."</td>";
									
									} else {
										
										echo "<td><span style='color:red;' >".$penal."</span></td>";
									}
									
									
									echo "<td>".$Total."</td>".'</tr>';

							
						}


						$rep->closeCursor();
						echo "</table>";


				}
	}

	


	}else{  		

	# code...




	if ($trajet=='trajet_confondu' ){ 



			if ($limit=='tout') {

				$rep =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reservation,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,reservation.etat_voyage_1 AS etat,paiement.ref_trans,paiement.montant_debite,reservation.trajet, reservation.excedent_1 AS excedent, reservation.penalite_1 AS penalite, DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement, reservation.heure_depart AS heure FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= ? AND reservation.type_reservation ='Aller_simple' AND transaction.statut= ? AND reservation.date_depart = ? AND reservation.etat_voyage_1 = ? AND reservation.heure_depart = ? 
	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reservation,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,reservation.etat_voyage_1 AS etat,paiement.ref_trans,paiement.montant_debite,reservation.trajet, reservation.excedent_1 AS excedent, reservation.penalite_1 AS penalite, DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement, reservation.heure_depart AS heure FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= ? AND reservation.type_reservation ='Aller_retour' AND transaction.statut= ? AND reservation.date_depart = ? AND reservation.etat_voyage_1 = ? AND reservation.heure_depart = ?

	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reservation,reservation.nbre_x_reserv_reprog_2 AS nbre_Xreprog,reservation.etat_voyage_2 AS etat,paiement.ref_trans,paiement.montant_debite,reservation.trajet_retour, reservation.excedent_2 AS excedent, reservation.penalite_2 AS penalite , DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement, reservation.heure_retour AS heure FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= ? AND reservation.type_reservation ='Aller_retour' AND transaction.statut= ? AND reservation.date_retour = ? AND reservation.etat_voyage_2 = ? AND reservation.heure_retour = ? ORDER BY date_reservation ASC ; ");


	$rep->execute(array($_SESSION['agence'],$statut,$date,$etat_reservation,$horaire,$_SESSION['agence'],$statut,$date,$etat_reservation,$horaire,$_SESSION['agence'],$statut,$date,$etat_reservation,$horaire));

	
				echo "<table>
						<thead>
						<tr>
						
						<th>Identifiant</th>
						<th>Nom</th>
						<th>N° de téléphone</th>
						<th>Type de réservation</th>
						<th>Nombre de place</th>
						<th>Trajet</th>
						<th>".$etat_reserv."</th>
						<th>Reference</th>
						<th>Date de paiement</th>
						<th>Prix du billet(XAF)</th>
						<th>Excédent(XAF)</th>
						<th>Penalité(XAF)</th>
						<th>Total(XAF)</th>
						</tr></thead><tr>"; 
				
				

						while ($donnees = $rep->fetch()) {

						
 						$penal = ($donnees['penalite']== 0) ? 'Aucune' : $donnees['penalite'];

						$excedent = ($donnees['excedent']== 0) ? 'Aucun' : $donnees['excedent'] ;
						
						$Total = $donnees['montant_debite'] +  $donnees['excedent'] + $donnees['penalite'];


								echo "<td>".$donnees['id']."</td>"
									."<td>".$donnees['nom']."</td>"
									."<td>".$donnees['num_tel']."</td>"	
									."<td>".$donnees['type']."</td>"	
									."<td>".$donnees['nombre_place']."</td>"
									."<td>".$donnees['trajet']."</td>"
									."<td>".$donnees['date_reservation']."</td>"									
									."<td>".$donnees['ref_trans']."</td>"
									."<td>".$donnees['date_paiement']."</td>"
									."<td>".$donnees['montant_debite']."</td>"
									."<td>".$excedent."</td>";
									
									if ($penal=="Aucune") {
										
										echo "<td>".$penal."</td>";
									
									} else {
										
										echo "<td><span style='color:red;' >".$penal."</span></td>";
									}
									
									
									echo "<td>".$Total."</td>".'</tr>';

							
						}



						echo "</table>";
						$rep->closeCursor();
				
			}else{


				$rep =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reservation,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,reservation.etat_voyage_1 AS etat,paiement.ref_trans,paiement.montant_debite,reservation.trajet,reservation.excedent_1 AS excedent, reservation.penalite_1 AS penalite, DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement, reservation.heure_depart AS heure FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_simple' AND transaction.statut= ? AND reservation.date_depart = ? AND reservation.etat_voyage_1 = ? AND reservation.heure_depart = ?
		UNION

		SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reservation,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,reservation.etat_voyage_1 AS etat,paiement.ref_trans,paiement.montant_debite,reservation.trajet,reservation.excedent_1 AS excedent, reservation.penalite_1 AS penalite, DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement, reservation.heure_depart AS heure FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_retour' AND transaction.statut= ? AND reservation.date_depart = ? AND reservation.etat_voyage_1 = ? AND reservation.heure_depart = ?

		UNION

		SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reservation,reservation.nbre_x_reserv_reprog_2 AS nbre_Xreprog,reservation.etat_voyage_2 AS etat,paiement.ref_trans,paiement.montant_debite,reservation.trajet_retour,reservation.excedent_2 AS excedent, reservation.penalite_2 AS penalite, DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement, reservation.heure_retour AS heure FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_retour' AND transaction.statut= ? AND reservation.date_retour = ? AND reservation.etat_voyage_2 = ? AND reservation.heure_retour = ? ORDER BY date_reservation  LIMIT $limit ");


			$rep->execute(array($_SESSION['agence'],$statut,$date,$etat_reservation,$horaire,$_SESSION['agence'],$statut,$date,$etat_reservation,$horaire,$_SESSION['agence'],$statut,$date,$etat_reservation,$horaire));

					echo "<table>
							<thead>
							<tr>
							
							<th>Identifiant</th>
							<th>Nom</th>
							<th>N° de telephone</th>
							<th>Type de réservation</th>
							<th>Nombre de place</th>
							<th>Trajet</th>
							
							<th>".$etat_reserv."</th>
							<th>Reference</th>
							<th>Date de paiement</th>
							<th>Prix du billet(XAF)</th>
							<th>Excédent(XAF)</th>
							<th>Penalité(XAF)</th>
							<th>Total(XAF)</th>
							</tr></thead><tr>";
					
					

							while ($donnees = $rep->fetch()) {


								
 						$penal = ($donnees['penalite']== 0) ? 'Aucune' : $donnees['penalite'];

						$excedent = ($donnees['excedent']== 0) ? 'Aucun' : $donnees['excedent'] ;
						
						$Total = $donnees['montant_debite'] +  $donnees['excedent'] + $donnees['penalite'];



									

									echo "<td>".$donnees['id']."</td>"
										."<td>".$donnees['nom']."</td>"
										."<td>".$donnees['num_tel']."</td>"
										."<td>".$donnees['type']."</td>"	
										."<td>".$donnees['nombre_place']."</td>"
										."<td>".$donnees['trajet']."</td>"
										
										."<td>".$donnees['date_reservation']."</td>"
										."<td>".$donnees['ref_trans']."</td>"
										."<td>".$donnees['date_paiement']."</td>"
										."<td>".$donnees['montant_debite']."</td>"
										."<td>".$excedent."</td>";
									
									if ($penal=="Aucune") {
										
										echo "<td>".$penal."</td>";
									
									} else {
										
										echo "<td><span style='color:red;' >".$penal."</span></td>";
									}
									
									
									echo "<td>".$Total."</td>".'</tr>';
									
							}


							$rep->closeCursor();
							echo "</table>";

							}

		

			

	
	}elseif ($etat_reservation=='Effectue' OR $etat_reservation=='Non-Effectue') {
		


			if ($limit =='tout') {
				$rep =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,reservation.excedent_1 AS excedent, reservation.penalite_1 AS penalite, DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_simple' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire
	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,reservation.excedent_1 AS excedent, reservation.penalite_1 AS penalite, DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire

	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog_2 AS nbre_Xreprog,(reservation.statut_voyage_2) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reserve,reservation.excedent_2 AS excedent, reservation.penalite_2 AS penalite, DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_2 ='Valide' AND transaction.statut= :statut AND reservation.date_retour = :depart AND reservation.trajet_retour= :trajet AND reservation.statut_voyage_2 = :etat AND reservation.heure_retour = :horaire ORDER BY date_reserve DESC;"); 

			
			if (($date > date('Y-m-d') OR $date <= date('Y-m-d')) AND $statut=='Echoue' ) {
				
				echo "<div id ='nonDispo'>Non disponible...<div>";
			
			}elseif ($date > date('Y-m-d')) {
				
			
				echo "<div id ='nonDispo'>Non disponible...<div>";



			}else{

	$rep->execute(array('agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'trajet'=>$trajet,'etat'=>$etat_reservation,'horaire'=>$horaire));

					echo "<table>
							<thead>
							<tr>
							<th>Identifiant</th>
							<th>Nom</th>
							<th>N° de téléphone</th>
							<th>Type de réservation</th>
							<th>Nombre de place</th>
							<th>Date de réservation</th>
							<th>Reference</th>
							<th>Date de paiement</th>
							<th>Prix du billet(XAF)</th>
							<th>Excédent(XAF)</th>
							<th>Penalité(XAF)</th>
							<th>Total(XAF)</th>
							</tr></thead><tr>";
				
				

						while ($donnees =$rep->fetch()) {

							
 						$penal = ($donnees['penalite']== 0) ? 'Aucune' : $donnees['penalite'];

						$excedent = ($donnees['excedent']== 0) ? 'Aucun' : $donnees['excedent'] ;
						
						$Total = $donnees['montant_debite'] +  $donnees['excedent'] + $donnees['penalite'];


								echo "<td>".$donnees['id']."</td>"
									."<td>".$donnees['nom']."</td>"
									."<td>".$donnees['num_tel']."</td>"
									."<td>".$donnees['type']."</td>"	
									."<td>".$donnees['nombre_place']."</td>"
									."<td>".$donnees['date_reserve']."</td>"
									."<td>".$donnees['ref_trans']."</td>"
									."<td>".$donnees['date_paiement']."</td>"
									."<td>".$donnees['montant_debite']."</td>"
									."<td>".$excedent."</td>";
									
									if ($penal=="Aucune") {
										
										echo "<td>".$penal."</td>";
									
									} else {
										
										echo "<td><span style='color:red;' >".$penal."</span></td>";
									}
									
									
									echo "<td>".$Total."</td>".'</tr>';
									

							
						}


						$rep->closeCursor();
						echo "</table>"; }

			}else{


			$rep =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,reservation.excedent_1 AS excedent, reservation.penalite_1 AS penalite, DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_simple' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire
	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,reservation.excedent_1 AS excedent, reservation.penalite_1 AS penalite, DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire

	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog_2 AS nbre_Xreprog,(reservation.statut_voyage_2) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reserve, reservation.excedent_2 AS excedent, reservation.penalite_2 AS penalite, DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_2='Valide' AND transaction.statut= :statut AND reservation.date_retour = :depart AND reservation.trajet_retour= :trajet AND reservation.statut_voyage_2 = :etat AND reservation.heure_retour = :horaire ORDER BY date_reserve DESC LIMIT $limit;"); 

		

			if (($date > date('Y-m-d') OR $date <= date('Y-m-d')) AND $statut=='Echoue' ) {
				
				echo "<div id ='nonDispo'>Non disponible...<div>";
			
			}elseif ($date > date('Y-m-d')) {
				
			
				echo "<div id ='nonDispo'>Non disponible...<div>";



			}else{
		$rep->execute(array('agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'trajet'=>$trajet,'etat'=>$etat_reservation,'horaire'=>$horaire));

					echo "<table>
							<thead>
							<tr>
							<th>Identifiant</th>
							<th>Nom</th>
							<th>N° de téléphone</th>
							<th>Type de réservation</th>
							<th>Nombre de place</th>
							<th>Date de réservation</th>
							<th>Reference</th>
							<th>Date de paiement(XAF)</th>
							<th>Prix du billet(XAF)</th>
							<th>Excédent(XAF)</th>
							<th>Penalité(XAF)</th>
							<th>Total(XAF)</th>
							</tr></thead><tr>";
				
				

						while ($donnees =$rep->fetch()) {


							
 						$penal = ($donnees['penalite']== 0) ? 'Aucune' : $donnees['penalite'];

						$excedent = ($donnees['excedent']== 0) ? 'Aucun' : $donnees['excedent'] ;
						
						$Total = $donnees['montant_debite'] +  $donnees['excedent'] + $donnees['penalite'];


								echo "<td>".$donnees['id']."</td>"
									."<td>".$donnees['nom']."</td>"
									."<td>".$donnees['num_tel']."</td>"
									."<td>".$donnees['type']."</td>"	
									."<td>".$donnees['nombre_place']."</td>"
									."<td>".$donnees['date_reserve']."</td>"
									."<td>".$donnees['ref_trans']."</td>"
									."<td>".$donnees['date_paiement']."</td>"
									."<td>".$donnees['montant_debite']."</td>"
									."<td>".$excedent."</td>";
									
									if ($penal=="Aucune") {
										
										echo "<td>".$penal."</td>";
									
									} else {
										
										echo "<td><span style='color:red;' >".$penal."</span></td>";
									}
									
									
									echo "<td>".$Total."</td>".'</tr>';

							
						}


						$rep->closeCursor();
						echo "</table>";


				}
	}

	


	}else{



			if ($limit =='tout') {
				$rep =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,(reservation.etat_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,reservation.excedent_1 AS excedent, reservation.penalite_1 AS penalite, DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_simple' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.etat_voyage_1 = :etat AND reservation.heure_depart = :horaire
	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,(reservation.etat_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve, reservation.excedent_1 AS excedent, reservation.penalite_1 AS penalite , DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_retour' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.etat_voyage_1 = :etat AND reservation.heure_depart = :horaire

	UNION

	SELECT  CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog_2 AS nbre_Xreprog,(reservation.etat_voyage_2) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reserve, reservation.excedent_2 AS excedent, reservation.penalite_2 AS penalite , DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND transaction.statut= :statut AND reservation.date_retour = :depart AND reservation.trajet_retour= :trajet AND reservation.etat_voyage_2 = :etat AND reservation.heure_retour = :horaire ORDER BY date_reserve DESC;"); 

		

		$rep->execute(array('agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'trajet'=>$trajet,'etat'=>$etat_reservation,'horaire'=>$horaire));

					echo "<table>
							<thead>
							<tr>
							<th>Identifiant</th>
							<th>Nom</th>
							<th>N° de téléphone</th>
							<th>Type de réservation</th>
							<th>Nombre de place</th>
							<th>".$etat_reserv."</th>
							<th>Reference</th>
							<th>Date de paiement</th>
							<th>Prix du billet(XAF)</th>
							<th>Excédent(XAF)</th>
							<th>Penalité(XAF)</th>
							<th>Total(XAF)</th>
							</tr></thead><tr>";
				
				

						while ($donnees =$rep->fetch()) {

							
 						$penal = ($donnees['penalite']== 0) ? 'Aucune' : $donnees['penalite'];

						$excedent = ($donnees['excedent']== 0) ? 'Aucun' : $donnees['excedent'] ;
						
						$Total = $donnees['montant_debite'] +  $donnees['excedent'] + $donnees['penalite'];



								echo "<td>".$donnees['id']."</td>"
									."<td>".$donnees['nom']."</td>"
									."<td>".$donnees['num_tel']."</td>"
									."<td>".$donnees['type']."</td>"	
									."<td>".$donnees['nombre_place']."</td>"
									."<td>".$donnees['date_reserve']."</td>"
									."<td>".$donnees['ref_trans']."</td>"
									."<td>".$donnees['date_paiement']."</td>"
									."<td>".$donnees['montant_debite']."</td>"
									."<td>".$excedent."</td>";
									
									if ($penal=="Aucune") {
										
										echo "<td>".$penal."</td>";
									
									} else {
										
										echo "<td><span style='color:red;' >".$penal."</span></td>";
									}
									
									
									echo "<td>".$Total."</td>".'</tr>';

							
						}



						echo "</table>";

						$rep->closeCursor();

					// 	$rep2 = $bdd->prepare(" SELECT COUNT(*) AS nbre_ligne FROM reservation WHERE (date_depart = ? OR date_retour = ?) AND (trajet = ? OR trajet_retour = ?) AND (etat_voyage_1 ='Valide' OR etat_voyage_2='Valide') ");

					// 	$rep2->execute(array($date,$date,$trajet,$trajet));

					// 	$donnee = $rep2->fetch();

					// echo $donnee['nbre_ligne'];

			}else{


			$rep =  $bdd->prepare("SELECT  CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,(reservation.etat_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,reservation.excedent_1 AS excedent, reservation.penalite_1 AS penalite, DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_simple' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.etat_voyage_1 = :etat AND reservation.heure_depart = :horaire
	UNION

	SELECT  CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog AS nbre_Xreprog,(reservation.etat_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve, reservation.excedent_1 AS excedent, reservation.penalite_1 AS penalite, DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_retour' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.etat_voyage_1 = :etat AND reservation.heure_depart = :horaire

	UNION

	SELECT  CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.nbre_x_reserv_reprog_2 AS nbre_Xreprog,(reservation.etat_voyage_2) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation_2, '%W %e %M %Y %T') AS date_reserve, reservation.excedent_2 AS excedent, reservation.penalite_2 AS penalite , DATE_FORMAT(paiement.date_paiement,'%W %e %M %Y') AS date_paiement FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND transaction.statut= :statut AND reservation.date_retour = :depart AND reservation.trajet_retour= :trajet AND reservation.etat_voyage_2 = :etat AND reservation.heure_retour = :horaire ORDER BY date_reserve DESC LIMIT $limit;"); 

		

		$rep->execute(array('agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'trajet'=>$trajet,'etat'=>$etat_reservation,'horaire'=>$horaire));

					echo "<table>
							<thead>
							<tr>
							<th>Identifiant</th>
							<th>Nom</th>
							<th>N° de téléphone</th>
							<th>Type de réservation</th>
							<th>Nombre de place</th>
							<th>".$etat_reserv."</th>
							<th>Reference</th>
							<th>Date de paiement</th>
							<th>Prix du billet(XAF)</th>
							<th>Excédent(XAF)</th>
							<th>Penalité(XAF)</th>
							<th>Total(XAF)</th>
							</tr></thead><tr>";
				
				

						while ($donnees =$rep->fetch()) {

						
 						$penal = ($donnees['penalite']== 0) ? 'Aucune' : $donnees['penalite'];

						$excedent = ($donnees['excedent']== 0) ? 'Aucun' : $donnees['excedent'] ;
						
						$Total = $donnees['montant_debite'] +  $donnees['excedent'] + $donnees['penalite'];



								echo "<td>".$donnees['id']."</td>"
									."<td>".$donnees['nom']."</td>"
									."<td>".$donnees['num_tel']."</td>"
									."<td>".$donnees['type']."</td>"	
									."<td>".$donnees['nombre_place']."</td>"
									."<td>".$donnees['date_reserve']."</td>"
									."<td>".$donnees['ref_trans']."</td>"
									."<td>".$donnees['date_paiement']."</td>"
									."<td>".$donnees['montant_debite']."</td>"
									."<td>".$excedent."</td>";
									
									if ($penal=="Aucune") {
										
										echo "<td>".$penal."</td>";
									
									} else {
										
										echo "<td><span style='color:red;' >".$penal."</span></td>";
									}
									
									
									echo "<td>".$Total."</td>".'</tr>';
									

							
						}


						$rep->closeCursor();
						echo "</table>";
				
	}


}

}

}elseif (preg_match('#^maritime$#', $_SESSION['type_agence'])) {
	


	if ($trajet =='trajet_confondu' AND ($etat_reservation=='Effectue' OR $etat_reservation=='Non-Effectue')) {
		# code...
		
		if ($limit =='tout') {
				$rep =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_depart) AS heure_voyage,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve, reservation.trajet AS trajet FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.type_reservation ='Aller_simple' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire
	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_depart) AS heure_voyage,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,reservation.trajet AS trajet FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire

	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_retour) AS heure_voyage,(reservation.statut_voyage_2) AS etat_voyage,paiement.ref_trans,CONCAT('-'),DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,reservation.trajet_retour AS trajet FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_2 ='Valide' AND transaction.statut= :statut AND reservation.date_retour = :depart AND reservation.statut_voyage_2 = :etat AND reservation.heure_retour = :horaire ORDER BY heure_voyage ASC;"); 

			
			if (($date > date('Y-m-d') OR $date <= date('Y-m-d')) AND $statut=='Echoue' ) {
				
				echo "<div id ='nonDispo'>Non disponible...<div>";
			
			}elseif ($date > date('Y-m-d')) {
				
			
				echo "<div id ='nonDispo'>Non disponible...<div>";



			}else{

	$rep->execute(array('agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire));

					echo "<table>
							<thead>
							<tr>
							<th>Identifiant</th>
							<th>Nom</th>
							<th>N° de telephone</th>
							<th>Type de réservation</th>
							<th>Nombre de place</th>
							<th>Categorie</th>
							<th>Classe</th>
							
							<th>Trajet</th>
							<th>Etat du voyage</th>
							<th>Date de réservation</th>
							<th>Reference</th>
							<th>Montant(XAF)</th>
							</tr></thead><tr>";
				
				

						while ($donnees =$rep->fetch()) {


								echo "<td>".$donnees['id']."</td>"
									."<td>".$donnees['nom']."</td>"
									."<td>".$donnees['num_tel']."</td>"
									."<td>".$donnees['type']."</td>"	
									."<td>".$donnees['nombre_place']."</td>"
									."<td>".$donnees['seuil']."</td>"
									."<td>".$donnees['classe']."</td>"
									
									."<td>".$donnees['trajet']."</td>"
									."<td>".$donnees['etat_voyage']."</td>"
									."<td>".$donnees['date_reserve']."</td>"
									."<td>".$donnees['ref_trans']."</td>"
									."<td>".$donnees['montant_debite']."</td>".'</tr>';

							
						}


						$rep->closeCursor();
						echo "</table>"; }

			}else{


			$rep =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_depart) AS heure_voyage,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,reservation.trajet AS trajet FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_simple' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire
	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_depart) AS heure_voyage,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,reservation.trajet AS trajet FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire

	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_retour) AS heure_voyage,(reservation.statut_voyage_2) AS etat_voyage,paiement.ref_trans,CONCAT('-'),DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve,reservation.trajet_retour AS trajet FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_2='Valide' AND transaction.statut= :statut AND reservation.date_retour = :depart AND reservation.statut_voyage_2 = :etat AND reservation.heure_retour = :horaire ORDER BY heure_voyage ASC LIMIT $limit;"); 

		

			if (($date > date('Y-m-d') OR $date <= date('Y-m-d')) AND $statut=='Echoue' ) {
				
				echo "<div id ='nonDispo'>Non disponible...<div>";
			
			}elseif ($date > date('Y-m-d')) {
				
			
				echo "<div id ='nonDispo'>Non disponible...<div>";



			}else{
		$rep->execute(array('agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire));

					echo "<table>
							<thead>
							<tr>
							<th>Identifiant</th>
							<th>Nom</th>
							<th>N° de telephone</th>
							<th>Type de réservation</th>
							<th>Nombre de place</th>
							<th>Categorie</th>
							<th>Classe</th>
							
							<th>Trajet</th>
							<th>Etat du voyage</th>
							<th>Date de réservation</th>
							<th>Reference</th>
							<th>Montant(XAF)</th>
							</tr></thead><tr>";
				
				

						while ($donnees =$rep->fetch()) {


								echo "<td>".$donnees['id']."</td>"
									."<td>".$donnees['nom']."</td>"
									."<td>".$donnees['num_tel']."</td>"
									."<td>".$donnees['type']."</td>"	
									."<td>".$donnees['nombre_place']."</td>"
									."<td>".$donnees['seuil']."</td>"
									."<td>".$donnees['classe']."</td>"
								
									."<td>".$donnees['trajet']."</td>"
									."<td>".$donnees['etat_voyage']."</td>"
									."<td>".$donnees['date_reserve']."</td>"
									."<td>".$donnees['ref_trans']."</td>"
									."<td>".$donnees['montant_debite']."</td>".'</tr>';

							
						}


						$rep->closeCursor();
						echo "</table>";


				}
	}

	


	}else{  		

	# code...




	if ($trajet=='trajet_confondu' ){ 



			if ($limit=='tout') {

				$rep =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reservation,reservation.heure_depart,reservation.etat_voyage_1 AS etat,paiement.ref_trans,paiement.montant_debite,reservation.trajet FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= ? AND reservation.type_reservation ='Aller_simple' AND transaction.statut= ? AND reservation.date_depart = ? AND reservation.etat_voyage_1 = ? AND reservation.heure_depart = ?
	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reservation,reservation.heure_depart,reservation.etat_voyage_1 AS etat,paiement.ref_trans,paiement.montant_debite,reservation.trajet FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= ? AND reservation.type_reservation ='Aller_retour' AND transaction.statut= ? AND reservation.date_depart = ? AND reservation.etat_voyage_1 = ? AND reservation.heure_depart = ?

	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reservation,reservation.heure_retour,reservation.etat_voyage_2 AS etat,paiement.ref_trans,CONCAT('-'),reservation.trajet_retour FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= ? AND reservation.type_reservation ='Aller_retour' AND transaction.statut= ? AND reservation.date_retour = ? AND reservation.etat_voyage_2 = ? AND reservation.heure_retour = ? ORDER BY nom ASC ; ");


	$rep->execute(array($_SESSION['agence'],$statut,$date,$etat_reservation,$horaire,$_SESSION['agence'],$statut,$date,$etat_reservation,$horaire,$_SESSION['agence'],$statut,$date,$etat_reservation,$horaire));

				echo "<table>
						<thead>
						<tr>
						
						<th>Identifiant</th>
						<th>Nom</th>
						<th>N° de telephone</th>
						<th>Type de réservation</th>
						<th>Nombre de place</th>
						<th>Categorie</th>
						<th>Classe</th>
						
						<th>Etat de réservation</th>
						<th>Trajet</th>
						<th>Date de réservation</th>
						<th>Reference</th>
						<th>Montant(XAF)</th>
						</tr></thead><tr>";
				
				

						while ($donnees = $rep->fetch()) {

								

								echo "<td>".$donnees['id']."</td>"
									."<td>".$donnees['nom']."</td>"
									."<td>".$donnees['num_tel']."</td>"	
									."<td>".$donnees['type']."</td>"	
									."<td>".$donnees['nombre_place']."</td>"
									."<td>".$donnees['seuil']."</td>"
									."<td>".$donnees['classe']."</td>"
									
									."<td>".$donnees['etat']."</td>"
									."<td>".$donnees['trajet']."</td>"
									."<td>".$donnees['date_reservation']."</td>"									
									."<td>".$donnees['ref_trans']."</td>"
									."<td>".$donnees['montant_debite']."</td>".'</tr>';

							
						}



						echo "</table>";
						$rep->closeCursor();
				
			}else{


				$rep =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reservation,reservation.heure_depart,reservation.etat_voyage_1 AS etat,paiement.ref_trans,paiement.montant_debite,reservation.trajet FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_simple' AND transaction.statut= ? AND reservation.date_depart = ? AND reservation.etat_voyage_1 = ? AND reservation.heure_depart = ?
		UNION

		SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reservation,reservation.heure_depart,reservation.etat_voyage_1 AS etat,paiement.ref_trans,paiement.montant_debite,reservation.trajet FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_retour' AND transaction.statut= ? AND reservation.date_depart = ? AND reservation.etat_voyage_1 = ? AND reservation.heure_depart = ?

		UNION

		SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reservation,reservation.heure_retour,reservation.etat_voyage_2 AS etat,paiement.ref_trans,CONCAT('-'),reservation.trajet_retour FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=? AND reservation.type_reservation ='Aller_retour' AND transaction.statut= ? AND reservation.date_retour = ? AND reservation.etat_voyage_2 = ? AND reservation.heure_retour = ? ORDER BY nom ASC LIMIT $limit ");


			$rep->execute(array($_SESSION['agence'],$statut,$date,$etat_reservation,$horaire,$_SESSION['agence'],$statut,$date,$etat_reservation,$horaire,$_SESSION['agence'],$statut,$date,$etat_reservation,$horaire));

					echo "<table>
							<thead>
							<tr>
							
							<th>Identifiant</th>
							<th>Nom</th>
							<th>N° de telephone</th>
							<th>Type de réservation</th>
							<th>Nombre de place</th>
							<th>Categorie</th>
							<th>Classe</th>
							
							<th>Etat de réservation</th>
							<th>Trajet</th>
							<th>Date de réservation</th>
							<th>Reference</th>
							<th>Montant(XAF)</th>
							</tr></thead><tr>";
					
					

							while ($donnees = $rep->fetch()) {

									

									echo "<td>".$donnees['id']."</td>"
										."<td>".$donnees['nom']."</td>"
										."<td>".$donnees['num_tel']."</td>"
										."<td>".$donnees['type']."</td>"	
										."<td>".$donnees['nombre_place']."</td>"
										."<td>".$donnees['seuil']."</td>"
										."<td>".$donnees['classe']."</td>"
										
										."<td>".$donnees['etat']."</td>"
										."<td>".$donnees['trajet']."</td>"
										."<td>".$donnees['date_reservation']."</td>"
										."<td>".$donnees['ref_trans']."</td>"
										."<td>".$donnees['montant_debite']."</td>".'</tr>';

								
							}


							$rep->closeCursor();
							echo "</table>";

							}

		

			

	
	}elseif ($etat_reservation=='Effectue' OR $etat_reservation=='Non-Effectue') {
		


			if ($limit =='tout') {
				$rep =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_depart) AS heure_voyage,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence= :agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_simple' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire
	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_depart) AS heure_voyage,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire

	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_retour) AS heure_voyage,(reservation.statut_voyage_2) AS etat_voyage,paiement.ref_trans,CONCAT('-'),DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_2 ='Valide' AND transaction.statut= :statut AND reservation.date_retour = :depart AND reservation.trajet_retour= :trajet AND reservation.statut_voyage_2 = :etat AND reservation.heure_retour = :horaire ORDER BY heure_voyage ASC;"); 

			
			if (($date > date('Y-m-d') OR $date <= date('Y-m-d')) AND $statut=='Echoue' ) {
				
				echo "<div id ='nonDispo'>Non disponible...<div>";
			
			}elseif ($date > date('Y-m-d')) {
				
			
				echo "<div id ='nonDispo'>Non disponible...<div>";



			}else{

	$rep->execute(array('agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'trajet'=>$trajet,'etat'=>$etat_reservation,'horaire'=>$horaire));

					echo "<table>
							<thead>
							<tr>
							<th>Identifiant</th>
							<th>Nom</th>
							<th>N° de telephone</th>
							<th>Type de réservation</th>
							<th>Nombre de place</th>
							<th>Categorie</th>
							<th>Classe</th>
							
							<th>Etat du voyage</th>
							<th>Date de réservation</th>
							<th>Reference</th>
							<th>Montant(XAF)</th>
							</tr></thead><tr>";
				
				

						while ($donnees =$rep->fetch()) {


								echo "<td>".$donnees['id']."</td>"
									."<td>".$donnees['nom']."</td>"
									."<td>".$donnees['num_tel']."</td>"
									."<td>".$donnees['type']."</td>"	
									."<td>".$donnees['nombre_place']."</td>"
									."<td>".$donnees['seuil']."</td>"
									."<td>".$donnees['classe']."</td>"
									
									."<td>".$donnees['etat_voyage']."</td>"
									."<td>".$donnees['date_reserve']."</td>"
									."<td>".$donnees['ref_trans']."</td>"
									."<td>".$donnees['montant_debite']."</td>".'</tr>';

							
						}


						$rep->closeCursor();
						echo "</table>"; }

			}else{


			$rep =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_depart) AS heure_voyage,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_simple' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire
	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_depart) AS heure_voyage,(reservation.statut_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_1='Valide' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.statut_voyage_1 = :etat AND reservation.heure_depart = :horaire

	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_retour) AS heure_voyage,(reservation.statut_voyage_2) AS etat_voyage,paiement.ref_trans,CONCAT('-'),DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND reservation.etat_voyage_2='Valide' AND transaction.statut= :statut AND reservation.date_retour = :depart AND reservation.trajet_retour= :trajet AND reservation.statut_voyage_2 = :etat AND reservation.heure_retour = :horaire ORDER BY heure_voyage ASC LIMIT $limit;"); 

		

			if (($date > date('Y-m-d') OR $date <= date('Y-m-d')) AND $statut=='Echoue' ) {
				
				echo "<div id ='nonDispo'>Non disponible...<div>";
			
			}elseif ($date > date('Y-m-d')) {
				
			
				echo "<div id ='nonDispo'>Non disponible...<div>";



			}else{
		$rep->execute(array('agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'trajet'=>$trajet,'etat'=>$etat_reservation,'horaire'=>$horaire));

					echo "<table>
							<thead>
							<tr>
							<th>Identifiant</th>
							<th>Nom</th>
							<th>N° de telephone</th>
							<th>Type de réservation</th>
							<th>Nombre de place</th>
							<th>Categorie</th>
							<th>Classe</th>
						
							<th>Etat du voyage</th>
							<th>Date de réservation</th>
							<th>Reference</th>
							<th>Montant(XAF)</th>
							</tr></thead><tr>";
				
				

						while ($donnees =$rep->fetch()) {


								echo "<td>".$donnees['id']."</td>"
									."<td>".$donnees['nom']."</td>"
									."<td>".$donnees['num_tel']."</td>"
									."<td>".$donnees['type']."</td>"	
									."<td>".$donnees['nombre_place']."</td>"
									."<td>".$donnees['seuil']."</td>"
									."<td>".$donnees['classe']."</td>"
									
									."<td>".$donnees['etat_voyage']."</td>"
									."<td>".$donnees['date_reserve']."</td>"
									."<td>".$donnees['ref_trans']."</td>"
									."<td>".$donnees['montant_debite']."</td>".'</tr>';

							
						}


						$rep->closeCursor();
						echo "</table>";


				}
	}

	


	}else{



			if ($limit =='tout') {
				$rep =  $bdd->prepare("SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_depart) AS heure_voyage,(reservation.etat_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_simple' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.etat_voyage_1 = :etat AND reservation.heure_depart = :horaire
	UNION

	SELECT CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_depart) AS heure_voyage,(reservation.etat_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_retour' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.etat_voyage_1 = :etat AND reservation.heure_depart = :horaire

	UNION

	SELECT  CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_retour) AS heure_voyage,(reservation.etat_voyage_2) AS etat_voyage,paiement.ref_trans,CONCAT('-'),DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND transaction.statut= :statut AND reservation.date_retour = :depart AND reservation.trajet_retour= :trajet AND reservation.etat_voyage_2 = :etat AND reservation.heure_retour = :horaire ORDER BY heure_voyage ASC;"); 

		

		$rep->execute(array('agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'trajet'=>$trajet,'etat'=>$etat_reservation,'horaire'=>$horaire));

					echo "<table>
							<thead>
							<tr>
							<th>Identifiant</th>
							<th>Nom</th>
							<th>N° de telephone</th>
							<th>Type de réservation</th>
							<th>Nombre de place</th>
							<th>Categorie</th>
							<th>Classe</th>
							
							<th>Etat de réservation</th>
							<th>Date de réservation</th>
							<th>Reference</th>
							<th>Montant(XAF)</th>
							</tr></thead><tr>";
				
				

						while ($donnees =$rep->fetch()) {


								echo "<td>".$donnees['id']."</td>"
									."<td>".$donnees['nom']."</td>"
									."<td>".$donnees['num_tel']."</td>"
									."<td>".$donnees['type']."</td>"	
									."<td>".$donnees['nombre_place']."</td>"
									."<td>".$donnees['seuil']."</td>"
									."<td>".$donnees['classe']."</td>"
									
									."<td>".$donnees['etat_voyage']."</td>"
									."<td>".$donnees['date_reserve']."</td>"
									."<td>".$donnees['ref_trans']."</td>"
									."<td>".$donnees['montant_debite']."</td>".'</tr>';

							
						}



						echo "</table>";

						$rep->closeCursor();

					// 	$rep2 = $bdd->prepare(" SELECT COUNT(*) AS nbre_ligne FROM reservation WHERE (date_depart = ? OR date_retour = ?) AND (trajet = ? OR trajet_retour = ?) AND (etat_voyage_1 ='Valide' OR etat_voyage_2='Valide') ");

					// 	$rep2->execute(array($date,$date,$trajet,$trajet));

					// 	$donnee = $rep2->fetch();

					// echo $donnee['nbre_ligne'];

			}else{


			$rep =  $bdd->prepare("SELECT  CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_simple','Unique','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_depart) AS heure_voyage,(reservation.etat_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_simple' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.etat_voyage_1 = :etat AND reservation.heure_depart = :horaire
	UNION

	SELECT  CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Aller','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_depart) AS heure_voyage,(reservation.etat_voyage_1) AS etat_voyage,paiement.ref_trans,paiement.montant_debite,DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.trajet= :trajet AND reservation.type_reservation ='Aller_retour' AND transaction.statut= :statut AND reservation.date_depart = :depart AND reservation.etat_voyage_1 = :etat AND reservation.heure_depart = :horaire

	UNION

	SELECT  CONCAT(SUBSTRING(UPPER(reservation.nom_agence),1,3),SUBSTRING(reservation.id_reservation,-3),SUBSTRING( client.nom,1,3),SUBSTRING(client.id_client,-3)) AS id,client.nom,CONCAT('+241',client.tel_client) AS num_tel,IF(reservation.type_reservation='Aller_retour','Retour','') AS type,reservation.nombre_place,reservation.seuil_age_personne AS seuil,reservation.classe,(reservation.heure_retour) AS heure_voyage,(reservation.etat_voyage_2) AS etat_voyage,paiement.ref_trans,CONCAT('-'),DATE_FORMAT(transaction.date_reservation, '%W %e %M %Y %T') AS date_reserve FROM `client`,`transaction`,`reservation`,`paiement` WHERE client.id_client = transaction.id_client AND reservation.id_reservation = transaction.id_reservation AND paiement.ref_trans = transaction.ref_trans AND reservation.nom_agence=:agence AND reservation.type_reservation ='Aller_retour' AND transaction.statut= :statut AND reservation.date_retour = :depart AND reservation.trajet_retour= :trajet AND reservation.etat_voyage_2 = :etat AND reservation.heure_retour = :horaire ORDER BY heure_voyage ASC LIMIT $limit;"); 

		

		$rep->execute(array('agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'trajet'=>$trajet,'statut'=>$statut,'depart'=>$date,'etat'=>$etat_reservation,'horaire'=>$horaire,'agence'=>$_SESSION['agence'],'statut'=>$statut,'depart'=>$date,'trajet'=>$trajet,'etat'=>$etat_reservation,'horaire'=>$horaire));

					echo "<table>
							<thead>
							<tr>
							<th>Identifiant</th>
							<th>Nom</th>
							<th>N° de telephone</th>
							<th>Type de réservation</th>
							<th>Nombre de place</th>
							<th>Categorie</th>
							<th>Classe</th>
							
							<th>Etat de réservation</th>
							<th>Date de réservation</th>
							<th>Reference</th>
							<th>Montant(XAF)</th>
							</tr></thead><tr>";
				
				

						while ($donnees =$rep->fetch()) {


								echo "<td>".$donnees['id']."</td>"
									."<td>".$donnees['nom']."</td>"
									."<td>".$donnees['num_tel']."</td>"
									."<td>".$donnees['type']."</td>"	
									."<td>".$donnees['nombre_place']."</td>"
									."<td>".$donnees['seuil']."</td>"
									."<td>".$donnees['classe']."</td>"
									
									."<td>".$donnees['etat_voyage']."</td>"
									."<td>".$donnees['date_reserve']."</td>"
									."<td>".$donnees['ref_trans']."</td>"
									."<td>".$donnees['montant_debite']."</td>".'</tr>';

							
						}


						$rep->closeCursor();
						echo "</table>";
				
	}


}

}

}

}


}
