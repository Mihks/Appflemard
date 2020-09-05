<?php

session_name('flemadmin');

session_start();


// Suppression des variables de session et de la session 
$_SESSION = array();
session_destroy();

//redirection vers connexion
header('Location:connexion.php');


?>