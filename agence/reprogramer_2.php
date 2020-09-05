<?php 

session_name('flemadmin');

session_start();



?>
<!DOCTYPE html>
<html>
<head>
	<title>reprogramer</title>

</head>
<body>


<?php


	include_once 'fonction.php';


function filtre($value)
{
	$nom = strip_tags($value);
	$nom = trim($nom);
	$nom = stripslashes($nom);
	return  $nom;
}



$date = $_POST['date'];


?>


<div id="retour"><?php 



$reponse = $bdd->prepare(" SELECT nom_trajet AS nom ,horaire,nombre_place_dispo AS dispo,nombre_place_reserve AS reserve FROM voyage WHERE date_voyage = ? AND nom_agence = ? AND horaire = '8h30min' ORDER BY nom ASC


		;");


	$reponse->execute(array($date,$_SESSION['agence']));




$reponse1 = $bdd->prepare(" SELECT nom_trajet AS nom ,horaire,nombre_place_dispo AS dispo,nombre_place_reserve AS reserve FROM voyage WHERE date_voyage = ? AND nom_agence = ? AND horaire = '9h30min' ORDER BY nom ASC


		;");


$reponse1->execute(array($date,$_SESSION['agence']));


				while ($donnee = $reponse1->fetch()) {

					
					$dispo[] = $donnee['dispo'];	
					$reserve[] = $donnee['reserve'];
							# code...
				}




			 echo "<table align='center'  class='table_gest_place'>


			<tr>
				<thead>
				
					<th>Trajet/Horaire</th>
					<th>heure 1</th>
					<th>heure 2</th>
				
				</thead>
			</tr>";

			

				$i= 0;

				while ($donnees = $reponse->fetch()) {

					
					echo "<tr><td><span style='color:black;text-shadow:1px 1px 3px orange;'>".$donnees['nom']."</span></td>
						  <td><span>".$donnees['dispo']."</span><br/> <span class='resvcolor'>".$donnees['reserve']."</span></td>
						  <td><span>".$dispo[$i]."</span><br/> <span class='resvcolor'>".$reserve[$i]."</span></td></tr>";
					$i++;
								
				}




	$reponse->closeCursor();



			echo "</table>"; 

	
	?>
	</div>


</body>

</html>