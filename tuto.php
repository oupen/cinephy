
   <?php 
   ini_set('display_errors',1);
   include('script_php/script_bdd.php'); ?>                                
   <? $req=$bdd->prepare('SELECT nom_categorie,id_categorie,difficulte,profil_photo,tuto_photo,tuto.titre_tuto, tuto.id_tuto, tuto.contenu_tuto, nom_utilisateur, tuto.ext_auteur,ext_categorie, id_utilisateur,DATE_FORMAT(tuto.date_tuto, "%d/%m/%Y ") AS jour 
                    FROM tuto,utilisateur,categorie 
                    WHERE categorie.id_categorie = tuto.ext_categorie AND tuto.ext_auteur = utilisateur.id_utilisateur AND tuto.id_tuto = ? AND tuto_moderation = 0 ');
                     $req->execute(array($_GET['tuto']));
                    while ($donnees=$req->fetch())
                    {  ?>

  <!DOCTYPE html>
  <html lang="fr">
    <head>
                     <title><?php echo ''.htmlspecialchars($donnees['titre_tuto']).'';?></title>
                      <!-- Bootstrap -->
      <link href="css/bootstrap.min.css" rel="stylesheet">
       <link rel="stylesheet" href="styles.css">

    </head>
    <body>                                
                  <?php include('header.php'); ?>    

               <main>
                      

                    <?
                    $nom_utilisateur =$donnees['id_utilisateur'];
                       // like
                    if ($_GET['like']=="ok") {
                          $req = $bdd->prepare('INSERT INTO tuto_like(number_tuto_like, utilisateur_like) VALUES ( ?, ?) ');
                            $req->execute(array(
                                        $_GET['tuto'] ,
                                        $_SESSION['id_utilisateur']

                              ));
                            $req->closeCursor();
                    }
                   elseif ($_GET['like']=="dislike") {
                     $req = $bdd->prepare('DELETE FROM tuto_like WHERE  utilisateur_like   = ? AND number_tuto_like = ?');
                      $req->execute(array(
                            $_SESSION['id_utilisateur'],
                                        $_GET['tuto'] 

                      ));
                      $req->closeCursor();
                   }
                           // follow
                    if ($_GET['follow']=="ok") {
                          $req = $bdd->prepare('INSERT INTO abonnement(utilisateur_suivie, utilisateur_suiveur) VALUES ( ?, ?) ');
                            $req->execute(array(
                                         $nom_utilisateur  ,
                                        $_SESSION['id_utilisateur']

                              ));
                            $req->closeCursor();
                    }
                   elseif ($_GET['follow']=="unfolow") {
                     $req = $bdd->prepare('DELETE FROM abonnement WHERE  utilisateur_suiveur   = ? AND utilisateur_suivie = ?');
                      $req->execute(array(
                            $_SESSION['id_utilisateur'],
                             $nom_utilisateur
                      ));
                      $req->closeCursor();
                   }
                       // difficulte
                 if ($donnees['difficulte'] == 1) {
                    $difficulte = "facile";
                 }
                 elseif ($donnees['difficulte'] == 2) {
                     $difficulte = "moyen";
                 }
                 elseif ($donnees['difficulte'] == 3) {
                     $difficulte = "difficile"; 
                 }
                      
                      if ($donnees['tuto_photo'] !='.') {
                                  ?>
                                  <div class="image_couverture_tuto" style="width:100%;height:502px;background: url('uploads/photo_couverture/<? echo $donnees['tuto_photo']?>') no-repeat center center fixed; 
                                                    -webkit-background-size: cover;
                                                    -moz-background-size: cover;
                                                    -o-background-size: cover;
                                                    background-size: cover;"></div>
                               <? }
                                 else{ ?> 
                                  <div class="image_couverture_tuto" style="background-size: cover;opacity:0.7;width:100%;height:402px;background:url('img/photo_couverture_article/default_photo.PNG') no-repeat fixed center;background-size: cover;"></div>
                               <?  
                                }
                                  ?>
                            
                <div class="head-tuto"> 
                  <div class="container">
                     <div class="row">
                       <div class="col-sm-6 col-md-4">
                          <h1>
                          <a href="tuto.php?tuto='.htmlspecialchars($donnees['id_tuto']).'"><? echo ''.htmlspecialchars($donnees['titre_tuto']).'' ?></a>
                          </h1>
                          <h4>catégorie <br><strong><? echo ''.$donnees['nom_categorie'].''; ?></strong></h4>
                          <h4>difficulte <br><strong><? echo ''.$difficulte.'' ?></strong></h4>
                          <?php 

                              $req1=$bdd->prepare('SELECT *
                    FROM  tuto_like,utilisateur,tuto
                    WHERE id_utilisateur = utilisateur_like AND id_utilisateur= ? AND id_tuto = ? AND number_tuto_like = ?   AND utilisateur_like = ? LIMIT 1');
                     $req1->execute(array(
                      $_SESSION['id_utilisateur'],
                      $_GET['tuto'],
                      $_GET['tuto'],
                      $_SESSION['id_utilisateur']
                      ));
                     $result = $req1->fetch();
                   if($result == true)
                {                  
               ?>
                               <a href="tuto.php?tuto=<? echo ''.$_GET['tuto']. ''?>&like=dislike" class="btn btn-success" role="button" style="display:block;margin:0 auto;width:50%">J'aime déjà le tutoriel</a>


           <? } 

          

                              
                          
                              else
                              {
                          ?>
                          <a href="tuto.php?tuto=<? echo ''.$_GET['tuto']. ''?>&like=ok" class="btn btn-primary" role="button" style="display:block;margin:0 auto;width:50%">J'aime</a>
                          <?   } 
                        
                  $req1->closeCursor();
                        ?>
                       </div>
                       <div class="col-sm-6 col-md-3">
                                     <?if (session_start() AND isset($_SESSION['nom'] ) AND $_SESSION['id_utilisateur'] ==$donnees['id_utilisateur']){
            echo '
            <a style="display: inline-block;
width: 100px;
margin: 0 auto;"href="update_tutoriel.php?tuto='.$donnees['id_tuto'].'" class="btn btn-primary">modifier</a> 
            <a style="display: inline-block;
width: 100px;
margin: 0 auto;"href="script_php/script_delete_tuto.php?tuto='.$donnees['id_tuto'].'" class="btn btn-danger">supprimer</a> 

                             '; 
        }                      ?>
                      </div>
                     <div class="col-sm-6 col-md-4">
                      <div class="thumbnail"> 
                    <?
                            if($donnees['profil_photo']!=""){
                                         ?>   <img src="uploads/photo_profil/<? echo ''.$donnees['profil_photo'] .'';?>" class="img-circle" width="40px" height="40px" alt="photo de profil"/>
                                         <?
                                       
                        }
                                   else{
                                        ?> <img src="img/photo_profil/default.png" width="40px" alt="photo de profil"/>
                   <?                   }
                                       
                     ?>
                        <p>par : <a href="profil.php?tuto=<? echo htmlspecialchars($donnees['id_utilisateur']);?>"><? echo htmlspecialchars($donnees['nom_utilisateur']) ;?></a></p>
                        <p>à été écrit le : <i><?echo ''.htmlspecialchars($donnees['jour']).'';?></i></p>
                        <p> 
                         <?php 

                              $req1=$bdd->prepare('SELECT *
                    FROM  abonnement,utilisateur,tuto
                    WHERE id_utilisateur = utilisateur_suiveur AND id_utilisateur= ? AND id_tuto = ? AND utilisateur_suivie = ? LIMIT 1');
                     $req1->execute(array(
                      $_SESSION['id_utilisateur'],
                      $_GET['tuto'],
                      $donnees['id_utilisateur']
                      ));
                     $result = $req1->fetch();
                   if($result == true)
                {        echo '<a href="tuto.php?tuto='.$_GET['tuto'].'&follow=unfolow" class="btn btn-primary" role="button">suivie</a></p>';        
                        
                 } 
                else{
                        echo '<a href="tuto.php?tuto='.$_GET['tuto'].'&follow=ok" class="btn btn-default" role="button">suivre</a></p>';

                }
                                  $req1->closeCursor();

                 ?>     
                      </div>
                     </div>
                     </div>
                    </div>
                    </div>
                    </div>

                  <div class="container">
                    <div class="row">
                    <div class="col-sm-2 col-md-2">
                    </div>
                    <div class="col-sm-8 col-md-8">

                     <div class="thumbnail"> 
              
                      <p><?echo ''.$donnees['contenu_tuto'].'';?></p>
                     
                       </div>
                      </div>
                      <div class="col-sm-2 col-md-2">
                    </div> 
                    </div> 
                      
                    <?
                    }
                    $req->closeCursor();

                    ?>    
                    <?php include('script_php/script_commentaire.php'); ?>

                    </div>  
                               
               </main>
                        <?php include('footer.php'); ?>
    </body>    
  </html>
  <?php 

  ?>