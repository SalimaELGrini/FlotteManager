<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Gate;
class SettingController extends Controller
{
    public function __construct()
    {
        // Appliquer la vérification de permission pour certaines actions
        $this->middleware('can:editSettings')->only(['update']);
    }

    public function index()
    {
        $settings = Setting::all();
        return view('pages.settings.index', compact('settings'));
    }

    
        public function update(Request $request)
    {
        // Vérification si l'utilisateur a le rôle 'admin' ou 'superadmin'
            if (!in_array(auth()->user()->role, ['admin', 'user'])) {
                return redirect()->route('home')->with('error', 'Vous n\'avez pas l\'autorisation de modifier les paramètres.');
            }
                // Mettre à jour les autres paramètres
        foreach ($request->all() as $key => $value) {
            Setting::set($key, $value);
        }

        
                // Mettre à jour la langue
            Setting::set('language', $request->language);

            // Rediriger vers la même page après la mise à jour
            return back()->with('success', 'Les paramètres ont été mis à jour');
    }

}
