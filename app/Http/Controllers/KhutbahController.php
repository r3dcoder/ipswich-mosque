<?php

namespace App\Http\Controllers;

use App\Models\Khutbah;
use Illuminate\Http\Request;

class KhutbahController extends Controller
{
    /**
     * Display the Khutbah library page.
     */
    public function index(Request $request)
    {
        $category = $request->input('category', 'all');
        
        // Get featured khutbah (first one)
        $featuredKhutbah = Khutbah::active()
            ->featured()
            ->ordered()
            ->first();
        
        // If no featured khutbah, get the latest one
        if (!$featuredKhutbah) {
            $featuredKhutbah = Khutbah::active()
                ->ordered()
                ->first();
        }
        
        // Get all latest khutbahs
        $khutbahs = Khutbah::active()
            ->category($category)
            ->ordered()
            ->paginate(12);
        
        // Get featured khutbahs for the series section
        $featuredSeries = Khutbah::active()
            ->featured()
            ->ordered()
            ->take(8)
            ->get();
        
        $categories = Khutbah::categories();
        
        return view('khutbah', compact('featuredKhutbah', 'khutbahs', 'featuredSeries', 'categories', 'category'));
    }
}