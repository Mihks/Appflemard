

<?php

	$url = getenv('JAWSDB_URL');
	$dbparts = parse_url($url);

	$hostname = $dbparts['host'];
	$username = $dbparts['user'];
	$password = $dbparts['pass'];
	$database = ltrim($dbparts['path'],'/');

// 	$dsn = "mysql:host=$hostname;dbname=$database;charset=utf8";
	


		try
			{
				$bdd = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8",$username,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}
		catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());

			}



function _header()
{
	echo '<header>
		
			<div class="log"><img src="agence/images/yaga.png" alt="logo" width="53" height="53"></div >
			<p class="slogan"></p>
			<span id="heure"></span>
			

			<button class="btn btn-navbar" id="btnMenu">    
				<span class="icon-bar"></span>    
				<span class="icon-bar"></span>    
				<span class="icon-bar"></span> 
			</button> 


			<nav id="nav">

				
				<div>
					
					<ul>

						<li><a href="index.php" class="">Accueil</a></li>
						<li><a href="index.php#reserve" id="lien-reserve">Reservation</a></li>
						<li><a href="index.php#a_propos" >A propos de</a></li>
						<li><a href="index.php#contact">Contact</a></li>

					
					</ul>
				</div>

			</nav>	

			<div id="heure"></div>

		</header>
		
		<br/><br/><br/><br/>';
}




// function FunctionTrajet() {
		

// 		$rep = $bdd->prepare("SELECT nom_trajet  FROM `trajets` WHERE trajets.nom_agence= ? ;");


// 		$rep->execute(array($_SESSION['agence']));

// 		echo '<label for="trajet">Trajet :</label>
		
// 		<select name="trajet" id="trajet">

// 			<option value="trajet_confondu">Trajets Confondus</option>';

// 		while ($donnees = $rep->fetch()) {
			

		
// 		echo '<option value="'.$donnees["nom_trajet"].'">'.$donnees["nom_trajet"].'</option>';
		
// 		}


// 		echo '</select>';

// }


			
function heure_agence()
			{

			 	$reponsehoraire = $bdd->prepare("SELECT DISTINCT horaire FROM voyage WHERE nom_agence = ? AND date_voyage = CURRENT_DATE ");

			 	$reponsehoraire->execute(array($_SESSION['agence']));

			 	

			 	while ( $heure = $reponsehoraire->fetch() ) {
			 		

			 		$arrayheure =  $heure['horaire'];
			 	}

			 	
			 	

			 $reponseheure = ($arrayheure =='' )? $bdd->prepare(" SELECT DISTINCT heure AS horaire   FROM horaire WHERE nom_agence = ? ") : $bdd->prepare(" SELECT DISTINCT horaire FROM voyage WHERE nom_agence = ? AND date_voyage = CURRENT_DATE "); 
				
				$reponseheure->execute( array($_SESSION["agence"])); 


				while ($donnees = $reponseheure->fetch()) {


					echo  "<option value='".$donnees['horaire']."'>".$donnees['horaire']."</option>" ;

							}

					$reponseheure->closeCursor();
			}

function FunctionTrajet() {
		

		$rep = $bdd->prepare("SELECT nom_trajet  FROM `trajets` WHERE trajets.nom_agence= ? ;");


		$rep->execute(array($_SESSION['agence']));

		echo '<label for="trajet">Trajet :</label>
		
		<select name="trajet" id="trajet">

			<option value="trajet_confondu">Trajets Confondus</option>';

		while ($donnees = $rep->fetch()) {
			

		
		echo '<option value="'.$donnees["nom_trajet"].'">'.$donnees["nom_trajet"].'</option>';
		
		}


		echo '</select>';

}


function demandeReconnexion()
	{

		echo '<h4 class="OperaReussi" style="width:640px;left: 340px;">Veuillez vous reconnecter !</h4>
		<button style="position: relative;top: 189px;left: -60px;height: 30px;border-radius:3px;" id="butt_reconn" >Reconnexion</button>';

		

		echo "

		<script>

			$(function(){

				$('#butt_reconn').click(function(){
						
					location.reload();
							
						});

				});

			</script>";

	
	}


 ?>
