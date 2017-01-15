<?php include('script_php/script_bdd.php'); 
if(session_start() AND isset($_SESSION['nom'])  AND  isset($_GET['tuto'])) {
    $reponse=$bdd->prepare('SELECT tuto.titre_tuto, tuto.id_tuto, tuto.contenu_tuto, nom_utilisateur,tuto_photo, tuto.ext_auteur, id_utilisateur,DATE_FORMAT(tuto.date_tuto, "%d/%m/%Y ") AS jour 
   FROM tuto,utilisateur
  WHERE  tuto.ext_auteur = utilisateur.id_utilisateur AND utilisateur.id_utilisateur = :idutilisateur AND id_tuto = :tuto');
                                   $reponse->execute(array(
                                   'idutilisateur' =>   $_SESSION['id_utilisateur'],
                                  'tuto' => $_GET['tuto']));
                                   if (FALSE === ($donnees = $reponse->fetch())) {
                              header('location:../index.php');

                      $reponse->closeCursor();
                            }
                            
                else {

    
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>EDITION TUTORIEL</title>
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">  
       <link rel="stylesheet" href="styles.css">

        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector: 'textarea',
                height: 800,

            });
        </script>
    </head>
    <body>

    <? if (session_start() OR isset($_SESSION['id_utilisateur'])
        OR isset($_POST['titre'])

        OR isset($_POST['mytextarea'])
        OR !empty($_POST['titre'])

        OR !empty($_POST['mytextarea'])
    ) {
        //on écrit le tuto


        function upload($index, $destination, $maxsize = FALSE, $extensions = FALSE)

        {

            //Test1: fichier correctement uploadé

            if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) return FALSE;

            //Test2: taille limite

            if ($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) return FALSE;

            //Test3: extension

            $ext = substr(strrchr($_FILES[$index]['name'], '.'), 1);
            $extention_photo = strtolower(substr(strrchr($_FILES['photo_couverture']['name'], '.'), 1));
            if ($extensions !== FALSE AND !in_array($ext, $extensions)) return FALSE;

            //Déplacement

            return move_uploaded_file($_FILES[$index]['tmp_name'], $destination);

        }

        //Créer un identifiant difficile à deviner

        $nom = md5(uniqid(rand(), true));

        //EXEMPLES
        $extention_photo = strtolower(substr(strrchr($_FILES['photo_couverture']['name'], '.'), 1));
        $upload1 = upload('photo_couverture', 'uploads/photo_couverture/' . $nom . '.' . $extention_photo, 1048576, array('png', 'jpg', 'jpeg','PNG', 'JPG', 'JPEG'));


        $nom_photo = $nom . "." . $extention_photo;

        if ($extention_photo == "") {
            $nom_photo = ".";
        }


        date_default_timezone_set('UTC');

        // Affichage de quelque chose comme : Monday 8th of August 2005 03:12:46 PM
        $date = date("y.m.d");
        // on update
        if (isset($_GET['tuto']) AND isset($_POST['titre'])) {

            $req = $bdd->prepare('UPDATE tuto SET  titre_tuto =:titre  WHERE id_tuto =:idtuto  ');
            $req->execute(array(
                'idtuto' => $_GET['tuto'],
                'titre' => $_POST['titre']


            ));
            $req->closeCursor();
            header('location:tuto.php?tuto='. $_GET['tuto'] . '');

        }
        // on update
        if (isset($_GET['tuto']) AND isset($_POST['mytextarea'])) {

            $req = $bdd->prepare('UPDATE tuto SET   contenu_tuto=:contenue  WHERE id_tuto =:idtuto  ');
            $req->execute(array(
                'idtuto' => $_GET['tuto'],
                'contenue' => $_POST['mytextarea']


            ));
            $req->closeCursor();

            header('location:tuto.php?tuto='. $_GET['tuto'] . '');

        }
            // on update
        if (isset($_GET['tuto']) AND isset($_POST['difficulte'])) {

            $req = $bdd->prepare('UPDATE tuto SET   difficulte=:difficulte  WHERE id_tuto =:idtuto  ');
            $req->execute(array(
                'idtuto' => $_GET['tuto'],
                'difficulte' => $_POST['difficulte']


            ));
            $req->closeCursor();

            header('location:tuto.php?tuto='. $_GET['tuto'] . '');

        }
            // on update
        if (isset($_GET['tuto']) AND isset($_POST['categorie'])) {

            $req = $bdd->prepare('UPDATE tuto SET   ext_categorie=:categorie  WHERE id_tuto =:idtuto  ');
            $req->execute(array(
                'idtuto' => $_GET['tuto'],
                'categorie' => $_POST['categorie']


            ));
            $req->closeCursor();

            header('location:tuto.php?tuto='. $_GET['tuto'] . '');

        }
        // on update
        if (isset($_GET['tuto']) AND isset($_FILES['photo_couverture']) AND $nom_photo!=".") {

            $req = $bdd->prepare('UPDATE tuto SET   tuto_photo=:photo  WHERE id_tuto =:idtuto  ');
            $req->execute(array(
                'idtuto' => $_GET['tuto'],
                'photo' => $nom_photo


            ));
            $req->closeCursor();

            header('location:tuto.php?tuto='. $_GET['tuto'] . '');

        }
    }

    include('header.php'); ?>
    <? $req = $bdd->prepare('SELECT tuto_moderation,tuto_photo,tuto.titre_tuto, tuto.id_tuto, tuto.contenu_tuto, nom_utilisateur, tuto.ext_auteur, id_utilisateur,DATE_FORMAT(tuto.date_tuto, "%d/%m/%Y ") AS jour 
                  FROM tuto,utilisateur
                  WHERE  tuto.id_tuto = ? AND tuto_moderation = 0 AND  nom_utilisateur= "admin"');
    $req->execute(array($_GET['tuto']));
    while ($donnees = $req->fetch())
    { ?>
    <main>
        <div class="container">
            <h1>Poster votre tuto</h1>
            <div class="thumbnail">
                <div class="form-group">
                    <form method="post" enctype="multipart/form-data" action="<? $_SERVER['PHP_SELF']?>">
                        <input type="text" id="titre" name="titre"
                               placeholder="<? echo '' . $donnees['titre_tuto'] . '' ?> "
                               value="<? echo '' . $donnees['titre_tuto'] . '' ?>" size="35px"
                               autocomplete="off" required class="form-control"/><br>
                        </select><br>
                        <label>Catégorie</label><br>
                   <select  name="categorie"  required  class="form-control">
                    <option value="1">Pré-production</option>
                    <option value="2">Realisation</option>
                    <option value="3">Post-production</option>
                  </select><br>
                   <label>Difficulté</label><br>
                  <select name="difficulte" required  class="form-control">
                    <option value="1">facile</option>
                    <option value="2">moyen</option>
                    <option value="3">dur</option>
                  </select><br>
                        <label>photo de couverture du tuto (1mo max)</label>
                        <?
                        if ($donnees['tuto_photo'] != '.') {
                            echo '<img style="opacity:0.7;width:100%;" src="uploads/photo_couverture/' . $donnees['tuto_photo'] . '" style="width:100%;" alt="photo de l\'tuto"/>';
                        } else {

                            echo '<img style="width:100%;" src="img/photo_couverture_tuto/default_photo.PNG" style="width:100%;" alt="photo de l\'tuto"/>';
                        }
                        ?>
                        <input type="file" name="photo_couverture" class="form-control"/><br>
                        <textarea id="mytextarea"
                                  name="mytextarea"><? echo '' . $donnees['contenu_tuto'] . '' ?></textarea><br>
                        <input type="submit" id="submit" name="submit" value="mettre à jour le tuto"
                               class="btn btn-primary"/>
                </div>

                <?
                }
                 $req->closeCursor();

                ?>

                </form>
            </div>
        </div>
    </main>

    <?php include('footer.php'); ?>
    </body>
    </html>
    <?php
}
}

else {
    header('location:login.php');
}
?>