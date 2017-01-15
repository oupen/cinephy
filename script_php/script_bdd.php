<?php

/* 
connection sécurisé base de données
*/
try

{
// on se log à la base de donnée 
  $bdd = new PDO('mysql:host=localhost;dbname=cinephy;charset=utf8', 'root', '');
}

catch (Exception $e)

{

  die('Erreur : ' . $e->getMessage());

}  

?>