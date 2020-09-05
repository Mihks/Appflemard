<?php 

session_name('flemadmin');

session_start();

include_once 'fonction.php';

function filtre($value)
{
	$nom = strip_tags($value);
	$nom = trim($nom);
	$nom = stripslashes($nom);
	return  $nom;
}


$id = filtre($_POST['id']);

if (isset($_SESSION['agence'])) {




	if (isset($id)) {
		
		
		$reponse = $bdd->prepare(" UPDATE transaction SET date_reservation = NOW()  WHERE id_reservation =  ?   ");

		$reponse->execute(array($id));


		$reponse = $bdd->prepare(" UPDATE reservation SET etat_voyage_1 = 'Annule' WHERE nom_agence = ? AND id_reservation =  ?   ");

		$reponse->execute(array($_SESSION['agence'],$id));



		
		echo "<div >Opération effectuée !</div><img src='images/accept.png' />";
		
	}else{

		echo " ";
	}

		



}else{

	echo " ";
}


