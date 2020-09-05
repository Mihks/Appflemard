<?php

session_name('flemadmin');

session_start();

 header('Content-Type: text/html; charset=utf-8');


	include_once 'fonction.php';

	$trajet = $_POST['trajet']; 
	$date = $_POST['date'];


$req = $bdd->exec(" SET lc_time_names = 'fr_FR';");




if (isset($_SESSION['agence']) && !empty($_SESSION['agence']) && isset($trajet) && !empty($trajet) && isset($date) && !empty($date)){



		

	$rep = $bdd->prepare(" SELECT DATE_FORMAT(?, '%W %e %M %Y') AS depart ");

	$rep->execute(array($date));

	$data = $rep->fetch();

	$depart = $data['depart'];

	$rep->closeCursor();




	if ($_POST['radio']=='Prix billet'){

		
		if ($trajet=='trajet_confondu'){



			$reponse =  $bdd->prepare(" 

				SELECT SUM(paiement.montant_debite) AS montant_debite FROM reservation,paiement,transaction WHERE transaction.statut ='Succes' AND paiement.id_reservation = reservation.id_reservation AND transaction.id_reservation = reservation.id_reservation AND transaction.ref_trans = paiement.ref_trans AND reservation.nom_agence= ? AND  paiement.date_paiement = ? ");

			$reponse->execute(array($_SESSION['agence'],$date));


			$donnee = $reponse->fetch();

				
			$solde = $donnee['montant_debite'];

			


			if ($solde == 0 OR is_null($solde)){ 

				echo "<strong>Pas d'entrée... </strong>";



			}else{ 

		 		echo "<strong>Le solde du  ".$depart." : ".$solde." XAF</strong>";

				}


		}else{



			$reponse =  $bdd->prepare(" 

				SELECT   SUM(paiement.montant_debite) AS montant_debite, SUM(reservation.excedent_1) AS excedent, reservation.penalite_1 AS penalite FROM reservation,paiement,transaction WHERE transaction.statut ='Succes' AND paiement.id_reservation = reservation.id_reservation AND transaction.id_reservation = reservation.id_reservation AND transaction.ref_trans = paiement.ref_trans AND reservation.nom_agence= ? AND  paiement.date_paiement = ? AND reservation.trajet = ?");

			$reponse->execute(array($_SESSION['agence'],$date,$trajet));

			
			$donnee = $reponse->fetch();

			$solde = $donnee['montant_debite'];

			
		
			$reponse->closeCursor();

			if ($solde == 0 OR is_null($solde)){ 


				echo "<strong>Pas d'entrée... </strong>";



			}else{ 

		 		echo "<strong>Le solde du  ".$depart." : ".$solde." XAF</strong>";

				}
					
			
			


		}#fin du else 
	


	}elseif ($_POST['radio']=='Excédents') {
		# code...
		
		if ($trajet=='trajet_confondu'){


			$reponse =  $bdd->prepare(" 

				SELECT SUM(reservation.excedent_1) AS excedent FROM reservation WHERE reservation.nom_agence= ? AND  reservation.date_depart = ?

				UNION

				SELECT SUM(reservation.excedent_2) AS excedent FROM reservation WHERE reservation.nom_agence= ? AND  reservation.date_retour = ? ");

			$reponse->execute(array($_SESSION['agence'],$date,$_SESSION['agence'],$date));


			$Total = array();
			
			while ($donnee = $reponse->fetch()) {

			
				$var = $donnee['excedent'];

				array_push($Total, $var);

			}


			if (array_sum($Total) == 0){ 


				echo "<strong>Pas d'entrée... </strong>";



			}else{ 

	 			echo "<strong>Le solde du  ".$depart." : ".array_sum($Total)." XAF</strong>";

				}

	
	}else{

		$reponse =  $bdd->prepare(" 

				SELECT   SUM(reservation.excedent_1) AS excedent FROM reservation WHERE reservation.nom_agence= ? AND  reservation.date_depart = ? AND reservation.trajet = ? 

				UNION

				SELECT SUM(reservation.excedent_2) AS excedent FROM reservation WHERE reservation.nom_agence = ? AND reservation.date_retour = ? AND reservation.trajet_retour = ? ");

		$reponse->execute(array($_SESSION['agence'],$date,$trajet,$_SESSION['agence'],$date,$trajet));


		$Total = array();

		while ($donnee = $reponse->fetch()) {
			
			$var =  $donnee['excedent'];

			array_push($Total, $var);
			
			}
		
		$reponse->closeCursor();

		if (array_sum($Total) == 0){ 


			echo "<strong>Pas d'entrée... </strong>";



		}else{ 

	 		echo "<strong>Le solde du  ".$depart." : ".array_sum($Total)." XAF</strong>";

			}




		}		


	}elseif ($_POST['radio']=='Total') {
		# code...
		
		if ($trajet=='trajet_confondu') {
			# code...

			#penalite
			$reponse =  $bdd->prepare(" 

				SELECT SUM(penalite) AS penalite FROM historique_reservation WHERE nom_agence= ? AND DATE(date_histo) = ? ");

				$reponse->execute(array($_SESSION['agence'],$date));

				$donnee = $reponse->fetch();

				$penalite = $donnee['penalite'];

				$reponse->closeCursor();

				$penalite = (is_null($penalite)) ? 0 : $penalite ;




				#excedent
			$reponse =  $bdd->prepare(" 

				SELECT SUM(reservation.excedent_1) AS excedent FROM reservation WHERE reservation.nom_agence= ? AND  reservation.date_depart = ?

				UNION

				SELECT SUM(reservation.excedent_2) AS excedent FROM reservation WHERE reservation.nom_agence= ? AND  reservation.date_retour = ? ");

			$reponse->execute(array($_SESSION['agence'],$date,$_SESSION['agence'],$date));


			$Total = array();

			while ($donnee = $reponse->fetch()) {
	
				$var = $donnee['excedent'];

				array_push($Total, $var);
			
			}

			$reponse->closeCursor();

			$excedent = array_sum($Total);

			$excedent = ( is_null($excedent) ) ? 0 : $excedent ;


			#billet
			$reponse =  $bdd->prepare(" 

				SELECT SUM(paiement.montant_debite) AS montant_debite FROM reservation,paiement,transaction WHERE transaction.statut ='Succes' AND paiement.id_reservation = reservation.id_reservation AND transaction.id_reservation = reservation.id_reservation AND transaction.ref_trans = paiement.ref_trans AND reservation.nom_agence= ? AND  paiement.date_paiement = ? ");

			$reponse->execute(array($_SESSION['agence'],$date));

			$donnee = $reponse->fetch();

			$solde = $donnee['montant_debite'];

			$reponse->closeCursor();


			$solde = (is_null($solde) ) ? 0 : $solde ;



			$somme = $solde + $penalite + $excedent;


			if ($somme == 0 OR is_null($somme)) {
				
				echo "<strong>Pas d'entrée... </strong>";
			
			}else{

		 		echo "<strong>Le solde du ".$depart." : ".$somme." XAF</strong>";
			}


		}else{


			#penalite

			$reponse =  $bdd->prepare(" 

				SELECT SUM(penalite) AS penalite FROM historique_reservation WHERE nom_agence= ? AND DATE(date_histo) = ? AND trajet = ? ");

				$reponse->execute(array($_SESSION['agence'],$date,$trajet));


				$donnee = $reponse->fetch();

				$penalite = $donnee['penalite'];

				$reponse->closeCursor();

				$penalite = (is_null($penalite)) ? 0 : $penalite ;



			#excedent

			$reponse =  $bdd->prepare(" 


				SELECT SUM(reservation.excedent_1) AS excedent FROM reservation WHERE reservation.nom_agence= ? AND  reservation.date_depart = ? AND trajet = ?

				UNION

				SELECT SUM(reservation.excedent_2) AS excedent FROM reservation WHERE reservation.nom_agence= ? AND  reservation.date_retour = ? AND trajet_retour = ? ");

			$reponse->execute(array($_SESSION['agence'],$date,$trajet,$_SESSION['agence'],$date,$trajet));


			$Total = array();

			while ($donnee = $reponse->fetch()) {
	
				$var = $donnee['excedent'];

				array_push($Total, $var);
			
			}

			$reponse->closeCursor();

			$excedent = array_sum($Total);

			$excedent = ( is_null($excedent) ) ? 0 : $excedent ;


			#billet

			$reponse =  $bdd->prepare("

	    		SELECT SUM(paiement.montant_debite) AS montant_debite FROM reservation,paiement,transaction WHERE transaction.statut ='Succes' AND paiement.id_reservation = reservation.id_reservation AND transaction.id_reservation = reservation.id_reservation AND transaction.ref_trans = paiement.ref_trans AND reservation.nom_agence= ? AND  paiement.date_paiement = ? AND reservation.trajet = ? ");
 

 			$reponse->execute(array($_SESSION['agence'],$date,$trajet));

 			$donnee = $reponse->fetch();

 			$solde = $donnee['montant_debite'];

			$reponse->closeCursor();


			$solde = (is_null($solde) ) ? 0 : $solde ;


			$somme = $solde + $penalite + $excedent;


			if ($somme == 0 OR is_null($somme)) {
				
				echo "<strong>Pas d'entrée... </strong>";
			
			}else{

		 		echo "<strong>Le solde du ".$depart." : ".$somme." XAF</strong>";
			}

		}

		// echo "En cours...";

	}elseif ($_POST['radio']=='Pénalité') {
		# code...
	

		if ($trajet=='trajet_confondu'){


			$reponse =  $bdd->prepare(" 

				SELECT SUM(penalite) AS penalite FROM historique_reservation WHERE nom_agence= ? AND DATE(date_histo) = ? ");

			$reponse->execute(array($_SESSION['agence'],$date));


			$donnee = $reponse->fetch();

				
			$solde = $donnee['penalite'];
				
			$reponse->closeCursor();


			if ($solde == 0 OR is_null($solde)){ 


				echo "<strong>Pas d'entrée... </strong>";



			}else{ 

		 		echo "<strong>Les pénalités du  ".$depart." : ".$solde." XAF</strong>";

				}



	}else{

		///

		$reponse =  $bdd->prepare(" 

					
				SELECT SUM(penalite) AS penalite FROM historique_reservation WHERE nom_agence= ? AND DATE(date_histo) = ? AND trajet = ? ");

			$reponse->execute(array($_SESSION['agence'],$date,$trajet));


			$donnee = $reponse->fetch();

				
			$solde = $donnee['penalite'];
			


			$reponse->closeCursor();


			if ($solde == 0 OR is_null($solde) ){ 


				echo "<strong>Pas d'entrée... </strong>";



			}else{ 

		 		echo "<strong>Les pénalités du  ".$depart." : ".$solde." XAF</strong>";

				}

	}

	
	



	}
		





	

}else{

	echo "Session fermée...";
}