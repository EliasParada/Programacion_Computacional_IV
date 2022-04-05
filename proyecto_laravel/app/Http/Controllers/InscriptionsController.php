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
        return Inscriptions::selectRaw('ins.id, ins.idInscription, ins.clycle, ins.number, std.id, std.name, std.last_name, std.code, GROUP_CONCAT(sbj.name) as sbjnames, GROUP_CONCAT(sbj.id) as sbdIds')
            ->from('inscriptions AS ins')
            ->join('students AS std', 'std.id', '=', 'ins.idStudent')
            ->join('inscriptions_details AS insdet', 'ins.id', '=', 'insdet.idInscription')
            ->join('subjects AS sbj', 'insdet.idSubject', '=', 'sbj.id')
            ->groupBy('ins.id', 'std.id', 'std.name')
            ->get();
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
