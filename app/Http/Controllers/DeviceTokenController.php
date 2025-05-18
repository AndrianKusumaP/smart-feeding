<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeviceToken;
use Illuminate\Support\Facades\Auth;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $user = Auth::user();

        // Update token jika sudah ada, atau buat baru
        DeviceToken::updateOrCreate(
            ['user_id' => $user->id], // kunci unik
            ['token' => $request->token]
        );

        return response()->json(['message' => 'Token disimpan atau diperbarui'], 200);
    }
}
