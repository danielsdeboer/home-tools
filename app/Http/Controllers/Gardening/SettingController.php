<?php

namespace App\Http\Controllers\Gardening;

use Admin\Common\Settings\FrostDateSettings;
use App\Enums\ResourceIcon;
use App\Http\Packets\Page\BreadcrumbsPacket;
use App\Http\Packets\Page\CrumbPacket;
use App\Http\Packets\Page\HeaderPacket;
use App\Http\Packets\Page\HtmlTitlePacket;
use App\Http\Packets\Page\PagePacket;
use Inertia\Inertia;
use Inertia\Response;

class SettingController
{
	private BreadcrumbsPacket $breadcrumbs;
	private HtmlTitlePacket $htmlTitle;

	public function __construct()
	{
		$this->breadcrumbs = new BreadcrumbsPacket(
			new CrumbPacket('Gardening', route('admin.farm.index')),
			new CrumbPacket('Settings', route('admin.farm.settings.index')),
		);

		$this->htmlTitle = new HtmlTitlePacket('Gardening', 'Settings');
	}

	public function index(FrostDateSettings $settings): Response
	{
		return Inertia::render('Gardening/Pages/Settings/SettingIndex', [
			'page' => new PagePacket(
				breadcrumbs: $this->breadcrumbs,
				header: new HeaderPacket('Settings', ResourceIcon::Setting),
				htmlTitle: $this->htmlTitle,
			),
			'settings' => [
				['name' => 'spring', 'value' => $settings->spring],
				['name' => 'autumn', 'value' => $settings->autumn],
			],
		]);
	}

	// public function show(Garden $garden): Response
	// {
	// 	$garden->load([
	// 		'plots' => fn (HasMany $relation) => $relation->orderBy('name'),
	// 		'observations' => fn (MorphMany $relation) => $relation->orderBy(
	// 			'observed_at',
	// 			'desc',
	// 		),
	// 	]);
	//
	// 	return Inertia::render('Gardening/Pages/Gardens/GardensShow', [
	// 		'page' => new PagePacket(
	// 			editRoute: route('admin.farm.gardens.edit', $garden),
	// 			breadcrumbs: $this->breadcrumbs->push(
	// 				new CrumbPacket($garden->name, '', disabled: true),
	// 			),
	// 			header: new HeaderPacket($garden->name, ResourceIcon::Garden),
	// 			htmlTitle: $this->htmlTitle->push($garden->name),
	// 		),
	// 		'garden' => new GardensShowPacket($garden),
	// 		'plants' => new CollectionPacket(
	// 			Plant::orderBy('name')->get(),
	// 			GardenPlantPacket::class,
	// 		),
	// 	]);
	// }
	//
	// public function create(): Response
	// {
	// 	return Inertia::render('Gardening/Pages/Gardens/GardensCreate', [
	// 		'page' => new PagePacket(
	// 			breadcrumbs: $this->breadcrumbs->pushDisabled('Create'),
	// 			header: new HeaderPacket(
	// 				'Create a new garden',
	// 				ResourceIcon::Garden,
	// 			),
	// 			htmlTitle: $this->htmlTitle->push('Create a new garden'),
	// 		),
	// 	]);
	// }
	//
	// public function edit(Garden $garden): Response
	// {
	// 	return Inertia::render('Gardening/Pages/Gardens/GardensEdit', [
	// 		'garden' => new GardensShowPacket($garden),
	// 		'page' => new PagePacket(
	// 			breadcrumbs: $this->breadcrumbs->pushDisabled(
	// 				sprintf('Edit: %s', $garden->name),
	// 			),
	// 			header: new HeaderPacket(
	// 				sprintf('Edit Garden - %s', $garden->name),
	// 				ResourceIcon::Garden,
	// 			),
	// 			htmlTitle: $this->htmlTitle->push(
	// 				sprintf('Edit garden - %s', $garden->name),
	// 			),
	// 		),
	// 	]);
	// }
	//
	// public function store(Request $request): RedirectResponse
	// {
	// 	$validated = $request->validate([
	// 		'name' => ['required', 'string'],
	// 		'location' => ['required', 'string'],
	// 		'description' => ['present', 'nullable', 'string'],
	// 	]);
	//
	// 	$garden = Garden::create($validated);
	//
	// 	return redirect()->route('admin.farm.gardens.show', $garden);
	// }
	//
	// public function update(Request $request, Garden $garden): RedirectResponse
	// {
	// 	$validated = $request->validate([
	// 		'name' => ['required', 'string'],
	// 		'location' => ['required', 'string'],
	// 		'description' => ['present', 'nullable', 'string'],
	// 	]);
	//
	// 	$garden->update($validated);
	//
	// 	return redirect()->route('admin.farm.gardens.show', $garden);
	// }
}
