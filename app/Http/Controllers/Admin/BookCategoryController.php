<?php

namespace App\Http\Controllers\Admin;

use App\Models\BookCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class BookCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:insert-book-category', ['only' => ['insert', 'create']]);
        $this->middleware('permission:delete-book-category', ['only' => ['destroy']]);
        $this->middleware('permission:update-book-category', ['only' => ['update', 'edit']]);
        $this->middleware('permission:show-book-category', ['only' => ['index']]);
    }
    public function index()
    {
        $book_categories = BookCategory::orderBy('updated_at', 'desc')->paginate(10);
        return view('admin.bookcategory.index', compact('book_categories'));
    }
    public function create()
    {
        return view('admin.bookcategory.create');
    }
    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:book_categories,name',
        ]);

        $name = $request->name;

        // insert record
        $book_category = new BookCategory();
        $book_category->name = $name;
        $book_category->save();
        return redirect()->route('admin.book-categories');
    }
    public function edit(Request $request, $id)
    {
        $book_category = BookCategory::findOrFail($id);
        return view('admin.bookcategory.edit', compact('book_category'));
    }
    public function update(Request $request, $id)
    {
        $book_category = BookCategory::findOrFail($id);
        $request->validate([
            'name' => 'required|string|unique:book_categories,name,' . $id,
        ]);

        $name = $request->name;


        // insert record
        $book_category->name = $name;
        $book_category->update();
        return redirect()->route('admin.book-categories');
    }
    public function destroy(Request $request, $id)
    {
        $book_category = BookCategory::findOrFail($id);
        $book_category->delete();

        return redirect()->route('admin.book-categories');
    }
}