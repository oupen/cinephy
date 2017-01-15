 <?php include('script_php/script_bdd.php'); ?>								


<!DOCTYPE html>
<html>
         <head>
                    <title>Login</title>
                    <link rel="stylesheet" href="styles.css">
                    <!-- Bootstrap -->
                    <link href="css/bootstrap.min.css" rel="stylesheet">

         </head>
  <body>
                       <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '196311917487552',
      xfbml      : true,
      version    : 'v2.6'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
  function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}
</script>
								
 
             <header> 
                      <a href="index.php" id="logo"><img src="img/photo_site/logo.jpg" width="140px"></a>


              </header>	     <main>
	     	<div class="container">	
         <div class="row"> 
            <div class="col-sm-6 col-md-3">
            </div>
            <div class="col-sm-6 col-md-5">
             <div class="thumbnail">
           <h2>Inscription</h2>  
				 <?php
					   include('script_php/script_inscription.php')
				 ?>
         <hr>
         <h2>Connexion</h2>
				<?php
					   include('script_php/script_conection.php')
				?>  
          <hr>
           
	         <fb:login-button 
              scope="public_profile,email"
               onlogin="checkLoginState();">
          </div>
          </div>
       </div>
     </div>
		 </main>
		 <?php include('footer.php'); ?>
  </body>	
</html>
<?php 

?>