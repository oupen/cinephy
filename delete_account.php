 <?php include('script_php/script_bdd.php'); ?>               

 <?php if(session_start() AND isset($_SESSION['id_utilisateur'] ))
 {
  ?>					
  <!DOCTYPE html>
  <html>
  <head>
    <title>supression compte</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>								
    <?php include('header.php'); ?>	

    <main>
     <div class="container"> 

      <h1>ÊTES VOUS SUR DE VOULOIR SUPRIMER VOTRE COMPTE</h1>
      
      <div class="thumbnail">
        <P>Tous les tutos que vous aurrez publier seront effacés.</P>
        <a href="delete_account.php?choix=oui" class="btn btn-danger" role="button">Oui je veux suprimer mon compte</a>
        <a href="delete_account.php?choix=non" class="btn btn-primary" role="button">Non, je ne souhaite pas</a>
      </div>
    </div>
    <?php
    if (($_GET['choix'])=="non") {
      header('location:index.php'); 
    }
    elseif (($_GET['choix'])=="oui") {
     $req = $bdd->prepare('DELETE FROM tuto WHERE ext_auteur = ?');
     $req->execute(array(
      $_SESSION['id_utilisateur']
      
      
      ));
     $req->closeCursor();
     $req = $bdd->prepare('DELETE FROM commentaire WHERE ext_auteur_commentaire = ?');
     $req->execute(array(
      $_SESSION['id_utilisateur']
      
      
      ));
     $req->closeCursor();
     $req = $bdd->prepare('DELETE FROM utilisateur WHERE id_utilisateur = ?');
     $req->execute(array(
      $_SESSION['id_utilisateur']
      
      
      ));
     $req->closeCursor();      
     header('location:script_php/script_deconection.php');  
   }
   ?>
 </main>
 <?php include('footer.php'); ?>
</body>	
</html>
<?
}
else{
  echo 'probleme !!!!';
}
?>