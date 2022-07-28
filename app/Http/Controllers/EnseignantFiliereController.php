<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnseignantFiliere;


class EnseignantFiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'Filiere'=>'required',
            'Heures'=>'required|numeric|min:2|max:20',
            'Module'=>'required|string',
            'id_P'=>'required'
        ]);
        
        $filieres=EnseignantFiliere::where('id_P','=',$request->id_P)->get();
        foreach ($filieres as $filiere) {
            if($filiere->id_F==$request->Filiere && $filiere->Module==$request->Module){
                return redirect()->back()->with('danger','Cette relation existe déjà, il suffit de la modifier'); 
            }
        }

        $heures=EnseignantFiliere::where('id_P','=',$request->id_P)->sum('Heures')+$request->Heures;
        if ($heures>40) {
            return redirect()->back()->with('danger','Le nombre total d\'heures doit être inférieur à 40 heures/semaine');
        }

        $rel=new EnseignantFiliere();
        $rel->Heures=$request->Heures;
        $rel->id_P=$request->id_P;
        $rel->id_F=$request->Filiere;
        $rel->Module=$request->Module;
        $rel->save();
        return redirect()->back()->with('success','L\'Enseignant a été Affecter avec succès');
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
        $request->validate([
            'Heures'=>'required|numeric|min:2|max:20'
        ]);
        $lastH=EnseignantFiliere::find($id);
        $heures=EnseignantFiliere::where('id_P','=',$request->id_P)->sum('Heures')+$request->Heures-$lastH->Heures;
        if ($heures>20) {
            return redirect()->back()->with('danger','Le nombre total d\'heures doit être inférieur à 20 heures/semaine');
        }
       EnseignantFiliere::where('id',$id)->update([
            'Heures'=>$request->Heures
       ]);
       return redirect()->back()->with('success','La relation a été  mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $enseignantFiliere = EnseignantFiliere::find($id);
        $enseignantFiliere->delete();
        return back()->with('danger', 'la relation a été supprimé avec succès!');
    }
}
