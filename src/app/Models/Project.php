<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    // uuidをpkにするためのフラグ
    public $incrementing = false;
    public $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'problem',
        'people',
        'period',
        'stack',
        'effort',
        'trouble',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
