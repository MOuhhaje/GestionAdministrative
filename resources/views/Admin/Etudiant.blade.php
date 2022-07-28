@extends('Layouts.Admin')
@section('title', 'Etudiant')
@section('content')
<div class="head-title">
    <div class="left">
        <h1>Etudiant</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('Admin.Dashbord') }}">Tableau de bord</a>
            </li>
            <li><i class='bi bi-chevron-right' ></i></li>
            <li>
                <a class="active" href="#">Etudiant</a>
            </li>
        </ul>
    </div>
    <a href="#" class="btn-download">
        <i class="bi bi-cloud-download-fill"></i>
        <span class="text">Télécharger</span>
    </a>
</div>
<div id="overlay" onclick="Down(); annule();"></div>
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

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Nombre d'étudiants : {{ count($etudiants) }}</h3>
            <i class='bi bi-search' ></i>
            <i class='bi bi-filter' ></i>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Etudiant</th>
                    <th>CIN</th>
                    <th>Filiere</th>
                    <th>Email</th>
                    <th style="text-align: center" colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                
                @if (count($etudiants)>0)
                    @foreach ($etudiants as $etudiant )
                    <tr >
                        <td>
                            <img src="/Gestionadmin/public/uploads/etudiants/{{ $etudiant->Image }}">
                            <p>{{ $etudiant->Prenom.' '.$etudiant->Nom }}</p>
                        </td>
                        <td>{{ $etudiant->CIN }}</td>
                        <td >
                            @foreach ($filiere as $fill)
                               @if ($fill->id==$etudiant->F_ID)
                                   {{ $fill->Nom }}
                               @endif
                            @endforeach
                        </td>
                        <td>{{ $etudiant->Email }}</td>
                        <td class="center"><span class="status i completed" onclick="edit({{ $etudiant}},{{ $filiere}});"><i class="bi bi-pen-fill"></i></span></td>
                        <td class="center"><span class="status i process"  onclick="show({{ $etudiant }},{{ $filiere}});"><i class="bi bi-eye-fill"></i></span></td>
                        <td class="center"><span class="status i pending"  onclick="sup({{ $etudiant->id }});"><i class="bi bi-trash2-fill"></i></span></td>
                    </tr>
                    @endforeach
                @else   
                    <tr>
                        <td>
                            Il n'y a pas de données
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<div class="update e"  id="popup">
    <form action="" method="post" id="form-id" enctype="multipart/form-data">
        @csrf 
        <div class="close">
            <i class="bi bi-x-lg" onclick="Down()"></i>
        </div>
        <h2>Modiffier Etudiant</h2>
        <input type="submit" style="visibility: hidden;"/><br>
        <div class="txt_field">
            <input type="text" name="Apogee" disabled id="Apogee">
            <span></span>
            <label for="Apogee"></label>
        </div>
        <div class="txt_field">
            <input type="text" name="CIN" disabled id="CIN">
            <span></span>
            <label for="CIN"></label>
        </div>
        <div class="txt_field">
            <input type="text" name="Nom" id="Nom">
            <span></span>
            <label for="Nom">Nom</label>
        </div>
        <div class="txt_field">
            <input type="text" name="Prenom" id="Prenom" >
            <span></span>
            <label for="Prenom">Prenom</label>
        </div>
        <div class="txt_field">
            <input type="email" name="Email" id="Email" >
            <span></span>
            <label for="Email">Email</label>
        </div>
        <div class="txt_field">
            <input type="text" name="Adresse" id="Adresse">
            <span></span>
            <label for="Adresse">Adresse</label>
        </div>
        <div class="txt_field">
            <select name="Genre" id="Genre">
                <option selected disabled>--Genre--</option>
                <option value="Male">Male</option>
                <option value="Femelle">Femelle</option>
            </select>
            {{-- <input type="text" name="Genre"id=""> --}}
            <span></span>
            <label for="Genre"></label>
        </div>
        <div class="txt_field">
            <input type="date" max="{{ Date('Y')-18 }}" name="Naissance" id="Naissance">
            <span></span>
            <label for="Naissance">Naissance</label>
        </div>
        <div class="txt_field">
            <select name="Niveau" id="Niveau">
                <option selected disabled>--Niveau--</option>
                <option value="1èr année">1èr année</option>
                <option value="2ème année">2ème année</option>
            </select>
           {{--  <input type="text" name="Niveau"id="" > --}}
            <span></span>
            <label for="Niveau"></label>
        </div>
        <div class="txt_field">
            
            <input type="text" name="Username"id="Username" >
            <span></span>
            <label for="Username">Username</label>
        </div>
        <div class="txt_field">
            <select name="Filiere" id="Filiere">
                <option selected disabled>--Filiere--</option>
                @foreach ($filiere as $fill)
                    <option value="{{ $fill->id }}">{{ $fill->Nom }}</option>
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
<div class="card" id="show">
    <div class="card-header">
        <div><i class="bi bi-x" onclick="annule();"></i></div>
        <form action="" method="post" id="form" enctype="multipart/form-data">
            @csrf
            <img src="" alt="Profile Image" id="img" class="profile-img">
            <div class="round">
                <input type="file" name="Image" id="Image" title="Choisie une image" onchange="document.getElementById('form').submit();">
                <label for="Image">
                    <i class="bi bi-camera-fill"></i>
                </label>
                
            </div>
        </form>  
    </div> 
    <div class="card-body" >
        <p class="full-name" id="full-name">oussama mouhhaje</p>
        <p class="username" id="username">@mouhhaje</p>
        <p class="city" id="city">Sale</p>
        <div class="info">
            <div class="right">
                <div>
                    <h3>Filiere</h3>
                    <p id="Filiere1">Genie informatique</p>
                </div>
                <div>
                    <h3>Email</h3>
                    <a href=""><p id="Email1">mouhhaje@gmail.com</p></a>
                </div>
                <div>
                    <h3>Genre</h3>
                    <p id="Genre1">Male</p>
                </div>
                
            </div>
            <div class="left">
                <div>
                    <h3>Apogee</h3>
                    <p id="Apogee1">7101781</p>
                </div>
                
                <div>
                    <h3>Naissance</h3>
                    <p id="Naissance1">19/19/2000</p>
                </div>
                <div>
                    <h3>Niveau</h3>
                    <p id="Niveau1">2eme annee</p>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>
<div class="popup_box" id="del">
    <i class="fas fa-exclamation"></i>
    <h1>Cette Etudiant sera définitivement supprimée !</h1>
    <label>Êtes-vous sûr de continuer ?</label>
    <div class="btns">
      <a href="#" class="b1" onclick="annule();">Annuler</a>
      <a href="" class="b2" id="sup">Supprimer</a>
    </div>
</div>
<script>
    function annule() {
        const show= document.getElementById('show');
        const del= document.getElementById('del');
        del.classList.remove('show');
        show.classList.remove('show');
        Off();
    }
    function sup(id) {
        const del= document.getElementById('del');
        const sup= document.getElementById('sup');
        let a="{{ route('Admin.Etudiant.destroy','id') }}"
        let link=a.replace("id",id)
        sup.setAttribute("href", link);
        del.classList.add('show');
        On();
    }
    function show(etudiant,filiere){
        const show= document.getElementById('show');
        let img='/Gestionadmin/public/uploads/etudiants/Image';
        document.getElementById('img').src= img.replace("Image", etudiant.Image);
        let a="{{ route('Admin.Etudiant.Image','id') }}";
        document.getElementById("form").action = a.replace("id", etudiant.id);
        document.getElementById('full-name').innerText = etudiant.Prenom+' '+etudiant.Nom;
        document.getElementById('username').innerText = '@'+etudiant.Username;
        document.getElementById('city').innerText = etudiant.Adresse;
        document.getElementById('Email1').innerText = etudiant.Email;
        document.getElementById('Genre1').innerText = etudiant.Genre;
        document.getElementById('Apogee1').innerText = etudiant.Apogee;
        document.getElementById('Naissance1').innerText = etudiant.Naissance;
        document.getElementById('Niveau1').innerText = etudiant.Niveau; 
        filiere.forEach(fill => {
            if (fill.id==etudiant.F_ID) {               
                document.getElementById("Filiere1").innerHTML = fill.Nom;
            }
        });
        show.classList.add('show');
        On();
    }
    function edit(etudiant,filiere){
        let a="{{ route('Admin.Etudiant.update','id') }}";
        document.getElementById("form-id").action = a.replace("id", etudiant.id);
        document.getElementById('Apogee').value = etudiant.Apogee;
        document.getElementById('CIN').value = etudiant.CIN;
        document.getElementById('Prenom').value = etudiant.Prenom;
        document.getElementById('Nom').value =etudiant.Nom;
        document.getElementById('Adresse').value = etudiant.Adresse;
        document.getElementById('Email').value = etudiant.Email;
        document.getElementById('Genre').value = etudiant.Genre;
        document.getElementById('Naissance').value = etudiant.Naissance;
        document.getElementById('Niveau').value = etudiant.Niveau; 
        document.getElementById('Username').value =etudiant.Username;
        filiere.forEach(fill => {
            if (fill.id==etudiant.F_ID) {               
                document.getElementById("Filiere").value = fill.id;
            }
        });
        Up();
    }
</script>

@endsection