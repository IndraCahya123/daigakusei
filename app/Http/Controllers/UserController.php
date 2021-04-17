<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    //show user profile
    public function index()
    {
        $user = Auth::user();

        return view('layouts.profile', compact('user'));
    }

    public function updateProfile(Request $request, User $user)
    {
        $request->validate([
            'thumbnail' => 'image|max:2048'
        ]);

        $userId = $request->user_id;

        $data = $request->all();

        if ($request->file('thumbnail') === null) {
            $data['thumbnail'] = $user->where('id', '=', $userId)->first()->thumbnail;
        } else {
            Storage::delete($user->where('id', '=', $userId)->first()->thumbnail);
            $thumbnail = request()->file('thumbnail')->store('images/photo');
            
            $data['thumbnail'] = $thumbnail;
        }
        
        $user->where('id', '=', $request->user_id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'thumbnail' => $data['thumbnail']
        ]);

        alert()->success('You Have Updated Your Profile')
        ->persistent('OK')->autoclose(5000);

        return redirect()->to(route('home.profile'));
    }
}
