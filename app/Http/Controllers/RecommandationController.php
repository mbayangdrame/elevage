<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recommandation;
use App\Notifications\RecommendationNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RecommandationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function indexlisteRecomandation()
     {
         $recomm = Recommandation::with('veterinaire')->get();
         return response()->json($recomm, 200);
     }

    public function index()
    {
        //
        $recomm = Recommandation::all();
        return response()->json($recomm, 200);
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
    public function store(Request $request,Recommandation $mod)
    {
        //
    //     $user= Auth::user();
   
            $id_veterinaire = $request->id_veterinaire;
            $description = $request->description;
            $image = $request->image;
            $dateEnvoie = $request->dateEnvoie;
            $Titre = $request->Titre;
            $conseils = $request->conseils;
           
            $imagePath = $request->file('image')->store('uploads','public');
          
                
                $mod->id_veterinaire=$id_veterinaire;
                $mod->description=$description;
                $mod->image=$imagePath;
                $mod->dateEnvoie=$dateEnvoie;
                $mod->Titre=$Titre;
                $mod->conseils=$conseils;
                $mod->save();

                $eleveurs = User::where('profil','eleveur')->get();
                Notification::send($eleveurs,new RecommendationNotification($mod));
        
               
                return response()->json([
                    'mod' =>$mod,
                    'status'=> 200,
                    
                    'message' => 'Recommandation publiée avec succès'
                    
                ]);
               
                $mod->save();
                return response()->json([
                    'mod' =>$mod,
                    'status'=> 200,
                    'msg' => "recommandations  inserer avec succes ",
                    
                ]);
    }
    public function getVeterinarianNotifications()
    {
        $veterinarian = Auth::user();
        $notifications = $veterinarian->notifications;
    
        return response()->json($notifications);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 
    
     public function show(string $id)
     {
         $recomm = Recommandation::with('veterinaire')->find($id);
         
         if (!$recomm) {
             return response()->json(['error' => 'Recommandation non trouvée'], 404);
         }
     
         return response()->json($recomm, 202);
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
    public function update(Request $request, string $id)
    {
        $r = Recommandation::find($id);
        
        if (!$r) {
            return response()->json(['message' => 'Recommandation non trouvé'], 404);
        }
        
        $r->id_veterinaire = $request->input('id_veterinaire');
        $r->description = $request->input('description');
        $r->image = $request->input('image');
        $r->dateEnvoie = $request->input('dateEnvoie');
        $r->Titre = $request->input('Titre');
        $r->conseils = $request->input('conseils');
    
        $r->save();
        
        return response()->json($r, 202);
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
        $re = Recommandation::find($id);
        $re->delete();
        return response()->json($re,203);
    }
}