<?php

namespace App\Http\Controllers;

use App\Models\Veterinaire;
use App\Models\Eleveur;
use Illuminate\Http\Request;
use App\Models\User;

class VeterinaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vet = Veterinaire::with('user')->get();;
        return response()->json($vet, 200);
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
        
        $vet = new Veterinaire([
            'id_users' => $request->input('id_users'),
            'Nomcabinet' => $request->input('Nomcabinet'),
            'specialite' => $request->input('specialite'),
            
        ]);
        $vet->save();
    
        
        return response()->json(['message' => 'le veterinaire créé avec succès'], 201); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vet = Veterinaire::with('user')->find($id);
        return response()->json($vet, 202);
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
        //
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
}
