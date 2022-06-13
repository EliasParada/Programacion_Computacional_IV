<?php

namespace App\Http\Controllers;

use App\Models\Experts;
use App\Models\User;
use Illuminate\Http\Request;

class ExpertsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'nationality' => 'required',
            'dni' => 'required',
            'university' => 'required',
            'imagen' => 'required',
        ]);
        $experts = new Experts;
        $experts->user_id = auth()->user()->id;
        $experts->nationality = $request->nationality;
        $experts->dni = $request->dni;
        $experts->university = $request->university;
        $img = $request->imagen;
        $img = explode(',', $img);
        $imgName = auth()->user()->id.'.png';
        $path = 'storage/images/titles/'.$imgName;
        if (!file_exists(public_path('storage/images/titles/'.auth()->user()->id))) {
            mkdir(public_path('storage/images/titles/'.auth()->user()->id), 0777, true);
        }
        file_put_contents($path, base64_decode($img[1]));
        $experts->title = $path;
        $experts->save();

        $user = User::find(auth()->user()->id);
        $user->permissions = 2;
        $user->save();

        return redirect('/home')->with('success', 'Titulo creado');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Experts  $experts
     * @return \Illuminate\Http\Response
     */
    public function show(Experts $experts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Experts  $experts
     * @return \Illuminate\Http\Response
     */
    public function edit(Experts $experts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Experts  $experts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Experts $experts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Experts  $experts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experts $experts)
    {
        //
    }
}
