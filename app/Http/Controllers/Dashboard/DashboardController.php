<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //Actions

    public function index()
    {
        $title = 'Store';
        $user = 'Ahmed Hathout';
        // return response : view , json , redirect or file .

        return view('dashboard.index', compact('user' , 'title'));
    }
}
