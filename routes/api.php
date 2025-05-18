<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->post('/store-token', function (Request $request) {
  $request->validate(['token' => 'required|string']);

  DB::table('device_tokens')->updateOrInsert(
    ['user_id' => $request->user()->id],
    ['token' => $request->token]
  );

  return response()->json(['message' => 'Token saved']);
});
