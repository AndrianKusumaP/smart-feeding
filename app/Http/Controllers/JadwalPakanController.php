<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;

class JadwalPakanController extends Controller
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
        $data = $this->firebase->getData('JadwalPakan');
        $manual = $this->firebase->getData('ControlSystem/beratPakanManual');
        $jarak = $this->firebase->getData('ControlSystem/jarakLontaran');
        return view('jadwal-pakan.index', [
            'data' => $data,
            'beratPakanManual' => $manual,
            'jarakLontaran' => $jarak
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jadwal-pakan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi dan simpan data
        $data = $request->validate([
            'waktu' => 'required|string',
            'berat' => 'required|numeric'
        ]);

        // Simpan ke Firebase dengan auto-generated key
        $this->firebase->storeData('JadwalPakan', $data);

        // Redirect kembali ke halaman dengan pesan sukses
        return redirect('jadwal-pakan')->with('success', 'Data berhasil disimpan!');
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
        $data = $this->firebase->getDataById('JadwalPakan', $id);

        return view('jadwal-pakan.edit', ['data' => $data, 'id' => $id]);
    }

    public function manualEdit()
    {
        $data = $this->firebase->getData('ControlSystem/beratPakanManual');

        return view('berat-pakan-manual.edit', ['beratPakanManual' => $data]);
    }

    public function jarakLontaranEdit()
    {
        $data = $this->firebase->getData('ControlSystem/jarakLontaran');

        return view('jarak-lontaran.edit', ['jarakLontaran' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $data = $request->validate([
            'waktu' => 'required|string',
            'berat' => 'required|numeric'
        ]);

        // Update data di Firebase
        $this->firebase->updateData("JadwalPakan", $id, $data);

        // Redirect ke halaman index dengan pesan sukses
        return redirect('jadwal-pakan')->with('success', 'Data berhasil diperbarui!');
    }

    public function manualUpdate(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'berat' => 'required|numeric'
        ]);

        // Update data di Firebase pada path "ControlSystem"
        $this->firebase->setValue('ControlSystem/beratPakanManual', (float) $data['berat']);

        // Redirect ke halaman index dengan pesan sukses
        return redirect('jadwal-pakan')->with('success', 'Data berhasil diperbarui!');
    }

    public function jarakLontaranUpdate(Request $request)
    {
        $data = $request->validate([
            'jarak' => 'required|numeric|in:180,220,255',
        ]);

        $this->firebase->setValue('ControlSystem/jarakLontaran', (float) $data['jarak']);

        return redirect()->route('jadwal-pakan.index')->with('success', 'Jarak lontaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hapus data dari Firebase
        $this->firebase->deleteData('JadwalPakan', $id);

        // Redirect ke halaman utama dengan pesan sukses
        return redirect()->route('jadwal-pakan.index')->with('success', 'Data berhasil dihapus!');
    }
}
