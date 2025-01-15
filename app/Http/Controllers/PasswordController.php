<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function updatePassword(Request $request)
    {
        // Validasi data yang diinput oleh pengguna
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Memastikan kata sandi saat ini benar
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password lama anda tidak benar'])->withInput();
        }

        // Memperbarui kata sandi pengguna
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        
        return back();
    }
}
