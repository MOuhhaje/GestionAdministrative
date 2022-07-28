<?php

namespace App\Providers;

use App\Models\Agent;
use App\Models\Demande;
use App\Models\Etudiant;
use App\Models\Enseignant;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $demande=array();
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $etudiants=Etudiant::all();
        $enseignants=Enseignant::all();
        $this->demande['count']=Demande::where('Status','En attant')->count();
        $this->demande['dataAll']=Demande::all();
        $this->demande['data']=Demande::where('Status','En attant')->get();
        $this->demande['etudiant']=array();
        $this->demande['enseignant']=array();
        foreach ($etudiants as $value) {
            foreach ($this->demande['data'] as $key ) {
                if ($value->id==$key->id_E) {
                    array_push($this->demande['etudiant'],$value);
                }
            }
        }
        foreach ($enseignants as $value1) {
            foreach ($this->demande['data'] as $key1 ) {
                if ($value1->id==$key1->id_P) {
                    array_push($this->demande['enseignant'],$value1);
                }
            }
        }
        
        view()->composer('Layouts.Admin', function ($view)
        {
            $view->with('demande',$this->demande);
        });
        view()->composer('Admin.Demande', function ($view)
        {
            $this->demande['etudiant']=Etudiant::all();
            $this->demande['enseignant']=Enseignant::all();
            $view->with('demande',$this->demande);
        });
        view()->composer('Layouts.Admin', function ($view)
        {
            if(Session::has('AdminId')){
                $agent=Agent::where('id','=',Session::get('AdminId'))->first();
            }
            $view->with('agent',$agent);
        });
    }
}
