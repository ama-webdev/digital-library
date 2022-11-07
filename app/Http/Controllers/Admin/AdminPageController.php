<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function dashboard()
    {
        $book_count = Book::count();
        $category_count = BookCategory::count();
        $user_count = User::count();
        $books = Book::orderBy('updated_at', 'desc')->paginate(10);
        return view("admin.dashboard", compact('book_count', 'category_count', 'user_count', 'books'));
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