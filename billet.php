<?php

include_once('agence/phpqrcode/qrlib.php');
header ("Content-type: image/jpeg");

$destination = imagecreatefromjpeg("agence/images/billet.jpg");


QRcode::png($id,'codeqr.png','M',4,2);

$noir = imagecolorallocate($destination, 0, 0, 0);
    
$red = imagecolorallocate($destination, 128, 0, 0);

            



 if (!file_exists("codeqr.png")){
                   echo '<h2>Erreur création du fichier QRcode</h2>';
                    exit; // pas les droits en écriture ?
                    }


 $source = imagecreatefrompng('codeqr.png');

 imagestring($destination, 4, 210,31,$_SESSION['agence'], $noir); // Agence

 imagestring($destination, 4, 510, 31,$_SESSION['id'], $red); // ID Unique

 imagestring($destination, 4, 215, 123,$_SESSION['date_voyage'], $noir); // Date voyage

  imagestring($destination, 4, 215, 155,$_SESSION['heure'], $noir); // heure

    imagestring($destination, 4, 215, 188,$_SESSION['trajet'], $noir); // Trajet
        
    imagestring($destination, 4, 245, 221, $_SESSION['ref_trans'], $noir); // ref trans

     imagestring($destination, 4, 510, 350, $_SESSION['type'], $noir); // type reservation

     imagestring($destination, 4, 195, 350, $_SESSION['nom'], $noir); // nom


 imagecopymerge($destination,$source, 900, 152, 0, 0, 100, 100, 60); //PERMET DE FUSIONER LES IMAGES



imagejpeg($destination);
