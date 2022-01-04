<?php

namespace App\Models;

use App\Scopes\ActiveScope;
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
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nome',
        'active',
        'categoria_pai_id',
        'created_by',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
    }

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
        return $this->hasMany(self::class, 'id', 'categoria_pai_id');
    }
}
