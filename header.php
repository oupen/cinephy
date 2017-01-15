             <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-87782941-1', 'auto');
  ga('send', 'pageview');

</script>
         <div class="navbar navbar-inverse navbar-fixed-top" style=" border-color: white;">
            
         
             <header>	
    	                <a href="index.php" id="logo"><img src="img/photo_site/logo.jpg" width="140px"></a>
    	                <a href="landing.php">comment ça marche ?</a>
                      <a href="edit_tutoriel.php" id="lien_fabrication_diy">Fabrique ton tuto</a>

    	                <?php if(session_start() AND isset($_SESSION['nom'] ))
                                  {
                                   echo'<a href="profil.php">'.$_SESSION['nom'].'';
                                      if($_SESSION['profil_photo']!=""){
                                  ?>         <img src="uploads/photo_profil/<? echo ''.$_SESSION['profil_photo'] .''?>" class="img-circle" width="40px" height="40px" alt="photo de profil"/>
                                  <? 
                                       }
                                   else{
                                  ?>        <img src="img/photo_profil/default.png" width="40px" alt="photo de profil"/>
                                  <?      
                                       }
                                  ?>

                                            <a href="account.php"><span class="glyphicon glyphicon-cog"></span></a>

                                     <?
             
                                  }

                                  else{  ?>
		                 
									     <a href="login.php">S'inscrire</a> /
									     <a href="login.php">Se connecter</a>									  

                                <?    }   ?>

							</header>
 </div>