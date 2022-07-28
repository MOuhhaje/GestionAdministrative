@extends('Layouts.Admin')
@section('title', 'Dashbord')
@section('content')
<div class="head-title">
    <div class="left">
        <h1>Tableau de bord</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Tableau de bord</a>
            </li>
           {{--  <li><i class='bx bx-chevron-right' ></i></li>
            <li>
                <a class="active" href="#">Home</a>
            </li> --}}
        </ul>
    </div>
   {{--  <a href="#" class="btn-download">
        <i class='bx bxs-cloud-download' ></i>
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
<ul class="box-info">
    <li>
        <a href="{{ route('Admin.Inscription') }}">
            <i class='bi bi-calendar-check-fill' ></i>
        </a>
        <span class="text">
            <h3>{{ $data[0] }}</h3>
            <p>Inscriptions</p>
        </span>
    </li>
    <li>
        <a href="{{ route('Admin.Etudiant') }}">
            <i class="bi bi-people-fill"></i>
        </a>
        <span class="text">
            <h3>{{ $data[1] }}</h3>
            <p>Etudiants</p>
        </span>
    </li>
    <li>
        <a href="{{ route('Admin.Enseignant') }}">
            <i class="bi bi-people-fill"></i>
        </a>
        <span class="text">
            <h3>{{ $data[2] }}</h3>
            <p>Enseignants</p>
        </span>
    </li>
    <li>
        <a href="{{ route('Admin.Filiere') }}">
            <i class="bi bi-building"></i>
        </a>
        <span class="text">
            <h3>{{ $data[3] }}</h3>
            <p>Filieres</p>
        </span>
    </li>
</ul>

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Inscription récente</h3>
            <i class='bi bi-search' ></i>
            <i class='bi bi-filter' ></i>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Etudiant</th>
                    <th>Date Inscription</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @if (count($inscription)>0)
                    @foreach ( $inscription as $ins )
                        
                        <tr onclick="window.location.href = '{{ route('Admin.Inscription')}}';" style="cursor: pointer">
                            <td>
                                <img src="/Gestionadmin/public/uploads/agents/noprofile.png">
                                <p>{{ $ins->Prenom.' '.$ins->Nom }}</p>
                            </td>
                            <td>{{ date("Y-m-d",strtotime($ins->created_at)); }}</td>
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
                            <td><span class="status {{ $v }}">{{ $ins->Status }}</span></td>                           
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
    <div class="todo">
        <div class="head">
            <h3>Analytique</h3>
            <i class='bx bx-plus' ></i>
            <i class='bx bx-filter' ></i>
        </div>
        <div class="chartCard">
            <div class="chartBox">
              <canvas id="myPieChart" style="max-height: 300px"></canvas>
            </div>
        </div>
    </div>
    {{-- <div class="order">
        <div class="head">
            <h3>Demande récente</h3>
            <i class='bi bi-search' ></i>
            <i class='bi bi-filter' ></i>
        </div>
        <table>
            <thead>
                <tr>
                    <th>CIN</th>
                    <th>Date Demande</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Il n'y a pas de données
                    </td>
                </tr>
            </tbody>
        </table>
    </div> --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript" >
       
        const data1 = {
            labels: [
                'Etudiants',
                'Enseignants',
                'Agents'
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [{{ $data[1] }}, {{ $data[2] }}, {{ $data[4] }}],
                backgroundColor: [
                'rgb(255, 206, 38)',
                'rgb(253, 114, 56)',
                'rgb(154, 235, 153)'
                ],
                borderColor:'rgb(0,0,0,.5)',
                hoverOffset: 4
            }]
            };
        const config1 = {
            type: 'pie',
            data: data1,
        };
        var mChart=new Chart(
            document.getElementById('myPieChart'),config1
        );
            
    </script> 
    
</div>


@endsection