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
	  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/GESTIONADMIN/resources/css/style.css?v=<?php echo time(); ?>" />
    <title>Login Etudaint</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        @if ($errors->any())
				<div class="session show danger" id="session">
					<div>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
						<script>
							SessionOut();
						</script>
					</div>
					<i class="bi bi-x" onclick="SessionIn()"></i>
				</div>
			@endif
			@if(session()->has('success'))
				<div class="session show success" id="session">
					<div>
						{{ session()->get('success') }}
						<script>
							SessionOut();
						</script>
					</div>
					<i class="bi bi-x" onclick="SessionIn()"></i>
				</div>
			@elseif (session()->has('danger'))
				<div class="session show danger" id="session">
					<div>
						{{ session()->get('danger') }}
					</div>
					<i class="bi bi-x" onclick="SessionIn()"></i>
				</div>
			@endif
        <div class="signin-signup">
          <form action="{{ route('Etudiant.Login') }}" method="POST" class="sign-in-form">
              @csrf
            <h2 class="title">S'identifier</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text"  name="Username" placeholder="Username" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="Password" id="Password" placeholder="Password" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" required/>
              <div class="eye">
                <i id="show" class="bi bi-eye-fill" onclick="pass()"></i>
                <i id="hide" class="bi bi-eye-slash-fill" onclick="pass()" hidden></i>
              </div>
            </div>
            <input type="submit" value="Connexion" name="Login" class="btn solid" />
            <p class="social-text">Ou suivez-nous sur les plateformes sociales</p>
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
              Ceci est l'espace étudiant, connectez-vous et découvrez plus
            </p>
            <a href="{{ route('Home') }}" id="logo">
                <button class="btn transparent" >
                  Accueil
                </button>
            </a>
          </div>
          <img src="/GESTIONADMIN/resources/img/education.svg" class="image" alt="" />
        </div>
      </div>
    </div>

    <script src="/GESTIONADMIN/resources/js/app1.js"></script>
    <script>
      function pass() {
        const x = document.getElementById("Password");
        const hide=document.getElementById("hide");
        const show=document.getElementById("show");
        if (x.type === "password") {
          x.type = "text";
          hide.hidden=false;
          show.hidden=true;
        } else {
          x.type = "password";
          show.hidden=false;
          hide.hidden=true;
        }
      }
        const myTimeout = setTimeout(function (){
          var element = document.getElementById('session');
          session.classList.remove('show');
        }, 8000);

      function SessionoOut() {
        const session=document.getElementById('session');
        session.classList.add('show');
      }
      function SessionIn() {
        const session=document.getElementById('session');
        session.classList.remove('show');
      }
    </script>
  </body>
</html>
