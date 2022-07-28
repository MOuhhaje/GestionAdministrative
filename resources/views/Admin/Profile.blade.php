@extends('Layouts.Admin')
@section('title', 'Profile')
@section('content')
<div class="head-title">
    <div class="left">
        <h1>Dashboard</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Profile</a>
            </li>
           {{--  <li><i class='bx bx-chevron-right' ></i></li>
            <li>
                <a class="active" href="#">Home</a>
            </li> --}}
        </ul>
    </div>
    {{-- <a href="#" class="btn-download">
        <i class='bx bxs-cloud-download' ></i>
        <span class="text">Download PDF</span>
    </a> --}}
</div>
<div id="overlay" onclick="Down()"></div>
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
<div class="card">
        <div class="card-header">
        <form action="{{  route('Admin.Image', $agent->id) }}" method="post" id="form" enctype="multipart/form-data">
            @csrf
            <img src="/Gestionadmin/public/uploads/agents/{{$agent->img}}" alt="Profile Image" class="profile-img">
            <div class="round">
                <input type="file" name="Image" id="Image" title="Choisie une image" onchange="document.getElementById('form').submit();">
                <label for="Image">
                    <i class="bi bi-camera-fill"></i>
                </label>
                
            </div>
        </form>
            
        </div> 
        <div class="card-body">
            <p class="full-name">{{ $agent->Nom.' '.$agent->Prenom}}</p>
            <p class="username">{{ $agent->Matricule }}</p>
            <p class="city"></p>
            <div class="info">
                <div class="right">
                   <div>
                       <h3>Email</h3>
                       <a href="mailto:{{ $agent->Email }}"><p>{{ $agent->Email }}</p></a>
                   </div>
                   
                </div>
                <div class="left">
                    <div>
                        <h3>Adresse</h3>
                        <p>{{ $agent->Adresse }}</p>
                    </div>
                    <div>
                        <h3>CIN</h3>
                        <p>{{ $agent->CIN }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="edit">
                <i class="bi bi-pencil-square" onclick="Up()"></i>
            </div>
        </div>
    </form>
</div>
    <div class="update"  id="popup">
        <form action="{{  route('Admin.update' , $agent->id) }}" method="post" id="form-id" enctype="multipart/form-data">
            @csrf 
            <div class="close">
                <i class="bi bi-x-lg" onclick="Down()"></i>
            </div>
            <h2>Profile</h2>
            <input type="submit" style="visibility: hidden;"/><br>
            <div class="txt_field">
                <input type="text" name="Matricule" value="{{ $agent->Matricule }}" disabled>
                <span></span>
                <label for="Matricule"></label>
            </div>
            <div class="txt_field">
                <input type="text" name="Nom"  value="{{ $agent->Nom }}">
                <span></span>
                <label for="Nom">Nom</label>
            </div>
            <div class="txt_field">
                <input type="text" name="Prenom"  value="{{ $agent->Prenom }}">
                <span></span>
                <label for="Prenom">Prenom</label>
            </div>
            <div class="txt_field">
                <input type="text" name="CIN" value="{{ $agent->CIN }}">
                <span></span>
                <label for="CIN">CIN</label>
            </div>
            <div class="txt_field">
                <input type="email" name="Email"  value="{{ $agent->Email}}">
                <span></span>
                <label for="Email">Email</label>
            </div>
            <div class="txt_field">
                <input type="text" name="Adresse"  value="{{ $agent->Adresse }}">
                <span></span>
                <label for="Adresse">Adresse</label>
            </div>
            <div class="check">
                <i class="fa-regular fa-circle-check" onclick="document.getElementById('form-id').submit();"></i>
            </div>
        </form>
    </div>



@endsection