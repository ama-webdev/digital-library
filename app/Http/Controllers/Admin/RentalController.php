<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\Rental;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RentalDetail;
use App\Models\User;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $code = $request->code;
        $email = $request->email;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $status = $request->status;

        $rentals = Rental::with('user')
            ->when($email, function ($query, $email) {
                $user = User::where('email', $email)->first();
                if ($user) {
                    $user_id = $user->id;
                } else {
                    $user_id = 0;
                }
                $query->where('user_id', $user_id);
            })
            ->when($code, function ($query, $code) {
                $query->where('code', $code);
            })
            ->when($start_date, function ($query, $start_date) {
                $query->where('start_date', '<=', $start_date);
            })
            ->when($end_date, function ($query, $end_date) {
                $query->where('end_date', '>=', $end_date);
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.rentals.index', compact('rentals'));
    }
    public function create(Request $request)
    {
        return view('admin.rentals.create');
    }
    public function show($id)
    {
        $rental = Rental::with('rental_details.book')->findOrFail($id);
        return view('admin.rentals.show', compact('rental'));
    }
    public function destroy(Request $request, $id)
    {
        $rental = Rental::with('rental_details')->find($id);
        foreach ($rental->rental_details as $detail) {
            $book = Book::find($detail->book_id);
            $book->qty += $detail->qty;
            $book->update();
        }
        $rental->delete();
        return response(['message' => 'Successfully deleted.'], 200);
    }
    public function detailDelete(Request $request, $id)
    {
        $detail = RentalDetail::findOrFail($id);
        $rental = Rental::find($detail->rental_id);
        $book = Book::find($detail->book_id);
        $book->qty += $detail->qty;
        $rental->total -= $detail->qty;
        $detail->delete();
        $rental->update();
        $book->update();
        return response(['message' => 'success'], 200);
    }
    public function edit(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);
        return view('admin.rentals.edit', compact('rental'));
    }
    public function rent(Request $request, $id)
    {
        $rental = Rental::findOrfail($id);
        $rental->status = $request->status;
        $rental->start_date = $request->start_date;
        $rental->end_date = $request->end_date;
        if ($request->status == 'return') {
            $rental->return_date = now();
            foreach ($rental->rental_details as $item) {
                $book = Book::find($item->book_id);
                $book->qty += $item->qty;
                $book->update();
            }
        }
        $rental->update();
        return redirect()->route('admin.rentals.index');
    }
}