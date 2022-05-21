<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ProjectsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $entries = Project::latest()
            ->with([
                'user:id,name', 
                'category:id,name', 
                'tags:id,name'
            ])
            ->paginate();

        return ProjectResource::collection($entries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $user = User::find(1);

        $data = $request->except('attachments');

        $project = $user->projects()->create( $data );

        $tags = explode(',', $request->input('tags'));
        $project->syncTags($tags);

        return $project;
        return response($project, 201);
        return response()->json($project, 201);
        return Response::json($project, 201);
        return new JsonResponse($project, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return new ProjectResource($project);

        //return $project->load(['category:id,name', 'user', 'tags']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'required', 'string'],
            'type' => ['sometimes', 'required', 'in:hourly,fixed'],
            'budget' => ['nullable', 'numeric', 'min:0'],
        ]);

        $project = Project::findOrFail($id);

        $project->update($request->all());

        return $project;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $user = Auth::guard('sanctum')->user();
        
        if (!$user->tokenCan('projects.delete')) {
            return Response::json([
                'message' => 'Permission denied!',
            ], 403);
        }

        $project->delete();

        if ($project->attachments) {
            foreach ($project->attachments as $file) {
                Storage::disk('public')->delete($file);
            }
        }

        return [
            'message' => 'Porject deleted',
        ];
    }

}
