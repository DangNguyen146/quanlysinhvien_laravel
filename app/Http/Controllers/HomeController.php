<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use App\Models\Challenge;

class HomeController extends Controller
{
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
    public function index()
    {
        $posts = Posts::where('status', 1)->orderBy('updated_at', 'desc')->get();
        $chall = Challenge::where('status', 1)->orderBy('updated_at', 'desc')->get();
        
        return view('home', compact('posts', 'chall'));
    }
}
