<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Project\ProjectInterface;
use App\Services\Form\Project\ProjectForm;
use App\Models\Project;

use Illuminate\Http\Request;

class ProjectsController extends Controller {

	protected $project;

	protected $projectForm;

	/**
	 * Create a new controller instance.
	 *
	 * @param \App\Repositories\Project\ProjectInterface $project
	 * @param \App\Services\Form\Project\ProjectForm     $projectForm
	 * @return void
	 */
	public function __construct(ProjectInterface $project, ProjectForm $projectForm)
	{
		$this->middleware('auth');

		$this->project     = $project;
		$this->projectForm = $projectForm;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$page = $request->input('page', 1);

		$perPage = 10;

		$projects = $this->project->byPage($page, $perPage);

		return view('projects.index')->with('projects', $projects);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('projects.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$input = $request->all();

		if ($this->projectForm->save($input)) {
			return redirect()->route('projects.index');
		} else {
			return redirect()->route('projects.create')
				->withInput()
				->withErrors($this->projectForm->errors());
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param \App\Models\Project $project
	 * @return Response
	 */
	public function show(Project $project)
	{
		return redirect()->route('projects.edit', [$project]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param \App\Models\Project $project
	 * @return Response
	 */
	public function edit(Project $project)
	{
		return view('projects.edit')->with('project', $project);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Project      $project
	 * @return Response
	 */
	public function update(Request $request, Project $project)
	{
		$input = array_merge($request->all(), ['id' => $project->id]);

		if ($this->projectForm->update($input)) {
			return redirect()->route('projects.index');
		} else {
			return redirect()->route('projects.edit', [$project])
				->withInput()
				->withErrors($this->projectForm->errors());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \App\Models\Project $project
	 * @return Response
	 */
	public function destroy(Project $project)
	{
		$this->project->delete($project->id);

		return redirect()->route('projects.index');
	}

}