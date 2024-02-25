<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Commande;
use App\Models\User;
use App\Models\Commandeproduit;
use Illuminate\Support\Facades\Auth;
use Cart; 
class PanierController extends Controller
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
        // Assurez-vous que l'id est passé dans la requête
        $productId = $request->input('id');
        
        // Recherchez l'animal par son id
        $product = Animal::find($productId);

        if ($product) {
            // Ajoutez le produit au panier
            Cart::add(array(
                'id' => $product->id, // L'id du produit
                'name' => $product->Nom,
                'price' => $product->prix,
                'quantity' => 1, // Vous pouvez ajuster la quantité selon votre besoin
            ));

            return response()->json(['message' => 'Produit ajouté au panier']);
        } else {
            return response()->json(['message' => 'Produit non trouvé'], 404); // Produit non trouvé
        }
    }

    public function validerCommande(Request $request)
    {
        // Validation des données
        $request->validate([
            'total' => 'required|numeric',
            'id_clients' => 'required|integer',
            'adresse_de_livraison' => 'required|string',
            'panier' => 'required|array',
            'panier.*.id_animal' => 'required|integer',
            'panier.*.quantite' => 'required|integer',
            'panier.*.prix' => 'required|numeric',
        ]);
    
        // Création d'une nouvelle commande
        $commande = new Commande();
        $commande->reference = uniqid();
        $commande->total = $request->input('total');
        $commande->id_clients = $request->input('id_clients');
        $commande->adresse_de_livraison = $request->input('adresse_de_livraison');
        $commande->save();
    
        // Ajout des produits du panier à la commande
        foreach ($request->input('panier') as $item) {
            $commandeProduit = new CommandeProduit();
            $commandeProduit->commande_id = $commande->id;
            $commandeProduit->id_animal = $item['id_animal'];
            $commandeProduit->quantite = $item['quantite'];
            $commandeProduit->prix = $item['prix'];
            $commandeProduit->save();
        }
    
        // Vider le panier après la validation de la commande (vous devrez peut-être ajuster selon votre logique)
        // Cart::clear();
    
        return response()->json(['message' => 'Commande validée avec succès'],200);
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
