<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://kit.fontawesome.com/31aebbf26b.js" crossorigin="anonymous"></script>

	<!-- Boxicons -->
	<link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="styleshee">
	{{-- <link rel="stylesheet" href="boxicons.min.css"> --}}
	<script src="https://kit.fontawesome.com/31aebbf26b.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
	<!-- My CSS -->
	<link rel="stylesheet" href="{{ asset('css/style1.css') }}">
	<link rel="icon" href="/GESTIONADMIN/resources/img/icon.png" type="image/icon type">
	<title>EST-@yield('title')</title>
	
</head>
<body onload="Check()" >
	<div class="back" id="loader">
		<div class="dots">
		  <div class="dot dot1"></div>
		  <div class="dot dot2"></div>
		  <div class="dot dot3"></div>
		</div>
	  </div>

	  
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="{{ route('Home') }}" class="brand">
			<img src="/GESTIONADMIN/resources/img/estlogo.png" alt="EST">
		</a>
		<span class="tooltipbrand">Accueil</span>
		<ul class="side-menu top">
			<li class="{{'Admin/Dashbord'==request()->path() ? 'active' : ''}}">
				<a href="{{ route('Admin.Dashbord') }}" >
					<i class="bi bi-speedometer2"></i>
					<span class="text">Tableau de bord</span>
				</a>
			</li>
			<span class="tooltip">Dasboard</span>
			<li class="{{'Admin/Filiere'==request()->path() ? 'active' : ''}} ">
				<a href="{{ route('Admin.Filiere') }}" >
					<i class="bi bi-building"></i>
					<span class="text">Filieres</span>
				</a>
			</li>
			<span class="tooltip">Filieres</span>
			<li class="{{'Admin/Etudiant'==request()->path() ? 'active' : ''}} ">
				<a href="{{ route('Admin.Etudiant') }}">
					<i class="bi bi-mortarboard-fill"></i>
					<span class="text">Etudiants</span>
				</a>
			</li>
			<span class="tooltip">Etudiants</span>
			<li class="{{'Admin/Enseignant'==request()->path() ? 'active' : ''}} ">
				<a href="{{ route('Admin.Enseignant') }}" >
					<i class="bi bi-people-fill"></i>
					<span class="text">Enseignants</span>
				</a>
			</li>
			<span class="tooltip">Enseignants</span>
			<li class="{{'Admin/Inscription'==request()->path() ? 'active' : ''}} ">
				<a href="{{ route('Admin.Inscription') }}" >
					<i class="bi bi-inboxes-fill"></i>
					<span class="text">Inscriptions</span>
				</a>
			</li>
			<span class="tooltip">Inscriptions</span>
			<li class="{{'Admin/Agent'==request()->path() ? 'active' : ''}} ">
				<a href="{{ route('Admin.Agent') }}" >
					<i class="bi bi-person-workspace"></i>
					<span class="text">Administrateurs</span>
				</a>
			</li>
			<span class="tooltip">Administrateurs</span>
		</ul>
		<ul class="side-menu bottom">
			<li>
				{{-- <a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a> --}}
			</li>
			<li>
				<a href="#" class="logout" onclick="logout();">
					<i class="bi bi-box-arrow-left"></i>
					<span class="text">Déconnecter</span>
				</a>
			</li>
			<span class="tooltip logout" >Déconnecter</span>
		</ul>
		
	</section>
	<div>
		<div class="overlay" onclick="Yes(); an();"></div>
		<div class="popup_box" id="logout">
			<i class="fas fa-exclamation"></i>
			<h1>Voulez-vous vraiment vous déconnecter de votre compte !</h1>
			<label>Êtes-vous sûr de continuer ?</label>
			<div class="btns">
			  <a href="#" class="b1" onclick="an();">Annuler</a>
			  <a href="{{ route('Admin.Logout') }}" class="b2" >Logout</a>
			</div>
		</div>
	</div>
	<!-- SIDEBAR -->

	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bi bi-list' onclick="Hide()"></i>
			{{-- <a href="#" class="nav-link">Categories</a> --}}
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bi bi-search'></i></button>
				</div>
			</form>

			<a href="javascript:void(0)" class="notification" onclick="notifi()">
				<i class='bi bi-bell-fill' ></i>
				@if ($demande['count']>0)
					<span class="num">{{ $demande['count'] }}</span>
				@endif
			</a>
			<div class="notification" id="notification">
				<ul>
					@if ($demande['count']>0)
						@foreach ($demande['data'] as $data )
							<li>
									@if ($data->Role=='Etudiant')
										<div class="text" onclick="">
											@foreach ($demande['etudiant'] as $etudiant )
												@if ($etudiant->id==$data->id_E)
													{{ $etudiant->Prenom.' '.$etudiant->Nom }} a demandé une attestation scolaire 
												@endif
											@endforeach
										</div>
									@else
										<div class="text" onclick="">
											@foreach ($demande['enseignant'] as $enseignant )
												@if ($enseignant->id==$data->id_P)
													{{ $enseignant->Prenom.' '.$enseignant->Nom }}  a demandé une attestation de travaile
												@endif
											@endforeach
										</div>
									@endif
							</li>
						@endforeach
						<li>
							<div class="link" onclick="link()">
								Show all
							</div>
							<a href="{{ route('Admin.Demande') }}" style="display: none" id="link"></a>
						</li>
					@else
						<li>
							<div class="text">
								il n'y a pas de notification !
							</div>
						</li>
					@endif
					
				</ul>
			</div>
			
			<i class='bi bi-sun-fill block' id="sun" onclick="Dark()" ></i>
			<i class='bi bi-moon-fill' id="moon" onclick="Dark()" ></i>

			<a href="{{ route('Admin.Profile') }}" class="profile" >
				@if (!$agent)
					<img src="/Gestionadmin/public/uploads/agents/noprofile.png" >
				@else
					<img src="/Gestionadmin/public/uploads/agents/{{ $agent->img }}" > 
				@endif
			</a>
			
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
            @yield('content')
			{{-- --}}
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="{{ asset('js/script.js') }}"></script>
    <script type="text/javascript">
		
		
		function link() {
			document.getElementById('link').click();
		}

		function notifi() {
			const notification=document.getElementById('notification');
			if (notification.classList=='notification show') {
				notification.classList.remove('show');
			} else {
				notification.classList.add('show');
			}
		}
		var loader = document.getElementById("loader");
		window.addEventListener('load',function () {

			const lodertime=setTimeout(function (){
				loader.classList.add('load');
			}, 400);
		})

		
		function On() {
			const v=document.getElementById('overlay');
			v.classList.add('block');
		}

		function Off() {
			const v=document.getElementById('overlay');
			v.classList.remove('block');
		}

		function Dark() {
			const sun = document.getElementById('sun');
			const moon = document.getElementById('moon');

			if(localStorage.getItem('Dark')=="Dark"){
				localStorage.removeItem('Dark');
				document.body.classList.remove('dark');
				sun.classList.remove('block');
				moon.classList.add('block');
				
			}else{
				localStorage.setItem('Dark', 'Dark');
				document.body.classList.add('dark');
				moon.classList.remove('block');
				sun.classList.add('block');
				
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
		function Up(){
			On();
			const popup = document.getElementById('popup');
			popup.classList.add('popup');
		}

		function Down(){
			Off();
			const popup = document.getElementById('popup');
			popup.classList.remove('popup');

		}

		function Hide(){
			var menuBar = document.querySelector('#content nav .bi.bi-list');
			menuBar.addEventListener('click',method())
		}
		function method() {
			if(localStorage.getItem('Hide')=="Hide"){
				localStorage.removeItem('Hide');
				sidebar.classList.remove("hide");
			}else{
				localStorage.setItem('Hide', 'Hide');
				sidebar.classList.add("hide");
			}
		}
		function Check() {
				if(localStorage.getItem('Hide')=="Hide"){
					sidebar.classList.add("hide");
				}else{
					sidebar.classList.remove("hide");
				}
				if(localStorage.getItem('Dark')=="Dark"){
					document.body.classList.add('dark');
					moon.classList.remove('block');
					sun.classList.add('block');
				}else{
					document.body.classList.remove('dark');
					sun.classList.remove('block');
					moon.classList.add('block');
				}
		}
                
		function an() {
			const del= document.getElementById('logout');
			del.classList.remove('show');
			Yes();
		}
		function logout() {
			const del= document.getElementById('logout');				 
			del.classList.add('show');
			No();
		}
		function No() {
			const v=document.querySelector('.overlay');
			v.classList.add('block');
		}
		function Yes() {
			const v=document.querySelector('.overlay');
			v.classList.remove('block');
		}
        
    </script>
    
</body>
</html>