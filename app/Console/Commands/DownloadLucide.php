<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class DownloadLucide extends Command
{
    protected $signature = 'download:lucide';
    protected $description = 'Télécharger lucide.js et le placer dans public/assets/js/';

    public function handle()
    {
        $jsPath = public_path('assets/js');

        // Créer dossier si makaynch
        if (!File::exists($jsPath)) {
            File::makeDirectory($jsPath, 0755, true);
            $this->info(' Dossier public/assets/js créé.');
        }

        // lien dyal lucide.js
        $url = 'https://unpkg.com/lucide@latest/dist/umd/lucide.js';
        $destination = $jsPath . '/lucide.js';

        // Télécharger le contenu
        $response = Http::get($url);

        if ($response->successful()) {
            File::put($destination, $response->body());
            $this->info(' Fichier lucide.js téléchargé et enregistré dans public/assets/js/');
        } else {
            $this->error(' Erreur lors du téléchargement de lucide.js');
        }
    }
}

