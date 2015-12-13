<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProfileController extends Controller
{
    // All profile functions require authentication
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // View your profile
    function view()
    {
        $user = Auth::user();
        return view('pages/profile/view', compact('user'));
    }

    // Edit your profile
    function edit()
    {
        $user = Auth::user();
        return view('pages/profile/edit', compact('user'));
    }

    // Upload a file
    function upload()
    {
        $user = Auth::user();
        return view('pages/profile/upload', compact('user'));
    }

    // View a list of your shifts
    function shifts()
    {
        $user = Auth::user();
        $upcoming = $user->slots()->where('start_date', '>=', Carbon::now()->format('Y-m-d'))
                                    ->orderBy('start_date', 'asc')
                                    ->orderBy('start_time', 'asc')->get();
                                    
        $past = $user->slots()->where('start_date', '<', Carbon::now()->format('Y-m-d'))
                                ->orderBy('start_date', 'desc')
                                ->orderBy('start_time', 'desc')->get();
                                
        return view('pages/profile/shifts', compact('user', 'upcoming', 'past'));
    }
}
