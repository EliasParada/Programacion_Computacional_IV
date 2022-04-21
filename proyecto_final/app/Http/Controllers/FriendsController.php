<?php

namespace App\Http\Controllers;

use App\Models\Friends;
use App\Models\FriendRequests;
use Illuminate\Http\Request;

class FriendsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Friends::where('user_id', auth()->id())->orWhere('friend_id', auth()->id())->get();
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
        FriendRequests::where('user_id', $request->friend_id)
            ->where('friend_id', auth()->id())
            ->delete();
        $friendship = Friends::create([
            'user_id' => auth()->id(),
            'friend_id' => $request->friend_id,
        ]);

        return $friendship;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Friends  $friendships
     * @return \Illuminate\Http\Response
     */
    public function show(Friends $friendships)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Friends  $friendships
     * @return \Illuminate\Http\Response
     */
    public function edit(Friends $friendships)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Friends  $friendships
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Friends $friendships)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Friends  $friendships
     * @return \Illuminate\Http\Response
     */
    public function destroy(Friends $friendships)
    {
        $friendship = Friends::where('user_id', auth()->id())
            ->where('friend_id', $friendships->friend_id)
            ->delete();
    }
}
