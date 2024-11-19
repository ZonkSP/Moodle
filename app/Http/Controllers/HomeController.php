<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Reader;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Return the dashboard view with data
        return view('welcome');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
}
