<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Filiere;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Inscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function Agent(){
        if(Session::has('AdminId')){
            $agent=Agent::where('id','=',Session::get('AdminId'))->first();
        }
        $agents=Agent::orderBy('Nom','desc')->get();
        
        return view('Admin.Agent',compact('agent','agents'));
    }
    public function index()
    {
        return view('Admin.Login');
    }
    public function Login(Request $request){
        $request->validate([
            'Username'=>'required',
            'Password'=>'required'
        ]);
        $agent=Agent::where('Matricule','=',$request->Username)->first();
        if($agent){
            if(Hash::check($request->Password,$agent->Password)){
                $request->session()->put('AdminId',$agent->id);
                $msg='';
                if($agent->Prenom==null || $agent->Nom==null){
                    $msg='Welcome Administrateur!';
                }else{
                    $msg='Welcome '.$agent->Nom.' '.$agent->Prenom.' !';
                }
                return redirect('Admin/Dashbord')->with('success',$msg);
            }else {
                return back()->with('danger','Password incorrect !!');
            }
        }
        else {
            return back()->with('danger','Matricule n`exist pas !!');
        }
        
    }
    public function Dashbord(){

        if(Session::has('AdminId')){
            $agent=Agent::where('id','=',Session::get('AdminId'))->first();
        }
        
        $inscription=Inscription::latest()->take(4)->get();
        $data[0]=Inscription::count();
        $data[1]=Etudiant::count();
        $data[2]=Enseignant::count();
        $data[3]=Filiere::count();
        $data[4]=Agent::count();
       
        return view('Admin.Dashbord',compact('inscription','data','agent')); 
    }


    public function Profile(){
        if(Session::has('AdminId')){
            $agent=Agent::where('id','=',Session::get('AdminId'))->first();
            return view('Admin.Profile',compact('agent'));
        }
        return view('Admin.Profile');
    }
    public function Logout(){
        if(Session::has('AdminId')){
            Session::pull('AdminId');
            return redirect('Admin');
        }
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
            'CIN'=>'required|unique:agents,CIN',
            'Email'=>'required|unique:agents,Email'
        ]);
        $agent=new Agent();
        $agent->CIN=$request->CIN;
        $agent->Nom=$request->Nom;
        $agent->Prenom=$request->Prenom;
        $agent->Email=$request->Email;
        $agent->Matricule=$this->GetMatricule();
        $agent->Password=Hash::make("mouhhaje");
        $agent->save();
        return redirect()->back()->with('ssuccess','Vous avez ajouté un autre administrateur');
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
    public function update(Request $req, $id)
    {
        $req->validate([
            'Email'=>'unique:agents,Email,'.$id.'|email',
            'CIN'=>'unique:agents,CIN,'.$id,
        ]);

        $agent=Agent::find($id);
        $agent->Nom=$req->Nom;
        $agent->Prenom=$req->Prenom;
        $agent->Adresse=$req->Adresse;
        $agent->CIN=$req->CIN;
        $agent->Email=$req->Email;
        $agent->save();
        return redirect('Admin/Profile')->with('success','Vos informations ont été mises à jour !'); 

    }
    public function updateimg(Request $req, $id){
        $req->validate([
            'Image'=>'image|mimes:jpeg,png,jpg,svg|max:512'
        ]);
        
        $agent=Agent::find($id);
        if($req->hasfile('Image')){
            $file=$req->file('Image');
            $extention=$file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('uploads/agents',$filename);
            $agent->img=$filename;
        }
        $agent->save();
        return redirect()->back()->with('success','Votre photo a été mise à jour !'); 
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    protected function GetMatricule(){
        A:
        $agents=DB::select('select * from agents order by  Matricule');
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
        foreach ($agents as $agent ) {
            if ($randstring!=$agent->Matricule) {
                return $randstring;
            }
            else{
                goto A;
                
            }
        }
    }



}

