
  <!---formulaire INSCRIPTION -->
              <div class="forminscription">
				 <div class="form-group">
				     <p>
					       <form method="post" >
									<input type="text" id="nom" name="nom" placeholder="nom"size="35px" autocomplete="off" required class="form-control" /></label><br/>
									<input type="password" id="passwordvalid" name="passwordvalid"placeholder="mot de passe"size="35px"autocomplete="off" required class="form-control"  /><br/>
									<input type="password" id="passwordconfirm" name="passwordconfirm" placeholder="confirmer mot de passe"	size="35px" autocomplete="off" required class="form-control"  /></br>
									<input type="mail" id="mail" name="mail" placeholder="mail"size="35px" class="form-control" /><br/>
									<input type="submit"  class="btn btn-primary" id="submit" name="submit" value="s' inscrire"/>
						  </form>
				     </p>
			   </div>  
			  </div> 
			 					 	<?php

// ON teste tous les posibilités

if (!isset($_POST['nom']) AND !isset($_POST['passwordvalid']) AND !isset($_POST['passwordconfirm']) AND !isset($_POST['mail']))
	{
	}
elseif (empty($_POST['nom']) OR empty($_POST['passwordvalid']) OR empty($_POST['mail']))
	{
	echo '<div class="alert alert-danger" role="alert">
				 					 	    	        <p>Un ou des parametres n\' ont  pas été remplis !</p>
				 					 	    	      </div>';
	}
elseif ($_POST['passwordvalid'] != $_POST['passwordconfirm'])
	{
	echo '<p>Vous n\' avez pas mis deux le même mots de passe !</p>';
	}
  else
	{
	$req = $bdd->prepare('SELECT mail FROM utilisateur WHERE mail = ?');
	$req->execute(array(
		$_POST['mail']
	));
	$resultat = $req->fetch();
	if ($resultat == true)
		{
		echo '<p>Cette email déjà enregistré ! <br/>Désolée... il faut choisir une autre adresse  : 
						 					 	       <span class="emailinvalide" style="color:red"> ' . $_POST['mail'] . '</span>
						 					 	     </p>';
		}
	  else
		{

		// verification nom

		$req->closeCursor();
		$req = $bdd->prepare('SELECT nom_utilisateur 
						 					 		                 FROM utilisateur 
						 					 		                 WHERE nom_utilisateur = ?');
		$req->execute(array(
			$_POST['nom']
		));
		$resultat = $req->fetch();
		if ($resultat == true)
			{
			echo '<p>Ce nom est déjà enregistré  ! <br/>Désolée... il faut choisir un autre nom : <span class="emailinvalide" style="color:red"> ' . $_POST['nom'] . '</span></p>';
			}

		// Si tout es ok on enregistre

		  else
			{
			date_default_timezone_set('UTC');

			// Affichage de quelque chose comme : Monday 8th of August 2005 03:12:46 PM

			$date = date("y.m.d");
			$ip = $_SERVER['REMOTE_ADDR'];
			$req->closeCursor();

			// on hache le mot de passe

			$passwordhach = sha1($_POST['passwordvalid']);

			// on insert les informations de l'utilisateur,

			$req = $bdd->prepare('INSERT INTO utilisateur ( nom_utilisateur, mail, password,date_inscription,ip_inscription) VALUES ( ?, ?, ?, ?, ?) ');
			$req->execute(array(
				$_POST['nom'],
				$_POST['mail'],
				$passwordhach,
				$date,
				$ip
			));
			$req->closeCursor();

			// selection  de l id user

			$req->closeCursor();
			$req = $bdd->prepare('SELECT nom_utilisateur,id_utilisateur FROM utilisateur WHERE nom_utilisateur = ?');
			$req->execute(array(
				$_POST['nom']
			));
			while ($donnees = $req->fetch())
				{
				$utilisateur_id = $donnees['id_utilisateur'];
				}

			$req->closeCursor();

			// On  créer la session

			session_start();
			$_SESSION['nom'] = $_POST['nom'];
			$_SESSION['id_utilisateur'] = $utilisateur_id;

			// rediriger vers paramétrage compte

			header('location:account.php');
			}
		}
	}

?>

