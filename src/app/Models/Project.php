<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // uuidをpkにするためのフラグ
    public $incrementing = false;
    public $keyType = 'string';
}
