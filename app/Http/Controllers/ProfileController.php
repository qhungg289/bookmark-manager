<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(Request $request, User $user)
    {
        $publicFolders = $user
            ->folders()
            ->where('is_public', true)
            ->with('bookmarks')
            ->get();

        return view('profiles.show', [
            'publicFolders' => $publicFolders,
            'user' => $user,
            'isOwner' => $request->user()->id == $user->id
        ]);
    }

    public function edit(Request $request, User $user)
    {
        if ($request->user()->id != $user->id) {
            return abort(403);
        }

        return view('profiles.edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        if ($request->user()->id != $user->id) {
            return abort(403);
        }

        $validated = $request->validate([
            'name' => ['string', 'required'],
            'email' => ['email', 'required', Rule::unique('users', 'email')->ignore(Auth::id())]
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return redirect()->route('profiles.show', ['user' => $user]);
    }

    public function editPassword(Request $request, User $user)
    {
        if ($request->user()->id != $user->id) {
            return abort(403);
        }

        return view('profiles.change-password', [
            'user' => $user
        ]);
    }

    public function updatePassword(Request $request, User $user)
    {
        if ($request->user()->id != $user->id) {
            return abort(403);
        }

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', 'min:8']
        ]);

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return redirect()->route('profiles.show', ['user' => $user]);
    }
}
