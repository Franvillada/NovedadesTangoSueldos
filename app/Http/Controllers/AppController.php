<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\User;

class AppController extends Controller
{
    public function showKpi(){
        return view('kpi')->with('active','kpi');
    }

}
