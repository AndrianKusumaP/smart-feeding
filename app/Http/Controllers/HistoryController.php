<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;

use Illuminate\Http\Request;

class HistoryController extends Controller
{

    protected FirebaseService $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function index()
    {
        $data = $this->firebase->getData('HistoryPakan');
        $data = collect($data)
            ->sortKeysDesc()
            ->map(function ($jamData) {
                return collect($jamData)->sortKeysDesc();
            });
        return view('history.index', ['data' => $data]);
    }
}
