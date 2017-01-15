<?php include('script_php/script_bdd.php'); ?>								

<?php if(session_start() AND isset($_SESSION['nom'] ))
{
?>
<!DOCTYPE html>
<html>
  <head>
    <title>CINEPHY</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">

 
  </head>
  <body>								
                <?php include('header.php'); ?>	
   
	     <main>
          <div class="container"> 
              <h1>Poster votre tuto</h1>
             <div class="thumbnail"> 
             <div class="form-group">
              <form method="post" enctype="multipart/form-data" width="110px" height="97px">
                  <input type="text" id="titre" name="titre" placeholder="titre article"size="35px" autocomplete="off" required   class="form-control"/><br/>
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
                  <label>photo de couverture du tuto</label>
                       <input type="file" name="photo_couverture"  class="form-control" /><br>
                       <textarea id="mytextarea" name="mytextarea"></textarea><br>
                  <input type="submit" id="submit" name="submit" value="Poster le tutoriel" class="btn btn-primary"/>
                </div>

            <?     
        


  if(                                      !empty($_POST['titre'])
                                       or !empty($_POST['categorie'])
                                       or !empty($_POST['difficulte'])
                                       or !empty($_POST['mytextarea'])) {
            echo "vous n' avez pas tous remplis !";
      }

             if (session_start() AND isset($_SESSION['id_utilisateur'] ) 
                                        AND isset($_POST['titre'])
                                        AND isset($_POST['categorie'])
                                        AND isset($_POST['difficulte'])
                                        AND isset($_POST['mytextarea'])
                                        AND    !empty($_POST['titre'])
                                        AND!empty($_POST['categorie'])
                                        AND !empty($_POST['difficulte'])
                                        AND !empty($_POST['mytextarea'])
                                        ) {
            //on écrit le tuto



             
               
             

                function upload($index,$destination,$maxsize=FALSE,$extensions=FALSE)

                {

                   //Test1: fichier correctement uploadé

                     if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) return FALSE;

                   //Test2: taille limite

                     if ($maxsize !== FALSE AND $_FILES[$index]['size'] > $maxsize) return FALSE;

                   //Test3: extension

                     $ext = substr(strrchr($_FILES[$index]['name'],'.'),1);
                      $extention_photo = strtolower(  substr(  strrchr($_FILES['photo_couverture']['name'], '.')  ,1)  );
                     if ($extensions !== FALSE AND !in_array($ext,$extensions)) return FALSE;

                   //Déplacement

                     return move_uploaded_file($_FILES[$index]['tmp_name'],$destination);

                }
                
                  //Créer un identifiant difficile à deviner

                 $nom = md5(uniqid(rand(), true));

                //EXEMPLES
                 $extention_photo = strtolower(  substr(  strrchr($_FILES['photo_couverture']['name'], '.')  ,1)  );
                  $upload1 = upload('photo_couverture','uploads/photo_couverture/'.$nom.'.'.$extention_photo,1048576, array('png','jpg','jpeg') );

                       
                        $nom_photo    =   $nom  .".". $extention_photo;
            
                  if ($extention_photo == "") {
$nom_photo  =".";            
     }
    

            date_default_timezone_set('UTC');


                                                        // Affichage de quelque chose comme : Monday 8th of August 2005 03:12:46 PM
                                                        $date = date("y.m.d");
                                        
                                                //on insert les informations de l'utilisateur,
                            $req = $bdd->prepare('INSERT INTO tuto(ext_auteur, titre_tuto,contenu_tuto,  ext_categorie,difficulte,date_tuto,tuto_photo) VALUES ( ?, ?, ?, ? , ?, ? , ?) ');
                            $req->execute(array(
                                        $_SESSION['id_utilisateur'] ,
                                        $_POST['titre'],
                                        $_POST['mytextarea'],
                                        $_POST['categorie'],
                                        $_POST['difficulte'],
                                        $date,
                                        $nom_photo
                              
                              ));
                            $req->closeCursor();

                             // selection  de l id du tuto

                        $req->closeCursor();        
                        $req= $bdd->prepare('SELECT titre_tuto,id_tuto FROM tuto WHERE titre_tuto = ?');
                        $req->execute(array($_POST[ 'titre' ] ));
                                                         while ($donnees = $req->fetch())
                                                        { 
                              $tuto_id = $donnees['id_tuto'] ;            
                              }
                          $req->closeCursor();            
                             //rediriger vers la page du tuto
                            header('location:tuto.php?tuto='.$tuto_id .'');
      }
    ?>
              </form>

             </div> 
           </div>                  		 
	     </main>

	         	     <?php include('footer.php'); ?>
                    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' ,  height : "480"
,plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample'
  ],
  toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample' });</script>
  
  </script>
  </body>	
</html>
<?php 
}
else {
   header('location:login.php');
}
?>