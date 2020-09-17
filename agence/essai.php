<?php 

session_name('flemadmin');

session_start();

include_once 'fonction.php';



$trajet = $_POST['trajet'];

$date_depart = $_POST['date'];

$heure_depart = $_POST['hora'];

 
 if (isset($_SESSION['agence']) && !empty($_SESSION['agence']) && isset($trajet) && !empty($trajet) && isset($date_depart) && !empty($date_depart) && isset($heure_depart) && !empty($heure_depart)) {
 	
 	
	  if (preg_match('#trajet_confondu#', $trajet)){
	  
	  	
	  	$reponse = $bdd->prepare(" SELECT SUM(nombre_place_dispo) AS nombre_place_dispo FROM voyage WHERE nom_agence = ? AND date_voyage = ? AND horaire = ?  ");

		$reponse->execute(array($_SESSION["agence"],$date_depart,$heure_depart));

		$donnees = $reponse->fetch();

// 		$reponse->closeCursor();
		
		if ($donnees['nombre_place_dispo']=='') {
               
             	    echo "0";
            
          	}else{
			
		   $place_aller_dispo = $donnees['nombre_place_dispo'];
          
              	    echo $place_aller_dispo;
            
              }

	  
	  
	  
	  }else{
	

		$reponse = $bdd->prepare(" SELECT nombre_place_dispo FROM voyage WHERE nom_agence = ? AND date_voyage = ? AND nom_trajet = ? AND horaire = ?  ");

		$reponse->execute(array($_SESSION["agence"],$date_depart,$trajet,$heure_depart));

		$donnees = $reponse->fetch();

		
// 		$reponse->closeCursor();
		
		if ($donnees['nombre_place_dispo']=='') {
               
             	    echo "0";
            
          	}else{
			
		   $place_aller_dispo = $donnees['nombre_place_dispo'];
          
              	    echo $place_aller_dispo;
            
              }
		
	  
	  }
	 //////////////////////////
	 
//  	$rep = $bdd->prepare("SELECT place_dispo(:date_voyage,:trajet,:nom_agence,:heure) ");

// 	$rep->execute(array('date_voyage' => $date_depart,'trajet' => $trajet,'nom_agence' => $_SESSION['agence'],'heure' => $heure_depart));


// 	$donnee = $rep->fetch();

// 	echo $donnee[0];

// 	$rep->closeCursor();


}else{

	echo  "...";
}
