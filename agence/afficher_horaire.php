<?php

session_name('flemadmin');

session_start();

include_once 'fonction.php';



$reponse =  $bdd->prepare(" SELECT  heure FROM horaire WHERE nom_agence = ? ");

$reponse->execute(array($_SESSION['agence']));

echo "<ul>";

while ($donnes = $reponse->fetch()) {
	
	echo "<li>".$donnes['heure']."</li>";
}


echo "</ul>";