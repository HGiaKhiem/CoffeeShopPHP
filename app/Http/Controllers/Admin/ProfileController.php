<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the admin profile page.
     */
    public function show(Request $request)
    {
        $user = $request->user();
        return view('admin.profile', compact('user'));
    }
}
