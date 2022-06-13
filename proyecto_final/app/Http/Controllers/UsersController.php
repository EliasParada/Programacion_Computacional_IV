<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FriendRequests;
use App\Models\Friends;
use App\Models\Notes;
use App\Models\Blocks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->check()) {
            return User::get();
            return User::where('id', '!=', auth()->user()->id)->get();
        }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->save();
        return $user;
    }

    public function expert(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->permissions = 2;
        $user->save();
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Notes::where('user_id', $user->id)->delete();
        Friends::where('user_id', $user->id)->delete();
        Friends::where('friend_id', $user->id)->delete();
        FriendRequests::where('user_id', $user->id)->delete();
        FriendRequests::where('friend_id', $user->id)->delete();
        Blocks::where('user_id', $user->id)->delete();
        Blocks::where('block_id', $user->id)->delete();
        $user->delete();
        return $user;
    }
}
