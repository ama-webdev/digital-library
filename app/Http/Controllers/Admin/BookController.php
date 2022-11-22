<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:insert-book', ['only' => ['insert', 'create']]);
        $this->middleware('permission:delete-book', ['only' => ['destroy']]);
        $this->middleware('permission:update-book', ['only' => ['update', 'edit']]);
        $this->middleware('permission:show-book', ['only' => ['index']]);
    }
    public function index()
    {
        $books = Book::orderBy('updated_at', 'desc')->paginate(10);
        return view('admin.books.index', compact('books'));
    }
    public function create()
    {
        $book_categories = BookCategory::all();
        return view('admin.books.create', compact('book_categories'));
    }
    public function insert(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'book_category_id' => 'required|exists:book_categories,id',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'qty' => 'required|integer'
        ]);

        $title = $request->title;
        $photo = $request->photo;
        $author = $request->author;
        $description = $request->description;
        $book_category_id = $request->book_category_id;
        $qty = $request->qty;

        // store image in products folder
        $photo_name = uniqid() . date('Ymd') .  '.' . $photo->extension();
        $photo_url = "/images/template/books/$photo_name";
        $photo->move(public_path('/images/template/books'), $photo_name);


        // insert record
        $book = new Book();
        $book->title = $title;
        $book->photo = $photo_url;
        $book->author = $author;
        $book->description = $description;
        $book->book_category_id = $book_category_id;
        $book->qty = $qty;
        $book->save();
        return redirect()->route('admin.books');
    }
    public function edit(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book_categories = BookCategory::all();
        return view('admin.books.edit', compact('book', 'book_categories'));
    }
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $old_photo = $book->photo;
        $old_file = $book->file;
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'book_category_id' => 'required|exists:book_categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'qty' => 'required|integer'
        ]);

        $title = $request->title;
        $photo = $request->photo;
        $author = $request->author;
        $description = $request->description;
        $book_category_id = $request->book_category_id;
        $qty = $request->qty;

        if ($photo) {
            // store image in products folder
            $photo_name = uniqid() . date('Ymd') .  '.' . $photo->extension();
            $photo_url = "/images/template/books/$photo_name";
            $photo->move(public_path('/images/template/books'), $photo_name);

            // delete old image if has new image
            $old_image_url = substr($old_photo, 1);
            if (File::exists($old_image_url)) {
                File::delete($old_image_url);
            }
        } else {
            $photo_url = $old_photo;
        }

        // insert record
        $book->title = $title;
        $book->photo = $photo_url;
        $book->author = $author;
        $book->description = $description;
        $book->book_category_id = $book_category_id;
        $book->qty = $qty;
        $book->update();
        return redirect()->route('admin.books');
    }
    public function destroy(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        $photo_url = substr($book->photo, 1);
        if (File::exists($photo_url)) {
            File::delete($photo_url);
        }
        return redirect()->route('admin.books');
    }
}