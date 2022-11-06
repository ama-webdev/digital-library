<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function dashboard()
    {
        return view("admin.dashboard");
    }

    public function changePassword()
    {
        return view('admin.auth.change-password');
    }

    public function showChangeStudentPassword()
    {
        return view('admin.auth.change-student-password');
    }
}