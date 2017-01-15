





















































                <? if (session_start() 
        OR isset($_POST['email'])
        OR isset($_POST['description'])
        OR isset( $_POST['nomutilisateur'])
        OR isset($_POST['prenom'])
        OR isset($_FILES['photo_profil']) 
        OR isset($_SESSION['id_utilisateur'])
    ) 
                {
            //on écrit le utilisateur




            date_default_timezone_set('UTC');

            // Affichage de quelque chose comme : Monday 8th of August 2005 03:12:46 PM
            $date = date("y.m.d");
             //on update   email
            if (isset($_POST['email']) AND isset($_SESSION['id_utilisateur'])) {

                $req = $bdd->prepare('UPDATE utilisateur SET  mail =:email  WHERE id_utilisateur =:idutilisateur  ');
                $req->execute(array(
                    'idutilisateur' => $_SESSION['id_utilisateur'],
                    'email' => $_POST['email']


                ));
                $req->closeCursor();
                header('location:../account.php?name=ok');

            }
            // on update   nom utilisateur
            if (isset($_SESSION['id_utilisateur']) AND isset($_POST['nomutilisateur'])) {

                $req = $bdd->prepare('UPDATE utilisateur SET   nom_utilisateur=:nom  WHERE id_utilisateur =:idutilisateur  ');
                $req->execute(array(
                    'idutilisateur' =>$_SESSION['id_utilisateur'],
                    'nom' => $_POST['nomutilisateur']


                ));
                $req->closeCursor();
                $_SESSION['nom'] = $_POST['nomutilisateur'];
                header('location:../account.php?name=ok');

            }
            // on update   prenom utilisateur
            if (isset($_SESSION['id_utilisateur']) AND isset($_POST['nomutilisateur'])) {

                $req = $bdd->prepare('UPDATE utilisateur SET   prenom_utilisateur=:nom  WHERE id_utilisateur =:idutilisateur  ');
                $req->execute(array(
                    'idutilisateur' =>$_SESSION['id_utilisateur'],
                    'nom' => $_POST['prenom']


                ));
                $req->closeCursor();

                header('location:../account.php?name=ok');

            }
             // on update   decrption utilisateur
            if (isset($_SESSION['id_utilisateur']) AND isset($_POST['description'])) {

                $req = $bdd->prepare('UPDATE utilisateur SET   utilisateur_description=:description  WHERE id_utilisateur =:idutilisateur  ');
                $req->execute(array(
                    'idutilisateur' =>$_SESSION['id_utilisateur'],
                    'description' => $_POST['description']


                ));
                $req->closeCursor();

                header('location:../account.php?name=ok');

            }
            //  on update   photo de profil
            if (isset($_SESSION['id_utilisateur']) AND isset($_FILES['photo_profil']) AND $_FILES['photo_profil'] !="") {
                
            function upload($index, $destination, $maxsize = FALSE, $extensions = FALSE)

            {

                //Test1: fichier correctement uploadé

                if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) return FALSE;

                //Test2: taille limite

                if ($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) return FALSE;

                //Test3: extension

                $ext = substr(strrchr($_FILES[$index]['name'], '.'), 1);
                $extention_photo = strtolower(substr(strrchr($_FILES['photo_profil']['name'], '.'), 1));
                if ($extensions !== FALSE AND !in_array($ext, $extensions)) return FALSE;

                //Déplacement

                return move_uploaded_file($_FILES[$index]['tmp_name'], $destination);

            }

            //Créer un identifiant difficile à deviner

            $nom = md5(uniqid(rand(), true));

            //EXEMPLES
            $extention_photo = strtolower(substr(strrchr($_FILES['photo_profil']['name'], '.'), 1));
            $upload1 = upload('photo_profil', '../uploads/photo_profil/' . $nom . '.' . $extention_photo, 1048576, array('png', 'jpg', 'jpeg','PNG', 'JPG', 'JPEG'));


            $nom_photo = $nom . "." . $extention_photo;

            if ($extention_photo == "") {
                header('location:../account.php?name=ok');
            }

              if ($extention_photo == "png" OR  $extention_photo =="jpg"  OR   $extention_photo =="jpeg"  OR   $extention_photo == "PNG"  OR   $extention_photo =="JPG" OR   $extention_photo =="JPEG" ) {
                
              
                $req = $bdd->prepare('UPDATE utilisateur SET  profil_photo=:photo  WHERE id_utilisateur =:idutilisateur  ');
                $req->execute(array(
                    'idutilisateur' => $_SESSION['id_utilisateur'],
                    'photo' => $nom_photo


                ));
                $req->closeCursor();

                header('location:../account.php?name=ok');
            }
        }

      }