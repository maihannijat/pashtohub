<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Term;
use App\Models\TermDefinition;
use App\Models\TermExample;
use App\Models\TermSynonym;
use App\Models\TermTranslation;
use App\Models\TermVariation;
use App\Utils\SendEmail;
use Illuminate\Http\Request;
use Exception;

class TermController extends BaseController
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

    /**
     * Search for term and return complete result if found
     * @param $term
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function search($term)
    {
        try {
            return response(Term::where('term', 'Like', urldecode($term) . '%')
                ->orderBy('term', 'ASC')
                ->limit(8)->offset(8)->get()->each(function ($term) {
                    $term->definitions = TermDefinition::where('term_id', $term->id)->get();
                    $term->examples = TermExample::where('term_id', $term->id)->get();
                    $term->synonyms = TermSynonym::where('term_id', $term->id)->get();
                    $term->translations = TermTranslation::where('term_id', $term->id)->get();
                    $term->variations = TermVariation::where('term_id', $term->id)->get();
                }));
        } catch (Exception $exception) {
            // Send email to the administrator
            SendEmail::sendError($exception);
            return response(['error' => 'Something went wrong - Unable to search for the term'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
