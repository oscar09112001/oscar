<?php

// Importo las clases necesarias para crear comandos personalizados de consola
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Aquí defino un comando de consola llamado "inspire"
// Cuando se ejecuta con: php artisan inspire
// Muestra una frase inspiradora en la terminal
Artisan::command('inspire', function () {
    // Escribe la frase inspiradora en la consola
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote'); // Esta descripción se muestra al listar los comandos con php artisan list