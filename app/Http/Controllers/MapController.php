<?php

namespace App\Http\Controllers;

use App\Models\Ong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
    public function index()
    {
        return view('geolocalizacao');
    }

    public function getOngs()
    {
        $ongs = Ong::select('nomeOng', 'cepOng', 'biografiaOng', 'fotoOng')->get();
        $googleApiKey = config('services.google.maps_key');
        
        $ongLocations = [];

        foreach ($ongs as $ong) {
            $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json", [
                'address' => $ong->cepOng,
                'key' => $googleApiKey
            ]);

            $locationData = $response->json();

            if ($locationData['status'] === 'OK' && !empty($locationData['results'])) {
                $coordinates = $locationData['results'][0]['geometry']['location'];

                $ongLocations[] = [
                    'nome' => $ong->nomeOng,
                    'latitude' => $coordinates['lat'],
                    'longitude' => $coordinates['lng'],
                    'biografia' => $ong->biografiaOng,
                    'foto' => asset('storage/uploads/' . $ong->fotoOng),
                ];
            }
        }

        return response()->json($ongLocations);
    }
}
