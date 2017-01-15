<?php include('script_php/script_bdd.php'); ?> 							
<!DOCTYPE html>
<html lang="fr">
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
                <div class="page-header">	                    
							   <h1>Bienvenue sur Cinephy!</h1><h2><small>Faites votre cinéma</small></h2>
                </div> 
                 <div class="infoconcept">
                               <h3>Tutos par catégories</h3>
                               <a href="?tri=1">Pre prod</a> |
							                 <a href="?tri=2">Realisation</a> |
							                 <a href="?tri=3">Post prod</a> |
                               <a href="index.php">Tous</a>   
                   <?php include('script_php/script_liste_tuto_accueil.php'); ?>
              </div>
			 </main>

		    <?php include('footer.php'); ?>	

  </body>	
</html>
<?php 

?>