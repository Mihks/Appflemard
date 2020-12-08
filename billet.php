<?php
include_once('agence/phpqrcode/qrlib.php');
header ("Content-type: image/jpeg");

$destination = imagecreatefromjpeg("agence/images/billet.jpg");

include_once'fonction.php';


$id = uniqid();


QRcode::png($id,'codeqr.png','M',4,2);

$noir = imagecolorallocate($destination, 0, 0, 0);
    
$red = imagecolorallocate($destination, 128, 0, 0);

            



 if (!file_exists("codeqr.png")){
                   echo '<h2>Erreur création du fichier QRcode</h2>';
                    exit; // pas les droits en écriture ?
                    }


 $source = imagecreatefrompng('codeqr.png');

 imagestring($destination, 4, 210,31,'Major Transport', $noir); // Agence

 imagestring($destination, 4, 510, 31,$id, $red); // ID Unique

 imagestring($destination, 4, 215, 123,'13/06/2021' , $noir); // Date voyage

  imagestring($destination, 4, 215, 155, '13:30', $noir); // heure

    imagestring($destination, 4, 215, 188,'Libreville-Oyem', $noir); // Trajet
        
    imagestring($destination, 4, 245, 221, "45mgkk548", $noir); // ref trans

     imagestring($destination, 4, 510, 350, 'Aller simple', $noir); // type reservation

     imagestring($destination, 4, 195, 350, 'Moudiba IV', $noir); // type reservation


 imagecopymerge($destination,$source, 900, 152, 0, 0, 100, 100, 60); //PERMET DE FUSIONER LES IMAGES



imagejpeg($destination);
