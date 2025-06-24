<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\Intervention;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
class NotificationController extends Controller
{
    // Créer une notification pour le SuperAdmin
    public function createNotificationForAdmin($message)
    {
        if (Setting::get('notifications_enabled') == 'true') {
            Notification::create([
                'user_id' => 1, // ID du SuperAdmin
                'type' => 'intervention',
                'message' => $message,
                'is_read' => false,
            ]);
        }
    }

    // Ajouter une intervention et envoyer une notification au SuperAdmin
    public function addIntervention(Request $request)
    {
        $intervention = Intervention::create([
            'user_id' => Auth::id(),
            'description' => $request->description,
            'date' => now(),
        ]);

        // Si l'utilisateur n'est pas un utilisateur standard, envoyer une notification au SuperAdmin
        if (auth()->user()->role !== 'user') {
            $this->createNotificationForAdmin(" Nouvelle intervention de " . Auth::user()->name);
        }

        return response()->json(['success' => true, 'intervention' => $intervention]);
    }

    // Marquer une notification comme lue
    /*public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)->where('user_id', Auth::id())->first();
        if ($notification) {
            $notification->update(['is_read' => true]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Notification non trouvée'], 404);
    }*/




   /* Supprimer une notification
    public function deleteNotification($id)
    {
        $notification = Notification::where('id', $id)->where('user_id', Auth::id())->first();
        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Notification non trouvée'], 404);
    }*/

    // Compter les notifications non lues
    public function countNotifications()
    {
        $count = auth()->user()->unreadNotifications()->count();
        return response()->json(['count' => $count]);
    }

    // Récupérer les notifications selon le rôle de l'utilisateur
    public function getNotifications()
    {
        $notifications = auth()->user()->notifications->filter(function ($notification) {
            if (auth()->user()->role == 'user' && $notification->type == 'approval') {
                return $notification;
            }
            if (auth()->user()->role == 'admin') {
                return $notification;
            }
            return false;
        });

        // Transmettre les notifications à la vue
        return view('layouts.navbars.auth.topnav', compact('notifications'));
    }

    // Créer une notification pour un utilisateur spécifique
    public function createNotificationForUser($userId, $message)
    {
        if (Setting::get('notifications_enabled') == 'true') {
            Notification::create([
                'user_id' => $userId,
                'type' => 'approval',
                'message' => $message,
                'is_read' => false,
            ]);
        }
    }
    public function getAll()
    {
        $notifications = Auth::user()->unreadNotifications->map(function ($notification) {
            return [
                'id' => $notification->id,
                'message' => $notification->data['message'] ?? 'Notification',
                'time' => $notification->created_at->diffForHumans(),
            ];
        });

        return response()->json(['notifications' => $notifications]);
    }

    public function markAsRead($id)
    {
        $notification = DatabaseNotification::findOrFail($id);

        if ($notification->notifiable_id == Auth::id()) {
            $notification->delete();
        }

        $count = auth()->user()->unreadNotifications()->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }


}
