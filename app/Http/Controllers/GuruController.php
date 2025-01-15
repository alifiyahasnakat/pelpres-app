<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('is_guru', true)->get();
    
        return view('data.guru.index', ['users' => $users]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->only(['nips', 'name', 'is_guru']);
    
        if (auth()->check()) {
            $validatedData['user_id'] = auth()->user()->id;
        } else {
            return redirect('/')->with('error', 'Mohon Login Untuk Menambahkan Data Guru');
        }
    
        // Set the password field equal to the nips value
        $validatedData['password'] = bcrypt($validatedData['nips']);
    
        User::create($validatedData);
    
        return redirect('/guru')->with('success', 'Data Berhasil Ditambahkan');
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
    public function update(Request $request, User $guru)
    {
        $validatedData = $request->only(['nips', 'name', 'password']);

        $validatedData['password'] = Hash::make($request->password);

        User::where('id', $guru->id)
            ->update($validatedData);
        
        return redirect('/guru')->with('success', 'Data Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $guru)
    {
        User::destroy($guru->id);
        return redirect('/guru')->with('success', 'Data Berhasil Dihapus');
    }

    
    public function updateStatus(Request $request, $id)
    {
        // Validasi request jika diperlukan
        $request->validate([
            'is_guru' => 'required|boolean', // Pastikan is_guru diisi dan berupa boolean
        ]);

        // Temukan data guru berdasarkan ID
        $guru = User::findOrFail($id);

        // Update status is_guru sesuai dengan nilai yang dikirimkan dari frontend
        $guru->is_guru = $request->input('is_guru');
        
        // Jika is_guru dinonaktifkan (false), atur is_pensiun menjadi true
        if (!$guru->is_guru) {
            $guru->is_pensiun = true;
        } else {
            $guru->is_pensiun = false; // Pastikan is_pensiun disetel kembali ke false jika is_guru diaktifkan
        }

        // Simpan perubahan
        $guru->save();

        // Respon JSON untuk konfirmasi
        return response()->json(['message' => 'Status updated successfully', 'guru' => $guru]);
    }

}
