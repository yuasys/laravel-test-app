<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminMainController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}
