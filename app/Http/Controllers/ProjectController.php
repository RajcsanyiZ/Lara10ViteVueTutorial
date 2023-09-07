<?php

namespace App\Http\Controllers;

use App\Enums\ProjectStatusEnum;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class ProjectController extends Controller
{
    const LIST_PER_PAGE=10;

    /**
     * Display the projects list page.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $projects = Project::status($request->get('status', ''))
        ->paginate(self::LIST_PER_PAGE)->through(fn($project) => [
            'id' => $project->id,
            'name' => $project->name,
            'status' => $project->status,
            'members' => $project->projectMember->count(),
            'updated_at' => $project->updated_at->diffForHumans(),
        ]);

        // $projects = Project::get()->only('id', 'name', 'status', 'members')->paginate(self::LIST_PER_PAGE);
        // $projects = Project::paginate(self::LIST_PER_PAGE, ['id', 'name', 'status']);

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
            'statuses' => ProjectStatusEnum::toArray(true),
            'status'   => $request->get('status', '')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create()
    {
        $project = new Project();

        $project->name = "Heló";

        return Inertia::render('Projects/Create', [
            'project' => $project,
            'statuses' => ProjectStatusEnum::toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->route('projects.index')
            ->with('toast', __('Project successfully created.'));

        $messages = [
            'name.required' => 'The name field is required!',
            'note.required' => 'The note field is required!',
            //'note.min' => 'The length of the name field is too short!'
        ];

        $attr = $request->validate([
            'name'=>'required',
            'note'=>['required', 'min:10']
        ], $messages);

        $project = (new Project())->fill($attr);
        $project->user_id = auth()->user()->id;
        $project->save();

        return redirect()->route('projects.index')
            ->with('toast', __('Project successfully created.'));
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
