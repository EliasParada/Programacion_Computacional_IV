<?php

namespace App\Http\Controllers;

use App\Models\InscriptionsDetails;
use Illuminate\Http\Request;

class InscriptionsDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return InscriptionsDetails::get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $idInscription = InscriptionsDetails::create($request->all())->idInscription;
        $idSubject = $request->idSubject;
        return response()->json(['idInscription' => $idInscription, 'idSubject' => $idSubject], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InscriptionsDetails  $inscriptionsDetails
     * @return \Illuminate\Http\Response
     */
    public function show(InscriptionsDetails $inscriptionsDetails)
    {
        return $inscriptionsDetails;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InscriptionsDetails  $inscriptionsDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(InscriptionsDetails $inscriptionsDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InscriptionsDetails  $inscriptionsDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InscriptionsDetails $inscriptionsDetails)
    {
        $idInscription = $request->idInscription;
        $inscripciones = InscriptionsDetails::where('idInscription', $idInscription)->get();
        $inscripciones->update($request->all());
        return response()->json(['idInscription' => $idInscription], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InscriptionsDetails  $inscriptionsDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy($idInscription, InscriptionsDetails $inscriptionsDetails)
    {
        $inscripciones = InscriptionsDetails::where('idInscription', $idInscription)->get();
        $inscripciones->delete();
        return response()->json(['idInscription' => $idInscription], 200);
    }
}
