<?php 
		
		
include_once('fonction.php');

if (isset($_REQUEST['trajet']) && isset($_REQUEST['agence']) && isset($_REQUEST['date']) ) {

  
$requete = $bdd->prepare(" SELECT horaire FROM voyage WHERE nom_agence = ? AND nom_trajet = ? AND date_voyage = ? ");


$requete->execute(array($_REQUEST["agence"],$_REQUEST["trajet"],$_REQUEST['date']));


echo '<optgroup label="'.$_REQUEST["agence"].'"  >';

while ($donnes = $requete->fetch()) {
  	
  	

  	echo '<option  value="'.$donnes['horaire'].'">'.$donnes['horaire'].'</option>';
  	
  		
  }  


echo "</optgroup>";

$requete->closeCursor();


}else
	
	echo "erreur...";
	
?>
