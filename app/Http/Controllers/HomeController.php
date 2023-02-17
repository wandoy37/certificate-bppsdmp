<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Participant;
use App\Models\Training;
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
        return view('home.category.index', compact('category'));
    }

    public function show_training($slug)
    {
        $training = Training::where('slug', $slug)->first();
        // return response()->json($training);
        return view('home.training.index', compact('training'));
    }

    public function show_participant($slug)
    {
        $participant = Participant::where('slug', $slug)->first();
        return view('home.participant.index', compact('participant'));
    }
}
