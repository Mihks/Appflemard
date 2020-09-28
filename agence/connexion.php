<!DOCTYPE html>
<html>
<head>
	<title>connexion</title>
	<meta charset="utf-8"/>

	<link rel="stylesheet" type="text/css" href="css/style.css">

	<style type="text/css">
	

		form{

			margin-left: 15px;
		}
	</style>
</head>
<body>


		<header>
		
			<div class="log"><img src="images/yaga.png" alt="logo" width="53" height="53"></div >
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

						<li><a href="../index.php" class="">Accueil</a></li>
						<li><a href="../index.php#reserve" id="lien-reserve">Reservation</a></li>
						<li><a href="../index.php#a_propos" >A propos de</a></li>
						<li><a href="../index.php#contact">Contact</a></li>
					
					</ul>
				</div>

			</nav>	

		
			<div id="heure"></div>


		</header>
		
		<br/><br/><br/><br/>

	<section>

		<h1 class="centre-text">Bienvenue sur l'interface de connexion Flemard !</h1>
	
	<div >
		<form action="traitement.php" method="POST" id="form" hidden>

			
			<label for="login">Login</label>
			<input type="text" name="login" id="login" class="frm-control" autocomplete="Off" maxlength="20"  placeholder="login" required><br/>

			<label for="agence" >Agence</label>
			<select  id="agence" class="frm-control" name="agence">
					
				<option value="">Choisir une agence</option>
				
				<optgroup label="Agence Terrestre">
					<option value="excellence_transport">Excellence Transport</option>
				</optgroup>

			</select><br/>


			<label for="membre" >Utilisateur</label>

			<select  id="membre" class="frm-control" name="membre" >

				<optgroup label="Utilisateur">
					<option value="gerant">Gerant</option>
					<option value="administrateur">Administrateur</option>
				</optgroup>

			</select><br/>

			<div id="grpsiege" >
				<label for="siege" >Siège</label>
				<select class="frm-control" name="region" id="siege">
					<option value="Libreville">Libreville</option>
					<option value="Oyem">Oyem</option>
					<option value="Bitam">Bitam</option>
					<option value="Mitzic">Mitzic</option>
					<option value="Mouila">Mouila</option>
					<option value="Fougamou">Fougamou</option>
					<option value="Port-gentil">Port-gentil</option>

				</select><br/>

			</div>


			<label for="mdp">Mot de passe</label>
			<input type="password" name="mdp" id="mdp" class="frm-control" autocomplete="Off" maxlength="30" minlength="4" placeholder="mot de passe" required /><br/>

			<!-- <label for="mail">E-mail</label>
			<input type="text" id="mail" class="frm-control" autocomplete="Off" placeholder='votre boite mail' pattern="^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$" name="mail" required><br/> -->

			<!-- <label for="tel">Contact</label>
			<input type="text" name="tel" id="contact" class="frm-control" autocomplete="Off" placeholder='tel' pattern="^0(62|65|66|74|77)([-. ]?[0-9]{2}){3}$" required><br/> -->
			
			<div>
				<button type="submit" id="send" style="border-radius: 12px;width: 105px;height: 35px;font-size: 14px;border-bottom: 1px solid orange;margin-left: 250px;">Valider</button>
			</div>

		</form>

	</div>

	




		 <?php // if (isset($_POST['mail']) AND isset($_POST['tel']) AND isset($_POST['agence'])) {    
			

		// 	$mail = htmlspecialchars($_POST['mail']); // On rend inoffensives les balises HTML que le visiteur a pu rentrer 

		// 	$tel =  htmlspecialchars($_POST['tel']);

		// 	$agence =  htmlspecialchars($_POST['agence']);


			 

		// 	if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $mail) AND preg_match('#^0(62|65|66|74|77)([-. ]?[0-9]{2}){3}$#', $tel) )  {        



		// 	//connexion à la base de données

		// 		$dsn = "mysql:host=localhost;dbname=wave;port=3306;charset=utf8";

		// 		try
		// 			{
		// 				$bdd = new PDO($dsn,'root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		// 			}
		// 		catch (Exception $e)
		// 			{
		// 				die('Erreur : ' . $e->getMessage());

		// 			}


		// 		$req= $bdd->prepare('INSERT INTO preinscription (agence,mail,contact,date_ajout) VALUES (?,?,?,NOW())');

		// 		$req->execute(array($agence,$mail,$tel));

		// 		echo "<p style='color:blue;'>votre Préinscription à été valider, nous vous contacterons pour un éventuel rendez-vous. Merci et à bientot </p>";



		// 	}else{    


		// 		echo "<p style='color:red;'>votre mail ou votre contact est invalide,Veuillez recommencer.</p>";    
    


		// 	} 
		// } ?> 


	</section>


	<?php include('includes/footer.php'); ?>


	<script src="js/jquery.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>


	<!-- <script src="js/interfaceClient.js"></script> -->
			
	<script type="text/javascript">
		
		$(function () {
			

			
			

				//AFFICHE LHEURE
//----------------------------------------------------------------------------------------

			function horloge(){

				var date = new Date();
				var h = date.getHours()+ ":"+ date.getMinutes()+ ":"+ date.getSeconds();
				$("#heure").text(h).css("color",'rgb(0,128,128)');
			}

			setInterval(horloge,1000);


			$(".slogan").html("Donner un Sens à votre Flemme !").css("font-size","small").css("color","rgb(0,128,128)").css("text-decoration","underline").css("text-decoration-color","orange");




			$('#btnMenu').on('click touch', function(){            

				$('#nav').slideToggle();    

				});


			$('#form').fadeIn(5000);


			$("#membre").change(function(){


				var valmembre =  $('#membre').val();


				if (valmembre =='administrateur') {

					$('#grpsiege').slideToggle();


				}else if(valmembre =='gerant'){

					$('#grpsiege').slideToggle();
				}



			});

		


		});
	</script>		

</body>
</html>







