<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'nips' => 'required',
            'password' => 'required'
        ]);
    
        $field = 'nips'; 
    
        $user = null;
        if($field === 'nips'){
            $user = Auth::attempt(['nips' => $credentials['nips'], 'password' => $credentials['password']]);
        }
    
        if ($user) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        
        return back()->with('loginError', 'Login failed!');
    }
    
    
    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        return redirect('/');
    }
}
