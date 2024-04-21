<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Epresence extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'is_approve',
        'waktu'
    ];

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }
}
