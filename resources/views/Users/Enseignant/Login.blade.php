<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
	  <link rel="icon" href="/GESTIONADMIN/resources/img/icon.png" type="image/icon type">
    <link rel="stylesheet" href="/GESTIONADMIN/resources/css/style.css?v=<?php echo time(); ?>" />
    <title>Login Enseignant</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="#" method="POST" class="sign-in-form">
              @csrf
            <h2 class="title">S'identifier</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Username" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Password" />
            </div>
            <input type="submit" value="Connexion" class="btn solid" />
            <p class="social-text">Ou suivez-nous avec les plateformes sociales</p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form> 
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Bienvenue</h3>
            <p>
              Ceci est l'espace enseignant, connectez-vous et découvrez plus
            </p>
            <a href="{{ route('Home') }}" id="logo">
              <button class="btn transparent" >
                Accueil
              </button>
            </a>
          </div>
          <img src="/GESTIONADMIN/resources/img/professor.svg" class="image" alt="" />
        </div>
      </div>
    </div>

    <script src="/GESTIONADMIN/resources/js/app1.js"></script>
  </body>
</html>
