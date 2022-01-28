<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nome
 * @property boolean $active
 * @property int $categoria_pai_id
 * @property int $created_by
 * @property int $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Categoria extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'nome',
        'active',
        'categoria_pai_id',
        'created_by',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriaPai()
    {
        return $this->belongsTo(self::class, 'categoria_pai_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categoriasFilhas()
    {
        return $this->hasMany(self::class, 'categoria_pai_id', 'id');
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAtivado($query)
    {
        return $query->where('active', true);
    }
}
