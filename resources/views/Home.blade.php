<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EST-Accueil</title>
	  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css"/>
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="crossorigin="anonymous"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap"rel="stylesheet"/>
	  <link rel="icon" href="/GESTIONADMIN/resources/img/icon.png" type="image/icon type">
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/queries.css') }}" />
  </head>
  <body>
    <div class="back" id="loader">
      <div class="dots">
        <div class="dot dot1"></div>
        <div class="dot dot2"></div>
        <div class="dot dot3"></div>
      </div>
    </div>
    <button id="scroll-top">
      <i class="bi bi-arrow-up"></i>
    </button>
    <header>
      <nav>
          <a href="{{ route('Home') }}" id="logo">{{-- Ecole Superieur de Technologie --}}
            <img src="/GESTIONADMIN/resources/img/estlogo.png" alt="" srcset="">
          </a>
        <i class="fas fa-bars" id="ham-menu"></i>
        <ul id="nav-bar">
          <li>
            <a href="#home">Accueil</a>
          </li>
          <li>
            <a href="#courses">Filieres</a>
          </li>
          <li>
            <a href="#container">Inscription</a>
          </li>
          {{-- <li>
            <a href="#testimonial">Testimonial</a>
          </li> --}}
          <li>
            <a href="{{ route('Admin.Login') }}">Admin</a>
          </li>
        </ul>
      </nav>
    </header>
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
    <section class="hero" id="home">
      <img src="/GESTIONADMIN/resources/img/header-shape.svg" id="header-shape" />
      <div class="hero-content">
        <h1 style="text-align: center;">
          ESTs vous souhaite la bienvenue
        </h1>
        <p>
          Un système d'information intégré qui permet la mise en place de nouvelles
           méthodes de travail pour la gestion administrative au niveau des écoles 
           supérieures de technologie
        </p>
        <div class="btn-container">
            <a href="{{ route('Etudiant.Login') }}" style="text-decoration: none;">
                <div class="courses-btn">
                    <button class="secondary-btn btn">Espace Etudiant</button>
                </div>
            </a>
            <a href="{{ route('Enseignant') }}"  style="text-decoration: none;">
                <div class="courses-btn">
                    <button class="secondary-btn btn">Espace Enseignant</button>
                </div>
            </a>
        </div>
      </div>
      <div class="hero-img">
        <img src="/GESTIONADMIN/resources/img/hero-image.svg" />
      </div>
    </section>
    <!------ Section: Features ------>
   
    {{-- <section class="features" id="features">
      <h2>Why Choose Us</h2>
      <p class="section-desc">
        We at study smart provide you with engaging video lessons taught by the
        top educators using smart techniques.
      </p>
      <div class="row">
        <div class="column">
          <i class="fas fa-star"></i>
          <h3>Engaging Lectures</h3>
          <p>
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Vel veniam
            voluptatibus nobis id perspiciatis ratione reiciendis quisquam
            assumenda minima. Facere.
          </p>
        </div>
        <div class="column">
          <i class="fas fa-thumbs-up"></i>
          <h3>Top Educators</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cumque
            nesciunt harum ducimus eum esse dolore debitis! Officiis autem est
            dolor.
          </p>
        </div>
        <div class="column">
          <i class="fas fa-graduation-cap"></i>
          <h3>Self Paced</h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio
            eveniet quasi aut quibusdam incidunt debitis voluptas qui enim modi
            rem!
          </p>
        </div>
      </div>
    </section> --}}
    <!------ Section: Courses ------>
    <section class="courses" id="courses">
      <h2>Notre filieres</h2>
      <p class="section-desc">
        Avec notre filieres parmi lesquels choisir, vous pouvez choisir votre parcours academique
      </p>
      <div class="row">
        <div class="column">
          <img src="/GESTIONADMIN/resources/img/gi.jpg" />
          <h3>Genie informatique</h3>
          <p>
            La filière Génie Informatique forme des techniciens supérieurs en informatique maîtrisant le volet technique et logiciel de l’informatique (hard et soft)
          </p>
          <div class="courses-btn">
            <button class="btn secondary-btn">Learn More</button>
          </div>
        </div>
        <div class="column">
          <img src="/GESTIONADMIN/resources/img/EEA.jpg" />
          <h3>Electronique Embarquée pour l’Automobile</h3>
          <p>
            Le DUT « Electronique Embarquée pour l’Automobile » offre une formation alliant l’électronique, la mécatronique, l’automatique, l’informatique et les techniques avancées de conception et de contrôle des systèmes embarquées pour l’automobile.
          </p>
          <div class="courses-btn">
            <button class="btn secondary-btn">Learn More</button>
          </div>
        </div>
        <div class="column">
          <img src="/GESTIONADMIN/resources/img/TM.jpg" />
          <h3>Techniques de Management</h3>
          <p>
            Le DUT « Techniques de Management » offre une formation menant aux fonctions de gestionnaire : logistique, commercial, juridique, fiscal, financier et comptable.
          </p>
          <div class="courses-btn">
            <button class="btn secondary-btn">Learn More</button>
          </div>
        </div>
      </div>
    </section>
    <!------ Section: Testimonial ------>
    <div class="body">
      <div style="padding-top:30px ">
        <h2>Inscris-vous</h2>
        <p class="section-desc">
          L'inscription n'est définitive qu'après la validation des services de scolarité de l'établissement de votre choix.
        </p>
      </div>
      <div class="row" id="container">
         <div class="img column">
        <img src="\gestionadmin\public\uploads\filieres\creation.svg" alt="">
      </div>
      <div class="container column">
        <header>Signup Form</header>
        <div class="container-body">
          <div class="progress-bar">
            <div class="step">
              <p>Step</p>
              <div class="step-container">
                <div class="bullet"><span>1</span></div>
                <div class="check fas fa-check"></i></div>
              </div>
            </div>
            <div class="step">
              <p>Step</p>
              <div class="step-container">
                <div class="bullet"><span>2</span></div>
                <div class="check fas fa-check"></i></div>
              </div>
            </div>
            <div class="step">
              <p>Step</p>
              <div class="step-container">
                <div class="bullet"><span>3</span></div>
                <div class="check fas fa-check"></i></div>
              </div>
            </div>
            <div class="step">
              <p>Step</p>
              <div class="step-container">
                <div class="bullet"><span>4</span></div>
                <div class="check fas fa-check"></i></div>
              </div>
            </div>
          </div>
          <div class="form-outer" >
            <form action="{{ route('Inscription') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="page slidePage">
                <div class="title" >Informations de base</div>
                <div class="field">
                  <div class="label">Prénom</div>
                  <input type="text" name="Prenom"/>
                </div>
                <div class="field">
                  <div class="label">Nom</div>
                  <input type="text" name="Nom"/>
                </div>
                <div class="field nextBtn">
                  <a>Suivant</a>
                </div>
              </div>
              <div class="page">
                <div class="title">Contacter</div>
                <div class="field">
                  <div class="label">Adresse E-mail</div>
                  <input type="email" name="Email" />
                </div>
                <div class="field">
                  <div class="label">CIN</div>
                  <input type="text" name="CIN"/>
                </div>
                <div class="field btns">
                  <a class="prev-1 prev">Précédent</a>
                  <a class="next-1 next">Suivant</a>
                </div>
              </div>

              <div class="page">
                <div class="title">Date de naissance</div>
                <div class="field">
                  <div class="label">Date</div>
                  <input type="date" name="Naissance" max="{{ Date('Y')-18 }}"/>
                </div>
                <div class="field">
                  <div class="label">Genre</div>
                  <select name="Genre">
                    <option value="" selected disabled>---Select---</option>
                    <option>Mâle</option>
                    <option>Femelle</option>
                  </select>
                </div>
                <div class="field btns">
                  <a class="prev-2 prev">Précédent</a>
                  <a class="next-2 next">Suivant</a>
                </div>
              </div>

              <div class="page">
                
                <div class="title">Login détails</div>
                <div class="field">
                  <div class="label">Adresse</div>
                  <input type="text" name="Adresse"/>
                </div>
                 <div class="field">
                  <div class="label">Filiere</div>
                  <select name="Filiere">
                    <option value="" selected disabled>---Select---</option>
                    @if(count($fil)>0)
                      @foreach ($fil as $fill )
                        <option value="{{ $fill->id }}">{{ $fill->Nom }}</option>
                      @endforeach
                    @else
                      <option disabled>No filiere</option>
                    @endif
                  </select>
                </div>
                {{--<div class="field">
                  <div class="label">Password</div>
                  <input type="password" />
                </div> --}}
                <div class="field btns">
                  <a class="prev-3 prev">Précédent</a>
                  <button class="submit">S'inscrire</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      </div>
     
    </div>
    {{-- <section class="testimonial" id="testimonial">
      <h2>What Our Students Say</h2>
      <p class="/GESTIONADMIN/resources/img/section-desc">
        We provide a learning experience that is not available elsewhere. We
        have over 50,000 happy students.
      </p>
      <div class="row">
        <div class="column">
          <div class="testimonial-image">
            <img src="/GESTIONADMIN/resources/img/person-1.jpg" />
          </div>
          <p>
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Est alias
            eligendi quia explicabo dolorem dignissimos nisi consequatur nobis
            quaerat quas iure nostrum laudantium similique ea iste sequi tempore
            natus, repellat quae deleniti. Veritatis sit deserunt rerum cum
            consectetur voluptate nisi.
          </p>
          <h3>Mark King</h3>
        </div>
        <div class="column">
          <div class="testimonial-image">
            <img src="/GESTIONADMIN/resources/img/person-2.jpg" />
          </div>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis
            exercitationem, deleniti illo modi voluptatibus, voluptatem totam ea
            consequuntur sint, sit voluptas laboriosam? Aperiam, iure sequi sunt
            assumenda molestiae recusandae, harum id aliquam ipsam eveniet
            ratione cupiditate libero quasi nobis nulla.
          </p>
          <h3>Rose Smith</h3>
        </div>
      </div>
    </section> --}}
    <!------ Section: Download App ------>
    {{-- <section class="download-app" id="download-app">
      <h2>Download Our App</h2>
      <p class="section-desc">
        Unloack all new amazing features with our mobile app.
      </p>
      <div class="row">
        <div class="column">
          <img src="/GESTIONADMIN/resources/img/download-app.png" />
        </div>
        <div class="column">
          <div class="app-feature">
            <div>
              <i class="fas fa-star"></i>
              <h3>Set Reminders</h3>
            </div>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit.
              Excepturi autem accusamus accusantium officia?
            </p>
          </div>
          <div class="app-feature">
            <div>
              <i class="fas fa-star"></i>
              <h3>Download Lectures</h3>
            </div>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit.
              Excepturi autem accusamus accusantium officia?
            </p>
          </div>
          <div class="app-feature">
            <div>
              <i class="fas fa-star"></i>
              <h3>30,000+ Lectures</h3>
            </div>
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit.
              Excepturi autem accusamus accusantium officia?
            </p>
          </div>
          <div class="download-btns">
            <a href="#google-play">
              <img src="/GESTIONADMIN/resources/img/google-play.png" />
            </a>
            <a href="#app-store">
              <img src="/GESTIONADMIN/resources/img/app-store.png" />
            </a>
          </div>
        </div>
      </div>
    </section> --}}
    <!------ Footer ------>
    <footer>
      <div class="row footer-about">
        <h3>Ecole Superieur de Technologie</h3>
        <p>                    
          L’Ecole Supérieure de Technologie de Kénitra (ESTK) est une composante
          de l’Université Ibn Tofail.  Créée en 2017, L’ESTK propose principalement
          des formations (Bac+2) et délivre le Diplôme Universitaire de Technologie
          (DUT) dans plusieurs spécialités.
        </p>
        <div class="social-links">
          <a href="#">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="#">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#">
            <i class="fab fa-facebook-f"></i>
          </a>
        </div>
      </div>
      <div class="row footer-contact">
        <div class="column">
          <h4>Telephone</h4>
          <p>
            <a href="tel:123-456-7890" style="text-decoration: none; font-size: 1.6rem; color: #676a8b;">0537329401</a>
          </p>
        </div>
        <div class="column">
          <h4>Email</h4>
          <p>
          <a href="mailto:estweb@uit.ac.ma" style="text-decoration: none; font-size: 1.6rem; color: #676a8b;">estweb@uit.ac.ma</a>
          </p>
        </div>
      </div>
      <p class="footer-copyright">
        Copyright &copy; 2022 Ecole Superieur de Technologie. All rights reserved.
      </p>
    </footer>
    <!------ Script ------>
    <script src="{{ asset('js/script1.js') }}"></script>
    <script>
      
      var loader = document.getElementById("loader");
		window.addEventListener("load",function () {

			const lodertime=setTimeout(function (){
				loader.classList.add('load');
			}, 400);
		})

      const slidePage = document.querySelector(".slidePage");
      const firstNextBtn = document.querySelector(".nextBtn");
      const prevBtnSec = document.querySelector(".prev-1");
      const nextBtnSec = document.querySelector(".next-1");
      const prevBtnThird = document.querySelector(".prev-2");
      const nextBtnThird = document.querySelector(".next-2");
      const prevBtnFourth = document.querySelector(".prev-3");
      const submitBtn = document.querySelector(".submit");
      const progressTexts = document.querySelectorAll(".step p");
      const progressChecks = document.querySelectorAll(".check");
      const bullets = document.querySelectorAll(".bullet");

      let max=4;
      let current = 1;

      firstNextBtn.addEventListener("click",()=>{
        slidePage.style.marginLeft="-25%";

        bullets[current-1].classList.add("active");
        animation = getComputedStyle(document.querySelectorAll('.bullet')[0], '::after').getPropertyValue('animation');
        console.log(animation);
        progressTexts[current-1].classList.add("active");
        progressChecks[current-1].classList.add("active");
        current +=1;
      })

      nextBtnSec.addEventListener("click",()=>{
        slidePage.style.marginLeft="-50%";
        bullets[current-1].classList.add("active");
        progressTexts[current-1].classList.add("active");
        progressChecks[current-1].classList.add("active"); 
        current +=1;
      })
      nextBtnThird.addEventListener("click",()=>{
        slidePage.style.marginLeft="-75%";
        bullets[current-1].classList.add("active");
        progressTexts[current-1].classList.add("active");
        progressChecks[current-1].classList.add("active"); 
        current +=1;
      })

      prevBtnSec.addEventListener("click",()=>{
        slidePage.style.marginLeft="0%";
        bullets[current-2].classList.remove("active");
        progressTexts[current-2].classList.remove("active");
        progressChecks[current-2].classList.remove("active"); 
        current -=1;
      })
      prevBtnThird.addEventListener("click",()=>{
        slidePage.style.marginLeft="-25%";
        bullets[current-2].classList.remove("active");
        progressTexts[current-2].classList.remove("active");
        progressChecks[current-2].classList.remove("active"); 
        current -=1;

      })
      prevBtnFourth.addEventListener("click",()=>{
        slidePage.style.marginLeft="-50%";
        bullets[current-2].classList.remove("active");
        progressTexts[current-2].classList.remove("active");
        progressChecks[current-2].classList.remove("active"); 
        current -=1;
      })

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
