<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit(Request $request)
    {
        $user = User::findOrFail($request->id);
        return view('admin.users-edit',compact('user'));
    }
}
