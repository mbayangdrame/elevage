<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Veterinaire;

class AuthController extends Controller
{
    public function userliste(){
        $users = User::all();
        return response()->json($users, 200);
    }

    public function show(string $id)
    {
        $users = User::find($id);
        return response()->json($users, 202);
        
    }


    public function register(Request $request)
    {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        } else {
            $imagePath = null; 
        }
        $user = new User([
            'prenom' => $request->input('prenom'),
            'nom' => $request->input('nom'),
            'adresse' => $request->input('adresse'),
            'NumeroTelephone' => $request->input('NumeroTelephone'),
            'profil' => $request->input('profil'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'image' => $imagePath,
           
        ]);
        $user->save();
        if ($request->input('profil') === 'veterinaire') {
            $vet = new Veterinaire([
                'id_users' => $user->id,
                'Nomcabinet' => $request->input('Nomcabinet'),
                'specialite' => $request->input('specialite'),
            ]);
    
            $vet->save();
        }
    
        return response()->json(['message' => 'Utilisateur et vétérinaire créés avec succès'], 201);
       
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'message' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }
    
        $user = Auth::user();
    
        $token = $user->createToken('token')->plainTextToken;
    
        // Définir le cookie avec le token
        $cookie = cookie('jwt', $token, 60 * 24); // 1 day
    
        return response([
            'message' => $token
        ])->withCookie($cookie);
    }
    

    public function user()
    {
        return response()->json(Auth::user());
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Success'
        ],200)->withCookie($cookie);
    }
}
