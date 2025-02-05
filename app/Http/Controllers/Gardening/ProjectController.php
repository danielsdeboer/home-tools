<?php

namespace App\Http\Controllers\Gardening;

use App\Enums\ResourceIcon;
use App\Http\Packets\CollectionPacket;
use App\Http\Packets\Gardening\Plants\PlantPacket;
use App\Http\Packets\Gardening\Projects\ProjectPacket;
use App\Http\Packets\Gardening\Projects\ProjectPlantPacket;
use App\Http\Packets\KeyPacket;
use App\Http\Packets\MergePacket;
use App\Http\Packets\ModelSelectPacket;
use App\Http\Packets\Page\BreadcrumbsPacket;
use App\Http\Packets\Page\CrumbPacket;
use App\Http\Packets\Page\HeaderPacket;
use App\Http\Packets\Page\HtmlTitlePacket;
use App\Http\Packets\Page\PagePacket;
use App\Http\Packets\PaginationPacket;
use App\Models\Plant;
use App\Models\Project;
use App\Models\Scopes\Search\SearchScope;
use App\Models\Scopes\WhenScope;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController
{
	private BreadcrumbsPacket $breadcrumbs;
	private HtmlTitlePacket $htmlTitle;

	public function __construct()
	{
		$this->breadcrumbs = new BreadcrumbsPacket(
			new CrumbPacket('Gardening', route('admin.farm.index')),
			new CrumbPacket('Projects', route('admin.farm.projects.index')),
		);

		$this->htmlTitle = new HtmlTitlePacket('Gardening', 'Projects');
	}

	public function index(Request $request): Response
	{
		$searchScope = new WhenScope(
			$request->filled('search'),
			fn () => new SearchScope(
				$request->input('search'),
				['name'],
			),
		);

		$projects = Project::query()
			->scope($searchScope)
			->withCount('plants')
			->paginate(perPage: 24);

		return Inertia::render('Gardening/Pages/Projects/ProjectsIndex', [
			'page' => new PagePacket(
				createRoute: route('admin.farm.projects.create'),
				breadcrumbs: $this->breadcrumbs,
				header: new HeaderPacket('Projects', ResourceIcon::Project),
				htmlTitle: $this->htmlTitle,
			),
			'projects' => new PaginationPacket(
				$projects,
				fn (Project $project) => new MergePacket(
					new ProjectPacket($project),
					['plants_count' => $project->plants_count],
				),
			),
		]);
	}

	public function show(Project $project): Response
	{
		return Inertia::render('Gardening/Pages/Projects/ProjectsShow', [
			'page' => new PagePacket(
				editRoute: route('admin.farm.projects.edit', $project),
				breadcrumbs: $this->breadcrumbs->pushDisabled($project->name),
				header: new HeaderPacket($project->name, ResourceIcon::Project),
				htmlTitle: $this->htmlTitle->push($project->name),
			),
			'project' => new MergePacket(
				new ProjectPacket($project),
				new KeyPacket(
					'plants', new CollectionPacket(
					$project->plants()
						->orderBy('name')
						->orderBy('variety')
						->get(),
					fn (Plant $plant) => new MergePacket(
						new PlantPacket($plant),
						new ProjectPlantPacket($plant),
					),
				),
				),
			),
			'plants' => new ModelSelectPacket(new Plant(), ['name', 'variety']),
		]);
	}

	public function create(): Response
	{
		return Inertia::render('Gardening/Pages/Projects/ProjectsCreate', [
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs->pushDisabled('Create'),
				header: new HeaderPacket(
					'Create a new project',
					ResourceIcon::Project,
				),
				htmlTitle: $this->htmlTitle->push('Create a new project'),
			),
		]);
	}

	public function edit(Project $project): Response
	{
		return Inertia::render('Gardening/Pages/Projects/ProjectsEdit', [
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs->pushDisabled('Edit'),
				header: new HeaderPacket(
					sprintf('Edit Project - %s', $project->name),
					ResourceIcon::Project,
				),
				htmlTitle: $this->htmlTitle->push(
					sprintf('Edit project - %s', $project->name),
				),
			),
			'project' => new MergePacket(
				new ProjectPacket($project),
			),
		]);
	}

	public function store(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required', 'string'],
			'description' => ['required', 'string'],
		]);

		$project = Project::create($validated);

		return redirect()->route('admin.farm.projects.show', $project);
	}

	public function update(Request $request, Project $project): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required', 'string'],
			'description' => ['required', 'string'],
		]);

		$project->update($validated);

		return redirect()->route('admin.farm.projects.show', $project);
	}
}
