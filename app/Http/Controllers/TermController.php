<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\TermDefinition;
use App\Models\TermExample;
use App\Models\TermSynonym;
use App\Models\TermTranslation;
use App\Models\TermVariation;
use Illuminate\Http\Request;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Term::all());
    }

    public function search($term)
    {
        return response(Term::where('term', 'Like', urldecode($term) . '%')
            ->orderBy('term', 'ASC')
            ->limit(8)->offset(8)->get()->each(function($term){
            $term->definitions = TermDefinition::where('term_id', $term->id)->get();
            $term->examples = TermExample::where('term_id', $term->id)->get();
            $term->synonyms = TermSynonym::where('term_id', $term->id)->get();
            $term->translations = TermTranslation::where('term_id', $term->id)->get();
            $term->variations = TermVariation::where('term_id', $term->id)->get();            
        }));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
