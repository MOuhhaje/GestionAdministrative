<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Filiere;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class FiliereController extends Controller
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
        $filieres=Filiere::all()->sortDesc();
             return view('Admin.Filiere',compact('filieres','agent')); 
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
    public function store(Request $req)
    {
        $req->validate([
            'Image'=>'image|max:512',
            'Capacite'=>'required|numeric',
            'Nom'=>'required',
            'Description'=>'required',
        ]);
        $filiere=new Filiere();
        $filiere->Nom=$req->Nom;
        $filiere->Capacite=$req->Capacite;
        $filiere->Description=$req->Description;
        if($req->hasfile('Image')){
            $file=$req->file('Image');
            $extention=$file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('uploads/filieres',$filename);
            $filiere->Image=$filename;
        }
        $filiere->save();
        return redirect()->back()->with('success', 'Filière a été créé avec succès!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $filiere=Filiere::find($id);
        if(Session::has('AdminId')){
            $agent=Agent::where('id','=',Session::get('AdminId'))->first();
        }
        $etudiants=Etudiant::where('F_ID','=',$id)->get(); 

        return view('Admin.showfiliere',compact('agent','filiere','etudiants'));
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
            'Image'=>'image',
            'Capacite'=>'required|numeric',
            'Nom'=>'required',
            'Description'=>'required',
        ]);
        if($request->hasfile('Image')){
            $file=$request->file('Image');
            $extention=$file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('uploads/filieres',$filename);
            Filiere::where('id',$id)->update([
                'Image'=>$filename
            ]);
        }
        Filiere::where('id',$id)->update([
            'Nom'=>$request->Nom,
            'Capacite'=>$request->Capacite,
            'Description'=>$request->Description,
        ]);
        return redirect()->back()->with('success', 'Filière a été créé avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $filiere = Filiere::find($id);
        $filiere->delete();
        return back()->with('danger', 'Filière a été supprimé avec succès!');
    }
    public function pdf(Request $request,$id){
            $filiere=Filiere::find($id);
            $etudiants1=Etudiant::where([['F_ID','=',$id],['Niveau','=',$request->Niveau]])->get();
            $output='<title>Classe'.$filiere->Nom.'</title>
                    <h3 align="center">'.$request->Niveau.' '.$filiere->Nom.'</h3>
                    <table  width="100%" style="border-collapse: collapse; border: 0px; font-size: 12.3px ">
                        <tr>
                            <th style="border: 0.5px solid; padding:5px; background-color:#d3eaf2 !important;" >Nom</th>
                            <th style="border: 0.5px solid; padding:5px; background-color:#d3eaf2 !important;" >Prenom</th>
                            <th style="border: 0.5px solid; padding:5px; background-color:#d3eaf2 !important;" >CIN</th>
                            <th style="border: 0.5px solid; padding:5px; background-color:#d3eaf2 !important;" >Apogee</th>
                            <th style="border: 0.5px solid; padding:5px; background-color:#d3eaf2 !important;" >Date de Naissance</th>
                            <th style="border: 0.5px solid; padding:5px; background-color:#d3eaf2 !important; width: 20px;" >A</th>
                            <th style="border: 0.5px solid; padding:5px; background-color:#d3eaf2 !important; width: 20px;" >P</th>
                            
                        </tr>';  
            foreach($etudiants1 as $etudiant){
                $output .= '
                        <tr align="center">
                            <td style="border: 0.5px solid; padding:5px;">'.$etudiant->Nom.'</td>
                            <td style="border: 0.5px solid; padding:5px;">'.$etudiant->Prenom.'</td>
                            <td style="border: 0.5px solid; padding:5px;">'.$etudiant->CIN.'</td>
                            <td style="border: 0.5px solid; padding:5px;">'.$etudiant->Apogee.'</td>
                            <td style="border: 0.5px solid; padding:5px;">'.$etudiant->Naissance.'</td>
                            <td style="border: 0.5px solid; padding:5px;"></td>
                            <td style="border: 0.5px solid; padding:5px;"></td>
                        </tr>
                        ';
            }
            $output .= '</table>';
            $pdf=App::make('dompdf.wrapper');
            $pdf->loadHTML($output);
            return $pdf->stream();
    }
}
