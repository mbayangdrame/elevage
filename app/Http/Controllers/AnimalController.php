<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function indexlisteAnimaux()
     {
         $product = Animal::with('user')->get();
         return response()->json($product, 200);
     }
 

    public function index()
    {
        $products = Animal::all();
        return response()->json($products, 200);
    }
    public function indexliste()
    {
        $products = Animal::all();
        return response()->json($products, 200);
    }

    // Afficher le formulaire de création de produit
    public function create()
    {
        return view('products.create');
    }

    // Enregistrer un nouveau produit
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads', 'public');
        } else {
            $imagePath = null; // Si aucune image n'est téléchargée
        }
    
        $animal = new Animal([
            'Nom' => $request->input('Nom'),
            'race' => $request->input('race'),
            'poids' => $request->input('poids'),
            'NomAliments' => $request->input('NomAliments'),
            'quantite' => $request->input('quantite'),
            'sexe' => $request->input('sexe'),
            'age' => $request->input('age'),
            'prix' => $request->input('prix'),
            'Description' => $request->input('Description'),
            'user_id' => $request->input('user_id'),
            'image' => $imagePath, 
        ]);
    
        $animal->save();
    
        
        return response()->json(['message' => 'Animal créé avec succès'], 201); 
    }
    
    

    // Afficher les détails d'un produit
    public function show(string $id)
    {
        $product = Animal::find($id);
        return response()->json($product, 202);
        
    }

    // Afficher le formulaire de modification d'un produit
    public function edit($id)
    {
        $product = Animal::find($id);
        return response()->json($product, 203);
       
    }

    // Mettre à jour un produit
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'Nom' => 'required', 
        //     'race' => 'required',
        //     'poids' => 'required',
        //     'NomAliments' => 'required',
        //     'quantite' => 'required',
        //     'image' => 'required|image|mimes:jpeg,png,jpg,svg,gif|max:2048',
        //     'sexe' => 'required',
        //     'age' => 'required',
        //     'prix' => 'required',
        //     'Description' => 'required',
        //     'user_id' => 'required',
        // ]);
    
        $product = Animal::find($id);
    
        // Check if the Animal with the given ID exists
        if (!$product) {
            return response()->json(['error' => 'Animal not found'], 404);
        }
    
        $product->Nom = $request->input('Nom');
        $product->race = $request->input('race');
        $product->poids = $request->input('poids');
        $product->NomAliments = $request->input('NomAliments');
        $product->quantite = $request->input('quantite');
    
        // Handle image upload
        if ($request->hasFile('image')) {
            try {
                $imagePath = $request->file('image')->store('uploads', 'public');
                $product->image = $imagePath;
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error uploading image'], 500);
            }
        }
    
        $product->sexe = $request->input('sexe');
        $product->age = $request->input('age');
        $product->prix = $request->input('prix');
        $product->user_id = $request->input('user_id');
        $product->Description = $request->input('Description');
    
        $product->save();
        
        return response()->json($product, 200);
    }
    

    // Supprimer un produit
    public function destroy($id)
    {
        $product = Animal::find($id);
        $product->delete();
        return response()->json($product, 205);
    }
}
