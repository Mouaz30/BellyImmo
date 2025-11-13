<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:client']);
    }

    /**
     * Affiche le dashboard client.
     */
    public function index()
    {
        $user = Auth::user();

        return view('client.dashboard', [
            'user' => $user,
        ]);
    }
}
