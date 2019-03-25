<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\TermDefinition;
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
        return response(Term::where('term', 'Like', $term . '%')->orderBy('term', 'ASC')->get());
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
        $term = Term::where('id', $id)->first();
        $term->definitions = TermDefinition::where('term_id', $term->id)->get();
        $term->examples = TermVariation::where('term_id', $term->id)->get();
        $term->synonyms = TermVariation::where('term_id', $term->id)->get();
        $term->translations = TermVariation::where('term_id', $term->id)->get();
        $term->variations = TermDefinition::where('term_id', $term->id)->get();
        return response($term);
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
