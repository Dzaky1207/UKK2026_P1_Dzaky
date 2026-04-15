<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $roleLogin = auth()->user()->role;

        if ($roleLogin == 'admin') {
            $users = User::latest()->get();
        } else {
            $users = User::where('role', '!=', 'admin')->latest()->get();
        }

        return view('User.user', compact('users'));
    }

    public function create()
    {
        return view('User.create');
    }

    public function store(Request $request)
    {
        $roleLogin = auth()->user()->role;

        if ($roleLogin == 'admin') {
            $allowedRoles = ['admin', 'petugas', 'user'];
        } else {
            $allowedRoles = ['petugas', 'user']; 
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:' . implode(',', $allowedRoles),
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('User.user')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('User.create', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $roleLogin = auth()->user()->role;

        if ($roleLogin == 'admin') {
            $allowedRoles = ['admin', 'petugas', 'user'];
        } else {
            $allowedRoles = ['petugas', 'user'];
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role' => 'required|in:' . implode(',', $allowedRoles),
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('User.user')
            ->with('success', 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        if (auth()->user()->role != 'admin') {
            abort(403, 'Tidak punya akses');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('User.user')
            ->with('success', 'User berhasil dihapus');
    }
}
