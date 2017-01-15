<?php include('script_php/script_bdd.php'); ?>								
/*****************************************   PAGE REGLAGE COMPTE ******************************************* 
<?php if(session_start() AND isset($_SESSION['nom'] ))
{
?>
<!DOCTYPE html>
<html lang="fr">
          <head>
                      <title><?php echo''.$_SESSION['nom'].''?></title>
                      <meta charset="UTF-8"/>
                      <meta name="keyword" content="cinéma utlisateur"/>
					  <link rel="stylesheet" href="styles.css">
					   <!-- Bootstrap -->
                       <link href="css/bootstrap.min.css" rel="stylesheet">

           </head>

  <body>
   
	               <?php include('header.php'); ?>								
   
				  <main> 
				  	<div class="container">	
				  	       <div class="panel-heading">
						    <h1>Compte</h1>
						   </div>
				
							 <?php
                             //*****************************************  VERIFICATION MOT DE PASSE ******************************************* 
							 if ($_GET['name']=='ok') {
							 	echo'<div class="alert alert-success" role="alert">Vos information ons été mis a jour.</div>';
							 }
							 elseif($_GET['name']=='problemnom')
							 {
							 	echo'<div class="alert alert-danger" role="alert">Attention ce nom d\'utilisateur existe déja veuillez modifier</div>';
							 }
							 elseif($_GET['name']=='problemmail')
							 {
							 	echo'<div class="alert alert-danger" role="alert">Attention cette email  existe déja veuillez modifier</div>';
							 }

                             elseif($_GET['name']=='problemnometmail')
							 {
							 	echo'<div class="alert alert-danger" role="alert">Attention cette email et ce nom d\'utilisateur existe déja veuillez modifier</div>';
							 }


                            //*****************************************   MODIFICATION INFORMATION DE BASE PROFIL ******************************************* 
						   $prenom=$_SESSION['nom'] ;	   
			               $req=$bdd->prepare('SELECT mail,id_utilisateur,prenom_utilisateur,profil_photo,utilisateur_description,nom_utilisateur,DATE_FORMAT(date_inscription, "%d/%m/%Y ") as jour FROM utilisateur WHERE nom_utilisateur = ?');
						   $req->execute(array($_SESSION['nom']));
						   while($donne=$req->fetch())
						   {  if($donne['profil_photo']!=""){
                                       ?> 	<p><img src="uploads/photo_profil/<? echo ''.$donne['profil_photo'] .''?>" class="img-circle" width="80px" height="80px" alt="photo de profil"/></p>
                                   <?
                                    $_SESSION['profil_photo'] =$donne['profil_photo'];
						          }
						          else{
                                      ?> <p><img src="img/photo_profil/default.png" width="80px" alt="photo de profil"/></p>
						     <?     }

						   	?>
						
                            <p><?php echo''.$donne['nom_utilisateur'].''; ?></p>
                            <p><i>Vous êtes inscrit depuis le <? echo ''.$donne['jour']. '';?></i></p>  
                            <a id="deconection" href="script_php/script_deconection.php" class="btn btn-danger" role="button">  Se déconnecter  </a>
                            <a id="profil" href="profil.php" class="btn btn-primary" role="button"> Mon profil  </a>

                            <div class="row">
                             <div class="col-sm-6 col-md-3">
                             </div>
                            <div class="col-sm-8 col-md-6">
							 <div class="thumbnail">
								<div class="form-group">
		                          <form method="post" action="script_php/script_update_user_profile.php" enctype="multipart/form-data">
								    Votre prenom : <input type="text" name="prenom" value="<?php echo''.$donne['prenom_utilisateur'].'' ?>" class="form-control" /><br>
								    Votre nom : <input type="text" name="nomutilisateur" value="<?php echo''.$donne['nom_utilisateur'].'' ?>" class="form-control" /><br>
								    Votre mail  <input type="email" name="email" value="<?php echo''.$donne['mail'].'' ?>" class="form-control" /></br>
								    Votre description <textarea name="description"  class="form-control"  ><?php echo''.$donne['utilisateur_description'].'' ?></textarea></br>
								    <label>changer de photo de profil</label>
		                            <input type="file" name="photo_profil" value="" class="form-control"/><br>
									<input type="submit"  class="btn btn-success" value="enregistrer les modifications"><br>
		                           </form>
							</div>
					    <hr>
                            <?      }  ?> 
                         
						  <?php 
						   $req->closeCursor();
						    //*****************************************  MODIFICATION MOT DE PASSE ******************************************* 

							 ?>    
							  <h2 id="motdepasse">Modifier votre mot de passe</h2>			   
							 <?php
						   $prenom=$_SESSION['nom'] ;	   
			               $req=$bdd->prepare('SELECT mail,id_utilisateur,nom_utilisateur,DATE_FORMAT(date_inscription, "%d/%m/%Y ") as jour FROM utilisateur WHERE nom_utilisateur = ?');
						   $req->execute(array($_SESSION['nom']));
						   while($donne=$req->fetch())
						   { ?>
                            <form method="POST" action="account.php#motdepasse">
						     <p>Ancien mot de passe : <input type="password"  name="password" class="form-control" required/></br> 
                     	        Nouveau mot de passe : <input type="password" name="passwordnew" class="form-control"required /><br>
						        Confirmation du nouveau mot de passe : <input type="password" name="passwordvalid" class="form-control" required/><br>
						    <input type="submit" class="btn btn-success" value="enregistrer votre mot de passe" /> 
						</form>
						    <?}     

						             $req->closeCursor();
                                     $passwordhach=sha1($_POST[ 'password' ]);
                                     $req = $bdd->prepare('SELECT  * FROM utilisateur WHERE   id_utilisateur = :id_utilisateur  AND password = :password');
											  $req->execute(array('id_utilisateur' =>$_SESSION['id_utilisateur'],
											                      'password' => $passwordhach ));
                                          $result= $req->fetch();	
													  if($result==true)
												     	  { 
												     	  	$ancienpasswordvalid = "true";
												     	  }
						               $req->closeCursor();
                                    if ($_POST['passwordvalid'] != $_POST['passwordnew'] ) {
                                    	echo '<div class="alert alert-warning" role="alert">
                                    	         <p>Les deux mots de passe ne sont pas identiques</p>
                                    	      </div>';
                                    }
                                   elseif ($ancienpasswordvalid!= true AND $_POST['password']!='') {
                                    	echo '<div class="alert alert-warning" role="alert">
                                    	         <p>L\'ancien mot de passe est incorect !</p>
                                    	      </div>
                                    	';
                                    }
                                    elseif ($_POST['password']== $_POST['passwordnew'] AND $_POST['password']!='') {
                                    	echo '<div class="alert alert-warning" role="alert">
                                    	         <p>Vous devez mettre un mot de passe nouveau</p>
                                    	      </div>'
                                    	;
                                    }
                                    elseif ($_POST['passwordvalid'] == $_POST['passwordnew'] AND $_POST['password'] !='' AND $ancienpasswordvalid == "true" AND $_POST['password'] != $_POST['passwordnew'])  {



                                    	  //on hache le mot de passe
							 					 $passwordhach2=sha1($_POST[ 'passwordvalid' ]);
                                       	$req = $bdd->prepare('UPDATE utilisateur SET password =:passwordhach2 WHERE id_utilisateur =:utilisateur  ');
							 					 		$req->execute(array(
							 					 		
							 					 			'passwordhach2' => $passwordhach2,
							 					 			'utilisateur' => $_SESSION['id_utilisateur']
							 					 			
							 					 			));
							 					 	echo '
                                                 <div class="alert alert-success" role="alert">Votre mot de passe a été modifier</div>';	
                                  }

						    ?>
                          				                   
						</p> 
						   </div>
                       </div>
               	             </div>
               	             </div>
               	             <div class="col-sm-6 col-md-3">
                             </div>
               		 <div class="container">
               		  <div class="row">
               		   
		                <? $reponse=$bdd->prepare('SELECT tuto.titre_tuto, tuto.id_tuto, tuto.contenu_tuto, nom_utilisateur,tuto_photo, tuto.ext_auteur, id_utilisateur,DATE_FORMAT(tuto.date_tuto, "%d/%m/%Y ") AS jour FROM tuto,utilisateur WHERE  tuto.ext_auteur = utilisateur.id_utilisateur AND utilisateur.nom_utilisateur = ? ');
		                   $reponse->execute(array($_SESSION['nom']));
		                   if (FALSE === ($donnees = $reponse->fetch())) {
					   echo '<h2>Vous n\' avez pas encore écrit de tutoriels !</h2>
					   <br><a class="btn btn-success" href="edit_tutoriel.php">Commencez a écrire</a>';
					} else {  echo'<h2>Tutoriel que vous avez écrit</h2>';
					    do {
					        echo '
		                    <div class="col-sm-6 col-md-4">
		                      <div class="thumbnail">
			                     ';
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
						                      <a href="script_php/script_delete_tuto.php?tuto='.$donnees['id_tuto'].'" class="btn btn-danger" role="button">Supprimer</a>                   
						                      <a href="update_tutoriel.php?tuto='.$donnees['id_tuto'].'" class="btn btn-primary" role="button">Modifier</a>
						                     </p>
				                   </div>
				                   </div> 
		                        </div>';

					    } while ($donnees = $reponse->fetch());
					}		

		                  $req->closeCursor();

		                  ?>
                          </div>
                         
                        
                       <a href="delete_account.php" class="btn btn-danger" role="button">Suprimer votre compte</a>
									  
							      </div>

							</div>
               
 				  <p ><a href="index.php">Retourner sur les tutos</a></p>
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