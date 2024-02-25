<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Commande;
use App\Models\Commandeproduit;
use Illuminate\Http\Request;
use Cart; 

use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    public function index()
    {
        $commandes = Commande::with(['animals','animals.animal', 'utilisateur'])->get();
        return response()->json($commandes);

    }

    public function create()
    {
        // Vous pouvez afficher le formulaire de création d'une commande ici
    }

    public function store(Request $request)
    {
        
        $cartItems = Cart::getContent();

        // Créez une nouvelle commande
        $commande = new Commande();
        $commande->reference = uniqid(); // Générez une référence unique pour la commande
        $commande->total = Cart::getTotal();
        $commande->id_clients = auth()->user()->id; // L'ID du client peut être récupéré depuis l'authentification
        $commande->adresse_de_livraison = $request->input('adresse_de_livraison');
        $commande->save();
    
        // Ajoutez les produits du panier à la commande
        foreach ($cartItems as $item) {
            $commandeProduit = new CommandeProduit();
            $commandeProduit->commande_id = $commande->id;
            $commandeProduit->id_animal = $item->id;
            $commandeProduit->quantite = $item->quantity;
            $commandeProduit->prix = $item->price;
            $commandeProduit->save();
        }
    
        // Videz le panier après la validation de la commande
        Cart::clear();
    
        return response()->json(['message' => 'Commande validée avec succès']);
    }

    public function accepterCommande(Request $request, $id)
{
    $commande = Commande::find($id);

    if (auth()->user()->profil === 'eleveur') {
        // return response()->json(['error' => 'Vous n\'avez pas la permission d\'accepter cette commande.'], 403);
    

    // Utilisez la méthode update pour mettre à jour les attributs
    $commande->update(['accepte' => true]);
    }
    // Vous pouvez envoyer une notification ici si nécessaire

    return response()->json(['message' => 'La commande a été acceptée avec succès']);
}



    public function show($id)
    {
        
    }

    public function edit($id)
    {
       
    }

    public function update(Request $request, $id)
    {
       
    }

    public function destroy($id)
    {
        
    }
}
