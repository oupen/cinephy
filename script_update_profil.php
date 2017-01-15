 <?   function upload($index,$destination,$maxsize=FALSE,$extensions=FALSE)

                {

                   //Test1: fichier correctement uploadé

                     if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) return FALSE;

                   //Test2: taille limite

                     if ($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) return FALSE;

                   //Test3: extension

                     $ext = substr(strrchr($_FILES[$index]['name'],'.'),1);
                      $extention_photo = strtolower(  substr(  strrchr($_FILES['photo_profil']['name'], '.')  ,1)  );
                     if ($extensions !== FALSE AND !in_array($ext,$extensions)) return FALSE;

                   //Déplacement

                     return move_uploaded_file($_FILES[$index]['tmp_name'],$destination);

                }
                
                  //Créer un identifiant difficile à deviner

                 $nom = md5(uniqid(rand(), true));

                //EXEMPLES
                 $extention_photo = strtolower(  substr(  strrchr($_FILES['photo_profil']['name'], '.')  ,1)  );
                 $upload1 = upload('photo_profil','uploads/photo_profil/'.$nom.'.'.$extention_photo,19048576, array('png','jpg','jpeg') );

                 $nom_photo    =   $nom  .".". $extention_photo;
            
                  if ($extention_photo == "" AND !isset($_SESSION['profil_photo'])) {
                  $nom_photo  ="";            
                   }
        
                        //on  met a jour les information
		        		$req = $bdd->prepare('UPDATE usere SET nom_usere =:nom , mail =:email , prenom_usere =:prenom ,  usere_description =:description , profil_photo =:photo WHERE id_usere =:usere  ');
		        		$req->execute(array(
		        			'email' => $_POST['email'],
		        			'prenom' => $_POST['prenom'],
		        			'nom' => $_POST['nomutilisateur'],
		        			'description' => $_POST['description'],
		        			'usere' => $_SESSION['id_usere'],
		        			'photo' => $nom_photo

		        			));

		        		$_SESSION['nom']=$_POST['nomutilisateur'];
		        		$_SESSION['profil_photo'] =$nom_photo;
		        		$req->closeCursor();
		        		header('location:user.php?name=ok');
                ?>