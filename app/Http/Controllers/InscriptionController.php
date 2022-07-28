<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Mail\SendMail;
use App\Models\Filiere;
use App\Models\Etudiant;
use App\Models\Inscription;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class InscriptionController extends Controller
{
   
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Session::has('AdminId')){
            $agent=Agent::where('id','=',Session::get('AdminId'))->first();
        }
        $inscription=Inscription::orderBy('created_at','desc')->get();  
        $filiere=Filiere::all();  
        return view('Admin.Inscription',compact('inscription','filiere','agent')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nom'=>'required|min:3',
            'Prenom'=>'required|min:3',
            'CIN'=>'required|unique:inscriptions',
            'Email'=>'required|unique:inscriptions|email',
            'Adresse'=>'required',
            'Naissance'=>'required|date|before:-17 years',
            'Genre'=>'required',
            'Filiere'=>'required'
        ]);
        $inscription=new Inscription();
        $inscription->Nom=$request->Nom;
        $inscription->Prenom=$request->Prenom;
        $inscription->CIN=$request->CIN;
        $inscription->Email=$request->Email;
        $inscription->Adresse=$request->Adresse;
        $inscription->Naissance=$request->Naissance;
        $inscription->Genre=$request->Genre;
        $inscription->F_Id=$request->Filiere;
        $inscription->save();
        
        $password=null;
        $msg="Nous avons le plaisir de vous informer que votre inscription a été enregistrée avec succès.";
        $data=[
            'Email'=>$inscription->Email,
            'Nom'=> $inscription->Prenom.' '.$inscription->Nom,
            'Password'=>$password,
            'Body'=>$msg,
            'Subject'=>'Validation d\'inscription '
        ];
        
        Mail::send('Email', $data, function ($message) use ($data) {
            $message->from('est@gestion.ma', 'Ecole Supérieure de Technologie');
            $message->sender('Admin@gestion.ma', 'Admin');
            $message->to($data['Email'],$data['Nom']);
            $message->subject('Validation d\'inscription ');
        }); 
        return redirect()->back()->with('success','Votre inscription a été enregistrée avec succès!  Vérifier votre e-mail!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $password=null;
        if($request->Status=="Confirme"){
            $inscription=Inscription::find($id);
            $inscription->Status=$request->Status;
            $inscription->save();
            $etudiant= new Etudiant();
            $etudiant->Nom=$inscription->Nom;
            $etudiant->Prenom=$inscription->Prenom;
            $etudiant->CIN=$inscription->CIN;
            $etudiant->Email=$inscription->Email;
            $etudiant->Adresse=$inscription->Adresse;
            $etudiant->Naissance=$inscription->Naissance;
            $etudiant->F_ID=$inscription->F_ID;
            $etudiant->Genre=$inscription->Genre;
            $etudiant->Username=$inscription->Email;    
            $etudiant->Apogee=$this->GetApogee();    
            $etudiant->Niveau='1èr année';
            $password=Str::random(10);
            $etudiant->Password=Hash::make($password);
            $etudiant->save();
            {
                $msg="Vous avez été accepté par nos administrateurs voici vos informations de connexion : ";
                $data=[
                    'Email'=>$inscription->Email,
                    'Nom'=> $inscription->Prenom.' '.$inscription->Nom,
                    'Password'=>$password,
                    'Body'=>$msg,
                ];
                Mail::send('Email', $data, function ($message) use ($data) {
                    $message->from('est@gestion.ma', 'Ecole Supérieure de Technologie');
                    $message->sender('Admin@gestion.ma', 'Admin');
                    $message->to($data['Email'],$data['Nom']);
                    $message->subject('Votre inscription a été confirmée');
                });
            }
            return redirect()->back()->with('success','L\'étudiant a été confirmé');
        }   
        elseif ($request->Status=="Refuse") {
            $inscription=Inscription::find($id);
            $inscription->Status=$request->Status;
            $inscription->save();
            {
                $msg="Nous tenons à vous informer que vous n'avez pas été sélectionné pour étudier à l'Ecole Supérieure de Technologie, nous vous souhaitons le meilleur.";
                $data=[
                    'Email'=>$inscription->Email,
                    'Nom'=> $inscription->Prenom.' '.$inscription->Nom,
                    'Password'=>$password,
                    'Body'=>$msg,
                ];
                Mail::send('Email', $data, function ($message) use ($data) {
                    $message->from('est@gestion.ma', 'Ecole Supérieure de Technologie');
                    $message->sender('Admin@gestion.ma', 'Admin');
                    $message->to($data['Email'],$data['Nom']);
                    $message->subject('Votre inscription a été Refusé');
                });
            }
            return redirect()->back()->with('danger','L\'étudiant a été Refusé');
        }else {
            return redirect()->back()->with('danger','Quelque chose n\'allait pas !');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inscription = Inscription::find($id);
        $inscription->delete();
        return back()->with('danger', 'Inscription a été supprimé avec succès!');
    }
    protected function GetApogee(){
        $etudiant=DB::select('select * from Etudiants order by Apogee ');
        if(count($etudiant)!=0){
            $apogee=Arr::last($etudiant);
            return $apogee->Apogee+1;
        }else{
            return 19201;
        }

    }
}


