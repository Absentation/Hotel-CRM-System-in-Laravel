<?php

namespace App\Http\Controllers;

use App\Models\HotelMedia;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $media = HotelMedia::query()
            ->where('is_published', true)
            ->orderBy('display_order')
            ->orderByDesc('created_at')
            ->get();

        return view('home', compact('media'));
    }
}
