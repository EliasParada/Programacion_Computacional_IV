<?php

namespace App\Http\Controllers;

use App\Models\FriendRequests;
use Illuminate\Http\Request;

class FriendRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FriendRequests::where('user_id', auth()->id())->orWhere('friend_id', auth()->id())->get();
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
        $friendshipRequest = FriendRequests::create([
            'user_id' => auth()->id(),
            'friend_id' => $request->friend_id,
        ]);

        return $friendshipRequest;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FriendRequests  $friendshipRequests
     * @return \Illuminate\Http\Response
     */
    public function show(FriendRequests $friendshipRequests)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FriendRequests  $friendshipRequests
     * @return \Illuminate\Http\Response
     */
    public function edit(FriendRequests $friendshipRequests)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FriendRequests  $friendshipRequests
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FriendRequests $friendshipRequests)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FriendRequests  $friendshipRequests
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $Request)
    {
        if ($Request->for == 'friend') {
            $a = FriendRequests::where('user_id', $Request->id)
                ->where('friend_id', auth()->id())
                ->delete();
            return 'friend request rejected';
        } else if ($Request->for == 'sent') {
            FriendRequests::where('user_id', auth()->id())
                ->where('friend_id', $Request->id)
                ->delete();
            return 'friend request cancelled';
        }
    }
}
