<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $getUniv = University::latest()->limit(3)->get();

        return view('welcome', compact('getUniv'));
    }
}
