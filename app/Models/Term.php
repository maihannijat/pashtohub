<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $table = 'terms';

/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
    ];

    public function term_definitions()
    {
        return $this->hasMany('App\Models\TermDefinition');
    }

    public function term_examples()
    {
        return $this->hasMany('App\Models\TermExample');
    }

    public function term_synonyms()
    {
        return $this->hasMany('App\Models\TermSynonym');
    }

    public function term_translations()
    {
        return $this->hasMany('App\Models\TermTranslation');
    }

    public function term_variations()
    {
        return $this->hasMany('App\Models\TermVariation');
    }
}
