<?php 

session_name('flemadmin');

session_start();


header('Content-Type: text/html; charset=utf-8');



	include_once 'fonction.php';




$reponse = $bdd->query(" SELECT CURRENT_DATE  AS today ;");


$donnee = $reponse->fetch();

echo $donnee['today'];