<?php

use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/api/ibge/municipios', function () {
    return Cache::remember('ibge.municipios.v1', now()->addDays(7), function () {
        $response = Http::timeout(20)->get('https://servicodados.ibge.gov.br/api/v1/localidades/municipios');
        $response->throw();

        return collect($response->json())
            ->map(fn ($municipio) => [
                'id' => $municipio['id'],
                'city' => $municipio['nome'],
                'uf' => data_get($municipio, 'microrregiao.mesorregiao.UF.sigla'),
                'state' => data_get($municipio, 'microrregiao.mesorregiao.UF.nome'),
                'region' => data_get($municipio, 'microrregiao.mesorregiao.UF.regiao.nome'),
            ])
            ->sortBy([
                ['state', 'asc'],
                ['city', 'asc'],
            ])
            ->values()
            ->all();
    });
});

Route::post('/api/email', [EmailController::class, 'store']);

Route::view('/{path}', 'welcome')->where('path', '.*');
