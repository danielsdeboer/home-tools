<?php

namespace App\Http\Controllers\Gardening;

use App\Enums\ResourceIcon;
use App\Http\Packets\CollectionPacket;
use App\Http\Packets\Gardening\Gardens\GardenStubPacket;
use App\Http\Packets\Gardening\Plants\PlantPacket;
use App\Http\Packets\Gardening\Plots\PlotPacket;
use App\Http\Packets\KeyPacket;
use App\Http\Packets\MergePacket;
use App\Http\Packets\ModelSelectPacket;
use App\Http\Packets\Observations\ObservationsPacket;
use App\Http\Packets\Page\BreadcrumbsPacket;
use App\Http\Packets\Page\CrumbPacket;
use App\Http\Packets\Page\HeaderPacket;
use App\Http\Packets\Page\HtmlTitlePacket;
use App\Http\Packets\Page\PagePacket;
use App\Http\Packets\PaginationPacket;
use App\Models\Garden;
use App\Models\Plant;
use App\Models\Plot;
use App\Models\Scopes\Gardening\Plots\PlotSearchScope;
use App\Models\Scopes\WhenScope;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PlotController
{
	private BreadcrumbsPacket $breadcrumbs;
	private HtmlTitlePacket $htmlTitle;

	public function __construct()
	{
		$this->breadcrumbs = new BreadcrumbsPacket(
			new CrumbPacket('Gardening', route('admin.farm.index')),
			new CrumbPacket('Plots', route('admin.farm.plots.index')),
		);

		$this->htmlTitle = new HtmlTitlePacket('Gardening', 'Plots');
	}

	public function index(Request $request): Response
	{
		$searchScope = new WhenScope(
			$request->filled('search'),
			fn () => new PlotSearchScope($request->input('search')),
		);

		$plots = Plot::query()
			->scope($searchScope)
			->with('garden')
			->withCount(['observations', 'plants'])
			->orderBy('name')
			->paginate(perPage: 24);

		return Inertia::render('Gardening/Pages/Plots/PlotsIndex', [
			'page' => new PagePacket(
				createRoute: route('admin.farm.plots.create'),
				breadcrumbs: $this->breadcrumbs,
				header: new HeaderPacket('Plots', ResourceIcon::Plot),
				htmlTitle: $this->htmlTitle,
			),
			'plots' => new PaginationPacket(
				$plots,
				fn (Plot $plot) => new MergePacket(
					new PlotPacket($plot),
					new KeyPacket('garden', new GardenStubPacket($plot->garden)),
					['observations_count' => $plot->observations_count],
					['plants_count' => $plot->plants_count],
				),
			),
		]);
	}

	public function show(Plot $plot): Response
	{
		$plot->load([
			'garden',
			'plants' => fn (BelongsToMany $query) => $query->orderBy('name'),
			'observations' => fn (MorphMany $query) => $query->orderBy(
				'observed_at',
				'desc',
			),
		]);

		return Inertia::render('Gardening/Pages/Plots/PlotsShow', [
			'page' => new PagePacket(
				editRoute: route('admin.farm.plots.edit', $plot),
				breadcrumbs: $this->breadcrumbs->pushDisabled($plot->name),
				header: new HeaderPacket($plot->name, ResourceIcon::Plot),
				htmlTitle: $this->htmlTitle->push($plot->name),
			),
			'plot' => new MergePacket(
				new PlotPacket($plot),
				new KeyPacket('garden', new GardenStubPacket($plot->garden)),
				new KeyPacket('plants', new CollectionPacket(
					$plot->plants,
					PlantPacket::class,
				)),
				new KeyPacket('observations', new ObservationsPacket($plot)),
			),
			'plants' => new ModelSelectPacket(new Plant(), ['name', 'variety']),
		]);
	}

	public function create(): Response
	{
		return Inertia::render('Gardening/Pages/Plots/PlotsCreate', [
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs->pushDisabled('Create'),
				header: new HeaderPacket(
					'Create a new plot',
					ResourceIcon::Plot,
				),
				htmlTitle: $this->htmlTitle->push('Create a new plot'),
			),
			'gardens' => new CollectionPacket(
				Garden::all(),
				GardenStubPacket::class,
			),
		]);
	}

	public function edit(Plot $plot): Response
	{
		return Inertia::render('Gardening/Pages/Plots/PlotsEdit', [
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs->pushDisabled('Edit'),
				header: new HeaderPacket(
					sprintf('Edit Plot - %s', $plot->name),
					ResourceIcon::Plot,
				),
				htmlTitle: $this->htmlTitle->push(
					sprintf('Edit plot - %s', $plot->name),
				),
			),
			'gardens' => new CollectionPacket(
				Garden::all(),
				GardenStubPacket::class,
			),
			'plot' => new MergePacket(
				new PlotPacket($plot),
				new KeyPacket('garden', new GardenStubPacket($plot->garden)),
			),
		]);
	}

	public function store(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'garden_uuid' => ['required', 'exists:gardens,uuid'],
			'name' => ['required', 'string'],
			'description' => ['present', 'nullable', 'string'],
			'planted_at' => ['required', 'date'],
			'germinated_at' => ['present', 'nullable', 'date'],
			'harvested_at' => ['present', 'nullable', 'date'],
		]);

		$plot = Plot::create($validated);

		return redirect()->route('admin.farm.plots.show', $plot);
	}

	public function update(Request $request, Plot $plot): RedirectResponse
	{
		$validated = $request->validate([
			'garden_uuid' => ['required', 'exists:gardens,uuid'],
			'name' => ['required', 'string'],
			'description' => ['present', 'nullable', 'string'],
			'planted_at' => ['required', 'date'],
			'germinated_at' => ['present', 'nullable', 'date'],
			'harvested_at' => ['present', 'nullable', 'date'],
		]);

		$plot->update($validated);

		return redirect()->route('admin.farm.plots.show', $plot);
	}
}
