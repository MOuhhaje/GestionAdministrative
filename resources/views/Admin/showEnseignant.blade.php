@extends('Layouts.Admin')
@section('title', 'Enseignant')
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
                <a class="active" href="{{ route('Admin.Enseignant') }}">{{ $enseignant->Prenom.' '.$enseignant->Nom }}</a>
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

<div id="overlay" onclick="annule();"></div>
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

<div class="table-data Ensiegnant">  
    <div class="todo">
        <div class="card">
            <div class="card-header">
                <form action="{{ route('Admin.Enseignant.Image',$enseignant->id) }}" method="post" id="form" enctype="multipart/form-data">
                    @csrf
                    <img src="/Gestionadmin/public/uploads/enseignants/{{ $enseignant->Image }}" alt="Profile Image" class="profile-img">
                    <div class="round">
                        <input type="file" name="Image" id="Image" title="Choisie une image" onchange="document.getElementById('form').submit();">
                        <label for="Image">
                            <i class="bi bi-camera-fill"></i>
                        </label>
                        
                    </div>
                </form>     
            </div> 
            <div class="card-body">
                <p class="full-name">{{ $enseignant->Prenom.' '.$enseignant->Nom }}</p>
                <p class="username">{{ $enseignant->Matricule }}</p>
                <p class="city"></p>
                <div class="info">
                    <div class="right">
                       {{--  <div>
                            <h3>Module</h3>
                            <p>{{ $enseignant->Module }}</p>
                        </div> --}}
                        <div>
                            <h3>Email</h3>
                            <a href="mailto:{{ $enseignant->Email }}"><p>{{ $enseignant->Email }}</p></a>
                        </div>
                    </div>
                    <div class="left">
                        <div>
                            <h3>CIN</h3>
                            <p>{{ $enseignant->CIN }}</p>
                        </div>
                        <div>
                            <h3>Adresse</h3>
                            <p>{{ $enseignant->Adresse }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="order">
        <div class="head">
            <h3>Enseigner</h3>
        </div>
        <table>
            <thead>
                <thead>
                    <tr>
                        <th>Filiere</th>
                        <th>Module</th>
                        <th>Heurs</th>
                        <th colspan="3" style="text-align: center">Action</th>
                    </tr>
                </thead>
            </thead>
            <tbody>
                @if (count($enseignantFilieres)>0)
                    @foreach ($enseignantFilieres as $enseignantFiliere)
                    <tr> 
                        <td>
                            @foreach ($filieres as $filiere)
                                @if ($enseignantFiliere->id_F==$filiere->id)
                                    {{ $filiere->Nom }}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            {{ $enseignantFiliere->Module }}
                        </td>
                        <td>{{ $enseignantFiliere->Heures }} heure/semaine</td>
                        <td class="center">
                            <span class="status i completed" onclick="edit({{ $enseignantFiliere }},{{ $filieres }})"><i class="bi bi-pen-fill"></i></span>
                        </td>
                        <td class="center">
                            <span class="status i pending" onclick="sup({{ $enseignantFiliere->id }});"><i class="bi bi-trash2-fill"></i></span>
                        </td>
                    </tr>
                    @endforeach
                @else   
                <tr>
                    <td> Il n'y a pas de données</td>
                </tr>
                @endif
            </tbody>
    </div>
</div>
<div class="card ajt"  id="ajt">
    <div>
        <i class="bi bi-x" onclick="annule();"></i>
    </div>
    <div class="card-body">
        <p class="full-name">Affecter Enseignant</p>
        <p class="username">{{ $enseignant->Matricule }}</p>
        <p class="city"></p>
        <div class="info c">
            <form action="{{ route('Admin.EnseignantFiliere') }}" method="post" id="add">
                @csrf
                <input type="submit" style="visibility: hidden;"/><br>
                <input type="hidden" value="{{ $enseignant->id }}" name="id_P">
                <div class="input">
                    <input type="number" name="Heures" id="Heures">
                    <span></span>
                    <label for="Heures">Heure</label>
                </div>
                <div class="input">
                    <select name="Filiere" id="Filiere">
                        <option selected disabled>--Filiere--</option>
                        @foreach ($filieres as $fill)
                            <option value="{{ $fill->id }}">{{ $fill->Nom }}</option>
                        @endforeach
                    </select>
                    <span></span>
                    <label for="Filiere"></label>
                </div>
                <div class="input">
                    <input type="text" name="Module" id="Module">
                    <span></span>
                    <label for="Module">Module</label>
                </div>
                <div class="check">
                    <span onclick="document.getElementById('add').submit();"><i class="bi bi-check-circle"></i></span>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="card ajt"  id="up">
    <div>
        <i class="bi bi-x" onclick="annule();"></i>
    </div>
    <div class="card-body">
        <p class="full-name">Modifier</p>
        <p class="username">{{ $enseignant->Matricule }}</p>
        <p class="city"></p>
        <div class="info c">
            <form action="" method="post" id="update">
                @csrf
                <input type="submit" style="visibility: hidden;"/><br>
                <input type="hidden" value="{{ $enseignant->id }}" name="id_P">
                <div class="input">
                    <input type="number" name="Heures" id="Heures1">
                    <span></span>
                    <label for="Heures">Heure</label>
                </div>
                <div class="input">
                    <input type="text" name="Filiere" id="Filiere1" disabled value="">
                    <span></span>
                    <label for="Filiere"></label>
                </div>
                <div class="input">
                    <input type="text" name="Module" id="Module1">
                    <span></span>
                    <label for="Module">Module</label>
                </div>
                <div class="check">
                    <span onclick="document.getElementById('update').submit();"><i class="bi bi-check-circle"></i></span>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="popup_box" id="del">
    <i class="fas fa-exclamation"></i>
    <h1>Cette Relation sera définitivement supprimée !</h1>
    <label>Êtes-vous sûr de continuer ?</label>
    <div class="btns">
      <a href="javascript:void(0)" class="b1" onclick="annule();">Annuler</a>
      <a href="" class="b2" id="sup">Supprimer</a>
    </div>
</div>
<script>
     function ajouter() {
        const ajouter=document.getElementById('ajt');
        ajouter.classList.add('show');
        On();
    }
    function annule() {
        const ajouter=document.getElementById('ajt');
        const overlay= document.getElementById('overlay');
        const del= document.getElementById('del');
        const update=document.getElementById('up');
        
        update.classList.remove('show');
        del.classList.remove('show');
        ajouter.classList.remove('show');
        overlay.classList.remove('block');
    }
    function sup(id) {
        const del= document.getElementById('del');
        const sup= document.getElementById('sup');
        let a="{{ route('Admin.EnseignantFiliere.destroy','id') }}"
        let link=a.replace("id",id)
        sup.setAttribute("href", link);
        del.classList.add('show');
        On();
    }
    function edit(EnseignantFiliere,filiere){
        const update=document.getElementById('up');
        let a="{{ route('Admin.EnseignantFiliere.update','id') }}";
        document.getElementById("update").action = a.replace("id", EnseignantFiliere.id);
        document.getElementById('Heures1').value = EnseignantFiliere.Heures;
        document.getElementById('Module1').value = EnseignantFiliere.Module;
        filiere.forEach(fill => {
            if (fill.id==EnseignantFiliere.id_F) {               
                document.getElementById("Filiere1").value = fill.Nom;
            }
        });
        update.classList.add('show');
        On();
    }

</script>
@endsection