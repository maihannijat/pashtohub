<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermExample extends Model
{
    protected $table = 'term_examples';
    public function term()
    {
        return $this->belongsTo('App\Models\Term', 'term_id');
    }
}
