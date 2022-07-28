@extends('Layouts.Admin')
@section('title', 'Profile')
@section('content')
<div class="head-title">
    <div class="left">
        <h1>Dashboard</h1>
        <ul class="breadcrumb">
            <li>
                <a href="#">Demande</a>
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

<div class="table-data">
    <div class="order">
        <div class="head">
            <h3>Demandes</h3>
            <i class='bi bi-search' ></i>
            <i class='bi bi-filter' ></i>
        </div>
        <table>
            <thead>
                <tr>
                    <th>######</th>
                    <th>Prenom</th>
                    <th>Nom</th>
                    <th>Date Demande</th>
                    <th class="center">Status</th>
                    <th class="center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($demande['dataAll'] as $data)
                    <tr>
                        @if ($data->Role=='Etudiant')
                            @foreach ($demande['etudiant'] as $etudiant )
                                @if ($etudiant->id==$data->id_E)
                                    <td>Etudiant</td>
                                    <td>{{ $etudiant->Prenom}}</td>
                                    <td>{{$etudiant->Nom }}</td>
                                    <td>{{ date("Y-m-d",strtotime($data->created_at)); }}</td>
                                    <?php 
                                        $v=''; 
                                        if($data->Status=='Refuse'){
                                            $v='pending';
                                        }elseif ($data->Status=='Confirme') {
                                            $v='completed';
                                        }else {
                                            $v='process';
                                        }
                                    ?>
                                    <td class="center">
                                        {{-- <span class="status text {{ $v }}">{{ $data->Status }}</span> --}}
                                        <span id="status" class="status {{ $v }}">{{ $data->Status }}</span>
                                    </td>
                                    <td class="center">
                                        @if ($data->Status=='En attant')
                                        <span class="status completed" onclick="alt({{ $data->id }},'Confirme')">Confirme</span>
                                        <span class="status pending" onclick="alt({{ $data->id }},'Refuse')">Refuse</span>
                                        @else
                                            <span class="status pending" onclick="document.getElementById('link1').click();">Supprimer</span>
                                            <a href="{{ route('Admin.Demande.destroy',$data->id) }}" id="link1"> </a>
                                        @endif
                                    </td>
                                @endif
                            @endforeach
                        @else
                            @foreach ($demande['enseignant'] as $enseignant )
                                @if ($enseignant->id==$data->id_P)
                                    <td>Enseignant</td>
                                    <td>{{ $enseignant->Prenom}}</td>
                                    <td>{{$enseignant->Nom }}</td>
                                    <td>{{ date("Y-m-d",strtotime($data->created_at)); }}</td>
                                    <?php 
                                        $v=''; 
                                        if($data->Status=='Refuse'){
                                            $v='pending';
                                        }elseif ($data->Status=='Confirme') {
                                            $v='completed';
                                        }else {
                                            $v='process';
                                        }
                                    ?>
                                    <td class="center">
                                        <span id="status" class="status {{ $v }}">{{ $data->Status }}</span>
                                    </td>
                                    <td class="center">
                                        @if ($data->Status=='En attant')
                                            <span class="status completed" onclick="alt({{ $data->id }},'Confirme')">Confirme</span>
                                            <span class="status pending" onclick="alt({{ $data->id }},'Refuse')">Refuse</span>
                                        @else
                                            <span class="status pending" onclick="document.getElementById('link2').click();">Supprimer</span>
                                            <a href="{{ route('Admin.Demande.destroy',$data->id)}}" id="link2"> </a>
                                        @endif
                                        
                                    </td>
                                @endif
                            @endforeach
                        @endif
                        <form action="" id="form_status" method="POST">
                            @csrf
                            <input type="hidden" name="status" id="inStatus">
                        </form>
                    </tr>
                @endforeach
            </tbody>
    </div>
</div>
<script>
    function alt(id,status) {
        let a= "{{ route('Admin.Demande.update','id') }}";
        const form=document.getElementById('form_status');
        form.action = a.replace("id", id);
        document.getElementById("inStatus").value=status;
        form.submit();
    }
</script>
@endsection