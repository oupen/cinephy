<?php include('script_php/bdd.php'); ?> 
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Landing Page</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="css/style_landing.css">

  <script>
      // 2. This code loads the IFrame Player API code asynchronously.
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      var player;
      function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
          height: '100%',
          width: '100%',
          playerVars: {
                    autoplay: 1,
                    loop: 1,
                    controls: 0,
                    showinfo: 0,
                    autohide:0,
                    modestbranding: 1,

                    vq: 'hd1080',
                    playlist: '42silsqv1co'},
          videoId: '42silsqv1co',
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
        player.mute();
      }
   var done = false;
      function onPlayerStateChange(event) {
        
      }
      function stopVideo() {
        player.stopVideo();
      }
     
    </script>
</head>
<body>
    <div id="player"><iframe src="https://www.youtube.com/embed/42silsqv1co?rel=0&amp;controls=0&amp;showinfo=0&amp;loop=1" width="100%" height="100%" frameborder="0" allowfullscreen="1"></iframe></div>
     <div class="ecran-vd">
        <img src="img//photo_site/logo-final.png" alt=" ">
        <div class="slogan">Faites votre cinéma</div>
        <a style="background:#6e1a2d;padding:15px;color:white; font-size: 1rem;font-family: 'Raleway', sans-serif, bold; top : 67vh;
    left: 42vw;position: absolute;" href="index.php">Commencer à apprendre</a>
     </div>
     
     <div class="main">
         <img src="img/photo_site/icone-camera.png" alt=" " class="floatleft">
         <p>On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. </p>
         <img src="img/photo_site/icone-camera.png" alt=" " class="floatright">
         <p>On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. </p>
         <img src="img/photo_site/icone-camera.png" alt=" " class="floatleft">
         <p>On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. </p>
         <div class="row">
<?


if ($_GET['tri']=='') {
                  // QUAND IL N Y A PAS DE TRI
              
                  $reponse = $bdd->query('SELECT * FROM tuto, categorie 
                                          WHERE  ext_categorie = categorie.id_categorie AND tuto_moderation = 0
                                          ORDER BY id_tuto 
                                          DESC LIMIT 0, 3');
  
                  while ($donnees = $reponse->fetch())
                  { 
              // difficulte
               if ($donnees['difficulte'] == 1) {
                  $difficulte = "facile";
               }
               elseif ($donnees['difficulte'] == 2) {
                   $difficulte = "moyen";
               }
               elseif ($donnees['difficulte'] == 3) {
                   $difficulte = "difficile"; 
               }
    echo '
                    
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail" style="padding:0px;">
                   <a href="tuto.php?tuto='.$donnees['id_tuto'].'">
                                <img src="img/photo_couverture_article/default_photo.PNG" style="width:100%;" alt="photo de l\'article"/>
                             </a>
                      <div class="caption">
                    <h3>
                             <a href="tuto.php?tuto='.htmlspecialchars($donnees['id_tuto']).'">'.htmlspecialchars($donnees['titre_tuto']).'</a>
                          </h3>
                            
                          <p>catégorie : '.$donnees['nom_categorie'].'</p>
                          <p>difficulte : '.$difficulte.'</p>
                        </div>
                     </div>
             </div>
';
                  }
                  $reponse->closeCursor();
 
                 
                    }
        ?>
          <p><a style="background:#6e1a2d;padding:15px;color:white; font-size: 1rem;font-family: 'Raleway', sans-serif, bold;

   " href="conection_inscription.php">Réaliser des tutoriels</a></p>
     </div>
     
  <?php include('footer.php'); ?>
</body>
</html>