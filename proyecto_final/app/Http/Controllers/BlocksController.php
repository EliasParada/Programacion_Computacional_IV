<?php

namespace App\Http\Controllers;

use App\Models\Blocks;
use Illuminate\Http\Request;

class BlocksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Blocks::where('user_id', auth()->id())->orWhere('block_id', auth()->id())->get();
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
        Blocks::create([
            'user_id' => auth()->id(),
            'block_id' => $request->blocked_id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blocks  $blocks
     * @return \Illuminate\Http\Response
     */
    public function show(Blocks $blocks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blocks  $blocks
     * @return \Illuminate\Http\Response
     */
    public function edit(Blocks $blocks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blocks  $blocks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blocks $blocks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blocks  $blocks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Blocks::where('user_id', auth()->id())->orWhere('block_id', auth()->id())->delete();
    }
}
