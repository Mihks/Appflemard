<?php
echo "Vous avez PHP ".phpversion();
$gd_info = gd_info();
if(!$gd_info)
    die("<br />La bibliothèque GD n'est pas installée !");

echo "<br />Vous avez GD {$gd_info['GD Version']}";
?>
