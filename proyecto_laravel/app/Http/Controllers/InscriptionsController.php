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
        return Inscriptions::selectRaw('ins.id as insId, ins.idInscription as insIdInscription, ins.cycle as insCycle, ins.number as insNumber, ins.idStudent as insIdStudent, ins.created_at as insCreateAt, ins.updated_at as insUpdateAt, std.id as stdId, std.idStudent as stdIdsStudent, std.name as stdName, std.last_name as stdLastName, std.code as stdCode, std.birth as stdBirth, std.phone as stdPhone, std.email as stdEmail, std.address as stdAddress, std.dui as astDui, std.created_at as stdCreateAt, std.updated_at as stdUpdateAt, GROUP_CONCAT(sbj.name) as sbjnames, GROUP_CONCAT(sbj.id) as sbjIds, GROUP_CONCAT(sbj.idSubject) as sbjIdsSubject, GROUP_CONCAT(sbj.name) as sbjNames, GROUP_CONCAT(sbj.teacher) as sbjTeachers, GROUP_CONCAT(sbj.day) as sbjDays, GROUP_CONCAT(sbj.start) as sbjStarts, GROUP_CONCAT(sbj.finish) as sbjFinishes, GROUP_CONCAT(sbj.room) as sbjRooms, GROUP_CONCAT(sbj.created_at) as sbjCreated_ats, GROUP_CONCAT(sbj.updated_at) as sbjUpdated_ats')
            ->from('inscriptions AS ins')
            ->join('students AS std', 'std.id', '=', 'ins.idStudent')
            ->join('inscriptions_details AS insdet', 'ins.id', '=', 'insdet.idInscription')
            ->join('subjects AS sbj', 'insdet.idSubject', '=', 'sbj.id')
            ->groupBy('ins.id', 'ins.idInscription', 'ins.cycle', 'ins.number', 'ins.idStudent', 'ins.created_at', 'ins.updated_at', 'std.id', 'std.idStudent', 'std.name', 'std.last_name', 'std.code', 'std.birth', 'std.phone', 'std.email', 'std.address', 'std.dui', 'std.created_at', 'std.updated_at')
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
/*SELECT
    ins.id AS insId,
    ins.idInscription AS insIdInscription,
    ins.cycle AS insCycle,
    ins.number AS insNumber,
    ins.idStudent AS insIdStudent,
    ins.created_at AS insCreateAt,
    ins.updated_at AS insUpdateAt,
    STD.id AS stdId,
    STD.idStudent AS stdIdsStudent,
    STD.name AS stdName,
    STD.last_name AS stdLastName,
    STD.code AS stdCode,
    STD.birth AS stdBirth,
    STD.phone AS stdPhone,
    STD.email AS stdEmail,
    STD.address AS stdAddress,
    STD.dui AS astDui,
    STD.created_at AS stdCreateAt,
    STD.updated_at AS stdUpdateAt,
    GROUP_CONCAT(sbj.name) AS sbjnames,
    GROUP_CONCAT(sbj.id) AS sbjIds,
    GROUP_CONCAT(sbj.idSubject) AS sbjIdsSubject,
    GROUP_CONCAT(sbj.name) AS sbjNames,
    GROUP_CONCAT(sbj.teacher) AS sbjTeachers,
    GROUP_CONCAT(sbj.day) AS sbjDays,
    GROUP_CONCAT(sbj.start) AS sbjStarts,
    GROUP_CONCAT(sbj.finish) AS sbjFinishes,
    GROUP_CONCAT(sbj.room) AS sbjRooms,
    GROUP_CONCAT(sbj.created_at) AS sbjCreated_ats,
    GROUP_CONCAT(sbj.updated_at) AS sbjUpdated_ats
FROM
    `inscriptions` AS `ins`
INNER JOIN `students` AS `std`
ON
    `std`.`id` = `ins`.`idStudent`
INNER JOIN `inscriptions_details` AS `insdet`
ON
    `ins`.`id` = `insdet`.`idInscription`
INNER JOIN `subjects` AS `sbj`
ON
    `insdet`.`idSubject` = `sbj`.`id`
GROUP BY
    `ins`.`id`,
    `std`.`id`,
    `std`.`name`,
    `std`.`last_name`,
    `std`.`code`,
    `std`.`birth`,
    `std`.`phone`,
    `std`.`email`,
    `std`.`address`,
    `std`.`dui`,
    `std`.`created_at`,
    `std`.`updated_at`,
    `ins`.`idInscription`,
    `ins`.`cycle`,
    `ins`.`number`,
    `ins`.`idStudent`,
    `ins`.`created_at`,
    `ins`.`updated_at`*/