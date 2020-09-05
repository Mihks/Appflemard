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

$excedent = filtre($_POST['excedent']);

 
$reponse = $bdd->prepare(" UPDATE reservation SET excedent_2 = ?  WHERE nom_agence = ? AND id_reservation =  ?   ");

$reponse->execute(array($excedent,$_SESSION['agence'],$id));

	
echo "<div>Opération effectuée !</div> <img src='images/accept.png' />";

