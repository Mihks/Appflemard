<?php 
session_name('flemadmin');
session_start();
include_once 'fonction.php';

if (!isset($_SESSION['agence'])) {
	
	echo "...";
}else{

if (isset($_POST['trajet']) AND isset($_POST['date']) AND isset($_POST['hora'])) {
		
	if (preg_match("#^trajet_confondu$#", $_POST['trajet']) ){


		 $reponse = $bdd->prepare(' SELECT SUM(nombre_place) AS nombre_place

		FROM voyage	  WHERE date_voyage = ? AND nom_agence = ? AND horaire = ?');

		$reponse->execute(array($_POST['date'],$_SESSION['agence'],$_POST['hora']));

		}else{

			$reponse = $bdd->prepare('SELECT nombre_place

			FROM voyage  WHERE date_voyage = ?  AND horaire = ?  AND nom_trajet = ? AND nom_agence = ? ');

	    	$reponse->execute(array($_POST['date'],$_POST['hora'],$_POST['trajet'],$_SESSION['agence']));


		} 
	 
	$data = $reponse->fetch();


	$nbre_place = ($data['nombre_place']=='') ? 0 : $data['nombre_place'];


	$reponse->closeCursor();

	echo $nbre_place;

}



 }

