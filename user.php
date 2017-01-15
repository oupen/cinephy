 <?php include('bdd.php'); ?>								

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



						   $prenom=$_SESSION['nom'] ;	   
			               $req=$bdd->prepare('SELECT mail,id_usere,prenom_usere,profil_photo,usere_description,nom_usere,DATE_FORMAT(date_inscription, "%d/%m/%Y ") as jour FROM usere WHERE nom_usere = ?');
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
						  
						    

                            <p><?php echo''.$donne['nom_usere'].'' ?></p>
                            <p><i>Vous êtes inscrit depuis le <? echo ''.$donne['jour']. '';?></i></p>  
                            <a id="deconection" href="deconection.php" class="btn btn-danger" role="button">  Se déconnecter  </a>
                            <a id="profil" href="profil.php" class="btn btn-primary" role="button"> Mon profil  </a>

                            <div class="row">
                             <div class="col-sm-6 col-md-3">
                             </div>
                            <div class="col-sm-8 col-md-6">
							 <div class="thumbnail">
								<div class="form-group">
		                          <form method="post" action="update_user_profile.php" enctype="multipart/form-data">
								    Votre prenom : <input type="text" name="prenom" value="<?php echo''.$donne['prenom_usere'].'' ?>" class="form-control" /><br>
								    Votre nom : <input type="text" name="nomutilisateur" value="<?php echo''.$donne['nom_usere'].'' ?>" class="form-control" /><br>
								    Votre mail  <input type="email" name="email" value="<?php echo''.$donne['mail'].'' ?>" class="form-control" /></br>
								    Votre description <textarea name="description"  class="form-control"  ><?php echo''.$donne['usere_description'].'' ?></textarea></br>
								    <label>changer de photo de profil</label>
		                            <input type="file" name="photo_profil" class="form-control"/><br>
									<input type="submit"  class="btn btn-success" value="enregistrer les modifications"><br>
		                           </form>
							</div>
					    <hr>
                            <?      }  ?> 
                         
						  <?php 
						   $req->closeCursor();
							 ?>    

							  <h2 id="motdepasse">Modifier votre mot de passe</h2>
						   

							 <?php
						   $prenom=$_SESSION['nom'] ;	   
			               $req=$bdd->prepare('SELECT mail,id_usere,nom_usere,DATE_FORMAT(date_inscription, "%d/%m/%Y ") as jour FROM usere WHERE nom_usere = ?');
						   $req->execute(array($_SESSION['nom']));
						   while($donne=$req->fetch())
						   { ?>
                            <form method="POST" action="user.php#motdepasse">
						     <p>Ancien mot de passe : <input type="password"  name="password" class="form-control" required/></br> 
                     	        Nouveau mot de passe : <input type="password" name="passwordnew" class="form-control"required /><br>
						        Confirmation du nouveau mot de passe : <input type="password" name="passwordvalid" class="form-control" required/><br>
						    <input type="submit" class="btn btn-success" value="enregistrer votre mot de passe" /> 
						</form>
						    <?}     

						             $req->closeCursor();
                                     $passwordhach=sha1($_POST[ 'password' ]);
                                     $req = $bdd->prepare('SELECT  * FROM usere WHERE   id_usere = :id_usere  AND password = :password');
											  $req->execute(array('id_usere' =>$_SESSION['id_usere'],
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
                                       	$req = $bdd->prepare('UPDATE usere SET password =:passwordhach2 WHERE id_usere =:usere  ');
							 					 		$req->execute(array(
							 					 		
							 					 			'passwordhach2' => $passwordhach2,
							 					 			'usere' => $_SESSION['id_usere']
							 					 			
							 					 			));
							 					 	echo '
                                                 <div class="alert alert-success" role="alert">Votre mot de passe a été modifier</div>

							 					 	';	
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
               		   
		                <? $reponse=$bdd->prepare('SELECT tuto.titre_tuto, tuto.id_tuto, tuto.contenu_tuto, nom_usere,tuto_photo, tuto.ext_auteur, id_usere,DATE_FORMAT(tuto.date_tuto, "%d/%m/%Y ") AS jour FROM tuto,usere WHERE  tuto.ext_auteur = usere.id_usere AND usere.nom_usere = ? ');
		                   $reponse->execute(array($_SESSION['nom']));
		                   if (FALSE === ($donnees = $reponse->fetch())) {
					   echo '<h2>Vous n\' avez pas encore écrit de tutoriels !</h2>
					   <br><a class="btn btn-success" href="edit.php">Commencez a écrire</a>';
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
						                    <p>par :<a href="user.php?tuto='.htmlspecialchars($donnees['id_usere']).'">'.htmlspecialchars($donnees['nom_usere']).'</a></p>
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