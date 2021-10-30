<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Project;
use App\Models\Proposal;
use App\Notifications\NewPropsalNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ProposalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::guard('web')->user();

        $proposals = $user->proposals()
            ->with('project')
            ->latest()
            ->paginate();

        return view('freelancer.proposals.index', [
            'proposals' => $proposals,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {

        return view('freelancer.proposals.create', [
            'project' => $project,
            'proposal' => new Proposal(),
            'units' => [
                'day' => 'Day',
                'week' => 'Week',
                'month' => 'Month',
                'year' => 'Year',
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        if ($project->status !== 'open') {
            return redirect()->route('freelance.proposals.index')
                ->with('error', 'You can not submit propsal to this project');
        }
        $user = Auth::guard('web')->user();
        if ($user->proposedProjects()->find($project->id)) {
            return redirect()->route('freelance.proposals.index')
                ->with('error', 'You already submitted propsal to this project');
        }

        $request->validate([
            'description' => ['required', 'string'],
            'cost' => ['required', 'numeric', 'min:1'],
            'duration' => ['required', 'int', 'min:1'],
            'duration_unit' => ['required', 'in:day,week,month,year'],
        ]);
        $request->merge([
            'project_id' => $project_id
        ]);

        $proposal = $user->proposals()->create( $request->all() );

        // Notifications
        // Channels: mail, database, nexmo (sms), broadcast (real-time), slack

        $project->user->notify(new NewPropsalNotification($proposal, $user));

        $admins = Admin::all();
        // foreach ($admins as $admin) {
        //     $admin->notify(new NewPropsalNotification($proposal, $user));
        // }
        //Notification::send($admins, new NewPropsalNotification($proposal, $user));

        // Notification::route('mail', 'test@example.org')
        //     ->notify(new NewPropsalNotification($proposal, $user));


        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Your propsal has been submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
