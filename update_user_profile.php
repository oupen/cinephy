		        <?php include('bdd.php'); ?>								
		        <?php if(session_start() AND isset($_SESSION['id_usere'] ))

		        {            $req=$bdd->prepare('SELECT mail,nom_usere FROM usere WHERE nom_usere = ?');
		        $req->execute(array($_SESSION['nom']));
		        while($donne=$req->fetch())
		        {
		        	$mailuser =$donne['mail'];
		        }  
		        $req->closeCursor();    
          //on a changer les deux

		        if ($_SESSION['nom']!=$_POST['nomutilisateur'] AND $mailuser!=$_POST['email'] AND !empty($_POST['email']) AND !empty($_POST['nomutilisateur']))
		        {           

		        	$req = $bdd->prepare('SELECT  * FROM usere WHERE   nom_usere =:nomutilisateur OR mail=:mail ');
		        	$req->execute(array(
		        		'nomutilisateur' => $_POST['nomutilisateur'],
		        		'mail' => $_POST['email']
		        		));
		        	$result = $req->fetch();
		        	if($result==true  )
		        	{  				  	  	 

		        		header('location:user.php?name=problemnometmail');
		        		$req->closeCursor();

		        	}                                       

		        	else{
		        				        include('script_update_profil.php');								

		        	}

		        }


 //si on a  changer le nom


		        elseif ($_SESSION['nom']!=$_POST['nomutilisateur'] AND $mailuser==$_POST['email']  AND !empty($_POST['nomutilisateur'])) {           
		        	$req = $bdd->prepare('SELECT  * FROM usere WHERE   nom_usere =:nomutilisateur ');
		        	$req->execute(array(
		        		'nomutilisateur' => $_POST['nomutilisateur']

		        		));
		        	$result = $req->fetch();
		        	if($result==true )
		        		{  				  	  	  header('location:user.php?name=problemnom');
		        	$req->closeCursor();


		        }
		        else{

					 include('script_update_profil.php');	
		        }
		    }



		 //si on a  changer le mail


		    elseif ($_SESSION['nom']==$_POST['nomutilisateur'] AND $mailuser!=$_POST['email'] AND !empty($_POST['email'])) {           
		    	$req = $bdd->prepare('SELECT  * FROM usere WHERE   mail =:email ');
		    	$req->execute(array(
		    		'email' => $_POST['email']

		    		));
		    	$result = $req->fetch();
		    	if($result==true )
		    	{  				  	  	
		    		header('location:user.php?name=problemail');
		    		$req->closeCursor();


		    	}
		    	else{
														     	   //on  met a jour les information
		    		 include('script_update_profil.php');	
		    	}
		    }

		    elseif( !empty($_POST['email']) AND !empty($_POST['nomutilisateur'])){



												     	  	   //on  met a jour les information
		    	 include('script_update_profil.php');	
		    }

		    else{
		    	header('location:user.php?name=problemnometmail');
		    }

		}


            
  











		?>
