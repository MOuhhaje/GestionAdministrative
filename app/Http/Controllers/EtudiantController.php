<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Demande;
use App\Models\Filiere;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class EtudiantController extends Controller
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
        $etudiants=Etudiant::orderBy('Nom','desc')->get();
        $filiere=Filiere::all();
        return view('Admin.Etudiant',compact('etudiants','agent','filiere'));
    }
    public function Log(){
        return view('Users.Etudiant.Login');
    }
    public function Login(Request $req){
        $etudiant=Etudiant::where('Username','=',$req->Username)->first();
        if($etudiant){
            if(Hash::check($req->Password, $etudiant->Password)){
                $req->session()->put('EtudiantId',$etudiant->id);
                return redirect('Etudiant/Home')->with('success','Bienvenue '.$etudiant->Prenom.' '.$etudiant->Nom.'');
            }else {
                return back()->with('danger','Password incorrect !!');
            }
        }
        else {
            return back()->with('danger','Email n`exist pas !!');
        }   
    }
    public function Logout(){
        if(Session::has('EtudiantId')){
            Session::pull('EtudiantId');
            return redirect('Etudiant');
        }
    }
    public function Image(Request $request, $id){
        $request->validate([
            'Image'=>'image|mimes:jpeg,png,jpg,svg|max:512'
        ]);
        $filename='';
        $etudiant=Etudiant::find($id);
        if($request->hasfile('Image')){
            $file=$request->file('Image');
            $extention=$file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('uploads/etudiants',$filename);
            $etudiant->Image=$filename;
        }
        if($etudiant->Image==$filename){
            
            $etudiant->save();
            return redirect()->back()->with('success','La photo a été mise à jour avec succès !'); 
        }
    }
    public function password(Request $request, $id){
        $request->validate([
            'Ancien_mot_de_passe'=>'required',
            'Nouveau_mot_de_passe'=>'required|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/'
        ]);

        $etudiant=Etudiant::where('id',$id)->first();
        if(!Hash::check($request->Ancien_mot_de_passe, $etudiant->Password)){
            return redirect()->back()->with("danger", "L'ancien mot de passe ne correspond pas !");
        }
        if(Hash::check($request->Nouveau_mot_de_passe, $etudiant->Password)){
            return redirect()->back()->with("danger", "Le nouveau mot de passe ne peut pas être identique à votre mot de passe actuel !");
        }
        Etudiant::where('id',$id)->update([
            'Password'=>Hash::make($request->Nouveau_mot_de_passe),
        ]);
        return redirect()->back()->with('success','Le mot de passe a été changé avec succès!"');
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if(Session::has('EtudiantId')){
            $etudiant=Etudiant::where('id','=',Session::get('EtudiantId'))->first();
            $filiere=Filiere::all();
            $demande=Demande::where('id_E','=',$etudiant->id)->first();
            return view('Users.Etudiant.Home',compact('etudiant','filiere','demande'));
        }
        return view('Users.Etudiant.Login');
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
        $request->validate([
            'Nom'=>'required|min:3',
            'Prenom'=>'required|min:3',
            'Email'=>'required|unique:etudiants,Email,'.$id.'|email',
            'Adresse'=>'required',
            'Naissance'=>'required|date|before:-18 years',
            'Genre'=>'required',
            'Niveau'=>'required',
            'Username'=>'required|unique:etudiants,Username,'.$id,
            'Filiere'=>'required'
        ]);
        Etudiant::where('id',$id)->update([
            'Nom'=>$request->Nom,
            'Prenom'=>$request->Prenom,
            'Email'=>$request->Email,
            'Adresse'=>$request->Adresse,
            'Naissance'=>$request->Naissance,
            'Genre'=>$request->Genre,
            'Niveau'=>$request->Niveau,
            'Username'=>$request->Username,
            'F_ID'=>$request->Filiere
        ]);
        return redirect()->back()->with('success','L\'Étudiant a été mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $etudiant = Etudiant::find($id);
        $etudiant->delete();
        return back()->with('danger', 'Etudiant a été supprimé avec succès!');
    }
    
    public function download($id){
        $etudiant=Etudiant::find($id);     
        $filiere=Filiere::find($etudiant->F_ID);
        $jours = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
        $mois = array(1=>'Janvier','Février','Mars', 'Avril', 'Mai', 'Juin', 'Juillet','Août','Septembre','Octobre','Novembre','Décembre');
        $today= mktime(0, 0, 0,date('n'),date('j'),date('Y') );
        $outetudaint='
            <html>
                <head>
                    <title>Attestation-'.$etudiant->Prenom.'-'.$etudiant->Nom.'</title>
                </head>
                <body>
                    <table width="100%" border="0"  style="font-size: 18px;">
                        <tbody >
                            <tr>
                                <td>
                                
                                </td>
                                <td rowspan="2"><p align="center">Royaume du Maroc<br>
                                Université Ibn Tofail <br>
                                Ecole Supérieure de Technologie Kenitra<br>
                                </p></td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="3"><p align="center">Service des Affaires Estudiantines</p></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table width="100%" border="0"  style="font-size: 18px;">
                                        <tbody >
                                            <tr>
                                                <td height="50" colspan="3" align="center" style="text-align:center;">
                                                    <h2>Attestation</h2>
                                                    <br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td  width="45%" height="40">Le nom et le prénom de l`étudiant</td>
                                                <td  width="10%" height="40">:</td>
                                                <td  width="45%" height="40">'.$etudiant->Nom.'&nbsp;&nbsp;'.$etudiant->Prenom.'</td>
                                            </tr>
                                            <tr >
                                                <td  width="45%" height="40">Numéro de la carte d`identité nationale</td>
                                                <td  width="10%" height="40">:</td>
                                                <td  width="45%" height="40">'.$etudiant->CIN.'</td>
                                            </tr>
                                            <tr >
                                                <td  width="45%" height="40"> Code Apogee de l`étudiant</td>
                                                <td  width="10%" height="40">:</td>
                                                <td  width="45%" height="40">'.$etudiant->Apogee.'</td>
                                            </tr>
                                            <tr >
                                                <td  width="45%" height="40"> Adresse de l`étudiant</td>
                                                <td  width="10%" height="40">:</td>
                                                <td  width="45%" height="40">'.$etudiant->Adresse.'</td>
                                            </tr>
                                            <tr>
                                                <td height="40" colspan="3" >
                                                Cette etudiant est régulièrement inscrit à l`Ecole Supérieure de Technologie Kenitra pour l`année universitaire '.(date('Y')-1).'/'.date('Y').'
                                                </td>
                                            </tr>

                                            <tr>
                                                <td height="40" colspan="3" >
                                                    Diplom : DUT '.$filiere->Nom.'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="40" colspan="3"  >
                                                Année : '.$etudiant->Niveau.' DUT '.$filiere->Nom.'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="40" colspan="3"  >
                                                <br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="40" colspan="3"  >
                                                <br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="40" colspan="3"  >
                                                <br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="40" colspan="3"  >
                                                <br>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td  width="50%" height="80"></td>
                                                <td  width="0%" height="80"></td>
                                                <td  width="50%" height="80" align="center" style="font-size:12; ">
                                                    Fait à kénitra, le '.$jours[date('w',$today)].' '.date('j').' '.$mois[date('n',$today)].' '.date('Y').'
                                                    <br>Le Directeur
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </body>
            </html>';
        $pdf=App::make('dompdf.wrapper');
        $pdf->loadHTML($outetudaint);
       // return $outetudaint;
        return $pdf->stream();
    }
    public function demande($id){
        $demande=new Demande();
        $demande->Role='Etudiant';
        $demande->id_E=$id;
        $demande->save();
        return redirect()->back()->with('success','La demande a été effectue avec succès');
    }
}
