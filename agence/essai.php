<?php 

session_name('flemadmin');

session_start();

include_once 'fonction.php';



$trajet = $_POST['trajet'];

$date_depart = $_POST['date'];

$heure_depart = $_POST['hora'];

 
 if (isset($_SESSION['agence']) && !empty($_SESSION['agence']) && isset($trajet) && !empty($trajet) && isset($date_depart) && !empty($date_depart) && isset($heure_depart) && !empty($heure_depart)) {
 	
 

	

 	$rep = $bdd->prepare("SELECT place_dispo(:date_voyage,:trajet,:nom_agence,:heure);");

	$rep->execute(array('date_voyage' => $date_depart,'trajet' => $trajet,'nom_agence' => $_SESSION['agence'],'heure' => $heure_depart));


	$donnee = $rep->fetch();

	echo $donnee[0];

	$rep->closeCursor();


}else{

	echo  "...";
}