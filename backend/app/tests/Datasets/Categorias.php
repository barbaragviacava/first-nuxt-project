<?php

use App\Models\Categoria;

dataset('categoria_geralt', function () {
    yield fn() => Categoria::factory()->create(['nome' => 'Geralt de Rivia']);
});
