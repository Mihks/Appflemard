<?php

session_name('flemadmin');

session_start();



if (isset($_SESSION['agence'])) {


	include_once 'fonction.php';



$req = $bdd->exec(" SET lc_time_names = 'fr_FR';");








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

	$reponse->execute(array($_SESSION['agence'],$_POST['motif'],$_POST['heure'],$_POST['trajet'],$_POST['date']));

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
		

}else {

	include_once 'fonction.php';

	demandeReconnexion();
}