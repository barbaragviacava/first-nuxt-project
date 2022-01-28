<?php

use App\Models\Produto;

dataset('produto_geralt', function () {
    yield fn() => Produto::factory()->create(['nome' => 'Geralt de Rivia']);
});
