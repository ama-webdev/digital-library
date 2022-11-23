<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:insert-user', ['only' => ['insert', 'create']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
        $this->middleware('permission:update-user', ['only' => ['update', 'edit']]);
        $this->middleware('permission:show-user', ['only' => ['index']]);
    }
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function insert(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20',
            'confirm_password' => 'required|same:password',
            'role' => 'required|exists:roles,name',
            'nrc' => 'required|string|unique:users,nrc',
            'address' => 'required|string',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->nrc = $request->nrc;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole($request->role);

        return redirect()->route('admin.users');
    }

    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'nrc' => 'required|string|unique:users,nrc,' . $id,
            'address' => 'required|string',

        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nrc = $request->nrc;
        $user->address = $request->address;
        $user->update();

        return redirect()->route('admin.users');
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users');
    }
}