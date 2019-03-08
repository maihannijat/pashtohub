<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermDefinition extends Model
{
    protected $table = 'term_definitions';
    public function term()
    {
        return $this->belongsTo('App\Models\Term', 'term_id');
    }
}
