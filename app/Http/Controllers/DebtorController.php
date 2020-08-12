<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebtorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->type == 1) {
            
            $type = $request->type;
            return view('Debtor.view', compact('data','type'));
        }
    }
}
