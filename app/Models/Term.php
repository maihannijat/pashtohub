<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
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
        return $this->hasMany('App\Models\TermSynonyms');
    }

    public function term_translation()
    {
        return $this->hasMany('App\Models\TermTranslations');
    }

    public function term_variations()
    {
        return $this->hasMany('App\Models\TermVariations');
    }
}
