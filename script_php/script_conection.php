		   
								      <div class="formulaire_conection">
								      	 <div class="form-group"> 
											 <p>
													<form method="post"  >
													  <input type="text" id="identifiant" name="identifiant" placeholder="email ou nom utilisateur" required class="form-control" /> <br>
													  <input type="password" id="password" name="password" placeholder="mot de passe" required class="form-control" /><br>
													  <input type="submit" name="submit"  class="btn btn-primary" id="submit"value="connection" class="form-control" />
													</form>
													<a href="forgot_password.php">J'ai oublié mon mot de passe ?</a>
											 </p>
										 </div> 	 
							       </div>
								     			  <?php
                                        											  
								    if(!isset($_POST['password']) AND !isset($_POST[ 'identifiant' ]))
									 {
									 }
								     elseif(empty($_POST[ 'password' ]) OR empty($_POST[ 'identifiant' ]) )
									 { echo '<p>l \'email ou le mot de passe manque</p>';
								
									 }
				
									 elseif( isset($_POST[ 'password' ]) AND isset($_POST[ 'identifiant' ]))
									 {       $passwordhach=sha1($_POST[ 'password' ]);
											  $req = $bdd->prepare('SELECT  * FROM utilisateur WHERE   mail = :email OR nom_utilisateur = :email AND password = :password AND utilisateur_moderation=0');
											  $req->execute(array('email' => $_POST[ 'identifiant' ],
											                      'password' => $passwordhach ));
											  $result= $req->fetch();	
													  if($result==true)
												     	  { 
												         	 
												       session_start();
													   $_SESSION['nom'] = $result['nom_utilisateur'];
                                                       $_SESSION['id_utilisateur'] = $result['id_utilisateur'];
													   $_SESSION['profil_photo'] = $result['profil_photo'];				
															$req->closeCursor();
															header('location:index.php');

															}
													 else
															{  echo'<p style="color:orange">email ou mot de passe non valide </p>';		 
															}
									} 
								  
								   ?>