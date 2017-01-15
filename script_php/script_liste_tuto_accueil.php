<div class="row">
<?
if ($_GET['tri']=='') {
                  // QUAND IL N Y A PAS DE TRI
              
                  $reponse = $bdd->query('SELECT * FROM tuto, categorie 
                                          WHERE  ext_categorie = categorie.id_categorie AND tuto_moderation = 0
                                          ORDER BY id_tuto 
                                          DESC LIMIT 0, 50');
  
                  while ($donnees = $reponse->fetch())
                  { 
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
    
    ?>
                    
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail" style="padding:0px;">
                   <a href="tuto.php?tuto=<?  echo $donnees['id_tuto'];?>">
                              <?   if ($donnees['tuto_photo'] !='.') {
                                echo  '<img src="uploads/photo_couverture/'.$donnees['tuto_photo'].'" style="width:100%;height:200px;" alt="photo de l\'article"/>';
                              }
                               else{

                                echo  '<img src="img/photo_couverture_article/default_photo.PNG" style="width:100%;height:200px;" alt="photo de l\'article"/>';
                              }
                                ?>
                             </a>
                      <div class="caption">
                    <h3>
                             <a href="tuto.php?tuto=<?  echo htmlspecialchars($donnees['id_tuto']); ?>" ><? echo htmlspecialchars($donnees['titre_tuto']);?></a>
                          </h3>
                            
                          <p>catégorie :<? echo $donnees['nom_categorie'];?></p>
                          <p>difficulte : <?echo $difficulte;?></p>
                        </div>
                     </div>
             </div>
             <? 
            }
                  $reponse->closeCursor();
 
                 
                    }
 
else{
                // quand il y a un tri
  
                
                  $reponse = $bdd->prepare('SELECT * 
                                            FROM tuto, categorie 
                                            WHERE  ext_categorie = ? AND ext_categorie = categorie.id_categorie 
                                            ORDER BY id_tuto 
                                            DESC LIMIT 0, 50');
                  $reponse->execute(array($_GET['tri']));
                  while ($donnees = $reponse->fetch())
                  { 
 
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

               
                
                                
                                 echo '
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail" style="padding:0px;">
                   <a href="tuto.php?tuto='.$donnees['id_tuto'].'">
                               ';
                                if ($donnees['tuto_photo'] !='.') {
                                echo  '<img src="uploads/photo_couverture/'.$donnees['tuto_photo'].'" style="width:100%;height:205px;" alt="photo de l\'article"/>';
                              }
                               else{

                                echo  '<img src="img/photo_couverture_article/default_photo.PNG" style="width:100%;" alt="photo de l\'article"/>';
                              }
                              echo '
                             </a>
                      <div class="caption">
                    <h3>
                             <a href="tuto.php?tuto='.htmlspecialchars($donnees['id_tuto']).'">'.htmlspecialchars($donnees['titre_tuto']).'</a>
                          </h3>
                            
                          <p>catégorie :'.$donnees['nom_categorie'].'</p>
                          <p>difficulte : '.$difficulte.'</p>
                        </div>
                     </div>
             </div>';
                  
                  }
                  $reponse->closeCursor();
 
                 
}

?>
</div>
