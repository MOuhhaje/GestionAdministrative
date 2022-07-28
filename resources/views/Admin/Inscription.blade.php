@extends('Layouts.Admin')
@section('title', 'Inscription')
@section('profile') 
@section('content')
<div class="head-title">
    <div class="left">
        <h1>Inscription</h1>
        <ul class="breadcrumb">
            <li>
                <a href="{{ route('Admin.Dashbord') }}">Tableau de bord</a>
            </li>
            <li><i class='bi bi-chevron-right' ></i></li>
            <li>
                <a class="active" href="#">Inscriptions</a>
            </li>
        </ul>
    </div>
        {{-- <a href="#" class="btn-download">
            <i class="bi bi-person-plus-fill"></i>
            <span class="text">Download PDF</span>
        </a> --}}
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
<div id="overlay" onclick="Down(); annule();"></div>

<div class="popup_box" id="del">
    <i class="fas fa-exclamation"></i>
    <h1>Cette inscription sera définitivement supprimée !</h1>
    <label>Êtes-vous sûr de continuer ?</label>
    <div class="btns">
      <a href="#" class="b1" onclick="annule();">Annuler</a>
      <a href="" class="b2" id="sup">Supprimer</a>
    </div>
</div>

<div class="card status " id="popup">
    <div class="close bi">
        <i class="bi bi-x-lg" onclick="Down()"></i>
    </div>
<form action="" method="POST" id="status">
    @csrf
    <div class="card-body">
        <p class="full-name" id="Nom">Oussama</p>
        <p class="username" id="CIN">AY8099</p>
        <p class="city"></p>
        <div class="info">
            <div class="right">
               <div>
                   <h3>Email</h3>
                   <a href="#" ><p id="Email">mouhhaje@gmail.com</p></a>
               </div>
               <div>
                   <h3>Naissance</h3>
                   <p id="Naissance">19/12/2000</p>
               </div>
               
            </div>
            <div class="left">
                <div>
                    <h3>Adresse</h3>
                    <p id="Adresse">Sale</p>
                </div>
                <div>
                    <h3>Filiere</h3>
                    <p id="Filiere">Genie info </p>
                </div>
                <div>
                    <h3>Genre</h3>
                    <p id="Genre">AY8099</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-footer" id="footerstatus">
        <span class="status completed" id="id1" onclick="document.getElementById('statusvalue').value ='Confirme'; sub();">
                <a href="#">Confirme</a></span>
        <span class="status pending" id="id2" onclick="document.getElementById('statusvalue').value ='Refuse'; sub();"><a href="#">Refuse</a></span>
        <input type="hidden" name="Status" value="" id="statusvalue">
    </div>
    <div  id="status1">
        <span class="status completed">Confirme</span>
    </div>
    <div  id="status2">
        <span class="status completed">Refuse</span>
    </div>
</form>
</div>
<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Totale Inscriptions  {{ count($inscription) }}</h3>
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
                    <th>Adresse</th>
                    <th>Status</th>
                    <th>Action</th>
                   
                </tr>
            </thead>
            <tbody>
                @if (count($inscription)>0)
                    @foreach ($inscription as $ins )
                    <tr >
                        <td>
                            {{-- <img src="/GESTIONADMIN/resources/img/pdp2.jpg"> --}}
                            <p>{{ $ins->Prenom.' '.$ins->Nom }}</p>
                        </td>
                        <td>{{ $ins->CIN }}</td>
                        <td>
                            @foreach ($filiere as $fill)
                               @if ($fill->id==$ins->F_ID)
                                   {{ $fill->Nom }}
                               @endif
                            @endforeach
                        </td>
                        <td>{{ $ins->Email }}</td>
                        <td>{{ $ins->Adresse }}</td>
                        <?php 
                                $v=''; 
                                if($ins->Status=='Refuse'){
                                    $v='pending';
                                }elseif ($ins->Status=='Confirme') {
                                    $v='completed';
                                }else {
                                    $v='process';
                                }
                            ?>
                            <td ><span class="status {{ $v }}" onclick="Up(); v({{ $ins }},{{ $filiere }});">{{ $ins->Status }}</span></td>
                            <td ><span class="status pending"  onclick="sup({{ $ins->id }});">Suprrime</span></td>
                    </tr>
                    @endforeach
                @else   
                <tr >
                    <td>
                        Il n'y a pas de données
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<script>
    function annule() {
        const del= document.getElementById('del');
        del.classList.remove('show');
        Off();
    }
    function sup(id) {
        const del= document.getElementById('del');
        const sup= document.getElementById('sup');
        let a="{{ route('Admin.Inscription.destroy','id') }}"
        let link=a.replace("id",id)
        sup.setAttribute("href", link);

        del.classList.add('show');
        On();
    }
    function sub() {
        document.getElementById('status').submit();
    }
    function v(ins,fill) {
        document.getElementById("Nom").innerHTML = ins.Prenom+' '+ins.Nom;
        document.getElementById("CIN").innerHTML = ins.CIN;
        document.getElementById("Naissance").innerHTML = ins.Naissance;
        document.getElementById("Adresse").innerHTML = ins.Adresse;
        document.getElementById("Genre").innerHTML = ins.Genre;
        document.getElementById("Email").innerHTML = ins.Email;
        let a= "{{ route('Admin.Inscription.update','id') }}";
        document.getElementById("status").action = a.replace("id", ins.id);
        fill.forEach(element => {
            if (element.id==ins.F_ID) {               
                document.getElementById("Filiere").innerHTML = element.Nom;
            }
        });
       
        const s1=document.getElementById("status1");
        const s2=document.getElementById("status2");
        const h=document.getElementById('footerstatus');
        if (ins.Status=='Confirme') {
            s1.classList.add('show');
            s2.classList.remove('show');
            h.classList.add('hide');
        }else if (ins.Status=='Refuse') {
            s2.classList.add('show');
            s1.classList.remove('show');
            h.classList.add('hide');    
        } else {
            h.classList.remove('hide');
            s1.classList.remove('show');
            s2.classList.remove('show');
        }
        On();
        const popup = document.getElementById('popup ');
        popup.classList.add('popup');
    }
    function v2() {
        Off();
        const popup = document.getElementById('popup ');
        popup.classList.remove('popup');
    }
</script>
@endsection