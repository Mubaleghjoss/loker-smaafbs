<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Position;

class LandingController extends Controller
{
    public function index()
    {
        $positions = Position::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('public.landing', [
            'positions' => $positions,
        ]);
    }
}
