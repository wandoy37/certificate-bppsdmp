<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('home.index', compact('categories'));
    }

    public function show_category($slug)
    {
        $category = Category::where('slug', $slug)->first();
        // return response()->json($category);
        return view('home.category.index', compact('category'));
    }
}
