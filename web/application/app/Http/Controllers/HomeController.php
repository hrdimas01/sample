<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Models\SysConfig;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Home';
        $data['menu_active'] = 'home';

        return view('home', $data);
    }
}
