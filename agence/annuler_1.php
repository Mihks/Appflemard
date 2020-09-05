<?php 

session_name('flemadmin');

session_start();


header('Content-Type: text/html; charset=utf-8'); 


include_once 'fonction.php';




function filtre($value)
{
	$nom = strip_tags($value);
	$nom = trim($nom);
	$nom = stripslashes($nom);
	return  $nom;
}


$id = filtre($_POST['id']);

$reponse = $bdd->prepare(" UPDATE transaction SET date_reservation_2 = NOW()  WHERE id_reservation =  ?   ");

$reponse->execute(array($id));


$reponse = $bdd->prepare(" UPDATE reservation SET etat_voyage_2 = 'Annule' WHERE nom_agence = ? AND id_reservation =  ?   ");

$reponse->execute(array($_SESSION['agence'],$id));



	
echo "<div>Validé !</div><img src='images/accept.png' />";

