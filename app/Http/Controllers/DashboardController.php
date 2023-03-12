<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Certificate;
use App\Models\Participant;
use App\Models\Training;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get kategori pelatihan
        $categories = Category::latest()->get();
        // Get Pelatihan
        $trainings = Training::latest()->get();
        // Get Peserta
        $participants = Participant::latest()->get();
        // Get certificates
        $certificates = Certificate::latest()->get();
        return view('auth.dashboard.index', compact('categories', 'trainings', 'participants', 'certificates'));
    }
}
