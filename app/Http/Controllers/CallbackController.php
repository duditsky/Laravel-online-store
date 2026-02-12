<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CallbackRequest;

class CallbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:25',
            'phone' => 'required|string|max:20',
        ]);

      
        CallbackRequest::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'status' => 'new'
        ]);

        return back()->with('success', "Thank you, {$request->name}! We will contact you soon.");
    }
}
