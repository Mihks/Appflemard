

<?php


	$dsn = "mysql:host=localhost;dbname=wave;port=3306;charset=utf8";

		try
			{
				$bdd = new PDO($dsn,'root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			}
		catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());

			}


function FunctionTrajet($agence,$bdd) {
		

		$rep = $bdd->prepare("SELECT nom_trajet  FROM `trajets` WHERE trajets.nom_agence= ? ;");


		$rep->execute(array($agence));

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