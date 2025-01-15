<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('is_admin', true)->get();
    
        return view('data.admin.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->only(['nips', 'name', 'is_admin']);
    
        if (auth()->check()) {
            $validatedData['user_id'] = auth()->user()->id;
        } else {
            return redirect('/')->with('error', 'Mohon Login Untuk Menambahkan Data Admin');
        }
    
        // Set the password field equal to the nips value
        $validatedData['password'] = bcrypt($validatedData['nips']);
    
        User::create($validatedData);
    
        return redirect('/admin')->with('success', 'Data Berhasil Ditambahkan');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $admin)
    {
        $validatedData = $request->only(['nips', 'name', 'password']);

        $validatedData['password'] = Hash::make($request->password);

        User::where('id', $admin->id)
            ->update($validatedData);
        
        return redirect('/admin')->with('success', 'Data Berhasil Diperbarui');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $admin)
    {
        User::destroy($admin->id);
        return redirect('/admin')->with('success', 'Data Admin Berhasil Dihapus');
    }
}
