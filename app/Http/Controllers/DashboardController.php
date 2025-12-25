<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function home()     { return view('dashboard.home'); }
    public function pages()    { return view('dashboard.pages'); }
    public function duas()     { return view('dashboard.duas'); }
    public function settings() { return view('dashboard.settings'); }
    public function payments() { return view('dashboard.payments'); }
    public function contacts() { return view('dashboard.contacts'); }
}
