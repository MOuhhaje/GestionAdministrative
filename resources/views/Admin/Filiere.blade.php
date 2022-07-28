@extends('Layouts.Admin')
@section('title', 'Filiere')
@section('content')
<div class="head-title">
    <div class="left">
        <h1>Filiere</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('Admin.Dashbord') }}">Tableau de bord</a>
            </li>
            <li><i class='bi bi-chevron-right' ></i></li>
            <li>
                <a class="active" href="#">Filiere</a>
            </li>
        </ul>
    </div>
    <a href="#" class="btn-download" onclick="Up()">
        <i class="bi bi-plus"></i>
        <span class="text" >Ajouter</span>
    </a>
</div>

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
<div id="overlay" onclick="Down(); v2();"></div>
<section class="container">
    @if(count($filieres)>0)
        @foreach ($filieres as $filiere)
            <div class="cardt">
                <div class="bg-img">
                    <img src="/Gestionadmin/public/uploads/filieres/{{$filiere->Image}}" alt="Profile Image" class="profile-img" >   
                </div>
                <div class="infot">
                    <h3>{{$filiere->Nom}}</h3>
                    <span>{{$filiere->Capacite}}</span>
                    <p>{{$filiere->Description}}</p>
                </div>
                <div class="card-footer">
                    <a href="#" class="pen" id="pen" onclick="v({{ $filiere }})">
                        <i class="bi bi-pen-fill"></i>
                    </a>
                    <a href="{{ route('Admin.Filiere.show',$filiere->id) }}" id="eye">
                        <i class="bi bi-eye-fill"></i>
                    </a>
                    <a href="javascript:void(0)" class="trash" onclick="sup({{ $filiere->id }})">
                        <i class="bi bi-trash2-fill"></i>
                    </a>
                </div>  
            </div>
        @endforeach
    @else
        <div class="cardt">
            <div class="bg-img">
                <img src="/Gestionadmin/public/uploads/filieres/filiere.png" alt="Profile Image" class="profile-img" >   
            </div>
            <div class="infot">
                <h3>Filiere Nom</h3>
                <span>Capacite</span>
                <p>La desciption de filiere</p>
            </div>
            <div class="card-footer">
                <a href="#" class="pen" id="pen" >
                    <i class="bi bi-pen-fill"></i>
                </a>
                <a href="#" class="eye">
                    <i class="bi bi-eye-fill"></i>
                </a>
                <a href="#" class="trash">
                    <i class="bi bi-trash2-fill"></i>
                </a>
            </div>  
        </div>
    @endif
    
</section>
<div class="popup_box" id="del">
    <i class="fas fa-exclamation"></i>
    <h1>Cette Filiere sera définitivement supprimée !</h1>
    <label>Êtes-vous sûr de continuer ?</label>
    <div class="btns">
      <a href="javascript:void(0)" class="b1" onclick="v2();">Annuler</a>
      <a href="" class="b2" id="sup">Supprimer</a>
    </div>
</div>
<div>
    <div class="update f " id="popup pop" >
        <form  method="post" id="create" enctype="multipart/form-data">
            @csrf 
            @method('put')
            <div class="close">
                <i class="bi bi-x" onclick="v2()"></i>
            </div>
            <h2>Modiffier Filiere</h2>
            <input type="submit" style="visibility: hidden;"/><br>
            <div class="txt_field">
                <input type="text" name="Nom" id="Nom" >
                <span></span>
                <label for="Nom">Nom</label>
            </div>
            <div class="txt_field">
                <input type="text" name="Capacite" id="Capacite" >
                <span></span>
                <label for="Capacite">Capacite</label>
            </div>
            <div class="" >
                <label for="file-uploadc" class="custom-file-upload" >
                    <i class="bi bi-camera-fill"></i>
                    <label for="file-uploadc" id="file-namec" style="cursor: pointer"></label>
                </label>
                <input id="file-uploadc" name="Image" type="file" style="display:none;" 
                onchange=" document.querySelector('#file-namec').textContent = this.files[0].name;">
            </div>
            
            <div class="textarea">
                <label for="Description">Description</label>
                <textarea rows="2" cols="50" name="Description" form="create" id="Description"></textarea>
            </div>
            <div class="check">
                <i class="fa-regular fa-circle-check" onclick="document.getElementById('create').submit();"></i>
            </div>
        </form>
    </div>
</div>
<div>
    <div class="update f " id="popup" >
        <form action="{{ route('Admin.Filiere') }}" method="post" id="form-id" enctype="multipart/form-data">
            @csrf 
            <div class="close">
                <i class="bi bi-x" onclick="Down()"></i>
            </div>
            <h2>Filiere</h2>
            <input type="submit" style="visibility: hidden;"/><br>
            <div class="txt_field">
                <input type="text" name="Nom" >
                <span></span>
                <label for="Nom">Nom</label>
            </div>
            <div class="txt_field">
                <input type="text" name="Capacite"  >
                <span></span>
                <label for="Capacite">Capacite</label>
            </div>
            <div class="" >
                <label for="file-upload" class="custom-file-upload" >
                    <i class="bi bi-camera-fill"></i>
                    <label for="file-upload" id="file-name" style="cursor: pointer"></label>
                </label>
                <input id="file-upload" name="Image" type="file" style="display:none;" 
                onchange=" document.querySelector('#file-name').textContent = this.files[0].name;">
            </div>
            
            <div class="textarea">
                <label for="Description">Description</label>
                <textarea rows="2" cols="50" name="Description" form="form-id"></textarea>
            </div>
            <div class="check">
                <i class="fa-regular fa-circle-check" onclick="document.getElementById('form-id').submit();"></i>
            </div>
        </form>
    </div>
</div>
<script>
    
    function v(filiere) {
        document.getElementById("Nom").value =filiere.Nom ; 
        document.getElementById("Capacite").value =filiere.Capacite ; 
        document.getElementById("file-name").textContent =filiere.Image ; 
        document.getElementById("Description").value =filiere.Description ; 
        let a= "{{ route('Admin.Filiere.update','id') }}";
        document.getElementById("create").action = a.replace("id", filiere.id);
        On();
        const popup = document.getElementById('popup pop');
        popup.classList.add('popup');
    }
    function v2() {
        Off();
        const del= document.getElementById('del');
        del.classList.remove('show');
        const popup = document.getElementById('popup pop');
        popup.classList.remove('popup');
    }
    function sup(id) {
        const del= document.getElementById('del');
        const sup= document.getElementById('sup');
        let a="{{ route('Admin.Filiere.destroy','id') }}"
        let link=a.replace("id",id)
        sup.setAttribute("href", link);
        del.classList.add('show');
        On();
    }
</script>
@endsection