<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('admin.login');
        }

        $genres = Genre::orderBy('name')->get();

         return view('admin.dashboard', compact('genres'));
    }
}

?>
