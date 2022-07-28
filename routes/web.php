<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Kernel;
use App\Models\Filiere;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $fil=Filiere::all();
    return view('Home',compact('fil'));
})->name('Home');
Route::post('/Inscription','InscriptionController@store')->name('Inscription');
Route::prefix('/Admin')->group(function () {
    
    Route::group(['middleware' => ['alreadyLogin', 'web']], function() {
        Route::get('/', 'AgentController@index')->name('Admin.Login');
        Route::post('/','AgentController@Login')->name('Admin.Login');
    });
    Route::group(['middleware' => ['authCheck', 'web']], function() {
        Route::get('/Dashbord','AgentController@Dashbord')->name('Admin.Dashbord');
        Route::get('/Profile','AgentController@Profile')->name('Admin.Profile');
        Route::get('/Logout','AgentController@Logout')->name('Admin.Logout');
        Route::post('/Update/{id}','AgentController@update')->name('Admin.update');
        Route::post('/Image/{id}','AgentController@updateimg')->name('Admin.Image');

        Route::get('/Filiere','FiliereController@index')->name('Admin.Filiere');
        Route::post('/Filiere','FiliereController@store')->name('Admin.Filiere');
        Route::put('/Update/Filiere/{id}','FiliereController@update')->name('Admin.Filiere.update');
        Route::get('/Filiere/{id}','FiliereController@destroy')->name('Admin.Filiere.destroy');
        Route::get('/Filiere/show/{id}','FiliereController@show')->name('Admin.Filiere.show');
        Route::post('/Filiere/pdf/{id}','FiliereController@pdf')->name('Admin.Filiere.pdf');
        
        Route::get('/Etudiant','EtudiantController@index')->name('Admin.Etudiant');
        Route::post('/Etudiant/update/{id}','EtudiantController@update')->name('Admin.Etudiant.update');
        Route::post('/Etudiant/Image/{id}','EtudiantController@Image')->name('Admin.Etudiant.Image');
        Route::get('/Etudiant/{id}','EtudiantController@destroy')->name('Admin.Etudiant.destroy');
        
        Route::post('/Enseignant_Filiere','EnseignantFiliereController@store')->name('Admin.EnseignantFiliere');
        Route::post('/Enseignant_Filiere/update/{id}','EnseignantFiliereController@update')->name('Admin.EnseignantFiliere.update');
        Route::get('/Enseignant_Filiere/{id}','EnseignantFiliereController@destroy')->name('Admin.EnseignantFiliere.destroy');

        Route::get('/Enseignant','EnseignantController@index')->name('Admin.Enseignant');
        Route::post('/Enseignant/Image/{id}','EnseignantController@Image')->name('Admin.Enseignant.Image');
        Route::get('/Enseignant/show/{id}','EnseignantController@show')->name('Admin.Enseignant.show');
        Route::post('/Enseignant','EnseignantController@store')->name('Admin.Enseignant');
        Route::post('/Enseignant/update/{id}','EnseignantController@update')->name('Admin.Enseignant.update');
        Route::get('/Enseignant/{id}','EnseignantController@destroy')->name('Admin.Enseignant.destroy');

        Route::get('/Inscription','InscriptionController@index')->name('Admin.Inscription');
        Route::post('/Inscription/update/{id}','InscriptionController@update')->name('Admin.Inscription.update');
        Route::get('/Inscription/{id}','InscriptionController@destroy')->name('Admin.Inscription.destroy');

        Route::get('/demande','DemandeController@index')->name('Admin.Demande');
        Route::post('/demande/{id}','DemandeController@update')->name('Admin.Demande.update');
        Route::get('/demande/destroy/{id}','DemandeController@destroy')->name('Admin.Demande.destroy');
        
        Route::get('/Agent','AgentController@Agent')->name('Admin.Agent');
        Route::post('/Agent','AgentController@store')->name('Admin.Agent');

    });
    
});
Route::get('/demande', function () {
    return view('Admin.Demande');
});
Route::prefix('/Etudiant')->group( function () {
    Route::group(['middleware' => ['authCheckEtudiant', 'web']], function() {
        Route::get('/Home','EtudiantController@show')->name('Etudiant.Home');
        Route::get('/logout','EtudiantController@Logout')->name('Etudiant.Logout');
        Route::post('/Etudiant/Image/{id}','EtudiantController@Image')->name('Etudiant.Image');
        Route::post('/Etudiant/update/{id}','EtudiantController@update')->name('Etudiant.update');
        Route::post('/Etudiant/password/{id}','EtudiantController@password')->name('Etudiant.Password');
        Route::get('/Etudiant/demande/{id}','EtudiantController@demande')->name('Etudiant.demande');
        Route::get('/Etudiant/download/{id}','EtudiantController@download')->name('Etudiant.download');

    }); 
    
    Route::group(['middleware' => ['alreadyLoginEtudiant', 'web']], function() {
        Route::post('/','EtudiantController@Login')->name('Etudiant.Login');
        Route::get('/','EtudiantController@Log')->name('Etudiant.Login');
    }); 
});
Route::prefix('/Enseignant')->group( function () {
    Route::post('/Login','EnseignanttController@Login')->name('Enseignant.Login');
    Route::post('/Register','EnseignanttController@Register')->name('Enseignant.Register');
    Route::get('/',function(){
        return view('Users.Enseignant.Login');
    })->name('Enseignant');
});





