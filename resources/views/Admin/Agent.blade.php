@extends('Layouts.Admin')
@section('title', 'Administrateur')
@section('content')
<div class="head-title">
    <div class="left">
        <h1>Administrateur</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('Admin.Dashbord') }}">Tableau de bord</a>
            </li>
            <li><i class="bi bi-chevron-right"></i></li>
            <li>
                <a class="active" href="#">Administrateur</a>
            </li>
        </ul>
    </div>
    <a href="#" class="btn-download" onclick="add();">
        <i class="bi bi-plus"></i>
        <span class="text">Ajouter</span>
    </a>
</div>
<div class="overlay" id="overlay" onclick="annule();"></div>

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
            <h3></h3>
            <i class='bi bi-search' ></i>
            <i class='bi bi-filter' ></i>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Administrateur</th>
                    <th>CIN</th>
                    <th>Email</th>
                    <th>Adresse</th>
                    <th colspan="2" >Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($agents)>0)
                    @foreach ($agents as $ag )
                    <tr >
                        <td>
                            <img src="/Gestionadmin/public/uploads/agents/{{ $ag->img }}">
                            <p>{{ $ag->Prenom.' '.$ag->Nom }}</p>
                        </td>
                        <td>{{ $ag->CIN }}</td>
                        <td>{{ $ag->Email }}</td>
                        <td>{{ $ag->Adresse }}</td>
                        @if($ag->id==$agent->id)
                            <td ><span class="status i process"  onclick="show({{ $ag }});"><i class="bi bi-eye-fill"></i></span></td>
                            <td ><a href="{{ route('Admin.Profile') }}"><span class="status i completed" ><i class="bi bi-award-fill"></i></span></a></td>
                        @else
                            <td ><span class="status i process"  onclick="show({{ $ag }});"><i class="bi bi-eye-fill"></i></span></td>
                            <td ></td>
                        @endif

                    </tr>
                    @endforeach
                @else   
                    <tr style="cursor: pointer" onclick="">
                        <td>
                            <p>Oussama MOUHHAJE</p>
                        </td>
                        <td>AY8099</td>
                        <td>oussama.mouhhaje@gmail.com</td>
                        <td>Sale</td>
                        <td>hgchghgch</td>
                        <td >
                            <span class="status process"  >En attant</span>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div> 
<div class="card" id="show add">
    <form action="{{ route('Admin.Agent') }}" method="post" id="form-id" enctype="multipart/form-data">
        @csrf 
        <div class="close">
            <i class="bi bi-x" onclick="annule();"></i>
        </div>
        <h2>Ajouter Administrateur</h2>
        <input type="submit" style="visibility: hidden;"/><br>
        <div class="txt_field">
            <input type="text" name="CIN"  id="CIN">
            <span></span>
            <label for="CIN">CIN</label>
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
        <div class="check">
            <i class="fa-regular fa-circle-check" onclick="document.getElementById('form-id').submit();"></i>
        </div>
    </form>
    <br>
</div>
<div class="card" id="show">
    <div class="card-header">
        <div><i class="bi bi-x" onclick="annule();"></i></div>
        <img src="" id="Profile" alt="Profile Image" class="profile-img">
    </div> 
    <div class="card-body">
        <p class="full-name" id="full-name">Oussam MOuhhaje</p>
        <p class="username" ></p>
        <p class="city"></p>
        <div class="info">
            <div class="right">
                <div>
                    <h3>Matricule</h3>
                    <p id="Matricule">M1000</p>
                </div>
                <div>
                    <h3>Email</h3>
                    <a href=""><p id="Email1">mouhhaje@gmail.com</p></a>
                </div>
                
            </div>
            <div class="left">
                <div>
                    <h3>CIN</h3>
                    <p id="CIN1">Ay8099</p>
                </div>
                <div>
                    <h3>Adresse</h3>
                    <p id="Adresse1">Sale</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">  
        
    </div>
    <br>
</div>

<script>

    function show(agent){
        const show= document.getElementById('show');
        let image='/Gestionadmin/public/uploads/agents/Image';
        document.getElementById('Profile').src= image.replace("Image", agent.img);
        document.getElementById('full-name').innerText = agent.Prenom+' '+agent.Nom;
        document.getElementById('Matricule').innerText = agent.Matricule;
        document.getElementById('Adresse1').innerText = agent.Adresse;
        document.getElementById('Email1').innerText = agent.Email;
        document.getElementById('CIN1').innerText = agent.CIN;
        show.classList.add('show');
        On();
    }
    function add() {
        const add= document.getElementById('show add');
        add.classList.add('show');
        On();
    }
    function annule() {
        const add= document.getElementById('show add');
        const show= document.getElementById('show');
        show.classList.remove('show');
        add.classList.remove('show');
        Off();
    }

</script>
@endsection