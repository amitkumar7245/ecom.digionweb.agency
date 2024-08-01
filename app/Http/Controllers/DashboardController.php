<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function Dashboard()
    {
        $data['header_title'] = 'Dashboard';

        if(Auth::user()->role == 'admin')
        {
            return view('admin.index',  $data);
        }
        else if(Auth::user()->role == 'vendor')
        {
            return view('vendor.index',  $data);
        }
    }

}
