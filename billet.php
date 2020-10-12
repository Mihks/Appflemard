<?php
header ("Content-type: image/png"); // 1 : on indique qu'on va envoyer une image PNG
$image = imagecreate(200,50); // 2 : on crée une nouvelle image de taille 200 x 50
// 3 : on s'amuse avec notre image (on va apprendre à le faire)
imagepng($image); // 4 : on a fini de faire joujou, on demande à afficher l'image
?>
