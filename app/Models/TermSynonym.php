<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermSynonym extends Model
{
    public function term()
    {
        return $this->belongsTo('App\Models\Term', 'term_id');
    }
}
