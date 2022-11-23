<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\User;
use App\Models\Damage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DamageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $damages = Damage::orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.damages.index', compact('damages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $books = Book::all();
        return view('admin.damages.create', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function insert(Request $request)
    {
        $request->validate([
            'book' => 'required|exists:books,id',
            'email' => 'required|exists:users,email',
            'qty' => 'required|integer',
            'remark' => 'nullable|string'
        ]);
        $book = $request->book;
        $email = $request->email;
        $qty = $request->qty;
        $remark = $request->remark;

        $user = User::where('email', $email)->first();

        $damage = new Damage();
        $damage->book_id = $book;
        $damage->user_id = $user->id;
        $damage->qty = $qty;
        $damage->remark = $remark;
        $damage->noted_by = Auth::user()->id;
        $damage->date = now();
        $damage->save();

        $obook = Book::find($book);
        $obook->qty -= $qty;
        $obook->update();

        return redirect()->route('admin.damage-books');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Damage::findOrFail($id);
        $book->delete();
        $obook = Book::find($book->book_id);
        $obook->qty += $book->qty;
        $obook->update();

        return redirect()->route('admin.damage-books');
    }
}