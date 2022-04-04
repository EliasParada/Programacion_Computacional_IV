<?php

namespace App\Http\Controllers;

use App\Models\Inscriptions;
use Illuminate\Http\Request;

class InscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inscriptions::get();
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
        $id = Inscriptions::create($request->all())->id;
        $idInscription = $request->idInscription;
        return response()->json(['id' => $id, 'idInscription' => $idInscription], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inscriptions  $inscriptions
     * @return \Illuminate\Http\Response
     */
    public function show(Inscriptions $inscriptions)
    {
        return $inscriptions;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inscriptions  $inscriptions
     * @return \Illuminate\Http\Response
     */
    public function edit(Inscriptions $inscriptions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inscriptions  $inscriptions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inscriptions $inscriptions)
    {
        $id = $request->id;
        $inscription = Inscriptions::find($id);
        $inscription->update($request->all());
        return response()->json(['id' => $id], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inscriptions  $inscriptions
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Inscriptions $inscriptions)
    {
        $inscriptions->destroy($id);
        return response()->json(['id' => $id], 200);
    }
}
