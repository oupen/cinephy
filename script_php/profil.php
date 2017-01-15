<?php include('script_php/script_bdd.php'); ?>								
 //*****************************************   PAGE PROFIL ******************************************* 
<?php if(session_start() AND isset($_SESSION['nom'] ))
{
?>
<!DOCTYPE html>
<html>
          <head>
                   <title><?php echo''.$_SESSION['nom'].''?></title>
                      <meta charset="UTF-8"/>
                      <meta name="keyword" content=""/>
					  <link rel="stylesheet" href="styles.css">
					   <!-- Bootstrap -->
                       <link href="css/bootstrap.min.css" rel="stylesheet">
           </head>
  <body>
	               <?php include('header.php'); ?>								
				  <main> 
				  	<div class="container">	
				  	       <div class="panel-heading">						    				
	            <?         //*****************************************   AFICHAGE INFORMATION PROFIL ******************************************* 
						   $prenom=$_SESSION['nom'] ;	   
			               $req=$bdd->prepare('SELECT mail,id_utilisateur,prenom_utilisateur,utilisateur_description,nom_utilisateur,DATE_FORMAT(date_inscription, "%d/%m/%Y ") as jour FROM utilisateur WHERE nom_utilisateur = ?');
						   $req->execute(array($_SESSION['nom']));
						   while($donne=$req->fetch())
						   { ?>

						        <h1><?php echo'<h1>'.$donne['nom_utilisateur'].'</h1>' ?></h1>
						    </div>

							    <p>
                                   <?
                            if($_SESSION['profil_photo']!=""){
                                         ?>   <img src="uploads/photo_profil/<? echo ''.$_SESSION['profil_photo'] .''?>" class="img-circle" width="40px" height="40px" alt="photo de profil"/>
                                         <?
                                       
                        }
                                   else{
                                        ?> <img src="img/photo_profil/default.png" width="40px" alt="photo de profil"/>
                   <?                   }
                                       
                     ?>
							    </p>
	                            <p><i>Vous êtes inscrit depuis le <? echo ''.$donne['jour']. '';?></i></p>  

                            <div class="row">
                            <div class="col-sm-6 col-md-3">
                            </div>
                            <div class="col-sm-8 col-md-6">
								<div class="thumbnail">   
									    <p><?php echo''.$donne['prenom_utilisateur'].' '.$donne['nom_utilisateur'].'<br>' 
									   .$donne['utilisateur_description'].'</p>'?>
								</div>
					        <hr>
                            <?      
                              }   	 
						   $req->closeCursor();
							 ?>   
 
                     </div>
          		     </div>
                        <div class="row">
               		           
				                <? //*****************************************   AFFICHAGE TUTO ******************************************* 
				                $reponse=$bdd->prepare('SELECT tuto.titre_tuto, tuto.id_tuto, tuto.contenu_tuto, nom_utilisateur,tuto_photo, tuto.ext_auteur, id_utilisateur,DATE_FORMAT(tuto.date_tuto, "%d/%m/%Y ") AS jour FROM tuto,utilisateur WHERE  tuto.ext_auteur = utilisateur.id_utilisateur AND utilisateur.nom_utilisateur = ? ');
				                   $reponse->execute(array($_SESSION['nom']));
				                   if (FALSE === ($donnees = $reponse->fetch())) {
							   echo '<h2>Vous n\' avez pas encore écrit de tutoriels !</h2>
							   <br><a class="btn btn-success" href="edit_tutoriel.php">Commencez a écrire</a>';
							} else {  echo'<h2>Tutoriel que vous avez écrit</h2>';
							    do {
							         ?>
				                    <div class="col-sm-6 col-md-4">
				                      <div class="thumbnail">
					                   <?
					                    if ($donnees['tuto_photo'] !='.') {
		                                echo  '<img src="uploads/photo_couverture/'.$donnees['tuto_photo'].'" style="width:100%;height:205px;" alt="photo de l\'article"/>';
		                              }
		                               else{

		                                echo  '<img src="img/photo_couverture_article/default_photo.PNG" style="width:100%;" alt="photo de l\'article"/>';
		                                   }

		                                echo  '
		              
						                     <div class="caption">
						                   <h2>
					                        <a href="tuto.php?tuto='.htmlspecialchars($donnees['id_tuto']).'">'.htmlspecialchars($donnees['titre_tuto']).'</a>
					                       </h2>
								                    <p>par :<a href="account.php?tuto='.htmlspecialchars($donnees['id_utilisateur']).'">'.htmlspecialchars($donnees['nom_utilisateur']).'</a></p>
								                    <p>à été écrit le :<i>'.htmlspecialchars($donnees['jour']).'</i></p>
								                    <p> 
								                      <a href="#" class="btn btn-danger" role="button">Supprimer</a>                   
								                      <a href="#" class="btn btn-primary" role="button">Modifier</a>
								                    </p>
						                   </div>
						                   </div> 
				                        </div>';

							    } while ($donnees = $reponse->fetch());
							}		
				                  
				                  $req->closeCursor();

				                  ?>
                        </div>
			   </div>               
           </div>
		</main>
	  <?php include('footer.php'); ?>
  </body>	
</html>
		  <?php
		  }
else
{ header('location:index.php');
}
?>