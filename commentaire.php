  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
 <script>tinymce.init({ selector:'' });</script>
   <script>
  tinymce.init({
    selector: '#form_commentaire'
  });
  </script>
        <?  
            if (session_start() AND isset($_SESSION['nom'] ) AND isset($_POST['form_commentaire']) AND !empty($_POST['form_commentaire'])) {
            //on écrit le commentaire
            date_default_timezone_set('UTC');


                                                        // Affichage de quelque chose comme : Monday 8th of August 2005 03:12:46 PM
                                                        $date = date("y.m.d");
																	      
				                                        //on insert les informations de l'utilisateur,
							 					 		$req = $bdd->prepare('INSERT INTO commentaire(ext_auteur_commentaire, contenue_commentaire,date_commentaire,ext_tuto) VALUES ( ?, ?, ?,?) ');
							 					 		$req->execute(array(
							 					 			$_SESSION['id_usere'],
							 					 			$_POST[ 'form_commentaire' ] ,
							 					 			$date,
							 					 			$_GET[ 'tuto' ] 
							 					 			));
							 					 		$req->closeCursor();
											           			


      }
     
   ?>

   <?   

      	 //on affiche le commentaire
      	 $reponse = $bdd->prepare('         SELECT * 
                                            FROM tuto, commentaire, usere
                                            WHERE  id_tuto = ? AND ext_tuto =  id_tuto AND ext_auteur_commentaire = id_usere AND moderation_commentaire = 0
                                            ORDER BY id_commentaire
                                            DESC LIMIT 0, 60
                                 ');

                 $reponse->execute(array($_GET['tuto']));
                  
			
					if (FALSE === ($donnees = $reponse->fetch())) {
					   echo '<h2>Pas de commentaire</h2>';
					} else {  echo'<h2 id="commentaire">Commentaires</h2>';
					    do {
					        echo '
														      <div class="thumbnail">
														             <p>écrit par : <a href="user.php?user='.$donnees['id_usere'].'">'.$donnees['nom_usere'].'</a></p>  
														             <p>le '.$donnees['date_commentaire'].'</p> 
														             <p>'.$donnees['contenue_commentaire'].'</p>    
														      
														        </div>'; 
					    } while ($donnees = $reponse->fetch());
					}			        

		                
                
    
                  $reponse->closeCursor();




                  ?>

<form method="POST" action="tuto.php?tuto=<? echo $_GET[ 'tuto' ] ?>#commentaire">
									<textarea id="form_commentaire" name="form_commentaire"></textarea><br>
									<input type="submit" id="submit" name="submit" value="envoyer votre commentaire" class="btn btn-primary"/>
		   </form>
      <?
      
 
      if(isset($_POST['form_commentaire']) and !isset($_SESSION['nom'])){
        	 header('location:conection_inscription.php');
        }
      ?>

 