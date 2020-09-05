<?php



header('Content-Type: text/html; charset=utf-8');



	include_once 'fonction.php';



if (isset($_POST['type']) && isset($_POST['choix']) && isset($_POST['id_reservation'])) {



$type = array();

$id_reservation = array();

$choix = array();

$type = $_POST['type'];

$id_reservation = $_POST['id_reservation'];

$choix = $_POST['choix'];


	# code...

// echo "<pre>";

// print_r($type);
// print_r($choix);
// print_r($id_reservation);

// echo "</pre>";


$nbre_ligne = count($type);



for ($i=0; $i < $nbre_ligne ; $i++) { 
	
	if ($type[$i]=='Unique' OR $type[$i]=='Aller') {


		$rep =  $bdd->prepare("UPDATE reservation SET statut_voyage_1 = ? WHERE id_reservation = ?");

		

	}elseif ($type[$i]=='Retour'){

		$rep =  $bdd->prepare("UPDATE reservation SET statut_voyage_2 = ? WHERE id_reservation = ?");

		
	}


	$rep->execute(array($choix[$i],$id_reservation[$i])) or die(print_r($bdd->errorInfo()));


	
}



echo "<div>Opération validée ! <img src='images/accept.png' /></div>";


}else{

	echo "La liste est vide !";
}
