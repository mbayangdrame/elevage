<?php

namespace App\Http\Controllers;
use App\Models\Eleveur;
use App\Models\Veterinaire;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use App\Notifications\RendezVousNotification;
use App\Notifications\RefuserRendezvousNotification;
use App\Notifications\AccepterRendezvousNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class RendezVousController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rendezVous = RendezVous::with(['veterinaires', 'eleveurs'])->get();
        return response()->json($rendezVous, 201);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, RendezVous $mod)
{
    $id_eleveur = $request->id_eleveur;
    $id_veterinaire = $request->id_veterinaire;
    $dateRendezVous = $request->dateRendezVous;
    $heure = $request->heure;
    $Motif =$request-> Motif;
    
    // Vérifiez si l'heure du rendez-vous est valide
    $heureDebutTravail = '08:00:00';
    $heureFinTravail = '20:00:00';
    
    if ($heure < $heureDebutTravail || $heure > $heureFinTravail) {
        return response()->json([
            'status' => 400, 
            'message' => "Heure non disponible",
        ]);
    }
    
    // Supposons que vous ayez une propriété "profil" dans l'objet utilisateur
  
    
    // Vérifiez si le profil est "eleveurs"
    if (auth()->user()->profil === 'eleveur' ) {
       
 
    
    $mod->id_eleveur = $id_eleveur;
    $mod->id_veterinaire = $id_veterinaire;
    $mod->dateRendezVous = $dateRendezVous;
    $mod->heure = $heure;
    $mod->Motif = $Motif;
    $mod->status = 'en_attente';
    
    
    $mod->save();
    
    $veterinaires = User::where('profil','veterinaire')->get();
    Notification::send($veterinaires, new RendezVousNotification($mod));
    return response()->json([
        'status' => 200,
        'heure' => $mod,
        'message' => "Le rendez-vous a été confirmé",
    ]);
}
 else {
    return response()->json([
        'status' => 400,
        'message' => "Vous n'avez pas le droit de prendre un rendez-vous",
    ]);
 }
    // Reste de votre code
}
public function getNotifications()
{
    // Récupérer l'éleveur actuellement authentifié
    $eleveur = Auth::user();

    // Récupérer les notifications pour les rendez-vous faits par cet éleveur
    $notifications = $eleveur->notifications()->where('type', RendezVousNotification::class,AccepterRendezvousNotification::class,RefuserRendezvousNotification::class)->get();

    // Marquer les notifications comme lues si nécessaire
    // $eleveur->unreadNotifications->markAsRead();

    $accepte = $eleveur->notifications()
    ->whereIn('type', [AccepterRendezvousNotification::class, RefuserRendezvousNotification::class])
    ->get();

// Filtrer les notifications par type
$accepterNotifications = $accepte->whereInstanceOf(AccepterRendezvousNotification::class);
$refuserNotifications = $accepte->whereInstanceOf(RefuserRendezvousNotification::class);

// Vous pouvez maintenant itérer sur $accepterNotifications et $refuserNotifications
foreach ($accepterNotifications as $accepte) {
    $data = $accepte->data;

    // Ajouter les données au tableau
    $accepterNotificationsData[] = [
        'message' => $data['message'],
        'rendezvous_id' => $data['rendezvous_id'],
    ];
}

foreach ($refuserNotifications as $accepte) {
    $data = $accepte->data;

    // Ajouter les données au tableau
    $refuserNotificationsData[] = [
        'message' => $data['message'],
        'rendezvous_id' => $data['rendezvous_id'],
    ];
}
    return response()->json([
        'status' => 200,
        'notifications' => $notifications,
        'accepte'=>$accepterNotificationsData,
        'refus'=>$refuserNotificationsData
    ]);

}
public function rendezVousNotifications()
{
    // Récupérer le vétérinaire actuellement authentifié
    $veterinaire = Auth::user();

    // Récupérer les notifications de type RendezVousNotification pour ce vétérinaire
    $notifications = $veterinaire->notifications()
        ->where('type', RendezVousNotification::class)
        ->get();

    // Marquer les notifications comme lues si nécessaire
    // $veterinaire->unreadNotifications->markAsRead();

    // Vous pouvez itérer sur $notifications pour obtenir les données nécessaires
    $notificationsData = [];
    foreach ($notifications as $notification) {
        $data = $notification->data;

        // Ajouter les données au tableau
        $notificationsData[] = [
            'message' => $data['message'],
            'rendezvous_id' => $data['rendezvous_id'],
        ];
    }

    return response()->json([
        'status' => 200,
        'notifications' => $notificationsData,
    ]);
}

public function accepterRendezvous(Request $request, Rendezvous $rendezvous)
{
    // Vérifier si l'utilisateur authentifié est un vétérinaire
    if (auth()->user()->profil === 'veterinaire') {
        // Mettre à jour le statut du rendez-vous
        $rendezvous->update(['status' => 'accepté']);

        // Notifier l'éleveur
        // $rendezvous->eleveurs->notify(new AccepterRendezvousNotification($rendezvous));
        foreach ($rendezvous->eleveurs as $eleveur) {
            $eleveur->notify(new AccepterRendezvousNotification($rendezvous));
        }
        

        return response()->json(['message' => 'Rendez-vous accepté avec succès']);
    }

    return response()->json(['message' => 'Vous n\'avez pas la permission d\'accepter ce rendez-vous'], 403);
}

public function refuserRendezvous(Request $request, Rendezvous $rendezvous)
{
    // Vérifier si l'utilisateur authentifié est un vétérinaire
    if (auth()->user()->profil === 'veterinaire') {
        // Mettre à jour le statut du rendez-vous
        $rendezvous->update(['status' => 'refusé']);

        foreach ($rendezvous->eleveurs as $eleveur) {
            $eleveur->notify(new RefuserRendezvousNotification($rendezvous));
        }
        

        return response()->json(['message' => 'Rendez-vous refusé avec succès']);
    }

    return response()->json(['message' => 'Vous n\'avez pas la permission de refuser ce rendez-vous'], 403);
}

public function notifications()
{
    // Assurez-vous que l'utilisateur est authentifié
    
        // Récupérez l'utilisateur authentifié
        $user = Auth::user();

        // Vérifiez si l'utilisateur est un vétérinaire
        if ($user->profil === 'veterinaire') {
            // Récupérez les notifications pour le vétérinaire
            // $notifications = $user->notifications()->get();
            $notifications = $user->notifications()
            ->where([
                ['notifiable_type', '=', 'App\Models\User'],
                ['notifiable_id', '=', $user->id],
                ['type', '=', 'App\Notifications\RendezVousNotification'], // Modifiez le type en fonction de vos notifications
            ])
            ->orderByDesc('created_at')
            ->get();
            // Retournez les notifications sous forme de réponse JSON
            return response()->json(['notifications' => $notifications]);
        }

        // Si l'utilisateur n'est pas un vétérinaire, retournez un message d'erreur
        return response()->json(['message' => 'Vous n\'avez pas la permission d\'accéder à ces notifications.'], 403);
    

    // Si l'utilisateur n'est pas authentifié, redirigez-le vers la page de connexion ou retournez un message d'erreur
    return response()->json(['message' => 'Vous devez être connecté pour accéder à ces notifications.'], 401);
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
