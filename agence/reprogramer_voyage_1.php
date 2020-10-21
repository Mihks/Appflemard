<?php 
session_name('flemadmin');
session_start();
header('Content-Type: text/html; charset=utf-8'); 


?>
<!DOCTYPE html>
<html>
<head>
	<title></title>

	<style type="text/css">
		
		.Resultat_reprog{

			/*font-family: 'chiller';*/
			color: rgb(0,128,128);
			text-shadow: 1px 1px 30px black;
			text-align: justify;
		}

		
	</style>
</head>
<body>


<?php

	include_once 'fonction.php';


function filtre($value)
{
	$nom = strip_tags($value);
	$nom = trim($nom);
	$nom = stripslashes($nom);
	return  $nom;
}

$id = filtre($_POST['id']);

$date = $_POST['date'];

$heure = $_POST['heure'];

$type_reserv = $_POST['type'];

$depart = $_POST['depart'];


$reponsedatepayement = $bdd->prepare(" SELECT date_paiement FROM paiement WHERE id_reservation = ? ");

$reponsedatepayement->execute(array($id)); 

$donn = $reponsedatepayement->fetch();

$date_paie = $donn['date_paiement']; 

$reponsedatepayement->closeCursor();


$reponse =  $bdd->prepare(" SELECT penalite,( ? + interval Duree_validite_billet DAY) AS duree FROM agence WHERE nom_agence = ? ");

$reponse->execute(array($date_paie,$_SESSION['agence']));

$data = $reponse->fetch() ;

$penalite = $data['penalite'];

$date_limit = $data['duree'];

$reponse->closeCursor() ;


?>





<div id="depart"><?php 




 $reponseverif = (preg_match('#Aller|Unique#', $type_reserv))? $bdd->prepare("SELECT excedent_1 AS excedent FROM reservation WHERE nom_agence = ? AND id_reservation = ? ") : $bdd->prepare("SELECT excedent_2 AS excedent FROM reservation WHERE nom_agence = ? AND id_reservation = ? ");


	$reponseverif->execute(array($_SESSION['agence'],$id));

	
	$data = $reponseverif->fetch();

	$excedent = $data['excedent'];


if ($excedent !=0) {
	
	echo "Désolé,vôtre voyage est dejà en cours...!";

} else {
	


$reponse = (preg_match("#Aller|Unique#", $type_reserv)) ? $bdd->prepare(" SELECT statut_voyage_1 AS etat_voyage FROM reservation WHERE id_reservation = ? ;") : $bdd->prepare(" SELECT statut_voyage_2 AS etat_voyage FROM reservation WHERE id_reservation = ? ;") ;

$reponse->execute(array($id));

$donnee = $reponse->fetch();

$etat = $donnee['etat_voyage'];

$reponse->closeCursor();





if ( $etat != 'Effectue' AND date('Y-m-d') <= $date_limit) { 


	if (preg_match("#Aller|Unique#", $type_reserv)) {
			

	$reponse = $bdd->prepare(" SELECT trajet,nombre_place,date_retour,type_reservation AS type, date_depart , heure_depart ,heure_retour FROM reservation WHERE id_reservation = ? ");

	$reponse->execute(array($id));

	$donnee = $reponse->fetch();

	$trajet = $donnee['trajet'];

	$nombre_place = $donnee['nombre_place'];

	$date_retour = $donnee['date_retour'];
	$heure_retour = $donnee['heure_retour'];
	
	$date_depart = $donnee['date_depart'];
	$heure_depart = $donnee['heure_depart'];

	$type = $donnee['type'];

	$reponse->closeCursor();

	$reponse = $bdd->prepare(" SELECT nombre_place_dispo , nombre_place_reserve FROM voyage WHERE date_voyage = :date_voyage AND nom_trajet = :trajet AND nom_agence = :nom_agence AND horaire = :heure ");

	$reponse->execute(array('date_voyage' => $date_depart,'trajet' =>$trajet,'nom_agence' => $_SESSION['agence'],'heure' => $heure_depart));
		
	$donnee = $reponse->fetch();

	$old_place_dispo = $donnee['nombre_place_dispo'];
	$old_place_reserve = $donnee['nombre_place_reserve'];
	
	
		
	$reponse = $bdd->prepare(" SELECT nombre_place_dispo , nombre_place_reserve FROM voyage WHERE date_voyage = :date_voyage AND nom_trajet = :trajet AND nom_agence = :nom_agence AND horaire = :heure ");

	$reponse->execute(array('date_voyage' => $date,'trajet' =>$trajet,'nom_agence' => $_SESSION['agence'],'heure' => $heure));

	$donnee = $reponse->fetch();

	$place_dispo = $donnee['nombre_place_dispo'];
	$place_reserve = $donnee['nombre_place_reserve'];
		
	$reponse->closeCursor();

	if ( $place_dispo >= $nombre_place) {


		if (preg_match("#Aller_retour#", $type)) {
			

			if ($date < $date_retour) {

				$rep = $bdd->prepare(" SELECT nbre_x_reserv_reprog AS nbre_Xreprog, penalite_1 AS penalite FROM reservation WHERE id_reservation = ? AND nom_agence = ? ");

				$rep->execute(array($id,$_SESSION['agence']));

				$donnee = $rep->fetch();

				$nbre_Xreprog = $donnee['nbre_Xreprog'] + 1;

				$ancienPenalite = $donnee['penalite'];

				$rep->closeCursor();

				$penalite = $ancienPenalite + $penalite;


				$reponse = $bdd->prepare(" UPDATE reservation SET date_depart = ? , heure_depart = ? , nbre_x_reserv_reprog = ? , penalite_1 = ? WHERE nom_agence = ? AND id_reservation =  ?  ");

				$reponse->execute(array($date,$heure,$nbre_Xreprog,$penalite,$_SESSION['agence'],$id));

				$reponse = $bdd->prepare("UPDATE transaction SET date_reservation = NOW()  WHERE id_reservation =  ?   ");

				$reponse->execute(array($id));
				
				/////New voyage
				$reponse = $bdd->prepare("UPDATE voyage SET nombre_place_dispo = ? , nombre_place_reserve = ? WHERE date_voyage = ? AND nom_trajet = ? AND nom_agence = ? AND horaire = ? ");
				
				$new_place_dispo = $place_dispo - $nombre_place;
				$new_place_reserve = $place_reserve + $nombre_place;
				$reponse->execute(array($new_place_dispo,$new_place_reserve,$date,$trajet,$_SESSION['agence'],$heure));
				
				//////ancien
				$reponse = $bdd->prepare("UPDATE voyage SET nombre_place_dispo = ? , nombre_place_reserve = ? WHERE date_voyage = ? AND nom_trajet = ? AND nom_agence = ? AND horaire = ? ");

				$new_place_dispo = $old_place_dispo + $nombre_place;
				$new_place_reserve = $old_place_reserve - $nombre_place;
				$reponse->execute(array($new_place_dispo,$new_place_reserve,$date_depart,$trajet,$_SESSION['agence'],$heure_depart));
				

			
				echo "<div class='Resultat_reprog'>La modification s'est effectuée avec succès ! <img src='images/accept.png' /></div>";
				

			}else{

				echo "<div class='Resultat_reprog'> La date de retour doit être postérieure à la date de l'aller ! <img src='images/s_error.png' /></div>";

			}
		

		}elseif (preg_match("#Aller_simple#", $type)) {


			if (is_null($date_retour)) {


				$rep = $bdd->prepare(" SELECT nbre_x_reserv_reprog AS nbre_Xreprog, penalite_1 AS penalite FROM reservation WHERE id_reservation = ? AND nom_agence = ? ");

				$rep->execute(array($id,$_SESSION['agence']));

				$donnee = $rep->fetch();

				$nbre_Xreprog = $donnee['nbre_Xreprog'] + 1;

				$ancienPenalite = $donnee['penalite'];

				$rep->closeCursor();

				$penalite = $ancienPenalite + $penalite;

				$reponse = $bdd->prepare(" UPDATE reservation SET date_depart = ? , heure_depart = ? , nbre_x_reserv_reprog = ? ,penalite_1 = ?  WHERE nom_agence = ? AND id_reservation =  ?  ");

				$reponse->execute(array($date,$heure,$nbre_Xreprog,$penalite,$_SESSION['agence'],$id));


				$reponse = $bdd->prepare("UPDATE transaction SET date_reservation = NOW()  WHERE id_reservation =  ?   ");

				$reponse->execute(array($id));
				
				
				/////New voyage
				$reponse = $bdd->prepare("UPDATE voyage SET nombre_place_dispo = ? , nombre_place_reserve = ? WHERE date_voyage = ? AND nom_trajet = ? AND nom_agence = ? AND horaire = ? ");
				
				$new_place_dispo = $place_dispo - $nombre_place;
				$new_place_reserve = $place_reserve + $nombre_place;
				$reponse->execute(array($new_place_dispo,$new_place_reserve,$date,$trajet,$_SESSION['agence'],$heure));
				
				//////ancien
				$reponse = $bdd->prepare("UPDATE voyage SET nombre_place_dispo = ? , nombre_place_reserve = ?  WHERE date_voyage = ? AND nom_trajet = ? AND nom_agence = ? AND horaire = ? ");

				$new_place_dispo = $old_place_dispo + $nombre_place;
				$new_place_reserve = $old_place_reserve - $nombre_place;
				$reponse->execute(array($new_place_dispo,$new_place_reserve,$date_depart,$trajet,$_SESSION['agence'],$heure_depart));
				

				
				echo "<div class='Resultat_reprog'>La modification s'est effectuée avec succès <img src='images/accept.png' /></div>";
					
					
			

			}else{

				echo "<div class='Resultat_reprog'>Imposible, Les conditions ne sont pas reunies ! <img src='images/s_error.png' /></div>";
			
			}


		}else{

			echo "<div class='Resultat_reprog'>Erreur ! <img src='images/s_error.png' /></div>";
		}
				
			
		
	
	}else{

		echo "<div class='Resultat_reprog'>Imposible, ce jour ne comporte pas assez de place. <img src='images/s_error.png' /></div>"; ///ssh2_auth_password(session, username, password) recherche
	}


}elseif (preg_match("#Retour#", $type_reserv)) {
	




	$reponse = $bdd->prepare(" SELECT trajet_retour,nombre_place,date_depart AS depart FROM reservation WHERE id_reservation = ?;");

	$reponse->execute(array($id));

	$donnee = $reponse->fetch();

	$trajet = $donnee['trajet_retour'];

	$date_depart = $donnee['depart']; 

	$nombre_place = $donnee['nombre_place']; 

	$reponse->closeCursor();


// 	$reponse = $bdd->prepare(" SELECT place_dispo(:date_voyage,:trajet,:nom_agence,:heure);");

// 	$reponse->execute(array('date_voyage' => $date,'trajet' =>$trajet,'nom_agence' => $_SESSION['agence'],'heure' => $heure));

// 	$donnee = $reponse->fetch();

// 	$place_dispo = $donnee[0];

// 	$reponse->closeCursor();

	$reponse = $bdd->prepare(" SELECT nombre_place_dispo , nombre_place_reserve FROM voyage WHERE date_voyage = :date_voyage AND nom_trajet = :trajet AND nom_agence = :nom_agence AND horaire = :heure ");

	$reponse->execute(array('date_voyage' => $date_retour,'trajet' =>$trajet,'nom_agence' => $_SESSION['agence'],'heure' => $heure_retour));
		
	$donnee = $reponse->fetch();

	$old_place_dispo = $donnee['nombre_place_dispo'];
	$old_place_reserve = $donnee['nombre_place_reserve'];
	
		
	$reponse = $bdd->prepare(" SELECT nombre_place_dispo , nombre_place_reserve FROM voyage WHERE date_voyage = :date_voyage AND nom_trajet = :trajet AND nom_agence = :nom_agence AND horaire = :heure ");

	$reponse->execute(array('date_voyage' => $date,'trajet' =>$trajet,'nom_agence' => $_SESSION['agence'],'heure' => $heure));

	$donnee = $reponse->fetch();

	$place_dispo = $donnee['nombre_place_dispo'];
	$place_reserve = $donnee['nombre_place_reserve'];
		
	
	if ($place_dispo >= $nombre_place ) {
		

		if ($date > $date_depart ) {


			$rep = $bdd->prepare(" SELECT nbre_x_reserv_reprog_2 AS nbre_Xreprog, penalite_2 AS penalite FROM reservation WHERE id_reservation = ? AND nom_agence = ? ");

			$rep->execute(array($id,$_SESSION['agence']));

			$donnee = $rep->fetch();

			$nbre_Xreprog = $donnee['nbre_Xreprog'] + 1;

			$ancienPenalite = $donnee['penalite']; 
			
			$rep->closeCursor();

			$penalite = $ancienPenalite + $penalite;

			$reponse = $bdd->prepare(" UPDATE reservation SET date_retour = ? , heure_retour = ? , nbre_x_reserv_reprog_2 = ? , penalite_2 = ? WHERE nom_agence = ? AND id_reservation =  ?   ");

			$reponse->execute(array($date,$heure,$nbre_Xreprog,$penalite,$_SESSION['agence'],$id));


			$reponse = $bdd->prepare(" UPDATE transaction SET date_reservation_2 = NOW()  WHERE id_reservation =  ?   ");

			$reponse->execute(array($id));

			/////New voyage
			$reponse = $bdd->prepare("UPDATE voyage SET nombre_place_dispo = ? , nombre_place_reserve = ? WHERE date_voyage = ? AND nom_trajet = ? AND nom_agence = ? AND horaire = ? ");
				
			$new_place_dispo = $place_dispo - $nombre_place;
			$new_place_reserve = $place_reserve + $nombre_place;
			$reponse->execute(array($new_place_dispo,$new_place_reserve,$date,$trajet,$_SESSION['agence'],$heure));
				
			//////Ancien
			$reponse = $bdd->prepare("UPDATE voyage SET nombre_place_dispo = ? , nombre_place_reserve = ? WHERE date_voyage = ? AND nom_trajet = ? AND nom_agence = ? AND horaire = ? ");

			$new_place_dispo = $old_place_dispo + $nombre_place;
			$new_place_reserve = $old_place_reserve - $nombre_place;
			$reponse->execute(array($new_place_dispo,$new_place_reserve,$date_depart,$trajet,$_SESSION['agence'],$heure_depart));
				
			
			echo "<div class='Resultat_reprog'>La modification s'est effectuée avec succès <img src='images/accept.png' /></div>";
		
		
		}else{

			echo "<div class='Resultat_reprog'> La date de retour doit être postérieure à la date de l'aller ! <img src='images/s_error.png' /></div>";

		}

			


	
	}else{

		echo "<div class='Resultat_reprog'>Imposible, ce jour ne comporte pas assez de place. <img src='images/s_error.png' /></div>"; ///ssh2_auth_password(session, username, password) recherche
	}


	#fin de retour

}


}else{


	echo "<div class='Resultat_reprog'>Opération impossible .  <img src='images/s_error.png' /></div>";

	if (preg_match('#^Effectue$#', $etat)) {
			
		echo "<div class='Resultat_reprog'>Le voyage a déjà été effectué ! </div>";
		
	}



	if( date('Y-m-d') > $date_limit) {
			
		echo "<div class='Resultat_reprog'>Vous ne pouvez plus effectuer cette operation, la durée de validité de votre billet a expirée ! </div>";

			}





	 } 





}
  #fin 

	?>



	</div>




</body>



</html>
