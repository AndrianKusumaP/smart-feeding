<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;

class PakanManualController extends Controller
{

    protected FirebaseService $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $manual = $this->firebase->getData('ControlSystem/beratPakanManual');

        return view('pakan-manual.index', [
            'beratPakanManual' => $manual
        ]);
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
        //
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
    public function edit()
    {
        $data = $this->firebase->getData('ControlSystem/beratPakanManual');

        return view('pakan-manual.edit', ['beratPakanManual' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'berat' => 'required|numeric'
        ]);

        // Update data di Firebase pada path "ControlSystem"
        $this->firebase->setValue('ControlSystem/beratPakanManual', (float) $data['berat']);

        // Redirect ke halaman index dengan pesan sukses
        return redirect('pakan-manual')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
