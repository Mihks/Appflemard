
			$(function() {

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

			$("[name='agence']").on("click change touch",function(){

				
				var agence = $(this).val();

				if (agence=="major") {

					$("#destination_major").show("slow");

					$("#lieu_dep_maj").prop("disabled",false);//les champs lie à major sont activés

					$("#horaire_dep_maj,#horaire_rtr_maj").prop("disabled",false); //les horaires de major sont actives
					
					$("[id='h1_dep_maj'],[id='h1_rtr_maj']").prop('selected',true); // les horaires de major sont delectionnées
					$(".horaire_depart:not(#horaire_dep_maj),.horaire_retour:not(#horaire_rtr_maj)").prop("disabled",true); //les horaires des autres agences sont desactivés

					$(".cache:not(#destination_major)").hide(1000);

					$(".a1:not(#lieu_dep_maj)").prop("disabled",true); //les champs des autres agence 																						//restent desactivé sauf ceux de major 
					$("[type='submit']").prop("disabled",false);

					}
				
				else if (agence=="hitu"){

					$("#destination_hitou").show("slow");
					$("#lieu_depart").prop("disabled",false); //mm resonnement que celui de major

					$("#horaire_dep_hitu,#horaire_rtr_hitu").prop("disabled",false);

					$("[id='h1_dep_hitu'],[id='h1_rtr_hitu']").prop('selected',true);

					$(".horaire_depart:not(#horaire_dep_hitu),.horaire_retour:not(#horaire_rtr_hitu)").prop("disabled",true);  // les horaires des autres agences sont desactivés

					$(".cache:not(#destination_hitou)").hide(1000);

					$(".a1:not(#lieu_depart)").prop("disabled",true);

					$("[type='submit']").prop("disabled",false);

				
				} else if (agence=="akewa") {
					
					$("#destination_akewa").show("slow");
					$("#lieu_dep_akewa,#nombre_adulte,#nombre_enfant,#classe_adulte,#classe_enfant").prop("disabled",false);

					$("#horaire_dep_akewa,#horaire_rtr_akewa").prop("disabled",false);

					$("[id='h1_dep_akewa'],[id='h1_rtr_akewa']").prop('selected',true);

					$(".horaire_depart:not(#horaire_dep_akewa),.horaire_retour:not(#horaire_rtr_akewa)").prop("disabled",true);

					$(".cache:not(#destination_akewa)").hide(1000);
					$(".a1:not(#lieu_dep_akewa,#nombre_adulte,#nombre_enfant,#classe_adulte,#classe_enfant)").prop("disabled",true);
					$("[type='submit']").prop("disabled",false);


				} else if (agence == "choix") {

					$(".cache").hide(1000);
					$(".a1").prop("disabled",true);

					$(".horaire_depart,.horaire_retour").prop("disabled",true);

					$("[type='submit']").prop("disabled",true);

				} else {

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
	
			
			$('#btnMenu').on('click touch', function(){            

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


		