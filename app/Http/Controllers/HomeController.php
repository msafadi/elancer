<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $recent_projects = Project::with('category', 'tags')
            ->latest()
            ->where('status', '=', 'open')
            ->limit(5)
            ->get();

        return view('home', [
            'recent_projects' => $recent_projects,
        ]);
    }
}
