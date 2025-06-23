<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseService;

class JarakLontaranController extends Controller
{
    protected FirebaseService $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function index()
    {
        $jarakLontaran = $this->firebase->getData('ControlSystem/jarakLontaran');
        return view('jarak-lontaran.index', compact('jarakLontaran'));
    }

    public function edit()
    {
        $data = $this->firebase->getData('ControlSystem/jarakLontaran');

        return view('jarak-lontaran.edit', ['jarakLontaran' => $data]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'jarak' => 'required|numeric|in:180,220,255',
        ]);

        $this->firebase->setValue('ControlSystem/jarakLontaran', (float) $data['jarak']);

        return redirect()->route('jarak-lontaran.index')->with('success', 'Jarak lontaran berhasil diperbarui!');
    }
}
