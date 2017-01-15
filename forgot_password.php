 <?php include('script_php/script_bdd.php'); ?>								


<!DOCTYPE html>
<html>
         <head>
                    <title>Login</title>
                    <link href="css/bootstrap.min.css" rel="stylesheet">

                    <link rel="stylesheet" href="styles.css">
                    <!-- Bootstrap -->

         </head>
  <body>

								
                 <?php include('header.php'); ?>	
	     <main>
	     	<div class="container">	
         <div class="row"> 
            <div class="col-sm-6 col-md-3">
            </div>
            <div class="col-sm-6 col-md-5">
             <div class="thumbnail">

         <h2>Entrer votre email pour réinitialiser le mot de passe !</h2>
            <form method="POST" action="forgot_password">
              <input type="text" placeholder="email" name="" required required class="form-control">
              <input type="submit" value="réinitialiser le mot de passe" required class="form-control">
            </form>
			       
          <hr>
           
	         
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