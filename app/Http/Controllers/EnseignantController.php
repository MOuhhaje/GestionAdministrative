<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Filiere;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use App\Models\EnseignantFiliere;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class EnseignantController extends Controller
{
    
    public function index()
    {
        if(Session::has('AdminId')){
            $agent=Agent::where('id','=',Session::get('AdminId'))->first();
        }
        $enseignants=Enseignant::orderBy('Nom','desc')->get();
        
        return view('Admin.Enseignant',compact('agent','enseignants'));
    }
    public function Image(Request $request, $id){
        $request->validate([
            'Image'=>'image|mimes:jpeg,png,jpg|max:512'
        ]);
        $filename='';
        $etudiant=Enseignant::find($id);
        if($request->hasfile('Image')){
            $file=$request->file('Image');
            $extention=$file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('uploads/enseignants',$filename);
            $etudiant->Image=$filename;
        }
        if($etudiant->Image==$filename){

            $etudiant->save();
            return redirect()->back()->with('success','La photo a été mise à jour avec succès !'); 
        }
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nom'=>'required|min:3',
            'Prenom'=>'required|min:3',
            'Email'=>'required|unique:enseignants,Email|email',
            'Adresse'=>'required',
            'CIN'=>'required',
        ]);
        $enseignant=new Enseignant();
        $enseignant->Nom=$request->Nom;
        $enseignant->Prenom=$request->Prenom;
        $enseignant->Email=$request->Email;
        $enseignant->Adresse=$request->Adresse;
        $enseignant->CIN=$request->CIN;
        $enseignant->Matricule=$this->GetMatricule();
        $enseignant->Password=Hash::make('mouhhaje');
        $enseignant->save();
        return redirect()->back()->with('success','L\'Enseignant a été ajouter avec succès');
    }

   
    public function show($id)
    {
        if(Session::has('AdminId')){
            $agent=Agent::where('id','=',Session::get('AdminId'))->first();
        }
        $enseignantFilieres=EnseignantFiliere::select()->where('id_P','=',$id)->get();
        $enseignant=Enseignant::find($id);
        $filieres=Filiere::all();
        return view('Admin.showEnseignant',compact('agent','enseignant','enseignantFilieres','filieres'));

    }

    
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Nom'=>'required|min:3',
            'Prenom'=>'required|min:3',
            'Email'=>'required|unique:enseignants,Email,'.$id.'|email',
            'Adresse'=>'required',
            'Module'=>'required'
        ]);

        Enseignant::where('id',$id)->update([
            'Nom'=>$request->Nom,
            'Prenom'=>$request->Prenom,
            'Email'=>$request->Email,
            'Adresse'=>$request->Adresse,
            'Module'=>$request->Module,
        ]);
        return redirect()->back()->with('success','L\'Enseignant a été  mis à jour avec succès');

    }

    public function destroy($id)
    {
        $enseignant = Enseignant::find($id);
        $enseignant->delete();
        return back()->with('danger', 'l\'Enseignant a été supprimé avec succès!');
    }
    
    protected function GetMatricule(){
        A:
        $enseignants=DB::select('select * from enseignants order by  Matricule');
        $numbers='0123456789';
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        $len=rand(1,2);
        for ($i = 0; $i < $len; $i++) {
            $randstring.= ''.$characters[rand(0,26)-1];
        }
        $len=rand(3,4)+1;
        for ($i = 0; $i < $len; $i++) {
            $randstring.=''.$numbers[rand(0, 10)-1];
        }
        if(count($enseignants)==0){
            return $randstring;
        }else{
            foreach ($enseignants as $enseignant ) {
                if ($randstring!=$enseignant->Matricule) {
                    return $randstring;
                }
                else{
                    goto A;
                    
                }
            }
        }
    }
}
