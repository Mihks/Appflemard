
<?php 
session_name("flemard");
session_start(); 

 // On écrit un cookie setcookie
// On démarre la session AVANT d'écrire du code HTML
include_once 'fonction.php';

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Voyage</title>
		<meta charset="utf-8"/>

		<meta name="viewport" content="width=device-width, initial-scale=1 ,target- densitydpi=device-dpi,maximum-scale=1.0" />
		<meta name="description" content="" />
		<meta name="keywords" content="voyage GABON" />
		<meta name="author" content="Klein Mihks" />
		<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 


        <!--[if lt IE 9]> <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> <![endif]--> 

         <!--[if lte IE 7]> <link rel="stylesheet" href="style_ie.css" /> <![endif]--> 
		<!-- Facebook and Twitter integration -->
		<meta property="og:title" content=""/>
		<meta property="og:image" content=""/>
		<meta property="og:url" content=""/>
		<meta property="og:site_name" content=""/>
		<meta property="og:description" content=""/>
		<meta name="twitter:title" content="" />
		<meta name="twitter:image" content="" />
		<meta name="twitter:url" content="" />
		<meta name="twitter:card" content="" />



		
		<link rel="stylesheet" type="text/css" href="agence/css/style.css">
		<link rel="stylesheet" type="text/css" href="agence/css/jquery-ui.structure.css">
		<link rel="stylesheet" type="text/css" href="agence/css/jquery-ui.theme.min.css">
		

	
		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		<link rel="shortcut icon" href="agence/images/flemard.jpg" />
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css' />
		
	</head>

	<body>

		<?php include_once 'agence/includes/header.php'; ?>
		
		<section>
			
		<div align='center'>
			<div class="slideshow">
			<ul>
				<li><img class="img-slide" src="agence/images/iStock-516654892-e1544537163371.jpg" alt="" /></li>
 				<li><img class="img-slide" src="agence/images/itl.cat_bus-wallpaper_2969762.png" alt=""  /></li> 
				<li><img class="img-slide" src="agence//images/iStock-516654892-e1544537163371.jpg" alt=""  /></li>
				<li><img class="img-slide" src="agence/images/téléchargé.jpg" alt="" /></li>
			</ul>
			</div>
		</div>
			<h2>Accueil</h2>

			<div class="centre-text">

				<p>Bienvenue sur votre site de réservation en ligne de billets de bus et de bateaux . Plus besoin de vous déplacer dans les agences de voyage pour une réservation. Réservez vos billets depuis chez vous et soldez via <b>Airtel Money</b> ou via <b>Mobi Cash</b> .</p>
 

				<p>Tout juste après avoir effectué votre paiement , un identifiant unique s'affiche en rouge , ce dernier contient toutes les coordonnées de votre réservation , il est à présenter à l'agence sollicitée. Ne procrastinez plus,  <b style="color: rgb(0,128,128);">Flemard</b> pointe le bout de son nez !</p>
			</div>
			
	
			<img class="img-diaspo" src="agence/images/51459340_949759081892876_3562716998855032832_n.jpg" height='200' width='250' id="imaga" />
<!-- 			<img hidden class="img-diaspo" height='200' width='250' src="agence/images/532d5cf1f3749247e6221c63fea18c3b.jpg" id="imaga">
 -->
<!-- 			<img class="img-diaspo" height='200' width='250' src="agence//images/unnamed.jpg" id="img4">
			<img class="img-diaspo" height='200' width='250' src="agence/images/FACEBOOK_RESERVATION_LIGNE.jpg" id="img3">
			<img class="img-diaspo" height='200' width='250' src="agence/images/6.png" id="img2">
			<img class="img-diaspo" height='200' width='250' src="agence/images/presentation.jpg" id="img1">	 -->

			
<!-- Start Form-->
			<h2 id="reserve">Réservation</h2>

			<div id="reservation" >

					<!-- infos personnelles-->

					<form action="traitements.php" method="POST" id="form">
							
							
						<div class="">

								
								
								<div >
									<label for="nom" class="" >Nom</label>
									<input type="text" name="nom" class="frm-control" id="nom" placeholder="ex:Mouloungui"  autocomplete="off"  required maxlength="20" minlength="5" pattern="^[A-Za-z -]+$" />
									
								</div>
								
						</div>
								
								<div>
									<label for="type_billet">Type de réservation</label>
									<select name="type_billet" id="type_billet" class="frm-control">
										<option value="Aller_simple" selected>Aller-simple</option>
										<option value="Aller_retour" >Aller-retour</option>
									</select> 

								</div>
									
								
								<div id="nbre-place" >
									<label for="nombre_billet">Nombre de place</label>
									<input  class="frm-control" type="number" id="nombre_billet" name="nombre_billet" min="1" max="10" placeholder="nombre entre 1 et 10" class="frm-control" autocomplete="off" required />
								</div>

								

								<div >
								<label for="agence">Agence</label>
								<select name="agence" id="agence"  class="frm-control">
									<option value="">Choisir votre agence</option>
									<optgroup label="Terrestre">
										<option value="excellence_transport">Excellence Transport</option>
									</optgroup>
								</select>

								</div>

							<!--excellence transport -->
							<?php include('agence/includes/excellence_transport.php'); ?>
<!--------------------------------------------------------------------------------------------------------------------------------->

				<?php		$reponse = $bdd->query(" SELECT 
										CURRENT_DATE + interval 1 DAY AS jour_1,
										CURRENT_DATE + interval 2 DAY AS jour_2 "); 
							
							$donnee = $reponse->fetch();

							$jour1 = $donnee['jour_1'];
							$jour2 = $donnee['jour_2'];

							$reponse->closeCursor();



							  ?>

							<div class="" >
								
								<div id="date_dep" >
									<label for="depart">Date de Depart</label>
									<input type="text" id="depart" name="depart" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" placeholder="aaaa-mm-jj" class="frm-control" required autocomplete="off" readonly  value='<?= strip_tags($jour1); ?>' /> <!-- une autre façon d'ecrire echo dans les versions recentes
													php est comme c ecrit dans value -->
								</div>



								<div>
									<label for="heure-depart" >Heure de Depart</label>
									<select name="heure_depart" id="heure-depart" class="frm-control">
											
										
									</select>
								</div>
								
								
								<div id="date_retour" >
									<div>
										<label for="retour">Date de Retour</label>
										<input type="text" id="retour" name="retour" placeholder="aaaa-mm-jj" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" class="frm-control" value='<?= strip_tags($jour2);?>' autocomplete="off" readonly />

									</div>

									<div>
										<label for="heure-retour" >Heure de Retour</label>
										<select name="heure_retour" id="heure-retour" class="frm-control">

										</select>	
									</div>
									
								</div>


							</div>
						
						
							<div>
									<label for="moyen_paiement">Moyen de paiement</label>
									<select name="moyen_paiement" id="moyen_paiement" class="frm-control">
										<option value="airtel" selected>Airtel Money</option>
										<option value="gabontelecom" >MobiCash</option>
									</select> 

								</div>


							
							<div style='margin-left: 30px;' id='valid' >

								<button style="border-radius: 15px;width: 100px;height: 40px;font-size: 14px;border-bottom: 1px solid orange;cursor: pointer;"  type="submit" id="envoyer" value="envoyer" >Valider</button>

								<!-- <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-ok-sign"></span> Envoyer</button> -->

							</div>
						</form>
					<!-- END Form -->
				</div>

			<p class="info"><b>Important: </b>Saisir le <strong>champ</strong> "nom" est <strong>obligatoire</strong>,celui-ci vous servira <strong>d'identifiant</strong>.<br/>Le <strong>type de réservation</strong> indique si le billet que vous sollicitez est un simple billet <strong>aller</strong> ou alors un billet <strong>aller-retour</strong> dans le cas d'un billet <strong>aller-retour</strong>,2 champs <strong>obligatoires</strong> apparaitront <strong>'Date de Retour' et' Heure de retour'</strong> .<br/><br/>Le 3e champ indique le <strong>nombre de place que vous reservez</strong>.<br/><br/><strong>Agence</strong> indique l'agence avec laquelle vous souhaitez <strong> voyager</strong>,selon le choix de cette dernière, vous serez amenés à sélectionner un <strong>trajet</strong>.<br/><br/><strong>Trajet</strong> indique le <strong>tronçon</strong> à effectuer. Les trajets disponibles, dépendent de ceux proposés par chacune des agences.<br/> <br/>Les champs <strong>Date de depart</strong> et <strong>heure de Depart</strong> indiquent <strong>respèctivemment le jour et l'heure</strong> du voyage.<br/><br/>.Pour plus <strong>d'infos ou un problème</strong> avec le <strong>formulaire n'hésitez</strong> pas à nous contacter.</p>


		</section>



		<section>
			<article>

				<div id="a_propos">


					<h2>A propos de</h2>

					<div class="centre-text">
						<p>Flemard est un service informatique indépendant <b> de mise en rélation</b> affilié à <b> AZOBE S.A.R.L</b> réconnue d’utilité publique . Son objectif fondamental est d’aider au mieux des individus au quotidien dans des secteurs d’activités variés, en apportant des solutions applicatives dynamiques et scalables . Pour débuter son action, <b>Flemard</b> se lance dans le secteur du transport en proposant une solution dans la réservation des billets. <b>Flemard</b> souhaite et est disposé à travailler en <i style="color: red;font-weight: bolder;">symbiose</i> avec tout <b>agence de voyage</b> routière et/ou maritime .</p>

						<p>Réservez vos places pour un voyage de Libreville vers l'interieur du Gabon et vise versa avec votre ordinateur, téléphones…</p>
					</div>

					<img src="agence/images/yagaC.png" id="imaga" width="200" height="200" border="1" title="Flemard" alt="Flemard"  /><sub style="font-family: chiller;color: red;">Flemard</sub>
					
				</div>
			</article>

			<article>

				<div id="contact">

					<h2>Contact</h2>

					<div class="centre-text">
						<p>Pour avoir des informations diverses notamment dans le cadre d’un partenariat, veuillez nous contacter par courriel ou par téléphone.</p>

						<p>Courriel :<a href="mailto:kleinmoudiba@gmail.com"> kleinmoudiba@gmail.com</a></p>

						<p>Tel : <a href="tel:+241 74 87 21 20"> +241 74 87 21 20</a></p>
						<p>Tel : <a href="tel:+241 77 67 37 88"> +241 77 67 37 88</a></p>

					</div>
				</div>
			</article>
		</section>

		                

		<hr/>

		<?php include('agence/includes/footer.php'); ?>

		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


		<script> 
			$(function() {
			 
			setInterval(function(){
         			$(".slideshow ul").animate({marginLeft:-350},800,function(){
            			$(this).css({marginLeft:0}).find("li:last").after($(this).find("li:first"));
         			})
      			}, 3500);
				
			$(".slogan").html("Donner un Sens à votre Flemme !").css("font-size","small").css("color","rgb(0,128,128)").css("text-decoration","underline").css("text-decoration-color","orange");

			//met une largeur de 200px à toutes les entrées du formulaire(input,textarea,button,select) sauf a l"input
			//de type submit
			//$(":input:not(input[type='submit'])").css("width","250px").css("margin-bottom","15px").css("padding","10px").css("border-radius","8px") ;

			var mois_fr = new Array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

			var jour_fr = new Array('00','01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
			
			var date = new Date();

			var annee = date.getFullYear();

			var jour = date.getDate();

			var mois = date.getMonth();

	

			


			//---CONTROLE DE SAISIE TYPE DE BILLET
//----------------------------------------------------------------------------------------
			$("#date_retour").hide();
				
			// selectionne l'element ayant l'atribut name de la valeur type_billet et applique lui
			// la methode change selon les valeurs de la l'attribut name afficher ou masquer
			// le champs date de retour

			$("[name='type_billet']").on("click change",function(e){

				//je stock dans la variable la valeur 
				//du type de billet
				//this fais reference au type de billet
				var resultat = $(this).val();

				if (resultat == 'Aller_retour') {

					$("#date_retour").fadeIn(2000,'linear');
					$("#retour").attr('required','required').prop('disabled',false);

					$("#heure-retour").prop('disabled',false);

				}
				else {
					
					$("#date_retour").fadeOut(2000,'linear');
					$("#retour").removeAttr('required').prop('disabled',true);
					$("#heure-retour").prop('disabled',true);
					
					}

				});

			 
			//---CONTROLE DE SAISIE AGENCE
//----------------------------------------------------------------------------------------
			//choix de l"agence et ses differents controles de saisies
			//du moins controles de selections

			$(".cache").hide() // tous les champs consernant les options des agences sont cachés lors du chargement de la page
			$(".a1").prop("disabled",true); //tous les champs concernant les options des agences sont disactivés lors du charchement de la page

			$(".horaire_depart,.horaire_retour").prop("disabled",true); // tous les horaires du champs heure sont desactivés au chargement de la page

			$("[type='submit']").prop("disabled",true); // le bouton d'envoie du formulaire est desactivé lors du chargement de la page


			function horaire(trajet) {
				// body...*

				var type = $('#type_billet').val();
				var depart = $('#depart').val();
				
				var agence = $("[name='agence']").val();

				if (type=='Aller_retour') {
					var retour = $('#retour').val();
					$.post('agence/horaire_retour.php',{trajet:trajet,agence:agence,date:retour},

					function(data){

						$('#heure-retour').html(data);

				});

				}
	
				$.post('horaire.php',{trajet:trajet,agence:agence,date:depart},

					function(data){

						$('#heure-depart').html(data);
						
						
				});
			}


			$('#lieu_dep_maj,#lieu_depart,#lieu_dep_akewa,#lieu_dep_transp').on("click change touch",function(){

				horaire($(this).val());
			});


			$('#depart,#type_billet,#retour').change(function(){


				var agence = $("[name='agence']").val();

				if (agence =='major') {

					horaire($('#lieu_dep_maj').val());

				}else if (agence=='transporteur'){


					horaire($('#lieu_dep_transp').val());
				
				}else if (agence=='hitu') {

					horaire($('#lieu_depart').val());
				
				}else if (agence=='akewa') {

					horaire($('#lieu_dep_akewa').val());
				
				}else if (agence=='excellence_transport') {

					horaire($('#lieu_dep_excel').val());
				
				}

				

							});


			$("[name='agence']").on("click change",function(){

				
				var agence = $(this).val();

				var type = $('#type_billet').val();

				if (agence=="major") {

					$("#destination_major").show("slow");

					$("#lieu_dep_maj").prop("disabled",false);//les champs lie à major sont activés


					(type =="Aller_retour" )? $("#horaire_rtr_maj").prop("disabled",false) :  $("#horaire_rtr_maj").prop("disabled",true); //les horaires de major sont actives
					

					$(".cache:not(#destination_major)").hide(1000);

					$(".a1:not(#lieu_dep_maj)").prop("disabled",true); //les champs des autres agence 																						//restent desactivé sauf ceux de major 
					$("[type='submit']").prop("disabled",false);

					horaire($('#lieu_dep_maj').val());

					}else if (agence=="hitu"){

					$("#destination_hitou").show("slow");
					
					$("#lieu_depart").prop("disabled",false); //mm resonnement que celui de major


					( type=='Aller_retour' )? $("#horaire_rtr_hitu").prop("disabled",false) :  $("#horaire_rtr_hitu").prop("disabled",true);

				

					$(".horaire_depart:not(#horaire_dep_hitu),.horaire_retour:not(#horaire_rtr_hitu)").prop("disabled",true);  // les horaires des autres agences sont desactivés

					$(".cache:not(#destination_hitou)").hide(1000);

					$(".a1:not(#lieu_depart)").prop("disabled",true);

					$("[type='submit']").prop("disabled",false);

					horaire($('#lieu_depart').val());

				
				} else if (agence=="akewa") {
					
					$("#destination_akewa").show("slow");
					$("#lieu_dep_akewa,#nombre_adulte,#nombre_enfant,#classe_adulte,#classe_enfant").prop("disabled",false);


					( type=='Aller_retour' )? $("#horaire_rtr_akewa").prop("disabled",false) :  $("#horaire_rtr_akewa").prop("disabled",true);


					$(".horaire_depart:not(#horaire_dep_akewa),.horaire_retour:not(#horaire_rtr_akewa)").prop("disabled",true);

					$(".cache:not(#destination_akewa)").hide(1000);
					$(".a1:not(#lieu_dep_akewa,#nombre_adulte,#nombre_enfant,#classe_adulte,#classe_enfant)").prop("disabled",true);
					$("[type='submit']").prop("disabled",false);

					horaire($('#lieu_dep_akewa').val());


				} else if (agence == "choix") {

					$(".cache").hide(1000);
					$(".a1").prop("disabled",true);

					$(".horaire_depart,.horaire_retour").prop("disabled",true);

					$("[type='submit']").prop("disabled",true);

				} else if (agence=='transporteur'){


					$("#destination_transp").show("slow");
					
					$("#lieu_dep_transp").prop("disabled",false); //mm resonnement que celui de major

					
					( type=='Aller_retour' )? $("#horaire_rtr_transp").prop("disabled",false) :  $("#horaire_rtr_transp").prop("disabled",true);

					$(".horaire_retour:not(#horaire_rtr_transp)").prop("disabled",true);  // les horaires des autres agences sont desactivés

					$(".cache:not(#destination_transp)").hide(1000);

					$(".a1:not(#lieu_dep_transp)").prop("disabled",true);

					$("[type='submit']").prop("disabled",false);

					horaire($('#lieu_dep_transp').val());

				}else if (agence=='excellence_transport'){


					$("#destination_excel_transp").show("slow");
					
					$("#lieu_dep_excel").prop("disabled",false); //mm resonnement que celui de major

					
					( type=='Aller_retour' )? $("#horaire_rtr_transp").prop("disabled",false) :  $("#horaire_rtr_transp").prop("disabled",true);

					$(".horaire_retour:not(#horaire_rtr_transp)").prop("disabled",true);  // les horaires des autres agences sont desactivés

					$(".cache:not(#destination_excel_transp)").hide(1000);

					$(".a1:not(#lieu_dep_excel)").prop("disabled",true);

					$("[type='submit']").prop("disabled",false);

					horaire($('#lieu_dep_excel').val());

				}else {

					$(".cache").hide(1000);
					$(".a1").prop("disabled",true);
					$(".horaire_depart,.horaire_retour").prop("disabled",true);
					$("[type='submit']").prop("disabled",true);
				}



				});



				// $('#agence').change(function(){

				// 	var agence = $(this).val();
					
				// 	if (agence =='akewa') {


				// 		$('#details').dialog({
				// 			modal:true,
				// 			width:340,
				// 			title:'Details',
				// 			buttons: {        
				// 			"Ok": function() { 
                 
				// 				$(this).dialog("close");
								    
				// 			}   
				// 		} });
					
				// 	}
				


				// });
				

			


  
				//AFFICHE LHEURE
//----------------------------------------------------------------------------------------

			function horloge(){

				var date = new Date();
				var h = date.getHours()+ ":"+ date.getMinutes()+ ":"+ date.getSeconds();
				$("#heure").text(h).css("color",'rgb(0,128,128)');
			}

			setInterval(horloge,1000);



		//-------------GERE LE NAV POUR PETIT ECRANS----------------------------------------------------------
//----------------------------------------------------------------------------------------
	
			
			$('#btnMenu').on('click', function(){            

				$('#nav').slideToggle();    

				});
			// $('nav a').on('click touch',function(){

			// 	$('#nav').slideToggle(); 
			// });



		//----------------INITIALISATION DE DATEPICKER-
		//METTRE LA DATE EN FR--------------------------
//----------------------------------------------------------------------------------------
			$.datepicker.regional['fr'] = {

					altField : 'Fermer',
					prevText : 'Précédent',
					nextText : 'Suivant',
					CurrentText : "Ajourd'hui",
					firstDay : 1,
					monthNames : ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aoùt', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],

					monthNamesShort : ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Aout.', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
					dayNames : ['Dimanche', 'Lundi','Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
					dayNamesShort : ['Dim.','Lun.','Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
					dayNamesMin : ['D','L','M','M', 'J', 'V','S'],
					weekHeader : 'sem.',
					dateFormat : 'yy-mm-dd',
					isRTL: false,  
					showMonthAfterYear: false,
					 yearSuffix: ''

				};

			$.datepicker.setDefaults($.datepicker.regional["fr"]);

			//----------DATEPICKER LE PLANNING DE RESERVATION SUR 2 SEMAINES
//----------------------------------------------------------------------------------------
			

			$(window).load(function(){

			var OjourD = $("#depart"),
				dateJour = new Date();

			OjourD.prop({

				"min": "+1j",
				"max": "+3j"

			}).datepicker({

				minDate : OjourD.prop("min"),
				maxDate : OjourD.prop("max"),
				dateFormat:'yy-mm-dd'
				
			});

			var retour =  $("#retour"),
				dateRetour = new Date();
			
			retour.prop({

				"min": "+2j",
				"max": "+4j"

			}).datepicker({

				minDate : retour.prop("min"),
				maxDate :retour.prop("max"),
				dateFormat:'yy-mm-dd'
				
			});
	
			$("[name='agence'],[name='type_billet']").trigger("click"); //

		});


		// var mois_fr = new Array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

		// var jour_fr = new Array('00','01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
		
		
		// var date = new Date();

		// var annee = date.getFullYear();

		// var jour = date.getDate();

		// var mois = date.getMonth();


		// // date_reserve = new Date(annee,mois,++jour);

		// // $("#depart").val(annee+'-'+mois_fr[mois]+'-'+jour);
		$("#retour").attr('placeholder','Ex:2020-03-09');

		$('#depart,#retour').focus(function(){  
			$(this).blur();

		});

		
		







	});


		
	</script>
	</body>
</html>
