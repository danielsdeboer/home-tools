<?php

namespace App\Http\Controllers\Gardening;

use App\Enums\ResourceIcon;
use App\Http\Packets\CollectionPacket;
use App\Http\Packets\Gardening\Plants\PlantPacket;
use App\Http\Packets\Gardening\Plants\PlantPlotCountPacket;
use App\Http\Packets\Gardening\Plants\PlantPlotsPacket;
use App\Http\Packets\Gardening\Projects\ProjectPacket;
use App\Http\Packets\Links\LinksPacket;
use App\Http\Packets\MergePacket;
use App\Http\Packets\Observations\ObservationsPacket;
use App\Http\Packets\Page\BreadcrumbsPacket;
use App\Http\Packets\Page\CrumbPacket;
use App\Http\Packets\Page\HeaderPacket;
use App\Http\Packets\Page\PagePacket;
use App\Http\Packets\PaginationPacket;
use App\Http\Packets\Photos\PhotoPacket;
use App\Models\Plant;
use App\Models\Scopes\HasScope;
use App\Models\Scopes\Gardening\Plants\PlantSearchScope;
use App\Models\Scopes\WhenScope;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PlantController
{
	private BreadcrumbsPacket $breadcrumbs;

	public function __construct()
	{
		$this->breadcrumbs = new BreadcrumbsPacket(
			new CrumbPacket('Gardening', route('gardening.index')),
			new CrumbPacket('Plants', route('gardening.plants.index')),
		);
	}

    public function index(Request $request): Response
    {
		$searchScope = new WhenScope(
			$request->filled('search'),
			fn () => new PlantSearchScope($request->input('search')),
		);

		$activeScope = new WhenScope(
			$request->boolean('active'),
			fn () => new HasScope('activePlots'),
		);

		$plants = Plant::withCount(['plots', 'activePlots'])
			->orderBy('name')
			->scope($searchScope, $activeScope)
			->paginate(perPage: 24);

        return Inertia::render('Gardening/Pages/Plants/PlantsIndex', [
			'page' => new PagePacket(
				createRoute: route('gardening.plants.create'),
				breadcrumbs: $this->breadcrumbs,
				header: new HeaderPacket('Plants', ResourceIcon::Plant),
			),
			'plants' => new PaginationPacket(
				$plants,
				fn (Plant $plant) => new MergePacket(
					new PlantPacket($plant),
					new PlantPlotCountPacket($plant),
				),
			),
		]);
    }

	public function show(Plant $plant): Response
	{
		$plant->load('plots.garden', 'observations', 'media', 'projects');

		return Inertia::render('Gardening/Pages/Plants/PlantsShow', [
			'plant' => new MergePacket(
				new PlantPacket($plant),
				new PlantPlotsPacket($plant),
				new ObservationsPacket($plant),
				new LinksPacket($plant),
				['photos' => new CollectionPacket(
					$plant->getMedia('photos'),
					PhotoPacket::class,
				)],
				['projects' => new CollectionPacket(
					$plant->projects,
					ProjectPacket::class,
				)],

			),
			'page' => new PagePacket(
				editRoute: route('gardening.plants.edit', $plant),
				breadcrumbs: $this->breadcrumbs->push(
					new CrumbPacket($plant->name, '', disabled: true),
				),
				header: new HeaderPacket($plant->name, ResourceIcon::Plant),
			),
		]);
	}

	public function create(): Response
	{
		return Inertia::render('Gardening/Pages/Plants/PlantsCreate', [
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs->pushDisabled('Create'),
				header: new HeaderPacket(
					'Create a new plant',
					ResourceIcon::Plant,
				),
			),
		]);
	}

	public function edit(Plant $plant): Response
	{
		return Inertia::render('Gardening/Pages/Plants/PlantsEdit', [
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs->pushDisabled('Edit'),
				header: new HeaderPacket(
					sprintf('Edit %s', $plant->name),
					ResourceIcon::Plant,
				),
			),
			'plant' => new PlantPacket($plant),
		]);
	}

	public function store(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required', 'string'],
			'variety' => ['required', 'string'],
			'botanical' => ['required', 'string'],
		]);

		$plant = Plant::create($validated);

		return redirect()->route('gardening.plants.show', $plant);
	}

	public function update(Request $request, Plant $plant): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required', 'string'],
			'variety' => ['required', 'string'],
			'botanical' => ['required', 'string'],
		]);

		$plant->update($validated);

		return redirect()->route('gardening.plants.show', $plant);
	}
}
