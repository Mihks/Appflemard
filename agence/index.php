<?php 


session_name('flemadmin');

session_start(); 



include_once('fonction.php');


$req = $bdd->exec(" SET lc_time_names = 'fr_FR';");



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



if (isset($_SESSION['region']) && isset($_SESSION['login']) && isset($_SESSION['agence']) && isset($_SESSION['membre']) && isset( $_SESSION['mdp'] ) ) {


?>


<!DOCTYPE html>
<html>

<html manifest="offline.appcache" >

<head>
	<title>FlemAdmin</title>
	<meta charset="utf-8"/>

	<link rel="stylesheet" type="text/css" href="css/jquery-ui.structure.min.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.theme.min.css">
<!-- 	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.3.custom.min.css"> -->

	
    <link href="css/style.css" rel="stylesheet">


	
	<style type="text/css">


		body{

			background-color: #f0f0f0;

		}

		


		.aligner{

			display: block; /* La balise devient de type block. */
			width: 150px; 
			float: left;
		}


		#dial_qrcode{
			
			/*background-color: rgba(12,12,12,0.1);*/

			/*backdrop-filter: contrast(1);*/
			
		}

		.class_dial_tarif{

			margin: 2px;
		}

		#tab_trajet,.aff_horaire{

			width: 400px;
			height: 105px;

		}

		#tab_trajet_bat{

			width: 700px;
			height: 105px;
		}


		#dispo_legend,#reserv_legend{

			height: 15px;
			width: 15px;
			
			border: 1px solid black;

			border-radius: 15px;
		}

		#dispo_legend{

			background: rgb(0,128,128);
			margin-bottom: 15px;
			position: absolute;
			top: 27px;
			left:460px;
		}

		#reserv_legend{

			background: red;
			position: absolute;
			top: 27px;
			left:584px;


		}


		#tabstat{

			width: 600px;
			height: 300px;

			overflow: auto;
		}
		
		.table_gest_place{

			border-collapse: collapse;
			padding: 5px;

			width: 600px;

			text-align: justify;
		}


		.resvcolor{

			color: red;
		}

		td span{

		color: rgb(0,128,128);

		font-weight: bolder;
	}


		.input_dial{

			width: 50px;
			margin: 10px;
			padding: 2px;
		
		}




		td,th{
			padding: 15px;
			text-align:center;
			
		}

		#bloc p{

			display: inline-block;
			text-align:center;
			border-bottom: 2px solid orange;
			border-radius: 12px;
			text-shadow: 1px 1px 1px orange;
			font-family: "chiller";
			background-color: black;
/*			background-image: url(images/bg-title-dark.png);
*/			color: rgb(0,128,128);
			padding-top: 13px;
			margin: 35px;
			width: 100px;
			height: 50px;
			text-align: center;
			font-size: 30px;
			box-shadow: 1px 1px 40px black;

		}


		

		header{

	/*	border: 2px solid orange;*/
		margin: 15px;
		margin-left: 0px;
		margin-right: 0px;
		position: fixed;
		top: -15px;
		width: 100%;
		height: 70px;
		border-bottom: 1px solid orange;
		background-color: white;

	}


		table {

			border-collapse: collapse;
			
			width: 1300px;
			

		}

		#tab_qrc{

			width: 500px;
		


		}


		#tab_qrc th,#tab_qrc td{

			padding: 5px;

			text-shadow: none;

		}

		#tab_qrc td{

			color: black;

		}


		#tab_qrc thead{

			background-color:white;
		}


		thead{

			background-color: black;
			color: rgb(0,128,128);
			text-shadow: 1px 1px 1px orange;
			border-bottom: 2px solid orange;

		}

		label{
			margin: 13px;
			
		}
		

		#sectiontab{

			width: 1305px;
			height: 300px;
			overflow: auto;
			box-shadow: 4px 2px 40px;
			border-bottom: 2px solid orange;
			border-radius: 4px;
			/*margin-bottom: 10px;*/
			margin-left: 15px;

			background-color: white;	



		}

		

		tr:nth-child(even){

			background-color: lightgrey;

		}

		
		



/*
		#sectiontab td:nth-child(8),#sectiontab td:nth-child(1){

			font-weight: bolder;
		}*/






		.OperaReussi,#chargement,#aucunResultat{

			font-family: 'chiller';
			font-size: 50px;
			color: rgb(0,128,128);
			position: relative;
			width: 500px;
			text-shadow: 1px 1px 30px black;
			top: 100px;
			left: 430px;
			


		}


		/*tr:hover{

			background: #ff2345;
		}*/

		input:hover,select:hover,button:hover,img:not(.pasHover):hover,a:hover{
			box-shadow: 1px 1px 10px black;
			color: rgb(0,128,128);
		}


	
.btn {    
	display: inline-block;    
	cursor: pointer; 

} 
.btn-navbar {    
	float: left;    
	padding: 12px 15px;    
	margin-right: 5px;    
	margin-left: 5px;
} 

.icon-bar {    
	display: block;
  	width: 18px;    
  	height: 3px;    
  	background-color: rgb(0,128,128);    
  	-webkit-border-radius: 1px; /* Ce sont des préfixes, pour que les navigateurs */       
  	-moz-border-radius: 1px; /* prennent en charge les nouvelles propriétés. */            
  	border-radius: 1px; 
 } 

 .icon-bar + .icon-bar { /* Le + permet de sélectionner les éléments qui suivent */    
  	margin-top: 3px;


}
  #btnMenu{

  	margin-top: 5px;
  	border-radius: 2px;

  }

  .notif{

  	border: 1px solid black;
  	background: black;
  	border-radius: 15px;
  	position: absolute;
  	height: 15px;
  	width: 15px;
  	left: 1207px;
  	top: 35px;

  }

input,select{

	border-radius: 4px 4px 4px 4px;
}

button{

	border-radius: 2px 2px 2px 2px;

	cursor: pointer;
		

}




	</style>
</head>

<body>



	<header>

		<button class="btn btn-navbar" id="btnMenu" title="Tableau de bord">    
			<span class="icon-bar"></span>    
			<span class="icon-bar"></span>    
			<span class="icon-bar"></span> 
		</button>

		<!-- <div class="notif"><font size="2" face="chiller" style="position: relative;top: -3px;color: rgb(0,128,128);text-shadow: 1px 1px 1px orange;left: 2px;">12</font></div> -->


		<!-- <img src="../images/cloche.png" style="position: absolute;left: 1200px;top: 12px;" title="Notification" /> -->
			
			<!-- <a href="#" style="text-decoration: none;"> -->
				
		<img src="images/question.svg" id="aide" alt="aide" title="Guide utilisation" style="position: absolute;left: 1269px;margin-top: 10px;border-radius: 3px;cursor: pointer;" /><!-- </a>-->
		
		


		<div><img src="<?= $_SESSION['logo_agence'];?>"  style="width: 50px;height: 30px;border-radius: 4px 4px 4px 4px;position: absolute;left: 1105px;margin-top: 15px;" alt="Logo agence" title="Logo agence" /></div>

		<!-- <div style="position: absolute;left: 1180px;margin-top: 15px;">

			<label for="theme">Thème :</label>
			<select  style="border-radius: 4px 4px 4px 4px;" alt="Thème" title="Thème" id="theme" />

				<option>Sobre</option>
				<option>Custom</option>

			</select>
		</div>
 -->
		<div style="height: 70px; width: 400px;position: absolute;top: 73px;left: 460px;padding-top: 5px;padding-left: 30px;background: rgba(0,128,128,0.3);border-bottom: 2px dotted orange;" id="menu" hidden>

			<ul style="position: relative;bottom: 20px;right: 40px;">


				<li style="list-style-type: none;display: inline-block;margin: 5px;">
					<a  href="#" id="messagerie" title="Centre de discussion" style="text-decoration: none;color: black;text-shadow: 1px 1px 1px orange;">
					Messagerie</a><img src="images/amelia-sms.svg" class="pasHover" style="width: 20px;height: 20px;position: relative;top:2.2px;left: 5px;" />
				</li>

				<li style="list-style-type: none;display: inline-block;">
					
					<a id="stats" title="statistique" href="#" style="text-decoration: none;color: black;text-shadow: 1px 1px 1px orange;margin: 5px;">Statistiques</a><img src="images/chart_bar.png" class="pasHover" style="position: relative;top: 1.1px;" />
				</li>


				<li style="list-style-type: none;display: inline-block;margin-left: 5px;">
					<a href="../index.php#reserve" id="lien-reserv" title="Réservation en ligne" target="_blank" style="text-decoration: none;color: black;text-shadow: 1px 1px 1px orange;" >
					
					Réserv. en ligne</a><img src="images/application_form.png" class="pasHover" style="position: relative;top:2.2px;left: 5px;" />
				</li>

				<li style="list-style-type: none;display: inline-block;">
					<a href="deconnexion.php" title="Déconnexion" style="text-decoration: none;color: black;text-shadow: 1px 1px 1px orange;margin: 5px;" >
					
					Déconnexion</a><span><img src="images/web-hook.svg" class="pasHover" style="" /></span>
				</li>

				<li style="list-style-type: none;display: inline-block;">
					<a href="#" id="lien_qrcode" style="text-decoration: none;color: black;text-shadow: 1px 1px 1px orange;" >
					
					Enrégistrement</a><img src="images/accept.png" class="pasHover" style="position: relative;left: 3px;top: 2px;" /></span>
				</li>




				<li style="list-style-type: none;display: inline-block;margin-left: 5px;">
					<a  id="gestionplace" href="#" title="Paramètres" class="<?= $_SESSION['agence'];?>" style="text-decoration: none;color: black;text-shadow: 1px 1px 1px orange;" >
					
					Paramètres</a><img src="images/cog.png" class="pasHover" style="position: relative;left: 2.5px;top: 2px;" />
				</li>




				
			</ul>
		</div>

		<img src="images/flem.png" style="height: 50px;width: 42px;position: absolute;left: 170px;" class="pasHover" />
		<h2 style="color:rgb(0,128,128);font-family:'chiller';position: relative;left: 200px;top: -40px;width: 100px;" hidden id="flemAdmin"><!-- MoulKyl -->lem<font color="orange">Admin</font></h2><span style="position: absolute;top: 27px;left: 320px;color: rgb(0,128,128);">Version bêta</span>

		<div align="center" id="bloc" style="position: relative;top:-127px;width: 880px;left: 235px;height: 100px;">
				<p id="reserv" title="le nombre de place Reservée" ><font size="4">chargement...</font></p><sub style="font-size: 20px;font-family:'chiller';background: url('images/bg-title-dark.png');color: white;text-shadow: 1px 1px 1px orange;vertical-align: middle;"><span id="reserv_label" ></span> - <span id="dispo_label" ></span></sub>
				<p id="dispo" title="le nombre de place disponible"  ><font size="4">chargement...</font></p>
				
				<!-- <progress id="progressbar" value="" max="" style="border:1px solid black;position: absolute;top: 85px;left:346px;width: 185px;" /> -->

				<div id="barre" style="width: 185px;height: 10px;position: absolute;top: 85px;left:346px;box-shadow: 1px 1px 10px black;"></div>

				<div id="pourcent_place_reserv" style="position: absolute;left:431px;top: 86px;font-size: x-small;color: rgb(0,128,128);">34%</div><!-- text-shadow: 1px 1px 0.3px orange; -->


		</div>


		<div id="solde_jour" style="font-size:15px ; position: relative;top:-144px;left: 50px;width: 350px;text-align: center;box-shadow: 1px 1px 20px black;background: url('images/bg-title-dark.png');color: white;text-shadow: 1px 1px 1px orange;">Chargement...</div>

	
			<div style="position: absolute;top: 70px;left: -6px;">

<!-- 				<fieldset>
 --><!-- 					<legend>Les differents soldes</legend>
 -->
					<label for="radio-1" style="font-size: 12px;text-shadow: 1px 1px 1px orange;font-weight: bolder;">Billets</label>
					<input type="radio" name="solde" value="Prix billet" checked style="" id="radio-1" />

					<label for="radio-2" style="font-size: 12px;text-shadow: 1px 1px 1px orange;font-weight: bolder;">Excédents</label>
					<input type="radio" name="solde" value="Excédents" style="" id="radio-2" />

					<label for="radio-3" style="font-size: 12px;text-shadow: 1px 1px 1px orange;font-weight: bolder;">Pénalités</label>
					<input type="radio" name="solde"  value="Pénalité" style="" id="radio-3" />

					<label for="radio-4" style="font-size: 12px;text-shadow: 1px 1px 1px orange;font-weight: bolder;">Totaux</label>
					<input type="radio" name="solde" value="Total" style="" id="radio-4" />
					
				<!-- </fieldset> -->

<!-- 				<span style="margin-left: 15px;" id="typeSolde"></span>
 -->			</div>


		
		<div  id="time"  style="font-weight: bolder;font-size:15px ; position: absolute;top:53px;left: 950px;width: 350px;text-align: center;box-shadow: 1px 1px 20px;background: url('images/bg-title-dark.png');color: white;text-shadow: 1px 1px 1px orange;"></div>
		<!-- <div style="position: absolute;top: 70px;left: 930px;">
				
			<label for="val-1" style="font-size: 12px;text-shadow: 1px 1px 1px orange;font-weight: bolder;">Azerty</label>
			<input type="radio" name="val" value=""  style="" id="val-1" />
			
			<label for="val-2" style="font-size: 12px;text-shadow: 1px 1px 1px orange;font-weight: bolder;">Qwerty</label>
			<input type="radio" name="val" value="" style="" id="val-2" />

			<label for="val-3" style="font-size: 12px;text-shadow: 1px 1px 1px orange;font-weight: bolder;">Mihky</label>
			<input type="radio" name="val"  value="" style="" id="val-3" />

			<label for="val-4" style="font-size: 12px;text-shadow: 1px 1px 1px orange;font-weight: bolder;">Weezy</label>
			<input type="radio" name="val" value="" style="" id="val-4" />


 			<span style="margin-left: 15px;" id="typeSolde"></span>
 		</div> -->
	</header>

	<br><br><br><br><br><br><br><br>

		
	<section >



	<img src="images/3gyeo9.svg" width="100" height="50" style="position: absolute;left: 88px;top: 12px;" class="pasHover" />

	<span id="afficheTraj" style="background-image: url(images/bg-title-dark.png);margin-bottom: 50px;margin: 15px;position: absolute;top:120px;float: left;font-size: 20px;text-shadow: 1px 1px 1px orange;color: white;"><img src="images/wait.gif" /></span>

	<!-- <span style="position: absolute;top: 150px;right: 60px;font-size: 20px;">Liste de reservation</span> -->


	<span style="background-image: url(images/bg-title-dark.png);text-shadow: 1px 1px 1px orange;font-size: 20px;position: absolute;top: 120px;left: 1000px;text-align: right;margin-bottom: 50px;color: white;margin: 15px;" id='date_de_voyage' ><img src="images/wait.gif" /></span><!-- width: 650px; -->


	<div style="position: absolute;top: 175px;left: 1050px;margin-bottom: 7px;width: 300px;margin-left: 0px;">
	
	<input type="search"  id="ref" placeholder="ID ou nom" style="text-align: center;" autocomplete="off" maxlength="25" />
	<button id="action" style="cursor: pointer;">Recherche<span  class="ui-icon ui-icon-search"></span></button></div>



<?php 

		 
			

				echo "<div id='sectiontab'>

					<div align ='center' style='margin:125px;'><img src='images/wait.gif' />
						</section><div>";
			
				
?>


<form method="POST" action="imprimer.php" target="_blank">

	<div style="position: relative;top: -330px;width: 800px;left: 16px;margin-left: 15px;">

		<span>
			<button type="submit" id="envoie" style="text-decoration: none;cursor: pointer;font-size: 12px;margin-top: -4px;" name="envoyer" value="envoie">Imprimer<span class="ui-icon ui-icon-print" ></span></button>
		</span>

		<span style="position: relative;left: 100px;" id="change_etat_hist_motif">
			
			<img src="images/s_status.png" />

			<label for="Etat">Etat :</label>

			<select id="Etat" name="Etat">

				<optgroup label="Réservation" id="etat_reservation" class="liste-etat">
					<option id="valide_list_reserv" selected value="Valide">Valide</option>
					<option value="Annule">Annulé</option>
					<option value="Avorte">Avorté</option>

				</optgroup>
					
				<optgroup label="Voyage" id="etat_voyage" class="liste-etat">
					<option value="Effectue">Effectué</option>
					<option value="Non-Effectue">Non-Effectué</option>
				</optgroup>


				

			</select>
		
		</span>
	
		<span style="position: relative;left: 200px;">
				Afficher

			<select id="limit" name="limit">
				<option value="10">10</option>
				<option value="25">25</option>
				<option value="30">30</option>
				<option value="50">50</option>
				<option selected value="tout">toutes</option>
			</select> les lignes
			
		</span>
	 
		 <span style="position: relative;left: 250px;"><img src="images/b_events.png" style="position: absolute;top: 0px;left: -7px;" />
		 	<label for="Stat">Horaire :</label>

		 			

		 			<select  id="hora" name="hora">

				  	<optgroup label="Horaire">
				
					
			<?php 

			function heure_agence($bdd)
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
			
				 heure_agence($bdd);



					?>

				
		 			</optgroup>
	
					
				<!-- <optgroup label="opt2">
					<option>Confondu</option>
					<option>Effectue</option>
					<option>Non-Effectue</option>
						
				</optgroup> -->

			</select>
		</span>

	</div>






	<fieldset style="float: left;">

		<legend>
			<select id="choixInfo">
				<option value="reservation">Réservation</option>
				<option value="Voyage">Voyage</option>
			</select>
		</legend>

	<span style="margin:15px;" id="info_reservation">

		
			<?php FunctionTrajet($_SESSION['agence'],$bdd);?>
			<!-- <label for="trajet">Trajet :</label><select name="trajet" id="trajet">
				<option value="trajet_confondu">Trajets Confondus</option>
				<option value="Libreville-Oyem">Libreville-Oyem</option>
				<option value="Libreville-Bitam">Libreville-Bitam</option>
				<option value="Oyem-Libreville">Oyem-Libreville</option>
				<option value="Bitam-Libreville">Bitam-Libreville</option>
			</select> -->

			<label for="date_reserve">Agenda :</label><input style="cursor: pointer;" title="Agenda" type="text" id="date_reserve" name="date" placeholder="entrer une date" />
			<img src="images/b_calendar.png" style="vertical-align: bottom;margin: 3px;" />

			
			<div hidden>
				<label for="statut">Statut :</label><select  id="statut" name="statut">
					<option value="Succes">Succès</option>
					<option value="Echoue">Echoué</option>
				</select>
			</div>

	</span>


	
	<span style="margin:15px;" id="info_voyage" hidden>

		
	

		

	</span>

	</fieldset>

	</form>


	

		<?php echo '<fieldset style="margin-top: 3px;"><legend style="border:1px solid black;background: white;font-weight: bolder; ">Modifier une réservation<img src="images/page_edit.png" /></legend><a href="#foot"><span class="ui-icon ui-icon-circle-plus" id="circle-plus" ></span></a><div id="invisible" hidden>
			<label id="label_change">Identifiant</label><span id="span_change"><input type="text" id="idAnnule" autocomplete="off" maxlength="15" /></span>
			<label>Action</label><select id="choixAction">	
				<option value="annuler">Annuler</option>
				<option value="reprogrammer">Reprogrammer</option>
				<option value="excedent">Ajouter des excédents</option>

			</select>
			<button id="butnAnnule" style="cursor: pointer;">Valider</button>
		</div></fieldset>'; ?>
			
		 

		
	

	<div id="dialogAnnule"></div>

	


<div id="dial_confidentiel" hidden>
	
	<label>Veuillez saisir le mot de passe</label>
	<input type="password" name="" id="mdp_admin_general" />
</div>

<div id="dialog" hidden >

	<div id="onglets">  
		
		<ul>    
			<li><a href="#onglet-1">Gestion de places</a></li>
			<li id="confidentiel" ><a href="#onglet-3">Confidentialité</a></li>
			<li><a href="#onglet-2">Impression</a></li>  
			<li><a href="#onglet-4">A propos de</a></li>  
		</ul>  


		<div id="onglet-1">  

			<!--contenu gestion place -->  

			<div style="margin-bottom: 15px;">

				<label for="date_gest">Date voyage :</label>
				<input type="text" name="" id='date_gest'/>

				<label>Horaire</label>
				<select id="horaire_gest_place">

		<?php 

				
				heure_agence($bdd);






	?>

				</select>

		<?php if ($_SESSION['membre']=='administrateur') {
			
			echo '<div style="position: relative;left: 0px;padding-top: 15px;">
					<a href="#" id="lien_modif_gestplace">Modifier</a> Nombre de place
				
					
				</div>';

		} ?>
				
	
				<div style="position: absolute;top: 50px;left:584px;">Disponible</div><div style="position: absolute;top: 70px;left: 614px" id='dispo_legend'></div>
				<div style="position: absolute;top: 50px;left:684px;">Reservée</div><div style="position: absolute;top: 70px;left: 714px;" id="reserv_legend"></div>

			</div>

			<div id="table_gestion_place"></div> 

			<div id="dial_modif_gestplace" hidden>

			<label class="aligner" for="trajet_modif_gestplace">Trajet:</label>
			
			<select id="trajet_modif_gestplace">

				<!-- <option value="trajet_confondu">Trajets confondus</option> -->

			 <?php 

			 $reponse = $bdd->prepare("SELECT nom_trajet AS nom  FROM `trajets` WHERE trajets.nom_agence= ? ;");


			 $reponse->execute(array($_SESSION['agence']));


			 

			 while ($donnees = $reponse->fetch() ) {
			 	
			 	echo "<option value='".$donnees['nom']."'>".$donnees['nom']."</option>";
			 }

			 $reponse->closeCursor();


			  ?>
			</select>
				<label class="aligner" for="date_modif_gestplace">Date voyage</label><input type="text" name="" id="date_modif_gestplace" />
				
				<div style="margin-top: 10px;">
				<label for="heure_modif_gestplace" >Horaire</label><br/><br/>
				
				<select id="heure_modif_gestplace">

					<!-- <option value="tout_heure">Toutes heures</option> -->
				<?php	heure_agence($bdd); ?>

				</select>

				</div>

				<label class="aligner" for="nombre_modif_gestplace">Nombre de place</label>

				<input type="number" name="" id="nombre_modif_gestplace" />

			</div> 
			<!--contenu gestion place fin -->  
		</div>


		<div id="onglet-2">

			<h4>Imprimer un billet</h4>	<br>

			<form target="_blank" action="billet2.php" method="get">

				<label for="id_billet">Identifiant</label>
				<input id="id_billet" type="text" name="imp_billet" />	

				<button type="submit">Valider</button>
			</form>
		</div>



		<div id="onglet-3">  

			 
			<!--contenu --> 



			<div>


				<?php   

				if (preg_match('#^akewa$#', $_SESSION['agence'])) {

					$requete = $bdd->prepare(' 
						
						SELECT
							nom_trajet,
					        prix_trajet_classe_eco_enfant,
					        prix_trajet_classe_aff_enfant,
					        prix_trajet_classe_eco_adulte,
					        prix_trajet_classe_aff_adulte
					        
					    FROM trajets WHERE nom_agence = ? ');

					$requete->execute(array($_SESSION['agence']));

					echo "<table id='tab_trajet_bat' align='center'>
						<tr>
							<thead>
								<th>Nom du trajet</th>
								<th>Prix du trajet classe eco enfant (XAF)</th>
								<th>Prix du trajet classe aff enfant (XAF)</th>
								<th>Prix du trajet classe eco adulte (XAF)</th>
								<th>Prix du trajet classe aff adulte (XAF)</th>
							</thead>

						</tr>";


						$nom_trajet_tarif = array();

						while ($data = $requete->fetch()) {

							array_push($nom_trajet_tarif, $data['nom_trajet']);

							echo "<tr><td><strong>".$data['nom_trajet']."</strong></td>"
								."<td><strong>".strip_tags($data['prix_trajet_classe_eco_enfant'])."</strong></td>"
								."<td><strong>".strip_tags($data['prix_trajet_classe_aff_enfant'])."</strong></td>"
								."<td><strong>".strip_tags($data['prix_trajet_classe_eco_adulte'])."</strong> </td>"
								."<td><strong>".strip_tags($data['prix_trajet_classe_aff_adulte'])."</strong></td></tr>";
							
						}

						echo "</table>";

					if ($_SESSION['membre']=='administrateur') {
						
						echo "<a href='#' id='modif_prix_trajet_bat'>Modifier</a>";
					}
						


					
				}else{


						$requete = $bdd->prepare(' SELECT prix_trajet,nom_trajet FROM trajets WHERE nom_agence = ?'); 

						$requete->execute(array($_SESSION['agence']));

						echo "<h4>Tarifs</h4>
						<table id='tab_trajet' align='center'>

							<caption style='font-weight:bolder;'>Tarifs des tronçons</caption>
						<tr>
							<thead>
								<th>Nom du trajet</th>
								<th>Prix du trajet (XAF)</th>
							</thead>

						</tr>";



						if ($_SESSION['membre']=='administrateur') {
							

							while ($data = $requete->fetch()) {

						echo "<tr><td><strong>".strip_tags($data['nom_trajet'])."</strong></td>"
							."<td><strong >".strip_tags($data['prix_trajet'])."</strong> <a href='#' id='".strip_tags($data['nom_trajet'])."'>Modifier</a></td></tr>";
							
						}

						echo "</table>";

						
						}else{


							while ($data = $requete->fetch()) {

						echo "<tr><td><strong>".strip_tags($data['nom_trajet'])."</strong></td>"
							."<td><strong >".strip_tags($data['prix_trajet'])."</strong></td></tr>";
							
						}

						echo "</table>";


						}



						}

						
				?>

				<div id="dial_tarif" hidden> <?php if (preg_match('#akewa#', $_SESSION['agence'])) {
						
						echo "<div class='class_dial_tarif' ><b>Choisir le trajet</b> <select id='choix_trajet_bat'>";
					foreach ($nom_trajet_tarif as $value) {
						
						echo "<option value='".$value."'>".$value."</option>";
					}

					echo "</select></div><br/>";
					echo "<div class='class_dial_tarif'><b>Choisir le type de montant</b> <select id='type_prix_trajet_tarif'><option value='classe_eco_enfant' >Prix du trajet classe eco enfant</option>
								  <option value='classe_aff_enfant' >Prix du trajet classe aff enfant</option>
								  <option value='classe_eco_adulte' >Prix du trajet classe eco adulte</option>
								  <option value='classe_aff_adulte' >Prix du trajet classe aff adulte</option></select></div><br/>";
				} ?><div class="class_dial_tarif"><b>Le Nouveau tarif</b> <input type="number" name="" id="nouveau_trajet_tarif" /></div>

				</div>


			</div>


			<br><br>
			<div>


				<?php 

					echo "<h4>Les horaires <img src='images/b_events.png'/></h4> <!-- clock.png -->

				<br><br>";



					$reponse =  $bdd->prepare(" SELECT  heure, trajet FROM horaire WHERE nom_agence = ? ");

					$reponse->execute(array($_SESSION['agence']));

					echo "<div style='overflow:auto;height:300px;width:480px;position:relative;left:150px;' align='center'><table class='aff_horaire'>
				
					<tr>

						<thead>
							<th>Nom trajet</th>
							<th>Horaire</th>
						</thead>
					</tr>";

				while ($donnes = $reponse->fetch()) {
	
					echo "<tr><td><b>".$donnes['trajet']."</b></td>
							  <td><b>".$donnes['heure']."</b></td>
						</tr>";
					
					}

				$reponse->closeCursor();

				echo "</table></div>";

						
				if ($_SESSION['membre']=='administrateur') {


						echo "<div><a href='#' id='lien_mdf_horaire' >Modifier les horaires</a></div><br/>"; 

					}

				 ?>
			</div>

			<div id="mdf_horaire" hidden >

				<?php 


			$mdf_horaire = $bdd->prepare("SELECT nom_trajet  FROM `trajets` WHERE trajets.nom_agence= ? ;");


			$mdf_horaire->execute(array($_SESSION['agence']));

			echo '<label for="">Trajet :</label>
		
				<select name="trajet" id="mdf_trajet">

					<option value="trajet_confondu">Trajets Confondus</option>';

			while ($donnees = $mdf_horaire->fetch()) {
			

		
				echo '<option value="'.$donnees["nom_trajet"].'">'.$donnees["nom_trajet"].'</option>';
		
			}


			echo '</select><br/><br/>';


				?>

				<label>Action :</label>

				<select id="horaire_action">
					<optgroup label="Horaire par défaut">
						<option value="ajouter_heure_defaut">Ajouter</option>
						<option value="changer_heure_defaut">Changer</option>
					</optgroup>
				</select>

				<span id='add_horaire'></span>
			
			</div>


			<div>
				<h4>Pénalité</h4>

				<br><br><br>


				<?php  $reponse = $bdd->prepare('SELECT penalite FROM agence WHERE nom_agence = ? ');

						$reponse->execute(array($_SESSION['agence']));

						$penalite = $reponse->fetch();

						echo '<p>Montant Penalité : <b>'.$penalite['penalite'].' XAF</b></p>';

						$reponse->closeCursor();
 ?>


				<div><?php if ($_SESSION['membre']=='administrateur'){

						echo '<a href="#" id="changer_penalite">Modifier</a>';
				} ?></div>

				<br><br>
			</div>

			<div id="dial_changer_penalite" hidden>
				
				<label for="penalite">Saisir nouveau montant :</label>
				
				<input type="number" name="" id="penalite" />

			</div>


			<div>
				<h4>Le pourcentage de remise</h4>

				<br><br><br>

				<?php
 				
 						$reponseremise = $bdd->prepare('SELECT remise FROM agence WHERE nom_agence = ? ');

						$reponseremise->execute(array($_SESSION['agence']));

						$remise = $reponseremise->fetch();

						$remise['remise'] = $remise['remise']*100;

						echo '<p>le pourcentage de remise : <b>'.$remise['remise'].'% </b></p>';

						$reponseremise->closeCursor();


						if ($_SESSION['membre']=='administrateur') {
							
							echo '<div><a href="#" id="changer_remise">Modifier</a></div>';
						}
 ?>
			</div>

			<div id="dial_changer_remise" hidden>
				
				<label for="remise">Saisir nouveau pourcentage :</label>
				
				<input type="number" name="" id="remise" />

			</div>

			<br><br><br>

			<div>
				<h4>Changer de logo <img src="images/b_usredit.png"/></h4>
			<br><br>
			
			<label>Téléverser une image</label>
			<input type="file" name="sendlogo" style="border:1px solid black;" />

			<input type="hidden" name="MAX_FILE_SIZE" value="1024" />

			<input  name="" id="envoie_logo" type="button" value="Valider" style="cursor: pointer;">

			</div>


			<div>
				<h4>Changer de mot de passe <img src="images/s_passwd.png"/></h4>


			<br><br>
				<div><a href="#"><span class="ui-icon ui-icon-circle-plus" id="hidden_mdp-circle-plus" ></span></a></div>

				<div id="hidden_mdp" hidden>
					
					.Ancien <input type="password" style="margin: 10px;" type="text" name="" id="ancien_mdp" maxlength="30" minlength="4" />
					<div>
					
						Nouveau <input  type="password" name="" id="nouveau_mdp" maxlength="30" minlength="4" />	
						Confirmer <input type="password" name="" id="confirm_mdp" maxlength="30" minlength="4" />
						<button id="execute_mdp">Exécuter</button>
					</div>
				</div>

			</div>

<!-- 			<video src="video/xvideos.com_3f62759c958731e6efa9edbc05b84cc7.mp4" controls poster="images/bdd.png" width="600"></video>

			<p><a href="video/xvideos.com_3f62759c958731e6efa9edbc05b84cc7.mp4">Tayame le porno </a></p> -->

			<div id="dial_mdp"></div>

		</div>

		<div id="onglet-4">    
			<!--contenu -->  
			<h4>Qu'est-ce que c'est Flemard ?</h4>
			<br/>
			<p style="text-align: justify;box-shadow: 1px 1px 13px black;padding: 15px;"> <b>Flemard</b> est un service informatique indépendant de mise en rélation affilié à <b>AZOBE S.A.R.L </b> réconnu d’utilité publique . Son objectif <b>fondamental</b> est d’aider au mieux des individus au quotidien dans des secteurs d’activités variés, en apportant des <b>solutions applicatives dynamiques et scalables</b> . Pour débuter son action, <b>Flemard</b> se lance dans le secteur du <b>transport</b> en proposant une solution dans la <b>réservation des billets</b>. <b>Flemard</b> souhaite et est disposé à travailler en <b>symbiose</b> avec toute agence de voyage routière et/ou maritime .

			Réservez vos places pour un voyage de Libreville vers l'interieur du Gabon et vise versa avec votre ordinateur, téléphones…</p>
			<div style="float: left;margin: 15px;">

				<h4>Merci à</h4>

				<br>
				<div >
					<ul  style="list-style: none;line-height: 25px;" >

						<li>MOULOUNGUI MOUDIBA IV Marcel</li>
						<li>IBONDOU MOULOUNGUI Florence</li>
						<li>BILALA MOULOUNGUI Emiliènne</li>
						<li>MBOUMBA MOULOUNGUI Warren</li>
						<li>VANE DIVINGOU</li>
						<li>NZIENGUI GAHEU Ulrick</li>
						<li>MALABA Yvan</li>
					</ul>				  

				</div>

			</div>

			<div style="margin: 15px;position: relative;left: 120px;">

				<h4>Partenaires</h4>

				<br>

				<div>
					<ul style="list-style: none;line-height: 25px;">
						<li>Airtel Gabon</li>
						<li>AZOBE S.A.R.L</li>
					
					</ul>
				</div>	 

			</div>

			<div style="margin: 15px;position: relative;left: 120px;">

				<h4>Extensions utilisées <img src="images/pngPlugin.png" /></h4>

				<br>

				<div>
					<ul style="list-style: none;line-height: 25px;">
						<li>JPgraph</li>
						<li>Webcodecamjs-master</li>
					
					</ul>
				</div>	 

			</div>

			<div style="clear: both;text-align: center;">All copyright reserved &copy 2020 <strong>Flemard</strong></div>

		</div> 
	
	</div>


	
</div>


	<div id="mdp_admin" hidden><label>Mot de passe</label><br/><input type="text" name="" /></div>

	 <footer id="foot" style="text-align: center;margin: 3.1px;">

		<span style="background-image: url(images/bg-title-dark.png);text-shadow: 1px 1px 1px orange;border-bottom:2px solid orange;background-color: rgba(0,128,128,0.3);font-weight: bold;padding: 3px;color: white;">Design By Klein Mihks . &copy Copyright 2020 Flemard

			
			<a href="tel:+241074872120" style="color: cyan;text-decoration: none;" id="contacts">Contact .</a>
			<span style="margin: 10px;">Partenaires : AZOBE S.A.R.L, Airtel Gabon</span> 
			</span>

	</footer>	

	<div id="dial_stats" hidden >
		<div id="stat_tab" >  
			<ul>    
				<li><a href="#stat_tab-1">Les recettes</a></li>    
				<li><a href="#stat_tab-2">Rapports</a></li>     
			</ul>


			<div id="stat_tab-1">  

				<h3>recettes</h3>
			<?php	$requete = $bdd->prepare(' SELECT nom_trajet FROM trajets WHERE nom_agence = ?'); 

					$requete->execute(array($_SESSION['agence'])); 

					echo "<label>Trajet :</label>

					<select id='trajetStat'>

						<option value='trajet_confondu'>Trajets confondus</option>";

					while ( $data = $requete->fetch()) {
						
						echo "<option value='".$data['nom_trajet']."'>".$data['nom_trajet']."</option>";						
					}
					
					echo "</select>"; $requete->closeCursor(); ?>

				

				<label>Année :</label>


				<select id="anneeStat">

				<?php 


				$requeteannee = $bdd->query(' SELECT DISTINCT IF(YEAR(date_voyage) IS NULL,2020,YEAR(date_voyage)) AS annees FROM voyage WHERE nom_agence = "'.$_SESSION['agence'].'" '); 

					while($donnees = $requeteannee->fetch()){

						echo "<option value='".$donnees['annees']."'>".$donnees['annees']."</option>";

					}

				?>

			</select>  

				<div id="infostat"></div>
				<!--contenu -->  
			</div>  


			<div id="stat_tab-2">    

				<!--contenu -->  
			</div> 


		</div> 

	

	</div>


	<div hidden id="dial_aide">

		<h4>Solutions</h4>

		<br/>

		<ol>
			<li><a href="FlemAdmin.pdf" target="_blank">Guide d'utilisation</a>
				<ul>
					<li><p>Un manuel au format pdf pour une immersion complète avec l'application web.</p>
					</li>
				</ul>
			</li>


			<li><a href="https//youtube.com" target="_blank">Tutoriels utiles</a>
				<ul>
					<li><p>Des vidéos instructives pour une bonne prise en main, et cela pour chaque version présentes ou à venir.</p>
					</li>
				</ul>
			</li>

			<li><a href="tel:+24174318064" title="+24174318064">Numéro téléphonique</a>

				<ul>
					<li><p>Contacter le webmestre par téléphone pour des éventuels problèmes.</p>
					</li>
				</ul>

			</li>

			<li><a href="mailto:Kleinmoudiba@gmail.com" title="Kleinmoudiba@gmail.com">Courrier électronique</a>

				<ul>
					<li><p>Envoyer un mail,</p>
					</li>
				</ul>

			</li>

			<li><a href="sms:+24174318064?body='test'" title="+24174318064">SMS</a>

				<ul>
					<li><p>Ou envoyer un SMS, pour une réponse prompte et consise dans les délais les meilleurs.</p>
					</li>
				</ul>

			</li>
		</ol>
		

	</div>



	<div id="dialog-messagerie" hidden>
		<H1>Hello World !</H1>
	</div>

	<div hidden id="dial_qrcode">

		<div id="win" >  
			<ul>    
				<li><a href="#win-1">Via Identifiant</a></li>    
				<li><a href="#win-2">Via QR Code</a></li>
				<li><a href="#win-3">Via une Liste </a></li>     
			</ul>  
			<div id="win-1">    

				<h3>Authentification & enrégistrement par ID</h3>

				<input id="input_id" type="text" name="" placeholder="Saisir l'ID du billet" />

				<button id="butt_id">Valider</button>


				<div id="dialog_qrc">


					<div  align="center"  id="result_id">
					

				</div>

				</div>
				<!--contenu -->  
			</div>  



			<div id="win-3">

		<h4>Enrégistrement des voyageurs  du 

			<?php  $repDatejour = $bdd->query("SELECT DATE_FORMAT(CURRENT_DATE,'%W %e %M %Y') AS date_jour ");

				$date_jour = $repDatejour->fetch();

				echo $date_jour['date_jour']; ?></h4>

				<br/><br/><br/>		

				<?php


			$reponse_trajet =  ($_SESSION['membre']=='administrateur') ? $bdd->prepare(' SELECT trajet FROM trajet_region WHERE nom_agence = ? ') : $bdd->prepare(' SELECT trajet FROM trajet_region WHERE nom_agence = ? AND region = ?');

			($_SESSION['membre']=='administrateur') ? $reponse_trajet->execute(array($_SESSION['agence'])) : $reponse_trajet->execute(array($_SESSION['agence'],$_SESSION['region']));
		
				echo '<label for="">Trajet</label> :

					<select  id="trajet_voy">';

				while ($data = $reponse_trajet->fetch()) {
			

					$trajet_region = $data['trajet'];
					
					echo '<option value="'.$trajet_region.'">'.$trajet_region.'</option>';					
		}

				echo "</select>";

		  ?>

		  

		   Horaire : <select id="horaire">
			<?php	heure_agence($bdd); ?>

			</select>

			<br/><br/>	
				<div id="sectionlistevoyage" style="overflow: auto;height: 300px;"></div>
			</div>


			
			<div id="win-2" > 

				 <div class="container" id="QR-Code">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="navbar-form navbar-left">
                        <h3>Authentification & enrégistrement par QR Code</h3>
                    </div>
                    <div class="navbar-form navbar-right">
                        <select class="form-control" id="camera-select"></select>
                        <div class="form-group"><br/>
                           <!--  <input id="image-url" type="text" class="form-control" placeholder="Image url"> -->
                            <button title="Decode Image" class="btn btn-default btn-sm" id="decode-img" type="button" data-toggle="tooltip"><span class="ui-icon ui-icon-arrowthickstop-1-n "></span></button>
                            <button title="Image shoot" class="btn btn-info btn-sm disabled" id="grab-img" type="button" data-toggle="tooltip"><span class="ui-icon ui-icon-image"></span></button>
                            <button title="Play" class=" " id="play" type="button" data-toggle="tooltip"><span class="ui-icon ui-icon-play"></span></button>
                            <button title="Pause" class="btn btn-warning btn-sm" id="pause" type="button" data-toggle="tooltip"><span class="ui-icon ui-icon-pause"></span></button>
                            <button title="Stop streams" class="btn btn-danger btn-sm" id="stop" type="button" data-toggle="tooltip"><span class="ui-icon ui-icon-stop"></span></button>
                         </div>
                    </div>
                </div>
                <div class="panel-body text-center" >
                    <div class="col-md-6" >
                        <div class="well" style="position: relative;display: inline-block;float: left;">
                            <canvas width="320" height="240" id="webcodecam-canvas"></canvas>
                            <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
                            <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
                            <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
                            <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
                        </div>
                       
                    </div>
                    <div class="col-md-6">
                        <div class="thumbnail" id="result">
                            <div class="well" style="overflow: hidden;margin-left: 30px;">
                                <img width="320" height="240" id="scanned-img" src="">
                            </div>
                            <div class="caption">
                                <h3>Résultat du scan</h3>
                                <p id="scanned-QR" style="color: red;"></p>
                            	
                            	<button hidden id="voir_scan">Voir le résultat</button>

                            </div>
                        </div>
                    </div>
                </div>

			
				<div align="center" style="overflow: auto;border-radius: 2px;" id="checkmatch"></div> 
			<!--contenu -->  


			</div>  


			
		</div>



	
	</div>

<!-- <div id="l">Pensez à télécharger la liste</div>
 -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	<script type="text/javascript" src="js/filereader.js"></script>
	        <!-- Using jquery version: -->
	        
	
	<script type="text/javascript" src="js/qrcodelib.js"></script>
	<script type="text/javascript" src="js/webcodecamjquery.js"></script>
	<script type="text/javascript" src="js/mainjquery.js"></script>


</body>

		
</html>

<?php }else{

	header("Location:connexion.php");
}

