



var mois_fr = new Array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

		var jour_fr = new Array('00','01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
		
		var date = new Date();

		var annee = date.getFullYear();

		var jour = date.getDate();

		var mois = date.getMonth();


		var date_reserve = new Date(annee,mois,jour);

		for (var i = 1; i <= 15 ; i++) {

			date_reserve = new Date(annee,mois,++jour);
			
			$("#date_reserve").append("<option>"+date_reserve.getFullYear()+"-"+mois_fr[date_reserve.getMonth()]+"-"+jour_fr[date_reserve.getDate()]+"</option>");

		}