<?php

namespace App\Http\Controllers\Roles;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;
    public function updateStatus(Request $request, User $user)
    {
        $this->authorize('update', $user); // Ensure only authorized users can enable/disable

        $user->update([
            'is_enabled' => $request->is_enabled
        ]);

        return back()->with('success', 'User status updated successfully.');
    }

    public function indexAssociation()
    {
        $usersAssociation = User::whereNotIn('role', ['Administrator', 'Beekeeping association'])->get();
        return view('roles.association', compact('usersAssociation'));
    }

    public function indexAdministrator()
    {
        $usersAdministrator = User::whereNotIn('role', ['Administrator', 'Beekeeper', 'Laboratory employee', 'Wholesaler', 'Packaging company'])->get();
        return view('roles.administrator', compact('usersAdministrator'));
    }
}
