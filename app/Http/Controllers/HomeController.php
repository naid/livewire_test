<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        //this contains the auto generated datatable
        return view('livewire.home');
    }

    public function users()
    {
        //this contains the manually created datatable
        return view('livewire.user');
    }

    public function resetPassword()
    {
        return view('livewire.password');
        
    }
}
