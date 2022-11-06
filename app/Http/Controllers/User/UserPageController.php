<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;

class UserPageController extends Controller
{
    public function home()
    {
        $categories = BookCategory::all();
        $books = Book::orderBy('id', 'desc')->take(6)->get();
        return view('user.home', compact('categories', 'books'));
    }
    public function about()
    {
        return view('user.about');
    }
    public function books(Request $request)
    {
        $cat = $request->cat;
        $title = $request->title;
        $author = $request->author;

        $books = Book::when($cat, function ($query, $cat) {
            $query->where('book_category_id', $cat);
        })->when($author, function ($query, $author) {
            $query->where('author', 'LIKE', '%' . $author . '%');
        })->when($title, function ($query, $title) {
            $query->where('title', 'LIKE', '%' . $title . '%');
        })->paginate(12);
        $categories = BookCategory::all();
        return view('user.books', compact('books', 'categories'));
    }
    public function bookDetail(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        return view('user.book-detail', compact('book'));
    }
}