<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function profile()
    {
        return view('user.profile',[
            'user'  => auth()->user()
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            "name"      => 'required',
            "username"  => 'required'
        ]);

        $user->fill($request->all());
        $user->save();

        return redirect('/profile');
    }
}
