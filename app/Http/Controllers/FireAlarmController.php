<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FireAlarmController extends Controller
{
    public function index() {
        return view('pages.fire-alarm.index');
    }
}
