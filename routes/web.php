<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Bienvenido a la API de inventario',
        'readme' => 'https://github.com/AndersonTriana/inventory-api'
    ]);
});
