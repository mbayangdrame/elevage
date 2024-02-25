<?php

use Illuminate\Http\Request;
use  App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\PanierController ;
use App\Http\Controllers\RecommandationController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\EleveurController;
use App\Http\Controllers\VeterinaireController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/veteliste', [VeterinaireController::class, 'index']);
Route::post('/veterinaire', [VeterinaireController::class, 'store']);
Route::post('/panier', [PanierController::class, 'store']);

Route::get('/lister', [AnimalController::class, 'index']);

Route::post('/commande', [CommandeController::class, 'store']);
Route::get('/listecommande', [CommandeController::class, 'index']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('/detailsVeterinaire{id}', [VeterinaireController::class, 'show']);
Route::POST('/filtrage', [VeterinaireController::class, 'filtrage']);
Route::get('/listeVeterinaire', [VeterinaireController::class, 'index']);
Route::get('/detail{id}', [AnimalController::class, 'show']);
Route::get('/recomme{id}', [RecommandationController::class,'show']);
 //pour les route rendez vous

 Route::get('/listerrecommande', [RecommandationController::class, 'index']);
 Route::put('/show{id}', [AnimalController::class,'show']);
 Route::put('/update{id}', [AnimalController::class,'update']);
 Route::middleware('auth:sanctum')->group(function () {
 
    Route::get('/remandation', [RecommandationController::class, 'index']);
    Route::get('/rendezVous', [RendezVousController::class, 'index']);
    Route::post('/AjouteRecomandation', [RecommandationController::class, 'store']);
    Route::get('/notifieEleveur', [RecommandationController::class, 'getVeterinarianNotifications']);
    Route::post('/ajouter', [AnimalController::class, 'store']);
    Route::post('/validation', [PanierController::class, 'validerCommande']);
    Route::get('userliste', [AuthController::class, 'userliste']);
    Route::get('/userlistee{id}', [AuthController::class,'show']);
 
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::delete('/destroy{id}', [AnimalController::class,'destroy']);
    Route::put('/accepterRendezvous/{rendezvous}', [RendezvousController::class, 'accepterRendezvous']);
    Route::put('/refuserRendezvous/{rendezvous}', [RendezvousController::class, 'refuserRendezvous']);
    Route::get('/notifiRendez', [RendezvousController::class, 'rendezVousNotifications']);
    Route::get('/notifiVete', [RendezvousController::class, 'notifications']);

    Route::put('/accepte{id}', [CommandeController::class, 'accepterCommande']);
    Route::get('/listeeleveur', [AnimalController::class, 'indexliste']);
    Route::post('/rendez', [RendezVousController::class, 'create']);

    Route::get('/indexlisteRecomandation', [RecommandationController::class, 'indexlisteRecomandation']);
    Route::get('/indexlisteAnimaux', [AnimalController::class,'indexlisteAnimaux']);
   
});