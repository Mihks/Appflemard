<?php 


	include_once 'fonction.php';



if (isset($_POST['trajet']) && isset($_POST['agence']) && isset($_POST['date']) ) {
	# code...
	
$portion =  explode('-', $_POST["trajet"]);

$trajet = $portion[1].'-'.$portion[0];


$requete = $bdd->prepare(" SELECT horaire FROM voyage WHERE nom_agence = ? AND nom_trajet = ? AND date_voyage = ? ");


$requete->execute(array($_POST["agence"],$trajet,$_POST['date']));


echo '<optgroup label="'.$_POST["agence"].'" >';


	while ($donnes = $requete->fetch()) {
  	
  	

  		echo '<option  value="'.$donnes['horaire'].'">'.$donnes['horaire'].'</option>';
  	
  		
  }  

echo "</optgroup>";

$requete->closeCursor();



}else
	echo "erreur...";

