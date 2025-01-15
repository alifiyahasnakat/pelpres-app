<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('is_siswa', true)->get();
        $kelass = Kelas::all();
    
        return view('data.siswa.index', ['users' => $users, 'kelass' => $kelass]);
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
        $validatedData = $request->only(['nips', 'name', 'nohp', 'kelas', 'angkatan', 'is_siswa']);
    
        if (auth()->check()) {
            $validatedData['user_id'] = auth()->user()->id;
        } else {
            return redirect('/')->with('error', 'Mohon Login Untuk Menambahkan Data Siswa');
        }
    
        // Set the password field equal to the nips value
        $validatedData['password'] = bcrypt($validatedData['nips']);
    
        User::create($validatedData);
    
        return redirect('/siswa')->with('success', 'Data Berhasil Ditambahkan');
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
    public function update(Request $request, User $siswa)
    {
        $validatedData = $request->only(['nips', 'name', 'password','nohp','kelas','angkatan']);

        $validatedData['password'] = Hash::make($request->password);

        User::where('id', $siswa->id)
            ->update($validatedData);
        
        return redirect('/siswa')->with('success', 'Data Berhasil Diperbarui');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $siswa)
    {
        User::destroy($siswa->id);
        return redirect('/siswa')->with('success', 'Data Berhasil Dihapus');
    }
    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file')->store('imports');
        $filePath = storage_path('app/' . $file);

        // Buat instance import dan panggil metode import
        $import = new SiswaImport();
        $import->import($filePath);

        return redirect()->back()->with('success', 'Data berhasil diimpor.');
    }
}
