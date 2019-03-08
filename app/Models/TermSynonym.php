<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermSynonym extends Model
{
    protected $table = 'term_synonyms';
    public function term()
    {
        return $this->belongsTo('App\Models\Term', 'term_id');
    }
}
