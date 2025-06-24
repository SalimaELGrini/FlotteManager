<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class DownloadAssets extends Command
{
    protected $signature = 'download:assets';
    protected $description = 'Télécharger JS & CSS assets et les placer localement dans public/assets/';

    public function handle()
    {
        $jsPath = public_path('assets/js');
        $cssPath = public_path('assets/css');

        foreach ([$jsPath, $cssPath] as $path) {
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
                $this->info(" Dossier $path créé.");
            }
        }

        $files = [
            'lucide.js' => [
                'url' => 'https://unpkg.com/lucide@latest/dist/umd/lucide.js',
                'path' => $jsPath . '/lucide.js'
            ],
            'toastr.min.js' => [
                'url' => 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js',
                'path' => $jsPath . '/toastr.min.js'
            ],
            'sweetalert2.min.js' => [
                'url' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11',
                'path' => $jsPath . '/sweetalert2.min.js'
            ],
            'bootstrap.bundle.min.js' => [
                'url' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js',
                'path' => $jsPath . '/bootstrap.bundle.min.js'
            ],
            'toastr.min.css' => [
                'url' => 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css',
                'path' => $cssPath . '/toastr.min.css'
            ],
            'sweetalert2.min.css' => [
                'url' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css',
                'path' => $cssPath . '/sweetalert2.min.css'
            ],
        ];

        foreach ($files as $name => $file) {
            $response = Http::get($file['url']);
            if ($response->successful()) {
                File::put($file['path'], $response->body());
                $this->info(" $name téléchargé.");
            } else {
                $this->error(" Erreur téléchargement $name");
            }
        }

        $this->info(' Tous les assets sont téléchargés et enregistrés localement !');
    }
}

