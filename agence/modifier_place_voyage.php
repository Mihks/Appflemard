<?php

session_name('flemadmin');

session_start();


	include_once 'fonction.php';



if (isset($_SESSION['agence'])) {



if (isset($_POST['nombre']) &&  isset($_POST['trajet']) && isset($_POST['date']) && isset($_POST['heure'])) {




$nombre = intval($_POST['nombre']);

$trajet = $_POST['trajet'];

$date = $_POST['date'];

$heure = $_POST['heure'];




$reponse = $bdd->prepare(" SELECT place_reserve(?,?,?,?)");

$reponse->execute(array($date,$trajet,$_SESSION['agence'],$heure));

$donnee = $reponse->fetch();

$place_reserve = $donnee[0];

$reponse->closeCursor();

$new_place_dispo = $nombre - $place_reserve;


// $reponse = $bdd->prepare(" SELECT nombre_place FROM voyage WHERE date_voyage = ? AND horaire = ? AND nom_trajet = ? AND nom_agence = ?");

// $reponse->execute(array($date,$heure,$trajet,$_SESSION['agence']));

// $donnee = $reponse->fetch();

// $bdd_nombre_place = $donnee['nombre_place'];

// $reponse->closeCursor();





	if (isset($nombre) && !empty($nombre) && $nombre >= $place_reserve  && isset($trajet) && !empty($trajet) &&  !intval($trajet) && isset($date) && !empty($date) && preg_match("#[0-9]{4}-[0-9]{2}-[0-9]{2}#", $date) && $date > date('Y-m-d') &&  isset($heure) && !empty($heure) ) {
		
				
		$reponse = $bdd->prepare('SELECT nombre_place  
			FROM voyage 
			WHERE nom_trajet = ? AND nom_agence = ? AND horaire = ? AND date_voyage = ? ');


		$reponse->execute(array($trajet,$_SESSION['agence'],$heure,$date));

		$donnee = $reponse->fetch();

		$bdd_nbre_place = $donnee['nombre_place'];
		
		$reponse->closeCursor();

		if($bdd_nbre_place =='' ) {



			$requete = $bdd->prepare('INSERT INTO 

				voyage(date_voyage,horaire,nom_trajet,nom_agence,nombre_place,nombre_place_dispo) VALUES(?,?,?,?,?,?)');

			$requete->execute(array($date,$heure,$trajet,$_SESSION['agence'],$nombre,$new_place_dispo));

		

		}else{


			$requete = $bdd->prepare("UPDATE voyage SET nombre_place = ? , nombre_place_dispo = ? WHERE date_voyage = ? AND horaire = ? AND nom_trajet = ? AND nom_agence = ? ");

			$requete->execute(array($nombre,$new_place_dispo,$date,$heure,$trajet,$_SESSION['agence'])) ;

		}
			


			echo "Operation effectuée !";



	}else{

		if ($nombre < $place_reserve) {
			
			echo "Le nombre de place réservés est bien plus important ! ";
		}


		if ($date <= date('Y-m-d')) {
			
			echo "Le changement ne peut plus se faire ! ";
		}

		echo "Il ya certaines incohérences...";
	}



}else{ 

	echo "...";

}



}else{

	echo "Veuillez vous reconnecter...";
}