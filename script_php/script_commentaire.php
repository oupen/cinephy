  <script src = "//cdn.tinymce.com/4/tinymce.min.js" > </script>
 <script>tinymce.init({ selector:'' });</script>
   <script>
  tinymce.init({
    selector: '#form_commentaire'
  });
  tinymce.init({
    selector: '#form_update_commentaire'
  });
  </script>
        <?php

if (session_start() AND isset($_GET['tuto']))
  {
  if (isset($_GET['delete_comment']))
    {
    $req = $bdd->prepare('DELETE FROM commentaire WHERE id_commentaire = ? AND ext_auteur_commentaire = ?');
    $req->execute(array(
      $_GET['delete_comment'],
      $_SESSION['id_utilisateur']
    ));
    $req->closeCursor();
    }

  if (isset($_GET['tuto']) AND isset($_POST['form_commentaire']) AND !empty($_POST['form_commentaire']))
    {

    // on écrit le commentaire

    date_default_timezone_set('UTC');

    // Affichage de quelque chose comme : Monday 8th of August 2005 03:12:46 PM

    $date = date("y.m.d");

    // on insert les informations de l'utilisateur,

    $req = $bdd->prepare('INSERT INTO commentaire(ext_auteur_commentaire, contenue_commentaire,date_commentaire,ext_tuto) VALUES ( ?, ?, ?,?) ');
    $req->execute(array(
      $_SESSION['id_utilisateur'],
      $_POST['form_commentaire'],
      $date,
      $_GET['tuto']
    ));
    $req->closeCursor();
    }

?>

   <?php
           // on update
        if (isset($_GET['tuto']) AND isset($_POST['form_update_commentaire'])) {

            $req = $bdd->prepare('UPDATE commentaire,tuto SET   contenue_commentaire=:contenue  WHERE ext_tuto =:idtuto   AND ext_auteur_commentaire = :idutilisateur AND id_commentaire=:idcommentaire');
            $req->execute(array(
                'idtuto' => $_GET['tuto'],
                'contenue' => $_POST['form_update_commentaire'],
                'idutilisateur' =>$_SESSION['id_utilisateur'],
                'idcommentaire' => $_GET['update_commentaire']



            ));
            $req->closeCursor();

            header('location:tuto.php?tuto='. $_GET['tuto'] . '');

        }

  // on affiche le commentaire

  $reponse = $bdd->prepare('         SELECT * 
                                            FROM tuto, commentaire, utilisateur
                                            WHERE  id_tuto = ? AND ext_tuto =  id_tuto AND ext_auteur_commentaire = id_utilisateur AND moderation_commentaire = 0
                                            ORDER BY id_commentaire
                                            DESC LIMIT 0, 60
                                 ');
  $reponse->execute(array(
    $_GET['tuto']
  ));
  if (FALSE === ($donnees = $reponse->fetch()))
    {
    echo '<h2>Pas de commentaire</h2>';
    }
    else
    {
    echo '<h2 id="commentaire">Commentaires</h2>';
    do
      {
      echo '          <hr>
                                  <div class="thumbnail">
                                         <p>écrit par : <a href="user.php?user=' . $donnees['id_utilisateur'] . '">' . $donnees['nom_utilisateur'] . '</a></p>  
                                         <p>le ' . $donnees['date_commentaire'] . '</p> 
                                         <p>' . $donnees['contenue_commentaire'] . '</p>    
                                    
                                    ';

      //   METTRE A JOUR COMMENTAIRE

      if (isset($_GET['update_comment']) AND $donnees['id_commentaire'] == $_GET['update_comment'])
        {
        $req = $bdd->prepare('SELECT * FROM commentaire WHERE id_commentaire = ? AND ext_auteur_commentaire = ?');
        $req->execute(array(
          $_GET['update_comment'],
          $_SESSION['id_utilisateur']
        ));
        while ($donnees=$req->fetch())
                    {  
      

?><form method="POST" action="tuto.php?tuto=<?php
        echo $_GET['tuto'] ?>&update_commentaire=<? echo ''.$_GET['update_comment'].'' ;?>#commentaire">
                                                                  <textarea id="form_update_commentaire" name="form_update_commentaire"><?echo''. $donnees['contenue_commentaire'].'' ;?></textarea><br />
                                                                  <input type="submit" id="submit" name="submit" value="modifier votre commentaire" class="btn btn-primary"/>
                                                       </form> <?php
                                                     }
                                                       $req->closeCursor();
        }

  


      if (session_start() AND isset($_SESSION['nom']) AND $_SESSION['id_utilisateur'] == $donnees['id_utilisateur'])
        {
        echo '
                                                            <a style="display: inline-block;
                                                width: 100px;
                                                margin: 0 auto;" href="tuto.php?tuto=' . $donnees['id_tuto'] . '&update_comment=' . $donnees['id_commentaire'] . '" class="btn btn-danger">modifier</a> 
                                                            <a style="display: inline-block;
                                                width: 100px;
                                                margin: 0 auto;"href="tuto.php?tuto=' . $donnees['id_tuto'] . '&delete_comment=' . $donnees['id_commentaire'] . '" class="btn btn-primary">supprimer</a> 

                                                                             </div>';
        }
      }

    while ($donnees = $reponse->fetch());
    }

  $reponse->closeCursor();
?>

<form method="POST" action="tuto.php?tuto=<?php
  echo $_GET['tuto'] ?>#commentaire">
                  <textarea id="form_commentaire" name="form_commentaire"></textarea><br />
                  <input type="submit" id="submit" name="submit" value="envoyer votre commentaire" class="btn btn-primary"/>
       </form>
      <?php
  if (isset($_POST['form_commentaire']) and !isset($_SESSION['nom']))
    {
    header('location:conection_inscription.php');
    }
  }

?>