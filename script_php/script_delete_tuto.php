<?php
ini_set('display_errors',1);
 if(session_start() AND isset($_SESSION['nom'] ))
{

 include('script_bdd.php');
 $reponse=$bdd->prepare('SELECT tuto.titre_tuto, tuto.id_tuto, tuto.contenu_tuto, nom_utilisateur,tuto_photo, tuto.ext_auteur, id_utilisateur,DATE_FORMAT(tuto.date_tuto, "%d/%m/%Y ") AS jour 
   FROM tuto,utilisateur
  WHERE  tuto.ext_auteur = utilisateur.id_utilisateur AND utilisateur.id_utilisateur = :idutilisateur AND id_tuto = :tuto');
				                   $reponse->execute(array(
				                   'idutilisateur' =>	$_SESSION['id_utilisateur'],
				                  'tuto' => $_GET['tuto']));
				                   if (FALSE === ($donnees = $reponse->fetch())) {
                              header('location:../index.php');

                      $reponse->closeCursor();
							}


                

else{
	if (isset($_GET['tuto'])) {
    $req = $bdd->prepare('DELETE FROM tuto WHERE id_tuto  = ?');
    $req->execute(array(
          $_GET['tuto']
    ));
    $req->closeCursor();
  header('location:../index.php');
}
}
 
}
else
{
    header('location:../index.php');
}
?>
