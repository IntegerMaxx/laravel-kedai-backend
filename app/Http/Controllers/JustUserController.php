<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JustUserController extends Controller
{
    public function userDashboard(){

        return view('user.dashboard');

    }
}
