<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class FireAlarmController
 * 
 * Controller to handle fire alarm related views.
 */
class FireAlarmController extends Controller
{
    /**
     * Display the fire alarm index page.
     *
     * @return \Illuminate\View\View View displaying the fire alarm index.
     */
    public function index() {
        // Return the fire alarm index view
        return view('pages.fire-alarm.index');
    }
}
