<?php

namespace App\Http\Controllers\Admin;

use App\Helper\UUID;
use App\Models\Book;
use App\Models\User;
use App\Models\Rental;
use App\Models\RentalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $code = $request->code;
        $email = $request->email;
        $nrc = $request->nrc;
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
            ->when($nrc, function ($query, $nrc) {
                $user = User::where('nrc', $nrc)->first();
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
        $books = Book::all();
        return view('admin.rentals.create', compact('books'));
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
        $rental->admin_remark = $request->remark;
        if ($request->status == 'return') {
            $rental->return_date = now();
            $rental->rentaled_by = Auth::user()->id;
            foreach ($rental->rental_details as $item) {
                $book = Book::find($item->book_id);
                $book->qty += $item->qty;
                $book->update();
            }
        }
        $rental->update();
        return redirect()->route('admin.rentals.index');
    }

    public function adminRent(Request $request)
    {
        $validated = $request->validate([
            "books" => "required|array|max:3",
            "email" => "required|exists:users,email",
            "end_date" => "required|after:now"
        ]);
        $email = $request->email;
        $books = $request->books;
        $end_date = $request->end_date;
        $remark = $request->remark;

        $user = User::where('email', $email)->first();

        $previous_rentals = Rental::where('user_id', $user->id)->where('status', '!=', 'return')->get();
        $total = 0;
        if ($previous_rentals) {
            foreach ($previous_rentals as $rental) {
                $total += $rental->total;
            }
            if ($total >= 3) {
                return back()->withErrors(['custom_error' => ['You borrowed ' . $total . ' books earlier. Therefore, you have to return those ' . $total . ' books and then borrow again.']]);
            }
        }

        if ($total + count($books) > 3) {
            return back()->withErrors(['custom_error' => ["You have only " . 3 - $total . ' books left to borrow. Please reduce some books.']]);
        }

        DB::beginTransaction();
        try {
            $rental = new Rental();
            $rental->user_id = $user->id;
            $rental->code = UUID::generate();
            $rental->start_date = now();
            $rental->end_date = $end_date;
            $rental->total = count($books);
            $rental->status = 'borrow';
            $rental->admin_remark = $remark;
            $rental->rentaled_by = Auth::user()->id;
            $rental->save();

            foreach ($books as $book) {
                RentalDetail::create([
                    'rental_id' => $rental->id,
                    'book_id' => $book,
                    'qty' => 1,
                ]);

                $book = Book::find($book);
                $book->qty -= 1;
                $book->update();
            }
            DB::commit();
            return redirect()->route('admin.rentals.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }
}