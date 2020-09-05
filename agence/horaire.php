<?php 

session_name('flemadmin');

session_start();

	include_once 'fonction.php';









if (  preg_match('#^trajet_confondu$#', $_POST['trajet']) ) {



	$reponsehoraire = $bdd->prepare("SELECT DISTINCT horaire FROM voyage WHERE nom_agence = ? AND date_voyage = ? ");

	$reponsehoraire->execute(array($_SESSION['agence'],$_POST['date']));

			 	
	$arrayheure ='';

 	while ( $heure = $reponsehoraire->fetch() ) {
			 		

		$arrayheure =  $heure['horaire'];
			 
		}





	if ($arrayheure=='') {
		

		$reponseheure =  $bdd->prepare(" SELECT DISTINCT heure AS horaire FROM horaire WHERE nom_agence = ? "); 
				
		$reponseheure->execute(array($_SESSION["agence"])); 

	} else {
		

		$reponseheure = $bdd->prepare(" SELECT DISTINCT horaire FROM voyage WHERE nom_agence = ? AND date_voyage = ? "); 
				
		$reponseheure->execute(array($_SESSION["agence"],$_POST['date'])); 

	}
	

	echo '<optgroup label="'.$_POST["trajet"].'"  >';


	while ($donnees = $reponseheure->fetch()) {


		echo  "<option value='".$donnees['horaire']."'>".$donnees['horaire']."</option>" ;

							}

	echo "</optgroup>";

	$reponseheure->closeCursor();


 



}else{





	$reponsehoraire = $bdd->prepare("SELECT horaire FROM voyage WHERE nom_agence = ? AND date_voyage = ? AND nom_trajet = ? ");

	$reponsehoraire->execute(array($_SESSION['agence'],$_POST['date'],$_POST['trajet']));


	while ( $heure = $reponsehoraire->fetch() ) {
			 		

		$arrayheure =  $heure['horaire'];
		
			}




if ($arrayheure=='') {

	$reponseheure = $bdd->prepare(" SELECT heure AS horaire FROM horaire WHERE nom_agence = ? AND trajet = ? "); 

	$reponseheure->execute(array($_SESSION["agence"],$_POST['trajet']));

} else {


	$reponseheure = $bdd->prepare(" SELECT  horaire FROM voyage WHERE nom_agence = ? AND date_voyage = ? AND nom_trajet = ?"); 

	$reponseheure->execute(array($_SESSION["agence"],$_POST['date'],$_POST['trajet']));

					
		}
								



echo '<optgroup label="'.$_POST["trajet"].'"  >';


	while ($donnees = $reponseheure->fetch()) {


		echo  "<option value='".$donnees['horaire']."'>".$donnees['horaire']."</option>" ;

		}

	$reponseheure->closeCursor();
				
echo "</optgroup>";



 }