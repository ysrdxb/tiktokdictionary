<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefinitionReaction extends Model
{
    protected $fillable = ['definition_id', 'ip_address', 'type'];
}
