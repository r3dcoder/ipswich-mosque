<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the admin users.
     */
    public function index()
    {
        $users = User::where('is_admin', true)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new admin user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created admin user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Auto-hashed by 'hashed' cast in User model
            'is_admin' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin user created successfully.');
    }

    /**
     * Show the form for editing the specified admin user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified admin user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin user updated successfully.');
    }

    /**
     * Show the form for changing password.
     */
    public function editPassword(User $user)
    {
        return view('admin.users.password', compact('user'));
    }

    /**
     * Update the specified admin user's password.
     */
    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->password = $request->password; // Auto-hashed by 'hashed' cast in User model
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Password updated successfully.');
    }

    /**
     * Remove the specified admin user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Admin user deleted successfully.');
    }
}