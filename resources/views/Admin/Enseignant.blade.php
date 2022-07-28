@extends('Layouts.Admin')
@section('title', 'Enseignant')
@section('profile') 
    @if (!$agent)
        <img src="/Gestionadmin/public/uploads/agents/noprofile.png" >
    @else
       <img src="/Gestionadmin/public/uploads/agents/{{ $agent->img }}" > 
    @endif
@endsection
@section('content')
<div class="head-title">
    <div class="left">
        <h1>Enseignant</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('Admin.Dashbord') }}">Tableau de bord</a>
            </li>
            <li><i class='bi bi-chevron-right' ></i></li>
            <li>
                <a class="active" href="#">Enseignant</a>
            </li>
        </ul>
    </div>
    <a href="javascript:void(0);" class="btn-download" onclick="ajouter();">
        <i class="bi bi-person-plus-fill"></i>
        <span class="text">Ajouter</span>
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
            <h3>Nombre d'Enseignants : {{ count($enseignants) }}</h3>
            <i class='bi bi-search' ></i>
            <i class='bi bi-filter' ></i>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Enseignant</th>
                    <th>CIN</th>
                    <th>Email</th>
                    <th style="text-align: center" colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                
                @if (count($enseignants)>0)
                    @foreach ($enseignants as $enseignant )
                    <tr >
                        <td>
                            <img src="/Gestionadmin/public/uploads/enseignants/{{ $enseignant->Image }}">
                            <p>{{ $enseignant->Prenom.' '.$enseignant->Nom }}</p>
                        </td>
                        <td>{{ $enseignant->CIN }}</td>
                        <td>{{ $enseignant->Email }}</td>
                        <td class="center">
                            <span class="status i completed" style="cursor: pointer" onclick="edit({{  $enseignant }});"><i class="bi bi-pen-fill"></i></span>
                        </td>
                        <td class="center">
                            <a href="{{ route('Admin.Enseignant.show',$enseignant->id) }}"><span class="status i process" style="cursor: pointer" ><i class="bi bi-eye-fill"></i></span></a>
                        </td>
                        <td class="center">
                            <span class="status i pending" style="cursor: pointer" onclick="sup({{ $enseignant->id }});"><i class="bi bi-trash2-fill"></i></span>
                        </td>
                    </tr>
                    @endforeach
                @else   
                    <tr style="cursor: pointer" >
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
        <h2>Éditer Enseignant</h2>
        <input type="submit" style="visibility: hidden;"/><br>
        <div class="txt_field">
            <input type="text" name="Matricule" disabled id="Matricule">
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
        {{-- <div class="txt_field">
            <input type="text" name="Module" id="Module">
            <span></span>
            <label for="Module">Module</label>
        </div>    
 --}}
        <div class="check">
            <i class="fa-regular fa-circle-check" onclick="document.getElementById('form-id').submit();"></i>
        </div>
    </form>
</div>
<div class="update e"  id="ajt">
    <form action="{{ route('Admin.Enseignant') }}" method="post" id="form" enctype="multipart/form-data">
        @csrf 
        <div class="close">
            <i class="bi bi-x-lg" onclick="annule()"></i>
        </div>
        <h2>Ajouter Enseignant</h2>
        <input type="submit" style="visibility: hidden;"/><br>
        <div class="txt_field">
            <input type="text" name="CIN"  >
            <span></span>
            <label for="CIN">CIN</label>
        </div>
        <div class="txt_field">
            <input type="text" name="Nom" >
            <span></span>
            <label for="Nom">Nom</label>
        </div>
        <div class="txt_field">
            <input type="text" name="Prenom" >
            <span></span>
            <label for="Prenom">Prenom</label>
        </div>
        <div class="txt_field">
            <input type="email" name="Email"  >
            <span></span>
            <label for="Email">Email</label>
        </div>
        <div class="txt_field">
            <input type="text" name="Adresse" >
            <span></span>
            <label for="Adresse">Adresse</label>
        </div>    
       {{--  <div class="txt_field">
            <input type="text" name="Module" >
            <span></span>
            <label for="Module">Module</label>
        </div>   --}}  

        <div class="check">
            <i class="fa-regular fa-circle-check" onclick="document.getElementById('form').submit();"></i>
        </div>
    </form>
</div>
<div class="popup_box" id="del">
    <i class="fas fa-exclamation"></i>
    <h1>Cette Enseignant sera définitivement supprimée !</h1>
    <label>Êtes-vous sûr de continuer ?</label>
    <div class="btns">
      <a href="javascript:void(0)" class="b1" onclick="annule();">Annuler</a>
      <a href="" class="b2" id="sup">Supprimer</a>
    </div>
</div>
<script>
    function annule() {
        const ajouter=document.getElementById('ajt');
        ajouter.classList.remove('popup');
        const del= document.getElementById('del');
        const overlay= document.getElementById('overlay');
        del.classList.remove('show');
        overlay.classList.remove('block');
    }
    function sup(id) {
        const del= document.getElementById('del');
        const sup= document.getElementById('sup');
        let a="{{ route('Admin.Enseignant.destroy','id') }}"
        let link=a.replace("id",id)
        sup.setAttribute("href", link);
        del.classList.add('show');
        On();
    }
    /* function show(etudiant){
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
        show.classList.add('show');
        On();
    } */
    function edit(Enseignant){
        let a="{{ route('Admin.Enseignant.update','id') }}";
        document.getElementById("form-id").action = a.replace("id", Enseignant.id);
        document.getElementById('Matricule').value = Enseignant.Matricule;
        document.getElementById('CIN').value = Enseignant.CIN;
        document.getElementById('Prenom').value = Enseignant.Prenom;
        document.getElementById('Nom').value =Enseignant.Nom;
        document.getElementById('Adresse').value = Enseignant.Adresse;
        document.getElementById('Email').value = Enseignant.Email;
        /* document.getElementById('Module').value = Enseignant.Module; */
        Up();
    }
    function ajouter() {
        const ajouter=document.getElementById('ajt');
        ajouter.classList.add('popup');
        On();
    }

</script>

@endsection