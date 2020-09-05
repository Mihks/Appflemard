<?php

 session_start();

 
header('Content-Type: text/html; charset=utf-8');


//connexion à la base de données

	$dsn = "mysql:host=localhost;dbname=wave;port=3306;charset=utf8";

	try
		{
			$bdd = new PDO($dsn,'root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
	catch (Exception $e)
		{
			die('Erreur : ' . $e->getMessage());

		}




$reponse = $bdd->query('SELECT DATE(date_reservation) AS  date_reservation , id_reservation FROM transaction ');


$array = array();

while ( $donnees = $reponse->fetch()) {
	# code...

	$tab = array($donnees['id_reservation']=>$donnees['date_reservation'],);

	array_push($array,$tab);

	// echo $donnees['id_reservation'].'<br>';

	

}

// print_r($array);

$reponse->closeCursor();

	$requete = $bdd->prepare('UPDATE paiement SET date_paiement = ? WHERE id_reservation = ? ');


 foreach ($array as $value) {
// # code...

 	foreach ($value as $key => $val) {
 		# code...

 		$requete->execute(array($val,$key));
 	}

 }	



echo "ok popoh !";




