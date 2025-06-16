<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\TestNotification;

/**
 * Class HomeController
 * 
 * Controller for handling the home page and dashboard.
 * Applies authentication middleware to all routes.
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Apply authentication middleware to all methods
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Return the home view (dashboard)
        return view('home');
    }
}
