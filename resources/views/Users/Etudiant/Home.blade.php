<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://kit.fontawesome.com/31aebbf26b.js" crossorigin="anonymous"></script>

	<!-- Boxicons -->
	<link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="styleshee">
	<script src="https://kit.fontawesome.com/31aebbf26b.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css">
	<!-- My CSS -->
	<link rel="stylesheet" href="{{ asset('css/style1.css') }}">
	<link rel="icon" href="/GESTIONADMIN/resources/img/icon.png" type="image/icon type">
	<title>EST-Espace Etudiant</title>
</head>
<body onload="Check()" >
	<div class="back" id="loader">
		<div class="dots">
		  <div class="dot dot1"></div>
		  <div class="dot dot2"></div>
		  <div class="dot dot3"></div>
		</div>
	</div>
	<div id="overlay" onclick="ann();"></div>
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
	<div>
		<div class="overlay" onclick="Yes(); an();"></div>
		<div class="popup_box" id="logout">
			<i class="fas fa-exclamation"></i>
			<h1>Voulez-vous vraiment vous déconnecter de votre compte !</h1>
			<label>Êtes-vous sûr de continuer ?</label>
			<div class="btns">
			  <a href="javascript:void(0)" class="b1" onclick="an();">Annuler</a>
			  <a href="{{ route('Etudiant.Logout') }}" class="b2" >Logout</a>
			</div>
		</div>
	</div>
	<!-- CONTENT -->
	<section id="content" class="user">
		<!-- NAVBAR -->
		<nav>
			<a href="{{ route('Home') }}" class="brand">
				<img src="/GESTIONADMIN/resources/img/estlogo.png" alt="EST">
			</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bi bi-search'></i></button>
				</div>
			</form>

			<i class='bi bi-sun-fill block' id="sun" onclick="Dark()" ></i>
			<i class='bi bi-moon-fill' id="moon" onclick="Dark()" ></i>


			<a href="javascript:void(0)" class="profile" >
				<img src="/Gestionadmin/public/uploads/etudiants/{{ $etudiant->Image }}" alt="">
			</a>
			<a href="javascript:void(0)" class="logout user" onclick="logout();">
				<i class="bi bi-box-arrow-left"></i>
			</a>
			<span class="tooltip logout user" >Déconnecter</span>
			
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			
			<div class="head-title">
				<div class="left">
					<h1>Etudiant</h1>
				</div>
			</div>
			<div class="table-data Ensiegnant">  
				<div class="todo">
					<div class="card">
						<div class="card-header">
							<form action="{{ route('Etudiant.Image', $etudiant->id ) }}" method="post" id="form" enctype="multipart/form-data">
								@csrf
								<img src="/Gestionadmin/public/uploads/etudiants/{{ $etudiant->Image }}" alt="Profile Image" class="profile-img">
								<div class="round">
									<input type="file" name="Image" id="Image" title="Choisie une image" onchange="document.getElementById('form').submit();">
									<label for="Image">
										<i class="bi bi-camera-fill"></i>
									</label>	
								</div>
							</form>     
						</div> 
						<div class="card-body">
							<p class="full-name">{{ $etudiant->Prenom.' '.$etudiant->Nom }}</p>
							<p class="username">Apogee : {{ $etudiant->Apogee }}</p>
							<p class="username">{{'@'.$etudiant->Username }}</p>
							<p class="city"></p>
							<div class="info">
								<div class="right">
									<div>
										<h3>Filiere</h3>
										<p>@foreach ($filiere as $fill)
											@if ($fill->id==$etudiant->F_ID)
												{{ $fill->Nom }}
											@endif
										 @endforeach</p>
									</div>
									<div>
										<h3>Email</h3>
										<a  href="mailto:{{ $etudiant->Email }}"><p>{{ $etudiant->Email }}</p></a>
									</div>
								</div>
								<div class="left">
									<div>
										<h3>CIN</h3>
										<p>{{ $etudiant->CIN }}</p>
									</div>
									<div>
										<h3>Adresse</h3>
										<p>{{ $etudiant->Adresse }}</p>
									</div>
								</div>
							</div>	
						</div>
						<div class="card-footer">
							<span class="span completed" onclick="edit()">Éditer</span>
							<span class="span pending" onclick="Pass()">Mot de passe</span>
						</div>
					</div>
				</div>
				<div class="order">
					<div class="head docs">
						<h3>Documents</h3>
					</div>
					<div class="docs" >
						@if ($demande!=null)
							@if ( $demande->Status=='En attant')
							<div  class="text">
								<p class="docs">Votre demande est entrain de traitement !</p>
							</div>
							@elseif ( $demande->Status=='Confirme')
							<div  class="text">
								<p class="docs">Téléchargez votre attestation scolaire ici !</p>
								<a href="{{ route('Etudiant.download',$etudiant->id ) }}"><span class="docs">Telecharger </span></a>
							</div>
							@elseif ($demande->Status=='Refuse')
							<div  class="text">
								<p class="docs">Votre demande a ete refuse.</p>
							</div>
							@endif
						@else
						<div class="text">
							<p class="docs">Demander votre attestation scolaire ici !</p>
							<a href="{{ route('Etudiant.demande',$etudiant->id ) }}"><span class="docs">Demander</span> </a>
						</div>
						@endif
						
						
					</div>
					{{-- <div class="docs">
						<div class="text">
							<p class="docs">	Téléchargez votre attestation d'inscription .</p>
							<a href=""><span class="docs">Télécharger</span></a>
						</div>
					</div> --}}
				</div>
			</div>
			<div class="update e"  id="popup">
				<form action="{{ route('Etudiant.update',$etudiant->id) }}" method="post" id="form-id" enctype="multipart/form-data">
					@csrf 
					<div class="close">
						<i class="bi bi-x-lg" onclick="Down()"></i>
					</div>
					<h2>Modiffier Etudiant</h2>
					<input type="submit" style="visibility: hidden;"/><br>
					<div class="txt_field">
						<input type="text" name="Apogee"  id="Apogee" value="{{ $etudiant->Apogee }}" readonly required>
						<span></span>
						<label for="Apogee"></label>
					</div>
					<div class="txt_field">
						<input type="text" name="CIN"  id="CIN" value="{{ $etudiant->CIN }}" readonly required>
						<span></span>
						<label for="CIN"></label>
					</div>
					<div class="txt_field">
						<input type="text" name="Nom"  id="Nom" value="{{ $etudiant->Nom }}" readonly required>
						<span></span>
						<label for="Nom"></label>
					</div>
					<div class="txt_field">
						<input type="text" name="Prenom"  id="Prenom"  value="{{ $etudiant->Prenom }}" readonly required>
						<span></span>
						<label for="Prenom"></label>
					</div>
					<div class="txt_field">
						<input type="email" name="Email"  id="Email"  value="{{ $etudiant->Email }}" readonly required>
						<span></span>
						<label for="Email"></label>
					</div>
					<div class="txt_field">
						<input type="text" name="Adresse"  id="Adresse" value="{{ $etudiant->Adresse }}" readonly required>
						<span></span>
						<label for="Adresse"></label>
					</div>
					<div class="txt_field">
						{{-- <select name="Genre" id="Genre">
							<option selected disabled>--Genre--</option>
							<option value="Male">Male</option>
							<option value="Femelle">Femelle</option>
						</select> --}}
						<input type="text" name="Genre"id="Genre"  value="{{ $etudiant->Genre }}" readonly required>
						<span></span>
						<label for="Genre"></label>
					</div>
					<div class="txt_field">
						<input type="date" max="{{ Date('Y')-18 }}" name="Naissance" id="Naissance"  value="{{ $etudiant->Naissance }}" readonly required>
						<span></span>
						<label for="Naissance"></label>
					</div>
					<div class="txt_field">
						{{-- <select name="Niveau" id="Niveau">
							<option selected value=""></option>
						</select> --}}
					    <input type="text" name="Niveau"id="Niveau"  value="{{ $etudiant->Niveau }}" readonly required>
						<span></span>
						<label for="Niveau"></label>
					</div>
					<div class="txt_field">
						
						<input type="text" name="Username"id="Username" value="{{ $etudiant->Username }}" required>
						<span></span>
						<label for="Username"></label>
					</div>
					<div class="txt_field">
						<select name="Filiere" id="Filiere">
							@foreach ($filiere as $fil )
								@if ($fil->id==$etudiant->F_ID)
								<option selected value="{{ $etudiant->F_ID }}">{{ $fil->Nom }}</option>	
								@endif
							@endforeach
						</select>
						{{-- <input type="text" name="Filiere" id="Filiere"> --}}
						<span></span>
						<label for="Filiere"></label>
					</div>
					<div class="check">
						<i class="fa-regular fa-circle-check" onclick="document.getElementById('form-id').submit();"></i>
					</div>
				</form>
			</div>
			<div class="popup_box" id="pass">
				<form action="" method="post" id="changePass">
					@csrf
					<h1>Modifiere Mot de pass</h1>
					<div class="g">
						<input type="password" name="Ancien_mot_de_passe" placeholder="A" id="pass1">
						<label >Ancien mot de passe</label>
						<div class="eye">
							<i id="aff1" class="bi bi-eye-fill" onclick="passShow(1)"></i>
							<i id="mask1" class="bi bi-eye-slash-fill" onclick="passShow(1)" hidden></i>
						</div>
					</div>
					<div class="g">
						<input type="password" name="Nouveau_mot_de_passe" placeholder="N" id="pass2" onkeyup="passCheck({{ $etudiant->id }})">
						<label >Nouveau mot de passe</label>
						<div class="eye">
							<i id="aff2" class="bi bi-eye-fill" onclick="passShow(2)"></i>
							<i id="mask2" class="bi bi-eye-slash-fill" onclick="passShow(2)" hidden></i>
						</div>
					</div>
					<div class="g">
						<input type="password" placeholder="C" id="pass3" onkeyup="passCheck({{ $etudiant->id }})">
						<label >Confirmez le mot de passe</label>
						<div class="eye">
							<i id="aff3" class="bi bi-eye-fill" onclick="passShow(3)"></i>
							<i id="mask3" class="bi bi-eye-slash-fill" onclick="passShow(3)" hidden></i>
						</div>
					</div>
					@error('Nouveau_mot_de_passe')
						<span class="error">Le mot de passe doit contenir (0-9,a-z,A-Z)</span>
					@enderror
					<div class="btns">
					<a href="javascript:void(0)" class="b1" onclick="ann();">Annuler</a>
					<a href="javascript:void(0)" class="b3" id="b3" onclick="" >Changer</a>
					</div>
				</form>
			</div>

		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="/GESTIONADMIN/resources/js/script.js?v=<?php echo time(); ?>"></script>
    <script type="text/javascript">
		var passCheck = function(id) {
			const action=document.getElementById('changePass');
			const b3=document.getElementById('b3');
			const a="{{ route('Etudiant.Password','id') }}";
			if (document.getElementById('pass2').value ==document.getElementById('pass3').value){
				document.getElementById("pass3").style.borderBottomColor = "green";
				action.action=a.replace("id",id);
				document.getElementById('b3').onclick=function(){return document.getElementById('changePass').submit();}; 
			} else {
				document.getElementById("pass3").style.borderBottomColor = "red";
				action.action='';
				document.getElementById('b3').onclick="";

			}
		}
		function passShow(v) {
			if (v==1) {
				const x = document.getElementById("pass1");
				const hide=document.getElementById("mask1");
				const show=document.getElementById("aff1");
				if (x.type === "password") {
				x.type = "text";
				hide.hidden=false;
				show.hidden=true;
				} else {
					x.type = "password";
					show.hidden=false;
					hide.hidden=true;
				}
			} else if (v==2) {
				const x = document.getElementById("pass2");
				const hide=document.getElementById("mask2");
				const show=document.getElementById("aff2");	
				if (x.type === "password") {
				x.type = "text";
				hide.hidden=false;
				show.hidden=true;
				} else {
					x.type = "password";
					show.hidden=false;
					hide.hidden=true;
				}
			} else if (v==3) {
				const x = document.getElementById("pass3");
				const hide=document.getElementById("mask3");
				const show=document.getElementById("aff3");
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
		}
		function edit() {
			Up();
		}
		function Pass() {
			const del= document.getElementById('pass');				 
			del.classList.add('show');
			On();
		}
		function ann() {
			const del= document.getElementById('pass');
			del.classList.remove('show');
			Off();
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
		
		function Check() {
				
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