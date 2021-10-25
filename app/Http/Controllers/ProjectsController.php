<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    
    public function index()
    {
        $projects = Project::latest()->paginate();

        return view('projects.index', [
            'projects' => $projects,
        ]);
    }

    public function show(Project $project)
    {
        return view('projects.show', [
            'project' => $project,
            'units' => Proposal::units(),
        ]);
    }
}
