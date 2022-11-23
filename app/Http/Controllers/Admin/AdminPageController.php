<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\User;
use App\Models\Rental;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminPageController extends Controller
{
    public function dashboard()
    {
        $book_count = Book::count();
        $category_count = BookCategory::count();
        $user_count = User::count();
        $rental_count = Rental::where('status', '!=', 'return')->count();
        $rentals = Rental::where('status', '!=', 'return')->orderBy('updated_at', 'desc')->paginate(10);
        return view("admin.dashboard", compact('book_count', 'category_count', 'user_count', 'rentals', 'rental_count'));
    }

    public function changePassword()
    {
        return view('admin.users.change-password');
    }

    public function showChangeStudentPassword()
    {
        return view('admin.users.change-student-password');
    }
    public function changeStudentPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required|min:6|max:20',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user->hasRole('user')) {
            return back()->with('error', "This email doesn't user email.");
        }
        $user->password = Hash::make($request->password);
        $user->update();
        return back()->with('success', 'Successfully changed.');
    }
}