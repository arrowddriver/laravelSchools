<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\School;

class HomeController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $user = User::find(Auth::user()->id);
            $school = School::find($user->schools);
            return view('home.index', ['user' => $user, 'school' => $school]);
        }else{
            return view('home.index');
        }

    }
}
