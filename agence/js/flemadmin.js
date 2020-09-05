
			
$(function(){



	/////////////////////Section de definition des fonctions ......////////////////////////////////////////






function INITIALISATION_DE_DATEPICKER() {
		

			$.datepicker.regional['fr'] = {

					altField : 'Fermer',
					prevText : 'Précédent',
					nextText : 'Suivant',
					CurrentText : "Ajourd'hui",
					firstDay : 1,
					monthNames : ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],

					monthNamesShort : ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
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
	

	}



	function naviguer_entre_date_gest(date) {
				

		$('#table_gestion_place').html('<div>chargement...</div>');

		$.post('gestion_de_place.php',{'date': date},function(donnee){

		$('#table_gestion_place').html(donnee);
				
				});
			

			}


	function gestion_des_voyages() {
				

				var trajet = $('#trajet_voy').val();
				var limit = $("#limit").val();
				var date = $("#date_voy").val();
				var horaire = $("#horaire").val();
	  
				
				$('#sectiontab').html("<div id='chargement' hidden>Chargement en cours...</div>");
				$('#chargement').toggle('explode');

				$("#solde_jour").load('soldeJour.php',{'trajet':trajet, 'date':date});
				
				$("#sectiontab").load("requetes_voyage.php",{'trajet' : trajet, 'limit':limit, 'date': date, 'horaire': horaire}); //charge les requetes faites sur requetes.php

				
				$("#afficheTraj").text('Trajet'+': '+trajet).show();

				var mois_cst_fr = new Array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

				var jour_cst_fr = new Array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi');
				var date_travel = new Date(date);
				var jour_travel = date_travel.getDate();
				var mois_travel = date_travel.getMonth();
				var annee_travel = date_travel.getFullYear();
				var nom_sem_jour_travel  = date_travel.getDay();

				$("#date_de_voyage").text(jour_cst_fr[nom_sem_jour_travel]+', '+jour_travel+' '+mois_cst_fr[mois_travel]+' '+annee_travel+': Date du Voyage');



			}




	function gestion_des_statistiques() {
				
		var trajetStat =  $("#trajetStat").val();

		var anneeStat =  $("#anneeStat").val();

		$('#infostat,#stat_tab-2').html("<img src='images/wait.gif' />");

		$("#infostat").load('statistique.php',{trajetStat:trajetStat,anneeStat:anneeStat});

		$("#stat_tab-2").html("<?php echo "<img src='courbe.php' />"; ?>");

			}






	function gestion_modification_du_nombre_de_place() {
					


				$('#dial_modif_gestplace').dialog({modal:true,title:'Modifier le nombre de place',buttons:{

				'Valider': function(){

						var nombre_modif_gestplace = $('#nombre_modif_gestplace').val();
						var trajet_modif_gestplace = $('#trajet_modif_gestplace').val();
						var date_modif_gestplace = $('#date_modif_gestplace').val();
						var heure_modif_gestplace = $('#heure_modif_gestplace').val();

						$.post('modifier_place_voyage.php',{'nombre':nombre_modif_gestplace,'trajet':trajet_modif_gestplace,'date':date_modif_gestplace,'heure':heure_modif_gestplace},function(donnees){


							$('#dial_modif_gestplace').html(donnees);

							$('#dial_modif_gestplace').dialog({modal:true,title:'Modifier le nombre de place',


								open: function(){

									$(".ui-dialog-titlebar-close").hide();
								}



								,buttons :{ 


								'Fermer': function(){ 


									$(this).dialog('close');

									location.reload();
 										



 										} 


 									}   



 									});

						}); // fin de la function de post


				} //fin de valider

				} //fin de button


			}); //fin de dial_modif
			


				}










	function modifier_prix_des_trajets_de_voyage(nom_trajet_tarif) {
			

			// $('#dial_tarif').html(

		// 	"<div><h4>Veuillez saisir le mot de passe administrateur</h4></div><input type='password' id='admin_mdp'/>");

		$('#dial_tarif').dialog({modal:true,title:'Changer le prix du trançon',buttons :{
					
					'Valider': function(){

						var nouveau_trajet_tarif = $('#nouveau_trajet_tarif').val();

						var agence = $("#gestionplace").attr('class');

						nom_trajet_tarif  = (agence.match(/akewa/)) ? $('#choix_trajet_bat').val() : nom_trajet_tarif;


						var type_prix_trajet_tarif = $('#type_prix_trajet_tarif').val();


						$.post('changer_tarif.php',{"nom_trajet_tarif":nom_trajet_tarif,"nouveau_trajet_tarif":nouveau_trajet_tarif,"type_prix_trajet_tarif":type_prix_trajet_tarif},function(data){
 


								$('#dial_tarif').html(data);

								$('#dial_tarif').dialog({modal:true,title:'Changer le prix du trançon',

									open: function(){

										$(".ui-dialog-titlebar-close").hide();
										
									},buttons :{
											
											'Fermer': function(){

												$(this).dialog('close');

												location.reload();

													}
												}
													});


												

							});

						$(this).dialog('close');


							}
						}

							});

		


		}








		function changer_mdp_compte_new_mdp() {
			


			var ancien_mdp = $("#ancien_mdp").val();

			var nouveau_mdp = $("#nouveau_mdp").val();

			var confirm_mdp = $('#confirm_mdp').val();
				

			$.post('changer_mdp.php',{

				'ancien_mdp':ancien_mdp,
				'nouveau_mdp':nouveau_mdp,
				'confirm_mdp':confirm_mdp},

			function(data){

				window['message_mdp'] = data;

				if (data=='Le mot de passe saisie est incorrect !') {


					$('#ancien_mdp').css({boxShadow:'1px 1px 20px red'});


					$('#dial_mdp').text(message_mdp);


					$('#dial_mdp').dialog({modal:true,title:'Changer de mot de passe',buttons :{
					'Fermer': function(){


						$('#ancien_mdp').css({boxShadow:''});

						$(this).dialog('close');


							}
						}
							});

					
				}else if(data=='Le nouveau mot de passe et la confirmation du mot de passe doivent être identiques et comporter au moins 4 caractères ,veuillez recommencer !' ){

					$('#nouveau_mdp,#confirm_mdp').css({boxShadow:'1px 1px 20px red'});


					$('#dial_mdp').text(message_mdp);


					$('#dial_mdp').dialog({modal:true,title:'Changer de mot de passe',buttons :{
					'Fermer': function(){

						$('#nouveau_mdp,#confirm_mdp').css({boxShadow:''});

						$(this).dialog('close');

							}
						}
							});

					
				
				}else if(data=='Opération effectuée...!'){


					$('#dial_mdp').html('<b>'+message_mdp+'</b>');


					$('#dial_mdp').dialog({modal:true,title:'Changer de mot de passe',buttons :{
					'Fermer': function(){

						$(this).dialog('close');

						location.reload();

							}
						}
							});

				}else if (data =="Aucun changement a été effectué !"){

					$('#dial_mdp').text(message_mdp);


					$('#dial_mdp').dialog({modal:true,title:'Changer de mot de passe',buttons :{
					'Fermer': function(){

						$(this).dialog('close');


							}
						}
							});

				}else if (data == "Veuillez vous reconnecter...") {

					$('#dial_mdp').text(message_mdp);

					$('#dial_mdp').dialog({modal:true,title:'Changer de mot de passe',buttons :{
					'Fermer': function(){

						$(this).dialog('close');


							}
						}
							});
				

				}

				
				
		});


		$("#ancien_mdp").val('');

		$("#nouveau_mdp").val('');

		$('#confirm_mdp').val('');


		}






	function gestion_des_annulation() {


		var idAnnule = $('#idAnnule').val();
		var choixAction = $('#choixAction').val();

		if (choixAction=='annuler') {

			$('#sectiontab').html("<div id='chargement' hidden>Chargement en cours...</div>");
			$('#chargement').fadeIn();
			$('#sectiontab').load('annuler_reservation.php',{'id':idAnnule});
				
				
		}else if (choixAction=='reprogram'){

			$('#sectiontab').html("<div id='chargement' hidden>Chargement en cours...</div>");
			$('#chargement').fadeIn();
			$('#sectiontab').load('reprogramer_voyage.php',{'id':idAnnule});
			

		}else{

			alert('Erreur');
		}


			}
			

	function button_plus_gestion_des_annulation_et_reprogrammation_de_voyage() {
				
		if ($('#invisible').prop("hidden",true)) {

			$('#invisible').slideToggle();

			$('#circle-plus').toggleClass("ui-icon-circle-plus").toggleClass("ui-icon-circle-minus");

		 }else{

		   	$('#invisible').slideToggle();
	
			$('#circle-plus').toggleClass("ui-icon-circle-plus").toggleClass("ui-icon-circle-minus");
		   		}
			}





	function changer_interface_reservation_ou_voyage(val) {
				
		// var val = $(this).val();

		if (val=='reservation') {

			$('#info_reservation').toggle();
			$('#info_voyage').toggle();
				
		}else{

			$('#info_voyage').toggle();
			$('#info_reservation').toggle();
				
				}
			}



	function recherche_ID_Nom() {
				
		var id = $('#ref').val(); 

		var limit = $('#limit').val();

		$('#sectiontab').html("<div id='chargement' hidden>Chargement en cours...</div>");

		$('#chargement').fadeIn();

				
		$('#afficheTraj').text('Recherche : '+id);
				
		$('#sectiontab').load('rechercheIDNom.php',{ id: id,limit:limit});
			

		}


	function changer_mdp_compte() {
			
		
		if ($('#hidden_mdp').prop("hidden",true)) {

			$('#hidden_mdp').slideToggle();

			$('#hidden_mdp-circle-plus').toggleClass("ui-icon-circle-plus").toggleClass("ui-icon-circle-minus");



		}else{

		   	$('#hidden_mdp').slideToggle();
		   	$('#hidden_mdp-circle-plus').toggleClass("ui-icon-circle-plus").toggleClass("ui-icon-circle-minus");

		   		}
		}
	
	 
	function gestion_des_reservation() {


			var limit = $('#limit').val();
			var trajet = $('#trajet').val();

			var etat_reservation = $('#Etat').val();

			var hora = $('#hora').val();
					
			var date = $("#date_reserve").val();
			var statut = $("#statut").val();

			// $(':checkbox[name="search"]').removeAttr('checked');
 
			// $('#sectiontab').html("<div id='chargement' hidden>Chargement en cours...</div>");
			// $('#chargement').toggle('explode');

			$("#solde_jour").load('soldeJour.php',{'trajet':trajet, 'date':date});
			
			$("#sectiontab").load("requetes.php",{'trajet' : trajet, 'limit':limit, 'date': date, 'statut': statut,'etat_reservation':etat_reservation,'hora':hora}); //charge les requetes faites sur requetes.php

			
			$("#afficheTraj").text('Trajet'+': '+trajet).show();

			var mois_cst_fr = new Array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');

			var jour_cst_fr = new Array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi');
			var date_travel = new Date(date);
			var jour_travel = date_travel.getDate();
			var mois_travel = date_travel.getMonth();
			var annee_travel = date_travel.getFullYear();
			var nom_sem_jour_travel  = date_travel.getDay();

			$("#date_de_voyage").text(jour_cst_fr[nom_sem_jour_travel]+', '+jour_travel+' '+mois_cst_fr[mois_travel]+' '+annee_travel+': Date du Voyage');

			// $("#reserv").html('<font size="4">chargement...</font>');
			nombre_place_reservees();		


			// $("#dispo").html('<font size="4">chargement...</font>');
			nombre_place_dispo();
		}



	 function nombre_place_reservees() {

		$("#reserv").load('gestionplace.php',{'trajet':$('#trajet').val(),'date':$('#date_reserve').val(),'hora':$('#hora').val()});		

	 }


	 function nombre_place_dispo() {

	 	// $("#dispo").html('<font size="4">chargement...</font>');
		$("#dispo").load('essai.php',{'trajet':$('#trajet').val(),'date':$('#date_reserve').val(),'hora':$('#hora').val()});
		
	 }

	setInterval(function() {
		nombre_place_reservees();
		nombre_place_dispo();
		// gestion_des_reservation();
	
		

	}, 2000);






///////////////////////////////////////fin des declaration des fonctions/////////////////////////////////////////////////////////////////
	






///////////////////////////////Section des instantations......./////////////////////////////////////


//////////////////////dialog aide...........//////////////////////

$('#aide').click(function(){


	$('#dial_aide').dialog({modal:true,title:'Aide',height:'500',width:'500',buttons:{'Fermer':function(){$(this).dialog('close');}}});


});

	
	//////////////////////////////



	 $("#lien_qrcode").click(function(){

	 	$('#dial_qrcode').dialog({modal:true,title:'Enrégistrement',height:'510',width:'800',buttons:{'Fermer':function(){$(this).dialog('close');}}});
	 });


	///////////////les tabs de l'app ......????///////////////////////////

	$('#win,#onglets,#dial_stats').tabs();

///////////////////////////////////////

	$('#butt_id').click(function(){

		var input_id = $('#input_id').val();
		$('#result_id').html('Chargement...');
		$('#result_id').load('qrc',{id:input_id});
	});

	/////////////////////////////changer de mot de passe.....///////////////////::


	$('#hidden_mdp-circle-plus').click(function(){

		changer_mdp_compte();

		});

		
	$('#execute_mdp').click(function(){


		changer_mdp_compte_new_mdp();
		

			}); 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	

	


////////////////////:::changer les prixs des trajets ....../////////////////////////////

	$('td a,#modif_prix_trajet_bat').on('click',function(){ 

		window['nom_trajet_tarif'] = $(this).attr('id');

		modifier_prix_des_trajets_de_voyage(nom_trajet_tarif);

	});

	


	////////////////:la transition du menu ......///////////

	$("#btnMenu").click(function(){

		 $('#menu').toggle('slide',{direction:'left'},1000);

		 // $('body').append('<div class="shade"></div>'); 

		 // $('.shade').css('opacity', 0.7).fadeIn(); 

	});

	


	$("#flemAdmin").show("explode",5000);





	/////////////////Recherche/////////////////////



		$('#action').click(function() {   

			recherche_ID_Nom(); 

			 }); 



		//changer d'interface reservation ou voyage
		$('#choixInfo').change(function(){

			changer_interface_reservation_ou_voyage($(this).val());

		});


		
		
////////////...............la gestion des reservation........///////////////////////////////////////////////////////

		$("#trajet,#date_reserve,#statut,#Etat,#hora").on("change touch",function(){ 

			$("#reserv").html('<font size="4">chargement...</font>');
			$("#dispo").html('<font size="4">chargement...</font>');

			$('#sectiontab').html("<div id='chargement' hidden>Chargement en cours...</div>");
			$('#chargement').toggle('explode');

			gestion_des_reservation();

			});

/////////////////////////////////////////////////////////////////////////////

		//gestion des annulation et reprogrammation de voyage
		
		$('#circle-plus').click(function(){

			
			button_plus_gestion_des_annulation_et_reprogrammation_de_voyage();

		});


		//////gestion Annulation

		$('#butnAnnule').click(function(){


			gestion_des_annulation();

		});

		$('#choixAction').change(function(){

			$('#label_change').text('Identifiant');
			$('#span_change').html("<input type='text' id='idAnnule' autocomplete='off'>");
				
		});



		//gestion voyage
		$("#trajet_voy,#date_voy,#horaire").on("change touch",function(){ //#choixInfo

			gestion_des_voyages();

			
			});


	
			

			$(window).load(function(){


					//----------------INITIALISATION DE DATEPICKER-
		//METTRE LA DATE EN FR--------------------------
//----------------------------------------------------------------------------------------

			INITIALISATION_DE_DATEPICKER();
			



				gestion_des_reservation();


				naviguer_entre_date_gest($('#date_gest').val());




			//----------DATEPICKER LE PLANNING DE RESERVATION SUR 3 à 4 JOURS
//----------------------------------------------------------------------------------------
				var OjourD = $("#date_reserve,#date_gest"),
					dateJour = new Date();

				OjourD.prop({

					"max": "+4j"

				}).datepicker({

					maxDate : OjourD.prop("max"),
					dateFormat:'yy-mm-dd'
					
				});




				var date_modif_gestplace =  $("#date_modif_gestplace"),
					date_modif = new Date();
				
				date_modif_gestplace.prop({

					"min": "+0j",
					"max": "+14j"
				}).datepicker({

					minDate : date_modif_gestplace.prop("min"),
					maxDate :date_modif_gestplace.prop("max"),
					dateFormat:'yy-mm-dd'
					
				});




				var date_voy =  $("#date_voy"),
					dateVoyage = new Date();
				
				date_voy.prop({

					"min": "+0j",
					"max": "+0j"

				}).datepicker({

					minDate : date_voy.prop("min"),
					maxDate :date_voy.prop("max"),
					dateFormat:'yy-mm-dd'
					
				});

		});


		var mois_fr = new Array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

		var jour_fr = new Array('00','01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');

		var mois_cfr = new Array('Janv', 'Fév', 'Mars', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc');
		
		var date = new Date();

		var annee = date.getFullYear();

		var jour = date.getDate();

		var mois = date.getMonth();



		$("#date_reserve,#date_voy,#date_modif_gestplace,#date_gest").val(annee+'-'+mois_fr[mois]+'-'+jour_fr[jour]);

		$('#date_reserve,#date_voy,#date_gest,#date_modif_gestplace').focus(function(){  
			$(this).blur();

		});


/////////////////////////////////////////gestion de place//////////////////////////////////
		


		$("#gestionplace").click(function(){


			var agence = $('#gestionplace').attr('class');


			$("#dialog").dialog({modal:true,title:'Paramètres - '+agence,height:'510',width:'800',buttons:{

				'Fermer': function(){

					$(this).dialog("close");
				}

			}});


			naviguer_entre_date_gest($('#date_gest').val());

		
				
		});




	///////gestion de modification de nombre de places////////////////////

		$("#lien_modif_gestplace").click(gestion_modification_du_nombre_de_place); //fin de lien_modif



		////////date de navigation entre les differentes dates de gestion de places....////////////////
		

		$("#date_gest").change(function(){

			naviguer_entre_date_gest($(this).val());

		});





//////////////////////////////////////Statistique////////////////////////////////


		/////////////////////:click bour obtenir le dialog des stats (son interface)/////////////

		$("#stats").click(function(){


			$('#dial_stats').dialog({modal:true,title:'Statistique',height:'510',width:'800',buttons:{'Fermer':function(){$(this).dialog('close');}}});

			gestion_des_statistiques();

		});



		////////////GESTION DES STATISTIQUES//////////////////

		$("#trajetStat").change(function(){

			gestion_des_statistiques();

		});



////////////////////////////////////////////////////////////////////////////////



	}); 
		