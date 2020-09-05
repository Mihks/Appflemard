<?php 

session_name('flemadmin');

session_start();



if ( isset($_SESSION['agence']) && isset( $_POST['date'])) {

	include_once 'fonction.php';


function filtre($value)
{
	$nom = strip_tags($value);
	$nom = trim($nom);
	$nom = stripslashes($nom);
	return  $nom;
}



$date = $_POST['date'];

$horaire = $_POST['horaire'];

 



$reponse = $bdd->prepare(" SELECT 

	nom_trajet AS nom ,
	horaire,nombre_place_dispo AS dispo,
	nombre_place_reserve AS reserve 
	FROM voyage WHERE date_voyage = ? 
	AND nom_agence = ? 
	AND horaire = ? ORDER BY nom ASC
		;");


$reponse->execute(array($date,$_SESSION['agence'],$horaire));




// $reponse1 = $bdd->prepare(" SELECT nom_trajet AS nom ,horaire,nombre_place_dispo AS dispo,nombre_place_reserve AS reserve FROM voyage WHERE date_voyage = ? AND nom_agence = ? AND horaire = '9h30min' ORDER BY nom ASC


// 		;");


// $reponse1->execute(array($date,$_SESSION['agence']));

// 				while ($donnee = $reponse1->fetch()) {

// 					$dispo[] = $donnee['dispo'];	
// 					$reserve[] = $donnee['reserve'];
// 							# code...
// 				}


		

			 echo "<table align='center'  class='table_gest_place'>

			 		<caption><b>Places disponibles/Réservées</b></caption>
			<tr>
				<thead>
				
					<th>Trajet</th>
					<th>Horaire : ".$horaire."</th>
				</thead>
			</tr>";


				while ($donnees = $reponse->fetch()) {


					$donnees['dispo'] = (isset($donnees['dispo'])) ? $donnees['dispo'] : 0 ;

					$donnees['reserve'] = (isset($donnees['reserve'])) ? $donnees['reserve'] : 0 ;
					
					echo "<tr>
							<td><span style='color:black;text-shadow:1px 1px 3px orange;'>".$donnees['nom']."</span></td>
						  	<td><span>".$donnees['dispo']."</span><br/> <span class='resvcolor'>".$donnees['reserve']."</span></td>
						</tr>";
					
								
				}




	$reponse->closeCursor();



			echo "</table>"; 


}else{

	echo "Veuillez vous connecter...";
}