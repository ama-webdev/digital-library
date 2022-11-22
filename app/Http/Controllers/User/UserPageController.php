<?php

namespace App\Http\Controllers\User;

use App\Helper\UUID;
use App\Models\Book;
use App\Models\Rental;
use App\Models\BookCategory;
use App\Models\RentalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

    public function showCart(Request $request)
    {
        return view('user.cart');
    }

    public function borrow(Request $request)
    {
        $previous_rentals = Rental::where('user_id', Auth::user()->id)->where('status', '!=', 'return')->get();
        $total = 0;
        if ($previous_rentals) {
            foreach ($previous_rentals as $rental) {
                $total += $rental->total;
            }
            if ($total >= 3) {
                return response(['errors' => ['You borrowed ' . $total . ' books earlier. Therefore, you have to return those ' . $total . ' books and then borrow again.']], 422);
            }
        }
        $books = json_decode($request->books);
        $remark = $request->remark;
        $end_date = $request->end_date;

        if ($total + count($books) > 3) {
            return response(['errors' => ["You have only " . 3 - $total . ' books left to borrow. Please reduce some books.']], 422);
        }

        $validator = Validator::make($request->all(), [
            'end_date' => 'required|after:now'
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $total_books = 0;
        foreach ($books as $book) {
            $total_books += $book->qty;
        }
        DB::beginTransaction();
        try {
            $rental = new Rental();
            $code = UUID::generate();
            $rental->user_id = Auth::user()->id;
            $rental->code = $code;
            $rental->status = 'draft';
            $rental->start_date = now();
            $rental->end_date = $end_date;
            $rental->total = $total_books;
            $rental->remark = $remark;
            $rental->save();

            foreach ($books as $book) {
                $detail = new RentalDetail();
                $detail->rental_id = $rental->id;
                $detail->book_id = $book->id;
                $detail->qty = $book->qty;
                $detail->status = 'draft';
                $detail->save();

                $primary_book = Book::find($book->id);
                $primary_book->qty -= $book->qty;
                $primary_book->update();
            }
            DB::commit();
            return response(['data' => ['code' => $code]], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['errors' => [$e->getMessage()]], 422);
        }
    }

    public function rentalList(Request $request)
    {
        $rentals = Rental::where('user_id', Auth::user()->id)->get();
        return view('user.rental-list', compact('rentals'));
    }

    public function rentalDetail($id)
    {
        $rental = Rental::with('rental_details')->findOrFail($id);
        return view('user.rental-detail', compact('rental'));
    }

    public function rentalDelete(Request $request, $id)
    {
        $rental = Rental::with('rental_details')->find($id);
        foreach ($rental->rental_details as $detail) {
            $book = Book::find($detail->book_id);
            $book->qty += $detail->qty;
            $book->update();
        }
        $rental->delete();
        return back();
    }
}