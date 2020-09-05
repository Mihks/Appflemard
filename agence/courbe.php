<?php

session_name('flemadmin');

session_start();

// header ("Content-type: image/png"); 



include ("jpgraph/src/jpgraph.php");
include ("jpgraph/src/jpgraph_line.php");








$tableauAnnees = array();

$tableauNombreVentes = array();
$moisFr = array('JAN', 'FEV', 'MAR', 'AVR', 'MAI', 'JUI', 'JUL', 'AOU', 'SEP',
'OCT', 'NOV', 'DEC');




	include_once 'fonction.php';


$reponse = $bdd->prepare("SELECT

					MONTH(paiement.date_paiement) AS MOIS,
					SUM(reservation.nombre_place) AS NOMBRE_VENTE,
					SUM(paiement.montant_debite) AS PRODUIT_VENTE
					FROM paiement,reservation,transaction
					WHERE YEAR(paiement.date_paiement) = YEAR(NOW()) 

					AND reservation.id_reservation = transaction.id_reservation

					AND reservation.id_reservation = paiement.id_reservation

					AND paiement.ref_trans = transaction.ref_trans

					AND transaction.statut = 'Succes' AND reservation.nom_agence = ?

					GROUP BY MOIS");


$reponse->execute(array($_SESSION['agence']));



// Initialiser le tableau à 0 pour chaque mois ***********************

$tableauVentes2020 = array(0,0,0,0,0,0,0,0,0,0,0,0); 


while ($row_mois = $reponse->fetch()){
	$tableauVentes2020[$row_mois['MOIS']-1] = $row_mois['PRODUIT_VENTE'];
}

$reponse->closeCursor();


// $reponse1 = $bdd->query("SELECT SUM(voyage.nombre_place) AS NBRE_PLACE_TOTAL, MONTH(date_voyage) from voyage GROUP BY MONTH(date_voyage)");

//  $NBRE_PLACE_TOTAL = array();

// while ($donnees = $reponse1->fetch()) {
	
// 	$NBRE_PLACE_TOTAL = $donnees['NBRE_PLACE_TOTAL'];

// }

// $reponse1->closeCursor();

// ***********************
// Création du graphique
// ***********************
// Création du conteneur
$graph = new Graph(500,300);
// Fixer les marges
$graph->img->SetMargin(40,30,50,40);
// Mettre une image en fond
// $graph->SetBackgroundImage("jpgraph/docs/chunkhtml/images/background_type_ex4.png",BGIMG_FILLFRAME);
// Lissage sur fond blanc (évite la pixellisation)
$graph->img->SetAntiAliasing("white");

// A détailler
$graph->SetScale("textlin");
// Ajouter une ombre
$graph->SetShadow();
// Ajouter le titre du graphique
$graph->title->Set("Graphique 'courbes' : le chiffre d'affaire des ventes ".date('Y'));
// Afficher la grille de l'axe des ordonnées
$graph->ygrid->Show();
// Fixer la couleur de l'axe (bleu avec transparence : @0.7)
$graph->ygrid->SetColor('blue@0.7');
// Des tirets pour les lignes
$graph->ygrid->SetLineStyle('dashed');
// Afficher la grille de l'axe des abscisses
$graph->xgrid->Show();
// Fixer la couleur de l'axe (rouge avec transparence : @0.7)
$graph->xgrid->SetColor('red@0.7');
// Des tirets pour les lignes
$graph->xgrid->SetLineStyle('dashed');
// Apparence de la police
$graph->title->SetFont(FF_ARIAL,FS_BOLD,11);
// Créer une courbes
$courbe = new LinePlot($tableauVentes2020);
// Ajouter la courbe au conteneur
$graph->Add($courbe);
// Afficher les valeurs pour chaque point
$courbe->value->Show();

// Valeurs: Apparence de la police
$courbe->value->SetFont(FF_ARIAL,FS_NORMAL,9);
$courbe->value->SetFormat('%d');
$courbe->value->SetColor("red");


// Chaque point de la courbe ****
// Type de point
$courbe->mark->SetType(MARK_FILLEDCIRCLE);

// Couleur de remplissage
$courbe->mark->SetFillColor(array(0,128,128));


// Taille
$courbe->mark->SetWidth(5);
// Couleur de la courbe
$courbe->SetColor("blue");
$courbe->SetCenter();


// Paramétrage des axes
$graph->xaxis->title->Set("Mois");
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetTickLabels($moisFr);

// $graph->yaxis->SetTickLabels($NBRE_PLACE_TOTAL);

$graph->Stroke();


?>

