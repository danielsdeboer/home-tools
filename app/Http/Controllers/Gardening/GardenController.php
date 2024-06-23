<?php

namespace App\Http\Controllers\Gardening;

use App\Enums\ResourceIcon;
use App\Http\Packets\CollectionPacket;
use App\Http\Packets\Gardens\GardenPlantPacket;
use App\Http\Packets\Gardens\GardensShowPacket;
use App\Http\Packets\Page\BreadcrumbsPacket;
use App\Http\Packets\Page\CrumbPacket;
use App\Http\Packets\Page\HeaderPacket;
use App\Http\Packets\Page\PagePacket;
use App\Models\Garden;
use App\Models\Plant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GardenController
{
	private BreadcrumbsPacket $breadcrumbs;

	public function __construct()
	{
		$this->breadcrumbs = new BreadcrumbsPacket(
			new CrumbPacket('Gardening', route('gardening.index')),
			new CrumbPacket('Gardens', route('gardening.gardens.index')),
		);
	}

	public function index(): Response
	{
		return Inertia::render('Gardening/Pages/Gardens/GardensIndex', [
			'page' => new PagePacket(
				createRoute: route('gardening.gardens.create'),
				breadcrumbs: $this->breadcrumbs,
				header: new HeaderPacket('Gardens', ResourceIcon::Garden),
			),
			'gardens' => Garden::paginate(perPage: 24),
		]);
	}

	public function show(Garden $garden): Response
	{
		return Inertia::render('Gardening/Pages/Gardens/GardensShow', [
			'page' => new PagePacket(
				editRoute: route('gardening.gardens.edit', $garden),
				breadcrumbs: $this->breadcrumbs->push(
					new CrumbPacket($garden->name, '', disabled: true),
				),
				header: new HeaderPacket($garden->name, ResourceIcon::Garden),
			),
			'garden' => new GardensShowPacket($garden),
			'plants' => new CollectionPacket(
				Plant::orderBy('name')->get(),
				GardenPlantPacket::class,
			),
		]);
	}

	public function create(): Response
	{
		return Inertia::render('Gardening/Pages/Gardens/GardensCreate', [
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs->pushDisabled('Create'),
				header: new HeaderPacket(
					'Create a new garden',
					ResourceIcon::Garden,
				),
			),
		]);
	}

	public function edit(Garden $garden): Response
	{
		return Inertia::render('Gardening/Pages/Gardens/GardensEdit', [
			'garden' => new GardensShowPacket($garden),
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs->pushDisabled(
					sprintf('Edit: %s', $garden->name)),
				header: new HeaderPacket(
					sprintf('Edit Garden - %s', $garden->name),
					ResourceIcon::Garden,
				),
			),
		]);
	}

	public function store(Request $request): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required', 'string'],
			'location' => ['required', 'string'],
			'description' => ['present', 'nullable', 'string'],
		]);

		$garden = Garden::create($validated);

		return redirect()->route('gardening.gardens.show', $garden);
	}

	public function update(Request $request, Garden $garden): RedirectResponse
	{
		$validated = $request->validate([
			'name' => ['required', 'string'],
			'location' => ['required', 'string'],
			'description' => ['present', 'nullable', 'string'],
		]);

		$garden->update($validated);

		return redirect()->route('gardening.gardens.show', $garden);
	}
}
